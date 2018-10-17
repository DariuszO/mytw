<?php
$modes = [
	"ally" => "Plemiona",
	"players" => "Gracze",
	"secrets" => "Odkrycia",
	"con_ally" => "Plemiona na kontynencie",
	"con_player" => "Gracze na kontynencie",
	"kill_ally" => "Pokonani przeciwnicy (plemię)",
	"kill_player" => "Pokonani przeciwnicy",
	"awards" => "Odznaczenia",
	"wars" => "Wojny"
];
if (!file_exists(PATH . "/game/{$screen}.{$mode}.mode.php")) {
	$mode = "players";
}
?>									
<h2>Ranking</h2>
<table width="100%"><tr><td valign="top" width="130px">

<table class="vis modemenu">
	<?php
	foreach ($modes as $m1 => $m2) {
		if ($mode === $m1) {
			$class = "class=\"selected\"";
		} else {
			$class = "";
		}
		echo "<tr><td {$class} style=\"min-width: 80px\"><a href=\"/game.php?village={$village['id']}&mode={$m1}&screen={$screen}\">{$m2} </a></td></tr>";
	}
	?>
</table>

</td><td valign="top">
	<?php
		require_once PATH . "/game/{$screen}.{$mode}.mode.php";
	?>
</td></tr></table>
