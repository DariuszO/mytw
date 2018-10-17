<?php
if(!defined("MyTW")) {
	exit;
}
/*
*	MapClass author: Felipe Medeiros
*/
class Map {
	var $villages = array();
	var $players = array();
	var $allies = array();
	var $allyRelations = array();
	var $Decorations = array();
	var $x;
	var $y;
	var $images = ['gras1','gras2','gras3','gras4','v1_left','v1','v2_left','v2','v3_left','v3','v4_left','v4','v5_left','v5','v6_left','v6','b1_left','b1','b2_left','b2','b3_left','b3','b4_left','b4','b5_left','b5','b6_left','b6','berg1','berg2','berg3','berg4','forest0000','forest0001','forest0010','forest0011','forest0100','forest0101','forest0110','forest0111','forest1000','forest1001','forest1010','forest1011','forest1100','forest1101','forest1110','forest1111','see','event_xmas','event_easter','ghost','event_merchant','event_wizard','event_easter2014','event_fall2014'];
	
	function Map($x, $y){
		$this->x = $x;
		$this->y = $y;
	}
	function addVillage($x, $y, $data){
		$this->villages[$x][$y] = $data;
	}
	function addDecorations($x, $y, $data){
		$this->Decorations[$x][$y] = $data;
	}
	function parseTiles(){
		$tiles = array();
		$c = 0;
		$Dec = new Decorations();
		$tiles = $Dec->make($this->x, $this->y, 20 , $this->Decorations);
		return $tiles;
	}
	function importPlayers($players){
		$this->players = $players;
	}
	function importAllies($allies){
		$this->allies = $allies;
	}
	function importAllyRelations($allyX){
		$this->allyRelations = $allyX;
	}
	function toJSON(){
		/* Parse each sector */
		$data = array();
		$data['x'] = $this->x;
		$data['y'] = $this->y;
		$data['tiles'] = $this->parseTiles();
		$data['data'] = array(
			'x' => $this->x,
			'y' => $this->y
		);
		$data['data']['villages'] = array();
		if(count($this->players) > 0){
			$data['data']['players'] = array();
			foreach($this->players as $player){
				$data['data']['players'][$player['id']] = [
					entparse($player['name']),
					str_replace(",",".",number_format($player['points'])),
					MyTW_or($player['ally'],"0",$player['ally'],"-1"),
					false,
					false
				];
			}
		}
		if(count($this->allies) > 0){
			$data['data']['allies'] = array();
			foreach($this->allies as $ally){
				$data['data']['allies'][$ally['id']] = array($ally['name'], format_number($ally['points']), $ally['short']);
			}
		}
		if(count($this->allyRelations) > 0){
			$data['data']['allyRelations'] = array();
			foreach($this->allyRelations as $ally_){
				$data['data']['allyRelations'][$ally_['from_ally']] = $ally_['type'];
			}
		}
		for($xP=0;$xP<20;$xP++){
			$xC = $this->x+$xP;
			$xField = strval($xP);
			$data['data']['villages'][$xField] = array();
			if(array_key_exists($xC, $this->villages)){
				foreach($this->villages[$xC] as $yC=>$v){
					$field = strval($yC-$this->y);
					$points = $v['points'];
					$gr = "";
					if ($v['bonus'] > 0) {
						$gr .= "b";
					} else {
						$gr .= "v";
					}
					$gr .= Village::graph($v['points']);
					if ($v['uid'] === "-1") {
						$gr .= "_left";
					}
					$graphic = array_search($gr,$this->images);
					$name = MyTW_or($v['uid'],0,entparse($v['name']),"-1");
					$data['data']['villages'][$xField][$field] = [
						$v['id'],
						$graphic,
						$name,
						number_format($v['points'],0,",","."),
						MyTW_or($v['uid'],0,$v['uid'],"-1"),
						"25",
						MyTW_or($v['bonus'],NULL,Bonus::view(["text","icon"],$v['bonus']),"0"),
						"0"
					];
				}
			}
		}
		return $data;
	}
	function newDecoration($number) {
		for($i=0;$i<=$number;$i++) {
			$rt = rand(1,4);
			if($rt===4) {
				$r = 3;
			} else {
				$r = rand(1,5);
				if ($r===5) {
					$r = 2;
				} else {
					$r = 1;
				}
			}
			$x = rand(0,999);
			$y = rand(0,999);
			$x1 = $x+1;
			$y1 = $y+1;
			if ($r===3) {
				$sql = DB::Query("SELECT `id` FROM `map_elements` WHERE (`x` = '{$x}' AND `y` = '{$y}') OR (`x` = '{$x1}' AND `y` = '{$y}') OR (`x` = '{$x}' AND `y` = '{$y1}') OR (`x` = '{$x1}' AND `y` = '{$y1}')",true);
				$sql2 = DB::Query("SELECT `id` FROM `mytw_world_pl1`.`villages` WHERE (`x` = '{$x}' AND `y` = '{$y}') OR (`x` = '{$x1}' AND `y` = '{$y}') OR (`x` = '{$x}' AND `y` = '{$y1}') OR (`x` = '{$x1}' AND `y` = '{$y1}')",true);
				if (DB::numrows($sql) < 1 || DB::numrows($sql1) < 1) {
					DB::Query("INSERT INTO `map_elements`(`x`,`y`,`type`) VALUES ('{$x}','{$y}','5')",true);
					DB::Query("INSERT INTO `map_elements`(`x`,`y`,`type`) VALUES ('{$x1}','{$y}','4')",true);
					DB::Query("INSERT INTO `map_elements`(`x`,`y`,`type`) VALUES ('{$x}','{$y1}','6')",true);
					DB::Query("INSERT INTO `map_elements`(`x`,`y`,`type`) VALUES ('{$x1}','{$y1}','3')",true);
				} else {
					$number++;
				}
			} else {
				$sql = DB::Query("SELECT `id` FROM `map_elements` WHERE `x` = '{$x}' AND `y` = '{$y}'");
				$sql2 = DB::Query("SELECT `id` FROM `mytw_world_pl1`.`villages` WHERE `x` = '{$x}' AND `y` = '{$y}'");
				if (DB::numrows($sql) < 1 || DB::numrows($sql1) < 1) {
					DB::Query("INSERT INTO `map_elements`(`x`,`y`,`type`) VALUES ('{$x}','{$y}','{$r}')");
				} else {
					$number++;
				}
			}
		}
		return $number;
	}
}

