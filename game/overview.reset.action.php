<?php
$defaultleft = ["show_summary","show_event","show_incoming_units","show_outgoing_units"];
$defaultright = ["show_newbie","show_prod","show_buildqueue","show_units","show_mood","show_effects","show_groups","show_notes","show_secret"];

$u = User::update($user['id'],["overview_leftcolumn","overview_rightcolumn"],[json_encode($defaultleft),json_encode($defaultright)]);
if ($u===false) {
	$errors[] = "Nie udało się przywrócić domyślnego przeglądu wioski";
} else {
	header("LOCATION: /game.php?village={$village['id']}&screen={$screen}");
}
?>