<?php
/*
*	Minimap
*	Author: Bartekst222
*	Comment lang: Polish
*/

/* Stwórz obiekt stdClass: */
$data = new stdClass();
$data->map_elements = [];
$data->villages = [];
$data->players = [];
$data->allies = [];
$data->map_groups = [1=>[],2=>[],3=>[]];

/* Załaduj pusty obraz minimapy: */
$img = imagecreatefrompng(PATH . "/libraries/conmap.png");

/* Kolory domyślne: */
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
$colors->group_color = Array();

/* Sprawdź czy podane zostały współrzędny X i Y: */
if(!isset($_GET['x']))
	$_GET['x'] = 0;
if(!isset($_GET['y']))
	$_GET['y'] = 0;

/* Przypisz współrzędnym i informacją zmienne: */
$x = (int)$_GET['x'];
$y = (int)$_GET['y'];
$uid = $_GET['player_id'];
$vid = $_GET['village_id'];

/* Sprawdź czy istnieje podany użytkownik: */
if ($uid!=="undefined") {
	$uid = (int)$uid;
	$user = User::get($uid);;
}
/* Oblicz startowe i końcowe X i Y: */
$startX = $x;
$startY = $y;
$endX = $x+50;
$endY = $y+50;

$players = Array();
$allies = Array();

/* Pobierz krzaki z sektora minimapy: */
$result = DB::Query("SELECT * FROM `map_elements` WHERE `x` >= '{$startX}' AND `y` >= '{$startY}' AND `x` <= '{$endX}' AND `y` <= '{$endY}'",true);
while($row = DB::fetch($result)) {
	$data->map_elements[$row['x']."|".$row['y']] = $row;
}

/* Pobierz wioski z sektora minimapy: */
$result = DB::Query("SELECT * FROM `{$DB}`.`villages` WHERE `x` >= '{$startX}' AND `y` >= '{$startY}' AND `x` <= '{$endX}' AND `y` <= '{$endY}'",true);
while($row = DB::fetch($result)) {
	$data->villages[$row['x']."|".$row['y']] = $row;
	if ($row['uid']!=="-1" && $row['event_village']!=="1") {
		$players[] = $row['uid'];
	}
}
/* Pobierz graczy występujacych w sektorze minimapy: */
foreach ($players as $pid) {
	$player = DB::fetch(DB::Query("SELECT * FROM `{$DB}`.`users` WHERE `id` = '{$pid}'"));
	$data->players[$pid] = $player;
	if ($player['ally']!=="1") {
		$allies[] = $player['ally'];
	}
}
/* Pobierz plemiona występujące w regionie minimapy*/
foreach ($allies as $aid) {
	$ally = DB::fetch(DB::Query("SELECT * FROM `{$DB}`.`ally` WHERE `id` = '{$aid}'"));
	$data->allies[$aid] = $ally;
}

/* Pobierz odznaczenia mapy użytkownika który korzysta z minimapy: */
$groups = DB::Query("SELECT * FROM `{$DB}`.`map_groups` WHERE `uid` = '{$uid}' AND `group_type` = '0'");

while($row = DB::Fetch($groups)) {
	$colors->group_colors[$row['id']] = imagecolorallocate($img, $row['r'], $row['g'], $row['b']);
	$color = DB::Query("SELECT * FROM `{$DB}`.`map_colors` WHERE `group` = '{$row['id']}'");
	while($crow = DB::Fetch($color)) {
		$data->map_groups[$crow['type']][$crow['value']] = $row['id'];
	}
}

/* Pobierz informacje o poktach plemienia w którym jest użytkownik: */

/* Sprawdź i pobierz informacje czy minimapa jest dla podglądu profilu: */
$cur = (int)$_GET['cur'];
$focus = (int)$_GET['focus'];
if ($focus!==0) {
	$colors->group_colors["default_black"] = imagecolorallocate($img, 0, 0, 0);
	$colors->group_colors["default_white"] = imagecolorallocate($img, 255, 255, 255);
	$colors->group_colors["default_yellow"] = imagecolorallocate($img, 240, 200, 0);
	$colors->group_colors["default_pink1"] = imagecolorallocate($img, 239, 165, 239);
	$colors->group_colors["default_pink2"] = imagecolorallocate($img, 255, 0, 255);
	
	$cur_v = Village::get($cur);
	if ($cur_v['uid']!=="-1") {
		$cur_p = User::Get($cur_v['uid']);
		$data->map_groups[2][$cur_p['id']] = "default_yellow";
	}
	$data->map_groups[3][$cur_v['id']] = "default_white";
	
	$focus_v = Village::get($focus);
	if ($focus_v['uid']!=="-1") {
		$focus_p = User::Get($focus_v['uid']);
		$data->map_groups[2][$focus_p['id']] = "default_pink1";
	}
	$data->map_groups[3][$focus_v['id']] = "default_pink2";
}

