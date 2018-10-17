<?php
/*
*	map.php
*	My-TW by Bartekst222
*/
require_once "./libraries/common.inc.php";

require_once PATH . "/libraries/world_common.inc.php";

$include = array();
foreach($_GET as $k=>$v){
	if(strpos($k, '_') !== FALSE){
		$parts = explode('_', $k);
		if(count($parts) > 2)
			die("Failure x1");
		$x = intval($parts[0]);
		$y = intval($parts[1]);

		$include[] = array($x, $y);
	}
}
$json = array();
foreach($include as $pair){
	$map = new Map($pair[0], $pair[1]);
	$players = array();
	//$map->newDecoration(10);
	$endX = ($pair[0]+20);
	$endY = ($pair[1]+20);
	$tiles_c = [$pair[0]-1,$pair[1]-1,$endX+1,$endY+1];
	$result = DB::Query("SELECT * FROM `map_elements` WHERE `x` >= '{$tiles_c[0]}' AND `y`>= '{$tiles_c[1]}' AND `x`<= '{$tiles_c[2]}' AND `y`<= '{$tiles_c[3]}'");
	while($row = DB::fetch($result)) {
		$map->addDecorations($row['x'] , $row['y'] , $row['type']);
	}
	
	$villages = array();
	$result = DB::query("SELECT `id` FROM `{$DB}`.`villages` WHERE `x`>='".$pair[0]."' AND `y`>='".$pair[1]."' AND `x`<='".$endX."' AND `y`<='".$endY."'");
	while($row = DB::fetch($result)){
		$data = DB::fetch(DB::query("SELECT * FROM `{$DB}`.`villages` WHERE `id`='".$row['id']."'"));
		$villages[] = $data;
		if (!in_array($data['uid'],$players) && $data['uid']!=="-1") {
			$players[] = $data['uid'];
		}
	}
	foreach($villages as $village){
		$map->addVillage($village['x'], $village['y'], $village);
	}
	$transformP = array();
	foreach($players as $player){
		$user = DB::fetch(DB::Query("SELECT * FROM `{$DB}`.`users` WHERE `id` = '{$player}'"));
		if($user['ally'] != -1)	$allies[] = $user['ally'];
		$transformP[] = $user;
	}
	$map->importPlayers($transformP);

	if($allies){
		$transformA = array();
		foreach($allies as $ally){
			if(!empty($ally)){
				$result = DB::query("SELECT `name`,`points`,`short` FROM `{$DB}`.`ally` WHERE `id`='".$ally."'");
				$row = DB::fetch($result);
				$ally_ = ($row) != array() ? $row : false;
				$transformA[] = array(
					'id' => $ally, 
					'name' => entparse($ally_['name']), 
					'points' => $ally_['points'],
					'short' => $ally_['short']
				);
			}
		}
		$map->importAllies($transformA);
	}
	$json[] = $map->toJSON();
}
$json = json_encode($json);
header('Content-Type: application/json;');
exit($json);
?>