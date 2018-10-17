<?php
/*
*	AdminTool
*	by Bartekst222
*/
require_once "../libraries/common.inc.php";

$Admin = new stdClass();
$Admin->login = false;
$Admin->Token = Array();
$Admin->Perm = Array();;
$Admin->User = Array();
$Admin->errors = Array();
$Admin->SuperAdmin = false;

if (isset($_GET['logout'])) {
	header("LOCATION: /");
}

function AdminLog($LOG,$AID,$TYPE) {
	$time = time();
	$LOG = parse($LOG,true);
	$TYPE = parse($TYPE,true);
	return DB::Query("INSERT INTO `admin_logs`(`log`,`acc_id`,`type`,`time`) VALUES ('{$LOG}','{$AID}','{$TYPE}','{$time}')");
}

$ajax = @$_GET['ajax'];
$ajaxaction = @$_GET['ajaxaction'];
$path = $_GET['path'];
$path_exp = explode("/",$path);
$p = $path_exp[2];
$token = $path_exp[3];
$_GET['server'] = @$path_exp[4];
$mode = @$path_exp[5];

if (empty($token)) {
	$Admin->login = false;
} else {
	$checktoken = DB::Query("SELECT * FROM `admin_tokens` WHERE `token` = '{$token}'");
	if (DB::numrows($checktoken) != 1) {
		$Admin->login = false;
		$Admin->errors[] = "Nieprawidłowy token!";
	} else {
		$Admin->Token = DB::Fetch($checktoken);
		if ($Admin->Token['last'] < time()-$Admin->Token["time_limit"]) {
			$Admin->login = false;
			$t = $Admin->Token["time_limit"];
			$act = "";
			$hours = floor($t/3600);
			$minuts = floor(($t-$hours*3600)/60);
			$seconds = floor($t-$minuts*60);			
			if ($hours > 0) {
				$act .= " {$hours} godz";
			}
			if ($minuts > 0) {
				$act .= " {$minuts} min";
			}
			if ($seconds > 0) {
				$act .= " {$seconds} sec";
			}
			$Admin->errors[] = "Brak aktywności przez{$act}. Prosimy zalogować się ponownie.";
		} else {
			$user = DB::Fetch(DB::Query("SELECT * FROM `admin_accounts` WHERE `id` = '{$Admin->Token['account']}'",true));
			if ($user['id'] !== $Admin->Token['account']) {
				$Admin->errors[] = "Użytkownik przypisany do tego tokenu nie istnieje!";
				$Admin->login = false;
				$Admin->Token = [];
			} else {
				$Admin->User = $user;
				$Admin->Perm = json_decode($Admin->User['permissions'],true);
				$Admin->login = true;
				if ($Admin->Perm['super_admin']==="Y") {
					$Admin->SuperAdmin = true;
				}
				DB::Query("UPDATE `admin_tokens` SET `last` = '". time() ."' WHERE `id` = '{$Admin->Token['id']}'");
			}
		}
	}
}

if (!file_exists(PATH . "/admin_tools/pages/{$p}.screen.php")) {
	$p = "home";
}


if ($Admin->login===false) {
	$p = "login";
}

$PF['ajaxaction'] = PATH . "/admin_tools/pages/{$p}.{$ajaxaction}.ajaxaction.php";
$PF['ajax'] = PATH . "/admin_tools/pages/{$p}.{$ajax}.ajax.php";
$PF['mode'] = PATH . "/admin_tools/pages/{$p}.{$mode}.mode.screen.php";
$PF['screen'] = PATH . "/admin_tools/pages/{$p}.screen.php";

if (isset($_GET['ajaxaction'])) {
	if ($PF['ajaxaction']!==false) {
		require_once $PF['ajaxaction'];
	}
}

if (isset($_GET['ajax'])) {
	if ($PF['ajax']!==false) {
		require_once $PF['ajax'];
	}
}

if ($Admin->login===false) {
	require_once $PF['screen'];
	exit;
}
$Admin->Menu = new stdClass();
$Admin->Menu->central = Array();
$Admin->Menu->server = Array();
if (isset($_GET['server']) && $_GET['server']!=="global") {
	if (World::exists($_GET['server'])) {
		$server = $_GET['server'];
	} else {
		$server = false;
	}
} else {
	$server = false;
}