/* Zacznij rysować: */
for($xxx = $startX;$xxx <= $endX;$xxx++) {
	for($yyy = $startY;$yyy <= $endY;$yyy++) {
		$cX = ($xxx-$x)*5;
		$cY = ($yyy-$y)*5;
		
		if ($xxx%100===0) {
			/* Narysuj linię kontynentu */
			imageline($img, $cX, 0, $cX, 888, $colors->black);
		} elseif ($yyy%100===0) {
			/* Narysuj linię kontynentu */
			imageline($img, 0, $cY, 888, $cY, $colors->black);
		} else {
			if ($xxx % 5 == 0) {
				/* Narysuj linię sektoru */
				imageline($img, $cX, 0, $cX, 888, $colors->border);
			} 
			if ($yyy % 5 == 0) {
				/* Narysuj lijnię sektoru */
			   imageline($img, 0, $cY,888 ,$cY, $colors->border);
			}
		}
		if ($xxx > 999 || $xxx < 0 || $yyy > 999 || $yyy < 0) {
			/* Jeśli współrzędne wychodzą po za granice mapy - zmień kolor tła */
			imagefilledrectangle($img, $cX+1, $cY+1, $cX+4, $cY+4, $colors->outside);
		}
		if (isset($data->map_elements["{$xxx}|{$yyy}"])) {
			/* Narysuj krzaczek */
			imagefilledrectangle($img, $cX+1, $cY+1, $cX+4, $cY+4, $colors->element);
		}
		if (isset($data->villages["{$xxx}|{$yyy}"])) {
			/* Pobierz informacje o wiosce: */
			$v_info = $data->villages["{$xxx}|{$yyy}"];
			if (isset($data->map_groups[3][$v_info['id']])) {
				/* Jeśli wioska jest odznaczona - pokoloruj ją */
				$color_id = $data->map_groups[3][$v_info['id']];
				imagefilledrectangle($img, $cX+1, $cY+1, $cX+4, $cY+4, $colors->group_colors[$color_id]);
			} else {
				if ($v_info['uid'] === "-1") {
					if ($v_info['event_village']==="1") {
						/* Jeśli jest to wioska eventowa - odznacz ją specialnym wyróżnieniem */
						imagefilledrectangle($img, $cX+1, $cY+1, $cX+4, $cY+4, $colors->blue);
						imagefilledrectangle($img, $cX+2, $cY+2, $cX+3, $cY+3, $colors->white);
					} else {
						/* Jeśli jest to zwyczajna wioska barbarzyńska - pokoloruj na szaro */
						imagefilledrectangle($img, $cX+1, $cY+1, $cX+4, $cY+4, $colors->gray);
					}
				} else {
					if(isset($data->map_groups[2][$v_info['uid']])) {
						/* Jeśli gracz jest odznaczony - pokoloruj wioskę na dany kolor */
						$color_id = $data->map_groups[2][$v_info['uid']];
						imagefilledrectangle($img, $cX+1, $cY+1, $cX+4, $cY+4, $colors->group_colors[$color_id]);
					} else {
						if($vid===$v_info['id']) {
							/* Jeśli z tej wioski użytkownik przegląda mapę, pokoloruj wioskę na biało */
							imagefilledrectangle($img, $cX+1, $cY+1, $cX+4, $cY+4, $colors->white);
						} elseif($v_info['uid']===$user['id']) {
							/* Jeśli jest to wioska użytkownika - pokoloruj wioskę na żółto */
							imagefilledrectangle($img, $cX+1, $cY+1, $cX+4, $cY+4, $colors->player);
						} else {
							$vown = $data->players[$v_info['uid']];
							if (isset($data->map_groups[1][$vown['ally']])) {
								/* Jeśli plemię jest odznaczone - pokoloruj wioskę na dany kolor*/
								$color_id = $data->map_groups[1][$vown['ally']];
								imagefilledrectangle($img, $cX+1, $cY+1, $cX+4, $cY+4, $colors->group_colors[$color_id]);
							} else {
								if ($vown['ally']===$user['ally'] && $vown['ally']!=="-1") {
									/* Jeśli jest to wioska współplemieńca użytkownika - pokoloruj na niebiesko */
									imagefilledrectangle($img, $cX+1, $cY+1, $cX+4, $cY+4, $colors->blue);
								} else {
									if (isset($data->contracts[$vown['ally']])) {
										/* Jeśli plemię w którym jest użytkownik ma pakt z plemieniem wioski - pokoloruj wieś na odpowiedni kolor */
										$ctype = $data->contracts[$vown['ally']];
										imagefilledrectangle($img, $cX+1, $cY+1, $cX+4, $cY+4, $colors->$ctype);
									} else {
										/* Jeśli wioska należy do jakiegoś gracza i nie spełnia pozostałych warunków - pokoloruj na brązowo */
										imagefilledrectangle($img, $cX+1, $cY+1, $cX+4, $cY+4, $colors->other);
									}
								}
							}
						}
					}
				}
			}
		}
	}
}

