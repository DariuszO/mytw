<?php
User::update($user['id'],"new_mail","0");
$modes = [
	"in" => "Wiadomości",
	"mass_out" => "Wiadomość grupowa",
	"new" => "Napisz wiadomość",
	"address" => "Książka adresowa",
	"groups" => "Katalog"
];
if (!file_exists(PATH . "/game/{$screen}.{$mode}.mode.php")) {
	$mode = "in";
}
?>
<table><tr><td valign="top" width="100">
<table class="vis modemenu">
	<?php
	foreach ($modes as $m => $t) {
		if ($mode === $m) {
			$class = "class=\"selected\"";
		} else {
			$class = "";
		}
		echo "<tr><td {$class} style=\"min-width: 80px\"><a href=\"/game.php?village={$village['id']}&mode={$m}&screen={$screen}\">{$t} </a></td></tr>";
	}
	?>

</table>
</td><td valign="top">
<?php
require_once PATH . "/game/{$screen}.{$mode}.mode.php";
?>
</td></tr></table>
