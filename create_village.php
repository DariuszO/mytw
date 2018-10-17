<?php
/*
*	create_village.php
*/
require_once "./libraries/common.inc.php";

require_once PATH . "/libraries/world_common.inc.php";

function sid_wrong() {
	header("LOCATION: /sid_wrong.php");
}

$DataReload->FullReload();

$session = $_COOKIE['session'];
$hkey = $_COOKIE['hkey'];
$user_glob = @DB::fetch(@DB::Query("SELECT * FROM `users` WHERE `session` = '{$session}' LIMIT 1"));

if ($user_glob===false) {
	sid_wrong();
} else {
	$sid->new_db($DB);
	$sess = $sid->check_sid($session);
	if ($sess===false) {
		sid_wrong();
	} else {
		$user = DB::fetch(@DB::Query("SELECT * FROM `{$DB}`.`users` WHERE `id` = '{$sess['uid']}' LIMIT 1"));
		if ($user===false) {
			sid_wrong();
		}
	}
}
if (DB::fetch(DB::Query("SELECT COUNT(`id`) FROM `{$DB}`.`villages` WHERE `uid` = '{$user['id']}'"))[0] > 0) {
	header("Location: /game.php");
	exit;
}
Village::create_new($user['id'],$server,$conf['start_villages'],"Wioska {$user['name']}","r",true);
Village::create_new("-1",$server,rand(1,2),"","r",true);
header("Location: /game.php");
?>