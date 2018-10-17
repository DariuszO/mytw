<?php
$username = parse($_POST['username']);
$pass = pass($_POST['password']);

$sql = DB::Query("SELECT * FROM `admin_accounts` WHERE `name` = '{$username}'");
if (DB::numrows($sql) != 1) {
	$json['error'] = "Ten użytkownik nie istnieje!";
} else {
	$user = DB::Fetch($sql);
	if ($user['pass']!==$pass) {
		$json['error'] = "Nieprawidłowe hasło!";
	} else {
		$new_token = random(100,"qwertyuiopasdfghjklzxcvbnm1234567890");
		$time = time();
		$uid = $user['id'];
		$time_limit = 60*15; /* 60 seconds * 15 minuts */
		DB::Query("INSERT INTO `admin_tokens`(`token`,`account`,`last`,`time_limit`) VALUES('{$new_token}','{$uid}','{$time}','{$time_limit}')");
		$login_history = json_decode($user['login_history'],true);
		$login_history[] = ["time"=>time(),"ip"=>$cfg['client']['ip'],"token"=>$new_token];
		$login_history = json_encode($login_history);
		DB::Query("UPDATE `admin_accounts` SET `login_history` = '{$login_history}' WHERE `id` = '{$uid}'");
		$json['url'] = "http://{$_SERVER['HTTP_HOST']}/home/{$new_token}/global/NULL/&login_success";
	}
}
MyTW_json_exit($json);
?>