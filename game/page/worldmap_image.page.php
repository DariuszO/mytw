<?php
/*
*	Minimap
*	Author: Bartekst222
*/

function sid_wrong() {
	header("LOCATION: /sid_wrong.php");
}

if (isset($_GET['map_elements'])) {
	$MM = new Map(0,0);
	$MM->newDecoration($_GET['map_elements']);
}
$session = $_COOKIE['session'];
$hkey = $_COOKIE['hkey'];
$user_glob = @DB::fetch(@DB::Query("SELECT * FROM `users` WHERE `session` = '{$session}' LIMIT 1"));

if ($user_glob===false) {
	sid_wrong();
} else {
	$sid->new_db($DB);
	$sess = $sid->check_sid($session);
	if ($sess===false) {
		sid_wrong();
	} else {
		$user = DB::fetch(@DB::Query("SELECT * FROM `{$DB}`.`users` WHERE `id` = '{$sess['uid']}' LIMIT 1"));
		if ($user===false) {
			sid_wrong();
		}
	}
}

$data = new stdClass();
$data->map_elements = [];
$data->villages = [];
$data->players = [];
$data->allies = [];
$data->p = [];
$data->info = [];
$data->info['barbarian'] = MyTW_or($_GET['barbarian'],true,false,"true");
$data->info['ally'] = MyTW_or($_GET['ally'],true,false,"true");
$data->info['partner'] = MyTW_or($_GET['partner'],true,false,"true");
$data->info['nap'] = MyTW_or($_GET['nap'],true,false,"true");
$data->info['enemy'] = MyTW_or($_GET['enemy'],true,false,"true");

$startX = 0;
$startY = 0;
$endX = 999;
$endY = 999;

$img = ImageCreate(998,998);

$colors = new stdClass();
$colors->background = imagecolorallocate($img,88,118,27);
$colors->black = imagecolorallocate($img, 0, 0, 0);
$colors->border = imagecolorallocate($img, 50, 76, 5);
$colors->outside = imagecolorallocate($img, 74, 102, 35);
$colors->px = imagecolorallocate($img, 73, 103, 21);
$colors->element = imagecolorallocate($img, 74, 102, 35);
$colors->gray = imagecolorallocate($img, 150, 150, 150);
$colors->white = imagecolorallocate($img, 255, 255, 255);
$colors->blue = imagecolorallocate($img, 0, 0, 244);
$colors->player = imagecolorallocate($img, 240, 200, 0);
$colors->other = imagecolorallocate($img, 130, 60, 10);

$result = DB::Query("SELECT * FROM `{$DB}`.`villages` WHERE `x` > '{$startX}' AND `y` > '{$startY}' AND `x` < '{$endX}' AND `y` < '{$endY}'",true);
while($row = DB::fetch($result)) {
	$data->villages[$row['x']."|".$row['y']] = $row;
	if ($row['uid']!=="-1" && $row['event_village']!=="1") {
		$players[] = $row['uid'];
	}
}

foreach ($players as $pid) {
	$player = DB::fetch(DB::Query("SELECT * FROM `{$DB}`.`users` WHERE `id` = '{$pid}'"));
	$data->players[$pid] = $player;
	if ($player['ally']!=="1") {
		$allies[] = $player['ally'];
	}
}

foreach ($allies as $aid) {
	$ally = DB::fetch(DB::Query("SELECT * FROM `{$DB}`.`ally` WHERE `id` = '{$aid}'"));
	$data->allies[$aid] = $ally;
}
for ($x=$startX;$x<$endX;$x++) {
	for($y=$startY;$y<$endY;$y++) {
		if ($x%100===0) {
			imageline($img, $x-1, 0, $x-1, 1000, $colors->black);
		} elseif ($y%100===0) {
			imageline($img, 0, $y-1, 1000, $y-1, $colors->black);
		}
		if (isset($data->villages[$x."|".$y])) {
			$v = $data->villages[$x."|".$y];
			if ($v['uid']==="-1") {
				if ($data->info['barbarian']===true) {
					$color[$x][$y] = "gray";
				}
			} else {
				if ($v['uid']===$user['id']) {
					$color[$x][$y] = "yellow";
				} else {
					$vown = User::get($v['uid']);
					if ($vown['ally']===$user['ally'] && $user['ally']!=="-1") {
						if ($data->info['ally']===true) {
							$color[$x][$y] = "blue";
						} else {
							$color[$x][$y] = "other";
						}
					} else {
						$color[$x][$y] = "other";
					}
				}
			}
		}
		
		if (isset($color[$x][$y])) {
			imagefilledrectangle($img, $x-1, $y-1, $x-1, $y-1, $colors->$color[$x][$y]);
		}
	}
}

header("Content-type: image/png");
imagepng($img);
imagedestroy($img);
?>