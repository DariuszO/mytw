<?php

class Sid {

	var $vacation = false;

	var $DB = "mytw_index";
	
	function new_db($DB) {
		return $this->DB = $DB;
	}
	
	function update_sid($uid) {
		$newsid = random(40);
		return DB::Query("UPDATE `users` SET `session` = '{$newsid}' WHERE `id` = '{$uid}'");
	}

	function logout($uid) {
		$DB = $this->DB;
		return DB::Query("DELETE FROM `{$DB}`.`sessions` WHERE `uid` = '{$uid}'");
	}
	
	function vacation() {
		return $this->vacation;
	}
	
	function new_sid($uid,$sid,$hkey,$vacation=false) {
		$DB = $this->DB;
		return DB::Query("INSERT INTO `{$DB}`.`sessions`(`uid`,`sid`,`hkey`,`vacation`) VALUES ('{$uid}','{$sid}','{$hkey}','".MyTW_or($vacation,"1","0",true)."')",true);
	}
	
	function check_sid($sid) {
		$DB = $this->DB;
		$row = DB::fetch(DB::Query("SELECT * FROM `{$DB}`.`sessions` WHERE `sid` = '{$sid}'"));
		if ($row['id'] < 1) {
			return false;
		} else {
			if ($row['vacation']===1) {
				$this->vacation = true;
			}
			return $row;
		}
	}
	
	function clear_sessions() {
		$DB = $this->DB;
		return DB::Query("TRUNCATE TABLE `{$DB}`.`sessions`");
	}
}
?>