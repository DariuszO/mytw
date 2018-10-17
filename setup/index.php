<?php
exit("Koniec :)");
error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED);

if (version_compare(PHP_VERSION,"5.4","lt")) {
	echo "<b>[PHP]:</b> Version conflick: <br><pre>Server version: <b style='color: red;'>". PHP_VERSION ."</b><br>Required version: <b style='color: green;'>5.4+</b></pre>";
	exit;
}

/*
*	@Function: MyTW_json_exit();
*/
function MyTW_json_exit($array) {
	error_reporting(0);
	$json = @json_encode($array);
	header('Content-Type: application/json;');
	echo $json;
	exit;
}


$step = $_GET['step'];

define("PATH",dirname(__DIR__));

$steps = [
	0 => "welcome",
	1 => "first_configs",
	2 => "mysql_connect",
	3 => "account"
];
if (empty($step)) {
	$step = 0;
}

if (isset($_GET['ajax'])) {
	require_once "steps/{$steps[$step]}.inc.php";
	exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="https://www.facebook.com/2008/fbml">
	<head>
		<title>MyTW - Instalacja</title>
		
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

		<link rel="stylesheet" type="text/css" href="/merged/index.css" />

		<script type="text/javascript" src="setup.js"></script>

	</head>

	<body>
		
		

		<div id="index_body">
			<div id="main">
						<div id="header">
				<div class="title">					<a href="/" style="background:url(http://dspl.innogamescdn.com/8.28.1/23007/graphic/lang/pl/bg-logo.jpg) no-repeat 100% 0;">
						<p style="position: absolute; top: -300px">Plemiona - gra online</p>
					</a>
				</div>				<div class="navigation">
					<div class="navigation-holder">
						<div class="navigation-wrapper">
							<div id="navigation_span">
								<progress value="0" id="install_proces" max="400" style="width: 100%; height: 50%;">Instalacja silnika...</progress>									
							</div>
						</div>
				</div>
				</div>
							</div>
					<div class="container-block-full">
			<div class="container-top-full"></div>
				<div class="container">
										<table>
						<tr>
							<td valign="top">
								<table class="vis" style="margin:0 18px 0 12px;">
									<tr>
										<td style="width:80px; height: 30px;" id="step1">
											<a href="#step_1">Ustawienia</a>
										</td>
									</tr>
									<tr>
										<td style="width:80px; height: 30px;" id="step2">
											<a href="#step_2">Połączenie MySQL</a>
										</td>
									</tr>
									<tr>
										<td style="width:80px; height: 30px;" id="step3">
											<a href="#step_3">Konto administratora</a>
										</td>
									</tr>
								</table>
							</td>
							<td style="width: 650px" valign="top">
								<div class="hof-wrapper">
<div>
	<h2 class="hof-banner" id="install_title">Instalacja</h2>
		<div id="setup_page">
			<h3>Witaj w procesie instalacji silnika MyTW!</h3>
			<p>Aby móc poprawnie korzystać z silnika wymagany jest ten proces instalacji. Po ukończeniu będziesz mógł w pełni korzystać z silnika oraz jego funkcji. Jeśli podczas instalacji wystąpiły błędy prosimy o poinformowanie <i>MyTW Team</i> o zaistniałym problemie na <a href="http://my-tw.tk/forum">Forum MyTW</a> lub w <a href="http://my-tw.tk/support">Centrum pomocy</a>. <b>UWAGA!</b> <i>MyTW Team</i> nie ponosi odpowiedzialności za tworzenie serwerów publicznych, silnik służy do zabawy w sieci lan. <br />Silnik powstał na podstawie gry <a href="http://plemiopna.pl/index.php">Plemiona.pl</a> firmy <a href="http://www.innogames.com/pl">InnoGames GmbH</a>, wszelkie prawa autorskie &copy;.</p>
			<div class="hof-footer">
				<div class="button-center-wrapper">
					<div class="the-red-button-border-right">
						<div class="the-red-button-border">
							<div class="the-red-button">
								<a href="#setup_start" onclick="Setup.go_step('1'); return false;">Rozpocznij instalację</a>
							</div>
						</div>
					</div>
				</div>
				<!---->
			</div>
		</div>
	</div>
</div><div class="clearfix"></div>
							</td>
						</tr>
					</table>
									</div>
			<div class="container-bottom-full"></div>
		 </div>
		</div><!-- content -->	
	        </body>
</html>
