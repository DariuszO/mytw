<?php
$username = $_POST['username'];
$pass = $_POST['password'];
$remembe = $_POST['remembe'];
$password = pass($pass);
$SQL = DB::Query("SELECT * FROM `users` WHERE `name` = '{$username}'");
$CheckUser = DB::numrows($SQL);
if ($CheckUser != 1) {
	MyTW_json_exit(["error"=>"Konto nie istnieje"]);
} else {
	$user = DB::Fetch($SQL);
	if ($user['pass'] != $pass && $user['pass'] != $password) {
		MyTW_json_exit(["error"=>"Niewłaściwe hasło"]);
	} else {
		if ($remembe==="1") {
			setcookie("session",$user['session'],time()+3600*24*365,"/");
		} else {
			setcookie("session",$user['session'],0,"/");
		}
		MyTW_json_exit(["success"=>"Zalogowano pomyślnie"]);
	}
}
?>