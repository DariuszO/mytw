<?php
if(!defined("MyTW")) {
	exit;
}

class User {
	static $_SERVER = w;
	static $DB = "";
	
	static function DB($DB) {
		self::$DB = $DB;
	}
	
	static function Update($uid,$configs,$values) {
		$Q = "UPDATE `". self::$DB ."`.`users` SET ";
		$counter = 0;
		if (is_array($configs)) {
			foreach ($configs as $conf) {
				if (!isset($values[$counter])) {
					return false;
				}
				$Q .= "`{$conf}` = '{$values[$counter]}'";
				$counter++;
				if ($counter < count($configs)) {
					$Q .= ", ";
				}
			}
		} else {
			$Q .= "`{$configs}`";
		}
		if (!is_array($values)) {
			$Q .= " = '{$values}'";
		}
		$Q .= " WHERE `id` = '{$uid}'";
		return DB::Query($Q);
	}
	
	static function get($uid) {
		$DB = self::$DB;
		return DB::Fetch(DB::Query("SELECT * FROM `{$DB}`.`users` WHERE `id` = '{$uid}'"));
	}
	
	static function get_status($uid) {
		$user = User::get($uid);
		if ($user['last_active'] <= time()+60) {
			return ["online","green","Aktywny"];
		} else {
			return ["offline","red","Nieaktywny"];
		}
	}
	
	static function name($uid,$pid,$URL="/game.php",$template="<a href=\"{URL}\">{FRIEND_STATUS} {NAME}</a>") {
		global $village;
		$DB = self::$DB;
		$uinfo = User::get($uid);
		$user = User::get($pid);
		$fcheck = DB::Fetch(DB::Query("SELECT * FROM `{$DB}`.`friends` WHERE (`from` = '{$uid}' AND `to` = '{$pid}') OR (`to` = '{$uid}' AND `from` = '{$pid}')"));
		if ($fcheck['accept']==="Y") {
			$status = User::get_status($uid);
			$FRIEND_STATUS = "<img src=\"/graphic/stat/{$status[1]}.png\" alt=\"{$status[2]}\"/>";
		} else {
			$FRIEND_STATUS = "";
		}
		$URL .= "?village={$village['id']}&id={$uid}&screen=info_player";
		$NAME = entparse($uinfo['name']);
		$ch = [
			[
				"{URL}",
				"{FRIEND_STATUS}",
				"{NAME}"
			],
			[
				$URL,
				$FRIEND_STATUS,
				$NAME
			]
		];
		return str_replace($ch[0],$ch[1],$template);
	}
}
User::DB("mytw_world_{$server}");
?>