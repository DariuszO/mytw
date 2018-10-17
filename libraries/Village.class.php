<?php
if(!defined("MyTW")) {
	exit;
}

class Village {

	static function continent($x,$y) {
	    $x_k = floor($x/100);
		$y_k = floor($y/100);
		$k = $y_k.$x_k;
		return $k;
	}
	
	static function getrandomxyforcircle($circle,$direction,$server) {
		global $cfg;
		$DB = "mytw_world_".$server;
		$conf = World::configs($server);
		if ($circle > 703) {
			$circle = 703;
		}		
		$directions = array('sw'=>[90001,180000],'nw'=>[180001,270000],'so'=>[0,90000],'no'=>[270001,360000],'r'=>[0,360000]);
			
		if (!array_search($direction,$directions)) {
			$direction = 'r';
		}
			
		$c = 1;
		for($i = 1; $i <= $c ; $i++) {
			$rand = mt_rand($directions[$direction][0],$directions[$direction][1]);
			$rand /= 1000;
			$x = round(cos($rand * M_PI / 180) * $circle) + 500;
			$y = round(sin($rand * M_PI / 180) * $circle) + 500;
			$x += mt_rand(-6,6);
			$y += mt_rand(-6,6);
			if ($x > 999 || $y > 999 || $x < 0 || $y < 0) {
				if ($c < 4000) {
					$c += 1;
					World::update_conf("villages_circle",$conf['villages_circle']+1,$server);
				}
			} else {		
				$cnt = DB::fetch(DB::Query("SELECT COUNT(id) FROM `{$DB}`.`villages` WHERE `x` = '$x' AND `y` = '$y' LIMIT 1",true))[0];		
				if ($cnt > 0) {
					if ($c < 4500) {
						$c += 1;
					}			   
				} else {
					$cnt = DB::fetch(DB::Query("SELECT COUNT(id) FROM `map_elements` WHERE `x` = '$x' AND `y` = '$y' LIMIT 1"))[0];		
					if ($cnt > 0) {
						if ($c < 5000) {
							$c += 1;
						}	
					} else {
						World::update_conf("villages_circle",$conf['villages_circle']+1,$server);
						return [$x,$y];
					}
				}
			}
		}
	}

	static function create_new($uid,$server,$number,$name,$direction="r",$is_first=false) {
		global $cfg;
		
		if (empty($direction) OR $direction===false) {
			$direction = "r";
		}		
		
		$DB = "mytw_world_{$server}";
		
		$conf = World::configs($server);
		if ($number < 1) {
			$number = 1;
		}
		if ($number > 15000) {
			$number = 15000;
		}
		
		$time = time();
		
		$minus = 0;
		
		for($i=1;$i<=$number;$i++) {
			if ($conf['villages_circle'] > ($conf['circle'] * 1.75) && $conf['circle'] < 705) {
				World::update_conf(["villages_circle","circle"],[0,$conf['circle']+1],$server);
			}
			if ($conf['circle'] < 705) {
				$coords = Village::getrandomxyforcircle($conf['circle'],$direction,$server);
				if (strlen($coords[0])  > 0 && strlen($coords[1]) > 0) {
					$continent = (int)Village::continent($coords[0],$coords[1]);
					
					$bonus = 0;
					
					$rand_bonus = mt_rand(0,5);
					if ($rand_bonus == 3 && $uid == '-1' && $conf['bonus_villages']===1) {
						$bonus = mt_rand(1,9);
					}
					if ($uid == '-1') {
						if ($bonus===0) {
							$name = "Wioska barbarzyńska";
						} else {
							$name = "Osada koczownicza";
						}
					}
					$name = parse($name);
					$is_first = MyTW_or($is_first,1,0,true);
					DB::Query("INSERT INTO `{$DB}`.`villages`(`uid`,`name`,`is_first`,`x`,`y`,`continent`,`create_time`,`reload_time`,`bonus`) VALUE('{$uid}','{$name}','{$is_first}','{$coords[0]}','{$coords[1]}','{$continent}','{$time}','{$time}','{$bonus}')",true);
					$lastid = DB::fetch(DB::Query("SELECT `id` FROM `{$DB}`.`villages` ORDER BY `id` DESC LIMIT 1",true))[0];
					DB::Query("INSERT INTO `{$DB}`.`unit_place`(`from`,`to`) value('{$lastid}','{$lastid}')",true);
					$is_first = 0;
				} else {
					$minus++;
				}
			}
		}
		
		$number -= $minus;
		
		if ($uid != "-1") {
			$pointsadd = $number * $conf["start_points"];
			DB::Query("UPDATE `{$DB}`.`users` SET `points` = `points` + '{$pointsadd}' , `villages` = `villages` + '{$number}' WHERE `id` = '{$uid}'");
		}
		World::update_conf("all_villages",$conf['all_villages']+$number,$server);
		
		return $number;
	}
	
