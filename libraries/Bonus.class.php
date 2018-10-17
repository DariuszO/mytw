<?php
if(!defined("MyTW")) {
	exit;
}

class Bonus {
	static $bonus = NULL;
	
	static function add_bonus($id,$pr,$text,$icon,$icon_mini) {
		$text = str_replace("%s",$pr*100,$text);
		self :: $bonus[$id] = ["pr"=>$pr,"text"=>$text,"icon"=>$icon,"icon_mini"=>$icon_mini];
		return true;
	}
	
	static function view($view,$bid) {
		$bonus = self :: $bonus[$bid];
		$return = [];
		foreach($view as $v) {
			if (isset($bonus[$v])) {
				$return[] = $v;
			}
		}
		return $return;
	}
}

Bonus::add_bonus('1','0.5','%s% większa pojemność spichlerza i handlarzy','storage.png','storage_mini.png');
Bonus::add_bonus('2','0.3','%s% większa produkcja surowców (wszystkie surowce)','all.png','all_mini.png');
Bonus::add_bonus('3','1','%s% większa produkcja drewna','wood.png','wood_mini.png');
Bonus::add_bonus('4','1','%s% większa produkcja gliny','stone.png','stone_mini.png');
Bonus::add_bonus('5','1','%s% większa produkcja żelaza','iron.png','iron_mini.png');
Bonus::add_bonus('6','0.33','%s% szybsze szkolenie w koszarach','barracks.png','barracks_mini.png');
Bonus::add_bonus('7','0.33','%s% szybsze szkolenie w stajniach','stable.png','stable_mini.png');
Bonus::add_bonus('8','0.5','%s% szybsza produkcja w warsztacie','garage.png','garage_mini.png');
Bonus::add_bonus('9','0.1','%s% więcej ludności','farm.png','farm_mini.png');
?>