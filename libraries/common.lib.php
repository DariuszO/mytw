<?php

if (!defined("MyTW")) {
	exit;
}
/*
*	Clear variables:
*/
$variables_whitelist = ['GLOBALS','_SERVER','_GET','_POST','_REQUEST','_FILES','_ENV','_COOKIE','_SESSION','variables_whitelist','key'];

foreach (get_defined_vars() as $key => $value) {
    if (! in_array($key, $variables_whitelist)) {
        unset($$key);
    }
}
unset($key, $value, $variables_whitelist);

/*
*	Load configs from: /configs/MyTW.ini
*/
$CFile = PATH . "/configs/MyTW.ini";
if (!file_exists($CFile)) {
	exit("<b>[MyTW] Fatalny błąd:</b> Plik konfiguracyjny <b>{$CFile}</b> nie został odnaleziony!");
} else {
	$cfg = parse_ini_file($CFile);
}

$cfg['host'] = "http";
if ($_SERVER['HTTPS']) {
	$cfg['host'] .= "s";
}
$cfg['host'] .= "://";
$cfg['host'] .= $_SERVER['HTTP_HOST'];


$cfg['client'] = Array();
$ip = (!empty($_SERVER['REMOTE_ADDR']))?$_SERVER['REMOTE_ADDR'] :((!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) ? $_SERVER['HTTP_X_FORWARDED_FOR']: @getenv('REMOTE_ADDR'));
if(isset($_SERVER['HTTP_CLIENT_IP']))
	$ip = $_SERVER['HTTP_CLIENT_IP'];
$cfg['client']['ip'] = $ip;
unset($ip);
/*
*	Load admintool configs from: /configs/admintool.ini
*/
$ATCFile = PATH . "/configs/admintool.ini";
if (!file_exists($CFile)) {
	exit("<b>[MyTW] Fatalny błąd:</b> Plik konfiguracyjny <b>{$ATCFile}</b> nie został odnaleziony!");
} else {
	$cfg['admintool'] = parse_ini_file($ATCFile);
}


/*
*	@Function: MyTW_check_version();
*/
function MyTW_check_version() {
	global $cfg;
	$_URL_CHECK = $cfg['mytw_website'] . "/version_check.php?v={$cfg['version']}";
	$open = @file_get_contents($_URL_CHECK);
	$decode = @json_decode($open,true);
	if ($decode['check_status'] != "OK") {
		return false;
	} else {
		return $decode;
	}
}

/*
*	@Function: MyTW_json_exit();
*/
function MyTW_json_exit($array) {
	$json = @json_encode($array);
	header('Content-Type: application/json;');
	echo $json;
	exit;
}

/*
*	@Function: replace_array();
*/
function replace_array($str,$arg=[]) {
	foreach ($arg as $from => $to) {
		$str = str_replace($from,$to,$str);
	}
	return $str;
}


/*
*	@Function: parse();
*/
function parse($text,$html=false) {
	if ($html===false) {
		$text = HTMLSpecialChars($text);
	}
	$text = trim(urlencode($text));
	return $text;
}

/*
*	@Function: entparse();
*/
function entparse($text,$nl2br=false) {
	$text = trim(urldecode($text));
	if ($nl2br===true) {
		$text = nl2br($text);
	}
	return $text;
}

/*
*	@Function: MyTW_ads_load();
*	NOT EDIT!
*/
function MyTW_ads_load($ads_type) {
	global $cfg;
	$_URL_CHECK = $cfg['mytw_website'] . "/ads.php?t={$ads_type}";
	$open = @file_get_contents($_URL_CHECK);
	$decode = @json_decode($open,true);
	if ($decode['check_status'] != "OK") {
		return false;
	} else {
		return $decode['servers_list_html'];
	}
}

/*
*	@Function: user_worlds()
*/
function user_worlds($user,$nv=[]) {
	global $cfg;
	$blocked_list = World::worlds_off();
	$return = "<form action=\"index.php?action=login\" method=\"post\" class=\"server-form\" id=\"server_select_list\">
	
	<input name=\"user\" value=\"". entparse($user['name']) ."\" type=\"hidden\">	<input name=\"password\" value=\"{$user['pass']}\" type=\"hidden\">
	<div id=\"active_server\">
					<p class=\"pseudo-heading\">Na którym świecie chcesz się zalogować?</p>";
	
	$user_worlds = json_decode($user['worlds']);
	$i = 0;
	foreach ($user_worlds as $server) {
		if (!in_array($server,$nv)) {
			$server_configs = World::configs($server);
			$server_configs['name'] = entparse($server_configs['name']);
			if ($i%2===0 OR $i === 0) {
				$return .= "<div class=\"clearfix\">";
			}
			$return .= "
							<a href=\"#\" onclick=\"return Index.submit_login('server_{$server}');\">
					<span class=\"world_button_active\">{$server_configs['name']}</span>
				</a>
							";
			if ($i%2===1) {
				$return .= "</div>";
			}
			$i++;
		}
		$blocked_list[] = $server;
	}
	if ($i%2===1) {
		$return .= "</div>";
	}
	
	$worlds_list = World::worlds_list($blocked_list);
	if ($worlds_list == false OR empty($worlds_list)) {
		$worlds_list = Array();
	}
	$i = 0;
	foreach ($worlds_list as $server) {
		$server_configs = World::configs($server);
		$server_configs['name'] = entparse($server_configs['name']);
		if ($i%2===0 OR $i === 0) {
			$return .= "<div class=\"clearfix\">";
		}
		$return .= "
						<a href=\"#\" onclick=\"return Index.submit_login('server_{$server}');\">
				<span class=\"world_button_inactive\">{$server_configs['name']}</span>
			</a>
						";
		if ($i%2===1) {
			$return .= "</div>";
		}
		$i++;
	}
	if ($i%2===1) {
		$return .= "</div>";
	}	
	$return .= "
	</div>
</form>";
	return $return;	
}