class Decorations {
	static $images = ['gras1','gras2','gras3','gras4','v1_left','v1','v2_left','v2','v3_left','v3','v4_left','v4','v5_left','v5','v6_left','v6','b1_left','b1','b2_left','b2','b3_left','b3','b4_left','b4','b5_left','b5','b6_left','b6','berg1','berg2','berg3','berg4','forest0000','forest0001','forest0010','forest0011','forest0100','forest0101','forest0110','forest0111','forest1000','forest1001','forest1010','forest1011','forest1100','forest1101','forest1110','forest1111','see','event_xmas','event_easter','ghost','event_merchant','event_wizard','event_easter2014','event_fall2014'];
	static function remakeTiles(&$tiles){
		foreach($tiles as $k1=>$xTile){
			foreach($xTile as $k2=>$mergeTile){
				$tiles[$k1][$k2] = array_search($mergeTile, self::$images);
			}
		}
	}
	static function make($thisx, $thisy, $range, $data){
		$tiles = array();
		for($x=0;$x<$range;$x++){
			for($y=0;$y<$range;$y++){
				if(isset($data[$x+$thisx][$y+$thisy])) {
					//$tiles[$x][$y] = $data[$x+$thisx][$y+$thisy];
					$tt = $data[$x+$thisx][$y+$thisy];
					if ($tt==="2") {
						$tiles[$x][$y] = "see";
					} elseif($tt>="3") {
						$berg = $tt-2;
						$tiles[$x][$y] = "berg{$berg}";
					} else {
						$IMG = "forest";
						if ($data[$thisx+$x][$thisy+$y+1]==="1") {
							$IMG .= "1";
						} else {
							$IMG .= "0";
						}
						if ($data[$thisx+$x-1][$thisy+$y]==="1") {
							$IMG .= "1";
						} else {
							$IMG .= "0";
						}
						if ($data[$thisx+$x][$thisy+$y-1]==="1") {
							$IMG .= "1";
						} else {
							$IMG .= "0";
						}
						if ($data[$thisx+$x+1][$thisy+$y]==="1") {
							$IMG .= "1";
						} else {
							$IMG .= "0";
						}
						
						$tiles[$x][$y] = $IMG;
					}
				} else {
					$tiles[$x][$y] = "gras".rand(1,4);
				}
			}
		}
		self::remakeTiles($tiles);
		return $tiles;
	}
}

