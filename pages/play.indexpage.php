<?php
$server = $path_exp[3];
$server_url = array_replace($cfg['world_url'],["[HOST]"=>$_SERVER['HTTP_HOST'],"[ID]"=>$server]);
$user_worlds = json_decode($user['worlds'],true);
$sid = $user['session'];
$HKey = random(4);
if (!in_array($server,$user_worlds)) {
	$location = "/page/join/{$server}";
} else {
	$location = "http://{$server}.{$_SERVER['HTTP_HOST']}/login.php?hkey={$HKey}&sid={$sid}&mobile=0&pass={$user['pass']}";
}
header("Location: {$location}");
?>