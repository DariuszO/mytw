<?php
require_once "./libraries/common.inc.php";
require_once "./libraries/world_common.inc.php";
/*
$el = 14999;
$start = time();
for($i;$i<=$el;$i++) {
	$x = rand(0,999);
	$y = rand(0,999);
	$x1 = $x++;
	$y1 = $y++;
	if ($x1 > 999 || $y1 > 999) {
		$type = 3;
	}
	$check = DB::numrows(DB::Query("SELECT * FROM `map_elements` WHERE `x` = '{$x}' AND `y` = '{$y}'"));
	if ($check > 0) {
		$el++;
	} else {
		$check = DB::numrows(DB::Query("SELECT * FROM `mytw_world_pl1`.`villages` WHERE `x` = '{$x}' AND `y` = '{$y}'"));
		if ($check > 0) {
			$el++;
		} else {
			$rt = rand(1,7);
			if ($rt===6) {
				$type = 2;
			} elseif ($rt===5 && $type !== 3) {
				$type = 3;
				$check1 = DB::numrows(DB::Query("SELECT * FROM `mytw_world_pl1`.`villages` WHERE `x` = '{$x1}' AND `y` = '{$y}'"));
				$check2 = DB::numrows(DB::Query("SELECT * FROM `mytw_world_pl1`.`villages` WHERE `x` = '{$x1}' AND `y` = '{$y1}'"));
				$check3 = DB::numrows(DB::Query("SELECT * FROM `mytw_world_pl1`.`villages` WHERE `x` = '{$x}' AND `y` = '{$y1}'"));
				$check4 = DB::numrows(DB::Query("SELECT * FROM `map_elements` WHERE `x` = '{$x1}' AND `y` = '{$y}'"));
				$check5 = DB::numrows(DB::Query("SELECT * FROM `map_elements` WHERE `x` = '{$x}+1' AND `y` = '{$y1}'"));
				$check6 = DB::numrows(DB::Query("SELECT * FROM `map_elements` WHERE `x` = '{$x}' AND `y` = '{$y1}'"));
				if ($check1 > 0 ||$check2 > 0 ||$check3 > 0 ||$check4 > 0 ||$check5 > 0 ||$check6 > 0) {
					$el++;
				} else {
					DB::Query("INSERT INTO `map_elements`(`x`,`y`,`type`,`berg`) VALUES('{$x}','{$y}','{$type}','3')",true);
					DB::Query("INSERT INTO `map_elements`(`x`,`y`,`type`,`berg`) VALUES('{$x1}','{$y}','{$type}','2')",true);
					DB::Query("INSERT INTO `map_elements`(`x`,`y`,`type`,`berg`) VALUES('{$x}','{$y1}','{$type}','4')",true);
					DB::Query("INSERT INTO `map_elements`(`x`,`y`,`type`,`berg`) VALUES('{$x1}','{$y1}','{$type}','1')",true);
					$Q = true;
				}
			} else {
				$type = 1;
			}
			if ($Q !== true) {
				DB::Query("INSERT INTO `map_elements`(`x`,`y`,`type`) VALUES('{$x}','{$y}','{$type}')",true);
			}
			$Q = false;
		}
	}
	$ok++;
}*/
//DB::Query("INSERT INTO `announcements`(`id`, `text`, `time`, `lock`, `admin_id`, `url`) VALUES (NULL,'". parse("Layout gry został zamieniony na nowy! Trwają teraz prace nad rejestracją oraz dokończeniem nowego wyglądu strony głównej. Na światy już można się logować.") ."',". time() .",'N','-1','http://mpcforum.pl/topic/1334314-nowy-silnik-mytw/')",true);

$us = $cl_units->get_array("dbname");
foreach ($us as $u) {
	DB::Query("ALTER TABLE `mytw_world_pl1`.`villages` ADD `tech_{$u}` ENUM( '1','0' ) NOT NULL DEFAULT '0'",true);
}
?>