	static function get_first($uid,$server="") {
		if (empty($server)) {
			$server = w;
		}
		$DB = "mytw_world_{$server}";
		$sql = DB::Query("SELECT * FROM `{$DB}`.`villages` WHERE `uid` = '{$uid}' LIMIT 1");
		$check = DB::numrows($sql);
		if ($check != 1) {
			return false;
		} else {
			return DB::fetch($sql)['id'];
		}
	}
	
	static function get($id,$server="") {
		if (empty($server)) {
			$server = w;
		}
		$DB = "mytw_world_{$server}";
		$sql = @DB::Query("SELECT * FROM `{$DB}`.`villages` WHERE `id` = '{$id}'");
		$check = @DB::numrows($sql);
		if ($check != 1) {
			return false;
		} else {
			return @DB::fetch($sql);
		}
	}
	
	static function production($vid,$server="") {
		if (empty($server)) {
			$server = w;
		}
		$DB = "mytw_world_{$server}";
		$village = Village::get($vid,$server);
		
		$conf = World::configs($server);
		
		$production_ph = [5,30,35,41,47,55,64,74,86,100,117,136,158,184,214,249,289,337,391,455,530,616,717,833,969,1127,1311,1525,1774,2063,2400];
		$bonus = [1,1,1];
		if ($village['bonus']===2) {
			$bonus[0] = 1.33;
			$bonus[1] = 1.33;
			$bonus[2] = 1.33;
		}
		if ($village['bonus']===3) {
			$bonus[0] = 2;
		}
		if ($village['bonus']===4) {
			$bonus[1] = 2;
		}
		if ($village['bonus']===5) {
			$bonus[2] = 2;
		}
	
		$return['per_hour']['wood'] = floor($production_ph[$village['wood']]*$conf['speed']*$bonus[0]);
		$return['per_hour']['stone'] = floor($production_ph[$village['stone']]*$conf['speed']*$bonus[1]);
		$return['per_hour']['iron'] = floor($production_ph[$village['iron']]*$conf['speed']*$bonus[2]);
		
		$return['per_second']['wood'] = $return['per_hour']['wood']/3600;
		$return['per_second']['stone'] = $return['per_hour']['stone']/3600;
		$return['per_second']['iron'] = $return['per_hour']['iron']/3600;
		
		return $return;
	}
	
	static function res_reload($vid,$server="") {
		if (empty($server)) {
			$server = w;
		}
		$DB = "mytw_world_{$server}";
		$village = Village::get($vid,$server);
		
		$conf = World::configs($server);
		$prod = Village::production($village['id'],$server);	
		$last_reload = $village['reload_time'];
		$time = time();
		$storage_max = Village::storage($vid,$server);
		
		$prod = Village::production($vid,$server);
		
		if ($last_reload !== $time) {
			$prod_x = $time - $last_reload;
			$add = [
				"wood" => $village['wood_float'] + $prod['per_second']['wood'] * $prod_x,
				"stone" => $village['stone_float'] + $prod['per_second']['stone'] * $prod_x,
				"iron" => $village['iron_float'] + $prod['per_second']['iron'] * $prod_x
			];
			if ($add['wood'] > $storage_max) {
				$add['wood'] = $storage_max;
			}
			if ($add['stone'] > $storage_max) {
				$add['stone'] = $storage_max;
			}
			if ($add['iron'] > $storage_max) {
				$add['iron'] = $storage_max;
			}
			DB::Query("UPDATE `{$DB}`.`villages` SET `wood_float` = '{$add['wood']}' , `stone_float` = '{$add['stone']}' , `iron_float` = '{$add['iron']}' , `reload_time` = '{$time}' WHERE `id` = '{$village['id']}'");
		}
		return [$add['wood'],$add['stone'],$add['iron']];
	}
	
	static function storage($vid,$server="") {
		if (empty($server)) {
			$server = w;
		}
		$conf = World::configs($server);
		$village = Village::get($vid,$server);
		$storage_bonus = 1;

		if ($village['bonus']===1) {
			$storage_bonus = 1.5;
		}

		return $conf['storage'][$village['storage']]*$storage_bonus;
	}
	
	static function pop($vid,$server="") {
		if (empty($server)) {
			$server = w;
		}
		$conf = World::configs($server);
		$village = Village::get($vid,$server);
		$pop_bonus = 1;

		if ($village['bonus']===9) {
			$pop_bonus = 1.1;
		}

		return $conf['farm'][$village['farm']]*$pop_bonus;
	}
	
	static function graph($points) {
		if ($points >= 0 xor 299 <= $points) {
			$gr = 1;
		} elseif ($points >= 300 xor 999 <= $points) {
			$gr = 2;
		} elseif ($points >= 1000 xor 2999 <= $points) {
			$gr = 3;
		} elseif ($points >= 3000 xor 8999 <= $points) {
		    $gr = 4;
		} elseif ($points >= 9000 xor 10999 <= $points) {
		    $gr = 5;
		} elseif ($points >= 11000) {
			$gr = 6;
		}
		return $gr;
	}
}
?>