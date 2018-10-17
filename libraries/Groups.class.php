<?php
if(!defined("MyTW")) {
	exit;
}

class Groups {
	
	static function villlist($gid,$server="") {
		if ($server==="") {
			$server = world;
		}
		$DB = "mytw_world_{$server}";
		$gjson = json_encode([$gid]);
		$result = DB::Query("SELECT * FROM `{$DB}`.`villages` WHERE `groups` REGEXP '{$gjson}' ORDER BY `name`");
		return $result;
	}
	
	static function addvill($gid,$vid,$server="") {
		if ($server==="") {
			$server = world;
		}
		$DB = "mytw_world_{$server}";
		$vill = Village::get($vid,$server);
		$groups = @json_decode($vill['groups'],true);
		$groups[] = [$gid];
		$groups = array_unique($groups);
		$groups = @json_encode($groups);
		$Q = DB::Query("UPDATE `{$DB}`.`villages` SET `groups` = '{$groups}' WHERE `id` = '{$vid}'");
		return $Q;
	}
	
	static function groupdel($gid,$server="") {
		if ($server==="") {
			$server = world;
		}
		$DB = "mytw_world_{$server}";
		$vills = Groups :: villlist($gid,$server);
		$where = "WHERE ";
		while($row = $vills) {
			$ng = json_decode($row['groups'],true);
			$gin = array_search([$gid]);
			unset($ng[0][$gin]);
			$ng = json_encode($ng);
			DB::Query("UPDATE `{$DB}`.`villages` SET `groups` = '{$ng}' WHERE `id` = '{$row['id']}'");
		}
		DB::Query("DELETE FEOM `groups` WHERE `id` = '{$gid}'");
	}
	
	static function exists($gid,$uid,$server="") {
		if ($server==="") {
			$server = world;
		}
		$DB = "mytw_world_{$server}";
		$c = DB::numrows(DB::Query("SELECT * FROM `{$DB}`.`groups` WHERE `id` = '{$gid}' AND `uid` = '{$uid}'"));
		if ($c===1) {
			return true;
		} else {
			return false;
		}
	}
}
?>