<?php
require_once "common.inc.php";
$ta = ["00:00:00","06:00:00","12:00:00","18:00:00"];
if (in_array(date("H:i:s",time()),$ta) OR in_array(date("H:i:s",time()-1),$ta) OR in_array(date("H:i:s",time()-2),$ta)) {
	$stats_check = true;
}
if (isset($_GET['sc'])) {
	$stats_check = true;
}
define("CRON",true);
$CT = "\r\nZadanie CRONA rozpoczete w " . date("H:i:s",time());
$result = DB::Query("SELECT * FROM `map_elements`");
while($row = DB::Fetch($result)) {
	
}

$worlds = World::worlds_list();
$C_server = $worlds[0];
require "world_common.inc.php";
$map = new Map(0,0);
if (DB::numrows("SELECT * FROM `map_elements`") < 500000) {
	$add = rand(10,25);
} else {
	$add = 0;
}
$map->newDecoration($add);
foreach ($worlds as $server) {
	$R = new DataReload($server,"mytw_world_{$server}");
	$R->FullReload();
	if ($stats_check===true) {
		$R->StatsCreate();
	}
}
$CT .= "\r\n Zadanie zakonczone w " . date("H:i:s",time());
$CT .= "\r\n Dodane krzaki: {$add}";
if ($stats_check===true) {
	$CT .= "\r\n Zaktualizowano statystyki!";
}
NewLog($CT,"CRON","/logs/cron.log");
?>