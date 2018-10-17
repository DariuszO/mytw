<?php
/*
*	@Author: Bartekst222
*/
require_once "./libraries/common.inc.php";
require_once PATH . "/libraries/world_common.inc.php";

$page = $_GET['page'];
$file = PATH . "/game/page/{$page}.page.php";
if(!file_exists($file)) {
	exit("Invalid request!");
} else {
	require_once $file;
}

?>