header("Content-type: image/png");
imagepng($img);
imagedestroy($img);
/*
$groups = DB::Query("SELECT * FROM `{$DB}`.`map_groups` WHERE `uid` = '{$uid}'");

while($row = DB::Fetch($groups)) {
	$color = DB::Query("SELECT * FROM `{$DB}`.`map_colors` WHERE `group` = '{$row['id']}'");
	while($crow = DB::Fetch($color)) {
		$data->map_groups[$crow['type']] = ["id"=>$row['id'],"val"=>$crow['value'],"r"=>$row['r'],"g"=>$row['g'],"b"=>$row['b']];
	}
}


for($xxx = $startX;$xxx <= $endX;$xxx++) {
	for($yyy = $startY;$yyy <= $endY;$yyy++) {
		$cX = ($xxx-$x)*5;
		$cY = ($yyy-$y)*5;
		if ($xxx%100===0) {
			imageline($img, $cX, 0, $cX, 888, $colors->black);
		} elseif ($yyy%100===0) {
			imageline($img, 0, $cY, 888, $cY, $colors->black);
		} else {
			if ($xxx % 5 == 0) {
				$C1 = ($xxx-$x);
				imageline($img, $cX, 0, $cX, 888, $colors->border);
			} 
			if ($yyy % 5 == 0) {
			   imageline($img, 0, $cY,888 ,$cY, $colors->border);
			}
		}
		if ($xxx > 999 || $xxx < 0 || $yyy > 999 || $yyy < 0) {
			imagefilledrectangle($img, $cX+1, $cY+1, $cX+4, $cY+4, $colors->outside);
		}
		if (isset($data->map_elements["{$xxx}|{$yyy}"])) {
			imagefilledrectangle($img, $cX+1, $cY+1, $cX+4, $cY+4, $colors->element);
		}
		if (isset($data->villages["{$xxx}|{$yyy}"])) {
			$v_info = $data->villages["{$xxx}|{$yyy}"];
			if ($data->map_groups["3"]["val"]===$v_info['id']) {
				$color_data = $data->map_groups["3"][$v_info['id']];
				$colors->group_color[$color_data["id"]] = imagecolorallocate($img, $color_data['r'], $color_data['g'], $color_data['b']);
				imagefilledrectangle($img, $cX+2, $cY+2, $cX+3, $cY+3, $colors->group_color[$color_data["id"]]);
			} else {
				if ($v_info['uid'] === "-1") {
					if ($v_info['event_village']==="1") {
						imagefilledrectangle($img, $cX+1, $cY+1, $cX+4, $cY+4, $colors->white);
						imagefilledrectangle($img, $cX+2, $cY+2, $cX+3, $cY+3, $colors->blue);
					} else {
						imagefilledrectangle($img, $cX+1, $cY+1, $cX+4, $cY+4, $colors->gray);
					}
				} else {
					if($data->map_groups["2"]["val"]===$v_info['uid']) {
						$color_data = $data->map_groups["2"][$v_info['uid']];
						$colors->group_colors[$color_data['id']] = imagecolorallocate($img, $color_data['r'], $color_data['g'], $color_data['b']);
						imagefilledrectangle($img, $cX+1, $cY+1, $cX+4, $cY+4, $colors->group_colors[$color_data['id']]);
					} else {
						if($vid===$v_info['id']) {
							imagefilledrectangle($img, $cX+1, $cY+1, $cX+4, $cY+4, $colors->white);
						} elseif($v_info['uid']===$uid) {
							imagefilledrectangle($img, $cX+1, $cY+1, $cX+4, $cY+4, $colors->player);
						} else {
							$vown = $data->players[$v_info['uid']];
							if ($vown['id']>0) {
								if ($data->map_groups["1"]["val"]===$vown['ally']) {
									$color_data = $data->map_groups["2"][$v_info['uid']];
									$colors->group_colors[$color_data['id']] = imagecolorallocate($img, $color_data['r'], $color_data['g'], $color_data['b']);
									imagefilledrectangle($img, $cX+1, $cY+1, $cX+4, $cY+4, $colors->group_colors[$color_data['id']]);
								} else {
									if ($vown['ally']===$user['ally'] && $vown['ally']!=="-1") {
										imagefilledrectangle($img, $cX+1, $cY+1, $cX+4, $cY+4, $colors->blue);
									} else {
										if (isset($data->contracts[$vown['ally']])) {
											$ctype = $data->contracts[$vown['ally']];
											imagefilledrectangle($img, $cX+1, $cY+1, $cX+4, $cY+4, $colors->$ctype);
										} else {
											imagefilledrectangle($img, $cX+1, $cY+1, $cX+4, $cY+4, $colors->other);
										}
									}
								}
							} else {
								imagefilledrectangle($img, $cX+1, $cY+1, $cX+4, $cY+4, $colors->other);
							}
						}
					}
				}
			}
		}
	}
}

header("Content-type: image/png");
imagepng($img);
imagedestroy($img);

*/
?>