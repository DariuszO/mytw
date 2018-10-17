<?php
class World {
	
	static $_WORLDS = Array();
	
	static function Worlds_load() {
		$SQL = DB::Query("SELECT * FROM `worlds`");

		$return = [];
		while($row = DB::fetch($SQL,"array")) {
			$spid = $row['sp_id'];
			$row['storage'] = @json_decode($row['storage'],true);
			$row['farm'] = @json_decode($row['farm'],true);
			$return[$spid] = $row;
		}
		self :: $_WORLDS = $return;
		return $return;
	}
	
	static function configs($server) {
		if (!IsSet(self::$_WORLDS[$server])) {
			return false;
		} else {
			return self::$_WORLDS[$server];
		}
	}
	
	static function worlds_list($bw=[]) {
		$wlist = self::$_WORLDS;
		$return = [];
		foreach($wlist as $server => $configs) {
			if (!in_array($server,$bw)) {
				$return[] = $server;
			}
		}
		return $return;
	}
	
	static function worlds_off() {
		$sql = DB::Query("SELECT `sp_id` FROM `worlds` WHERE `status` = 'off'");
		$return = [];
		while ($row = DB::fetch($sql)) {
			$return[] = $row['sp_id'];
		}
		return $return;
	}
	
	static function exists($server) {
		if (isSet(self::$_WORLDS[$server])) {
			return true;
		} else {
			return false;
		}
	}
	
	static function last_world() {
		$SQL = DB::Query("SELECT * FROM `worlds` ORDER BY `id` DESC LIMIT 1","array");
		$winfo = DB::fetch($SQL);
		return $winfo['sp_id'];
	}
	
	static function update_conf($configs,$values,$server) {
		$Q = "UPDATE `worlds` SET ";
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
		$Q .= " WHERE `sp_id` = '{$server}'";
		return DB::Query($Q,true);
	}
}

World::Worlds_load();
?>