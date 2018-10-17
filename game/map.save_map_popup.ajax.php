<?php
$values = [];
$configs = ["map_popup_attack","map_popup_attack_intel","map_popup_moral","map_popup_res","map_popup_pop","map_popup_trader","map_popup_reservation","map_popup_units","map_popup_units_home","map_popup_units_time","map_popup_flag","map_popup_notes"];
foreach($configs as $c) {
	if ($_POST[$c]==="on") {
		$values[] = "1";
	} else {
		$values[] = "0";
	}
}
$upd = User::update($user['id'],$configs,$values);
if ($upd===false) {
	$json['code'] = false;
} else {
	$json['code'] = true;
}
MyTW_json_exit($json);
?>