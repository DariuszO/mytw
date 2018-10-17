<?php
/*
*	Login file
*/
require_once "./libraries/common.inc.php";

require_once PATH . "/libraries/world_common.inc.php";

if (!world) {
	MyTW_world_location("index.php");
}

if (!World::exists(w)) {
	MyTW_world_location("index.php");
}

$wconf = World::configs(w);
$session = $_GET['sid'];
$HKey = $_GET['hkey'];
$pass = $_GET['pass'];
$search = DB::Query("SELECT * FROM `users` WHERE `session` = '{$session}'");
$check = DB::numrows($search);
if ($check != 1) {
	MyTW_world_location("index.php");
}

$user = DB::fetch($search);
$uid = $user['id'];
if ($user['pass'] != $pass) {
	exit("Nieprawidłowe hasło!");
}

setcookie("session",$session,time()+3600*24*365);
setcookie("hkey",$HKey,time()+3600*24*365);

$DB = "mytw_world_" . w;
$sid->new_db($DB);
$create = $sid->new_sid($uid,$session,$HKey);
if ($create != true) {
	MyTW_world_location("index.php?err=".DB::last_err()["error"]);
}
$time = time();
DB::Query("INSERT INTO `{$DB}`.`logins` VALUES(NULL,'{$uid}','{$time}','{$cfg['client']['ip']}','0','{$session}','{$HKey}')");

header("Location: /game.php?screen=welcome&intro&oscreen=overview");
?>