$default = [
	"d" => [
		"announcements" => "Ogłoszenia",
		"configs" => "Ustawienia serwera",
		"ftp" => "Edytor plików",
		"users" => "Użytkownicy",
		"admins" => "Administratorzy",
		"servers" => "Serwery",
		"new_server" => "Nowy serwer",
		"logs" => "Logi serwera",
		"admin_logs" => "Logi administratora",
		"sql" => "Konsola SQL",
		"debuggers" => "Debuggery",
		"reset" => "RESET"
	],
	"c" => [
		"configs" => "Ustawienia świata",
		"users" => "Użytkownicy",
		"ally" => "Plemienia",
		"logins" => "Historia logowań",
		"multi" => "Wykrywacz multikont",
		"mails" => "Wiadomości",
		"villages" => "Wioski",
		"map_groups" => "Oznaczenia na mapie",
		"groups" => "Grupy wiosek",
		"sessions" => "Sesje",
		"units" => "Menadżer wojsk"
	]
];
foreach ($default['d'] as $d1=>$d2) {
	if (@in_array($d1,$Admin->Perm['global']) OR $Admin->SuperAdmin === true) {
		$Admin->Menu->central[$d1] = $d2;
	}
}
if ($server!==false) {
	foreach ($default['c'] as $c1=>$c2) {
		if (@in_array($c1,$Admin->Perm["server_{$server}"]) OR $Admin->SuperAdmin === true) {
			$Admin->Menu->server[$c1] = $c2;
		}
	}
}

$AdminData = [
	"token" => $Admin->Token,
	"ajax_url" => "/SCREEN/TOKEN/MODE/SERVER"
];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>MyTW Admintool</title>
		<link rel="stylesheet" type="text/css" href="/admin.css" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<script src="/admin.js" type="text/javascript"></script>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js"></script>
		<script type="text/javascript">
			var admin_data = <?php echo json_encode($AdminData)?>;
		</script>
	</head>
	<div id="os"></div>
	<body style="margin-top:6px;">

		<table cellspacing="0" width="80%" style="margin: auto auto;">
			<tr>
				<td width="180px" valign="top">
				
					<table class="main" width="100%">
						<tr>
							<td>
								<table class="vis" width="100%">
									<tr><th>Funkcje główne</th></tr>
										<?php
										foreach ($Admin->Menu->central as $m1 => $m2) {
											echo "<tr><td><a href=\"/{$m1}/&token={$Admin->Token['token']}\" onclick=\" return Menu.load('{$m1}','global')\">{$m2}</a></td></tr>";
										}
										?>
										<tr><td><a href="/home/&logout">Wyloguj</a></td></tr>
										<?php
										if ($server!==false) {
										?>
									<tr><th>Funkcje serwera <?php echo $server;?></th></tr>
										<?php
										foreach ($Admin->Menu->server as $m1 => $m2) {
											echo "<tr><td><a href=\"/{$m1}/&token={$Admin->Token['token']}&server={$server}\" onclick=\" return Menu.load('{$m1}','{$server}')\">{$m2}</a></td></tr>";
										}
										?>
										<tr><td><a href="/home/&logout">Wyloguj</a></td></tr>
										<?php } ?>
								</table>
							</td>
						</tr>
					</table>
				</td>
				<td width="*" valign="top">
					<table class="main" width="100%">
						<tr>
							<td style="padding:2px;">
								<div id="page">
									<b>Token:</b><i><?php echo $Admin->Token['token']; ?></i><br />
									<b>Administrator:</b><i><?php echo entparse($Admin->User['name']);?></i><br />
									<b>Strona:</b><i><?php echo $p;?></i><br />
									<b>Podstrona:</b><i><?php echo $mode; ?></i>
									</div>
								<div id="TokenStatus"></div>
								</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>

		<script type="text/javascript">
		//<![CDATA[
			$(document).ready(function() { 
			});
			
			//]]>
		</script>
	        </body>
</html>