/*
class Map {
	var $x;
	var $y;
	var $villages;
	var $players;
	var $allies;
	var $limit = 20;
	var $images = ['gras1','gras2','gras3','gras4','v1_left','v1','v2_left','v2','v3_left','v3','v4_left','v4','v5_left','v5','v6_left','v6','b1_left','b1','b2_left','b2','b3_left','b3','b4_left','b4','b5_left','b5','b6_left','b6','berg1','berg2','berg3','berg4','forest0000','forest0001','forest0010','forest0011','forest0100','forest0101','forest0110','forest0111','forest1000','forest1001','forest1010','forest1011','forest1100','forest1101','forest1110','forest1111','see','event_xmas','event_easter','ghost','event_merchant','event_wizard','event_easter2014','event_fall2014'];
	var $DB;
	var $tiles;
	var $vill;
	var $users;
	var $all;
	var $player;
	var $ally;
	
	function Map($server="") {
		if ($server==="") {
			$server = w;
		}
		$this->DB = "mytw_world_{$server}";
	}
	
	function coords($x,$y) {
		$this->x = $x;
		$this->y = $y;
		return true;
	}
	
	function villages() {
		$data = Array();
		/*
		*	"0":["58357",23,"wyzysk","7.598","698334175","25",["100% wi\u0119ksza produkcja gliny","bonus\/stone.png"],"0"]
		*
		$x = $this->x;
		$y = $this->y;
		$x2 = $x+$this->limit;
		$y2 = $y+$this->limit;
		$DB = $this->DB;
		$villages = Array();
		$result = DB::Query("SELECT * FROM `{$DB}`.`villages` WHERE `x` >= '{$x}' AND `y` >= '{$y}' AND `x` <= '{$x2}' AND `y` <= '{$y2}'",true);

		while($row = DB::fetch($result)) {
			$villages[$row['x']][$row['y']] = $row;
			$gr = "";
			if ($row['bonus'] > 0) {
				$gr .= "b";
			} else {
				$gr .= "v";
			}
			$gr .= Village::graph($row['points']);
			if ($row['uid'] === "-1") {
				$gr .= "_left";
			}
			$graphic[$row['id']] = array_search($gr,$this->images);
		}
		
		$count = [];
		$c = 0;
		$players = [];
		
		for($xxx=0;$xxx<$this->limit;$xxx++) {
			$acx = $x+$xxx;
			if (array_key_exists($acx,$villages)) {
				foreach($villages[$acx] as $yyy => $vill) {
					$field = $yyy-$this->y;
					$nd[$xxx][$field] = [
						$vill['id'],
						$graphic[$vill['id']],
						entparse($vill['name']),
						str_replace(",",".",number_format($vill['points'])),
						$vill['uid'],
						"25",
						MyTW_or($vill['bonus'],NULL,Bonus::view(["text","icon"],$vill['bonus']),"0"),
						"0"
					];
					$players[] = $vill["uid"];				
				}
				$data[] = $nd[$xxx];
			} else {
				$data[] = [];
			}
		}
		
		$this->player = $players;
		return $data;
	}/*"104355":["MarioY","1.094.166","7335",0,false,"0"]*
	
	function players() {
		$p = $this->player;
		$data = [];
		foreach($p as $uid) {
			$user = DB::fetch(DB::Query("SELECT * FROM `{$this->DB}`.`users` WHERE `id` = '{$uid}'"));
			$data[$uid] = [
				entparse($user['name']),
				str_replace(",",".",number_format($user['points'])),
				MyTW_or($user['ally'],"0",$user['ally'],"-1"),
				false,
				"0"
			];
		}
		return $data;
	}
	function tiles() {
		$data = Array();
		$x = $this->x;
		$y = $this->y;
		$startX = $x-1;
		$startY = $y-1;
		$x2 = $x+$this->limit;
		$y2 = $y+$this->limit;
		$endX = $x2+1;
		$endY = $y2+1;
		$tiles = Array();
		$t = Array();
		$result = DB::Query("SELECT * FROM `map_elements` WHERE `x` >= '{$startX}' AND `y` >= '{$startY}' AND `x` <= '{$endX}' AND `y` <= '{$endY}'");

		while($row = DB::fetch($result)) {
			$tiles[$row['x']][$row['y']] = $row['type'];
			if ($row['berg']==="1") {
				$berg = 3;
			} elseif ($row['berg']==="2") {
				$berg = 4;
			} elseif ($row['berg']==="3") {
				$berg = 1;
			} else {
				$berg = 2;
			}
			$t[$row['x']][$row['y']] = $berg;
		}
		for($xxx=$x;$xxx<=$x2;$xxx++) {
			for($yyy=$y;$yyy<=$y2;$yyy++) {
				if (isset($tiles[$xxx][$yyy])) {
					$tt = $tiles[$xxx][$yyy];
					if ($tt==="2") {
						$td[] = array_search("see",$this->images);
					} elseif($tt==="3") {
						if ($t[$xxx][$yyy] > 0) {
							$td[] = array_search("berg{$t[$xxx][$yyy]}",$this->images);
						} else {
							$td[] = array_search("gras2",$this->images);
						}
					} else {
						$IMG = "forest";
						if (isset($tiles[$xxx][$yyy+1]) && $tiles[$xxx][$yyy+1]==="1") {
							$IMG .= "1";
						} else {
							$IMG .= "0";
						}
						if (isset($tiles[$xxx-1][$yyy]) && $tiles[$xxx-1][$yyy]==="1") {
							$IMG .= "1";
						} else {
							$IMG .= "0";
						}
						if (isset($tiles[$xxx][$yyy-1]) && $tiles[$xxx][$yyy-1]==="1") {
							$IMG .= "1";
						} else {
							$IMG .= "0";
						}
						if (isset($tiles[$xxx+1][$yyy]) && $tiles[$xxx+1][$yyy]==="1") {
							$IMG .= "1";
						} else {
							$IMG .= "0";
						}
						$td[] = array_search($IMG,$this->images);
					}
				} else {
					if($xxx%10!==0&&$yyy%10===0) {
						$GI = 2;
					} elseif($xxx%5===0&&$yyy%5!==0) {
						$GI = 3;
					} else {
						$GI = 1;
					}
					$td[] = array_search("gras{$GI}",$this->images);
				}
			}
			$data[] = $td;
			$td = Array();
		}
		
		return $data;
	}
	
	function create($xy=[]) {
		$data = Array();
		$x = $this->x;
		$y = $this->y;
		$sx = $x;
		$sy = $y;
		$this->tiles = $this->tiles();
		$this->vill = $this->villages();
		$this->users = $this->players();
		$dd = [
			"x" => $x,
			"y" => $y,
			"tiles" => $this->tiles
		];
		if (count($xy) > 0) {
			foreach($xy as $xx => $yy) {
				$this->x = $xx;
				$this->y = $yy;
				$this->tiles = $this->tiles();
				$this->vill = $this->villages();
				$this->users = $this->players();
				$dd["dataSP_{$xx}_{$yy}"] = [
					"x" => $xx,
					"y" => $yy		
				];
				if ($sx!==$xx && $sy!==$yy) {
					$dd["dataSP_{$xx}_{$yy}"]["tiles"] = $this->tiles;
				}
				$dd["dataSP_{$xx}_{$yy}"]["villages"] = $this->vill;
				$dd["dataSP_{$xx}_{$yy}"]["players"] = $this->users;
			}
		}
		$data[] = $dd;
		return $data;
	}
}*/
?>