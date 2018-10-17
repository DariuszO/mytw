<?php
if(!defined("MyTW")) {
	exit;
}

class DataReload {
	var $DB = NULL;
	var $server = NULL;
		
	function DataReload($server,$DB) {
		global $cl_builds;
		$this->DB = $DB;
		$this->server = $DB;
		$this->cl_builds = $cl_builds;
		return true;
	}
	
	function villages_check_own() {
		$i = 0;
		$result = DB::Query("SELECT * FROM `{$this->DB}`.`villages`");
		while($row = DB::Fetch($result)) {
			$ucheck = DB::numrows(DB::Query("SELECT `id` FROM `{$this->DB}`.`users` WHERE `id` = '{$row['uid']}'"));
			if ($ucheck!==1) {
				$name = parse("");
				DB::Query("UPDATE `{$this->DB}`.`villages` SET `uid` = '-1' , `name` = '{$name}' WHERE `id` = '{$row['id']}'");
				$i++;
			}
		}
		return $i;
	}	
	
	function VillagePoints($vill) {
		$points = 0;
		foreach ($this->cl_builds->get_array("dbname") as $build) {
			if ($vill[$build] > 0) {
				$points += $this->cl_builds->get_points($build,$vill[$build]);
			}
		}
		DB::Query("UPDATE `{$this->DB}`.`villages` SET `points` = '{$points}' WHERE `id` = '{$vill['id']}'");
		return $points;
	}
	
	function BarbianReload() {
		$points = 0;
		$result = DB::Query("SELECT * FROM `{$this->DB}`.`villages` WHERE `uid` = '-1'");
		while($row = DB::fetch($result)) {
			$points += $this->VillagePoints($row);
		}
		return $points;
	}
	
	function PlayerPoints($user) {
		$points = 0;
		$villages = 0;
		$result = DB::Query("SELECT * FROM `{$this->DB}`.`villages` WHERE `uid` = '{$user['id']}'");
		while($row = DB::fetch($result)) {
			$points += $this->VillagePoints($row);
			$villages++;
		}
		return [$points,$villages];
	}
	
	function PlayerReload() {
		$rank = 0;
		$result = DB::Query("SELECT * FROM `{$this->DB}`.`users`");
		$total_points = 0;
		$up = Array();
		while($row = DB::fetch($result)) {
			$up[$row['id']] = $this->PlayerPoints($row);
			$total_points += $up[$row['id']][0];
			DB::Query("UPDATE `{$this->DB}`.`users` SET `points` = '{$up[$row['id']][0]}' , `villages` = '{$up[$row['id']][1]}' WHERE `id` = '{$row['id']}'");
		}
		$result = DB::Query("SELECT * FROM `{$this->DB}`.`users` ORDER BY `points` DESC");
		while($row = DB::fetch($result)) {
			$rank++;
			DB::Query("UPDATE `{$this->DB}`.`users` SET `rank` = '{$rank}' WHERE `id` = '{$row['id']}'");
		}
		return [$total_points,$rank];
	}
	
	function StatsCreate($WHERE_u="",$WHERE_a="") {
		/* USERS */
		$result = DB::Query("SELECT * FROM `{$this->DB}`.`users` {$WHERE_u}");
		while($row = DB::Fetch($result)) {
			$time = time();
			DB::Query("INSERT INTO `{$this->DB}`.`stats`(`own_id`,`type`,`time`,`value`) VALUES ('{$row['id']}','1','{$time}','{$row['points']}')");
			DB::Query("INSERT INTO `{$this->DB}`.`stats`(`own_id`,`type`,`time`,`value`) VALUES ('{$row['id']}','2','{$time}','{$row['villages']}')");
		}
		/* ALLY: */
		$result = DB::Query("SELECT * FROM `{$this->DB}`.`ally` {$WHERE_a}");
		while($row = DB::Fetch($result)) {
			$time = time();
			DB::Query("INSERT INTO `{$this->DB}`.`stats`(`own_id`,`type`,`time`,`value`) VALUES ('{$row['id']}','3','{$time}','{$row['points']}')");
		}		
	}
	
	function FullReload() {
		return [$this->PlayerReload(),$this->BarbianReload(),$this->villages_check_own()];
	}
}
?>