/*
*	@Function: format_number();
*/
function format_number($num) {
	return str_replace(',','<span class="grey">.</span>',number_format($num));
}

/*
*	@Function: format_time();
*/
function format_time($arg) {
	if ($arg < 0) {
		return "00:00:$arg";
	} else {
		$h = floor($arg / 3600);
		$m = floor(($arg % 3600) / 60);
		$s = ($arg % 3600) % 60;
		
		if ($m < 10) $m = "0".$m;
		if ($s < 10) $s = "0".$s;
		
		$c = $h.':'.$m.':'.$s;
		return $c;
	}
}

/*
*	@Function: format_date();
*/
function format_date($unix) {
	if (date('I')) {
		$modifer = 7200;
		} else {
		$modifer = 0;
		}
		
	$aktuday = floor((date("U") + $modifer) / 86400);
	$dateday = floor(($unix + $modifer) / 86400);
	if ($aktuday == $dateday) {
		return "dzisiaj o " . date("H:i:s",$unix);
	} elseif (($aktuday + 1) == $dateday) {
		return "Jutro o " . date("H:i:s",$unix);
	} elseif (($aktuday - 1) == $dateday) {
		return "Wczoraj o " . date("H:i:s",$unix);
	} else {
		$date = date("d.m H:i:s",$unix);
		return "w ". str_replace(" "," o ",$date);
	}
}

/*
*	@Function: get_validete_reg();
*/
function get_validete_reg() {
	return '/[^A-Za-z0-9_ąężźóśłćńĄĘŻŹÓŚŁĆŃ\.\/\:\;\[\]\=\+\-\)\(\*\&\^\%\$\#\@\!\~\`\n\| \?\,\{\}]/';
}

/*
*	@Function: str_validator();
*/
function str_validator($str) {
	$str = preg_replace(get_validete_reg(),'',$str);
	return $str;
}

/*
*	@Function: cmp_str();
*/
function cmp_str($str,$min,$max) {
	$str = str_validator($str);
	$len = strlen($str);
	
	if ($len < $min) {
		return 'SHORT';
	} else {
		if ($len > $max) {
			return 'LONG';
		} else {
			if (substr_count($str," ") == $len) {
				return 'SPACES';
			} else {
				return $str;
			}
		}
	}
}

/*
*	@Function: random();
*/
function random($length, $pattern = 'qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890') {
	$tmp_len = strlen($pattern)-1;
	$random_string = "";
	for($i=1;$i<=$length;$i++) {
		$random_string .= $pattern{mt_rand(0,$tmp_len)};
	}
	
	return $random_string;
}

/*
*	@Function: pass();
*/
function pass($p) {
	return sha1(md5(base64_encode("mm14XRFkx2kjrrGylF20HVm8nW9MxCnqfl8XBm9GGu9ZN9nmzlaUVxfeWUraSBSpD5Wrui5a0TBhyKuUNMvKOQtAgZYB9vAGLcxs" . $p . "i9k8SmaUhO0KcPZDU2khfXoyAWVKS4yw3mMyxUtotCtiBdGbBMzdFGtr13nI0nHnsImrDJZsUjvP35ZTIZQ1fcRdCZpUvhaxFAFG")));
}

/*
*	@Function: NewLog();
*/
function NewLog($LOG,$TYPE="INFO",$FILE="/logs.log") {
	$FILE = PATH . $FILE;
	$DATE = date("y-m-d H:i:s");
	$LOG = "[{$TYPE}][{$DATE}] {$LOG}";
	if (!file_exists($FILE)) {
		file_put_contents($FILE,$LOG);
	} else {
		$F = FOpen($FILE,"r+");
		$OldLogs = @fread($F,filesize($FILE));
		$LOGS = "\n" . $LOG;
		FWrite($F,$LOGS);
		fClose($F);
	}
	return true;
}

/*
*	@Function: MyTW_world_location();
*/
function MyTW_world_location($f) {
	header("LOCATION: http://privek.tk/{$f}");
	exit;
	return true;
}

/*
*	@Function: My_TW_or();
*/
function MyTW_or($r,$r1=true,$r2=false,$rc="1") {
	if ($r === $rc) {
		return $r1;
	} else {
		return $r2;
	}
}
?>