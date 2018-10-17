<?php
$id = $_GET['id'];
$player = User::get($id);
if ($player===false) {
	$player = $user;
}
$mode = $_GET['mode'];
$modes = [
	"info" => entparse($player['name']),
	"inventory" => "Inwentarz",
	"awards" => "Odznaczenia",
	"stats_own" => "Statystyki",
	"buddies" => "Przyjaciele",
	"block" => "Czarna lista"
];
if (!file_exists(PATH . "/game/{$screen}.{$mode}.mode.php")) {
	$mode = "info";
}
if ($_GET['edit']==="1" && $player['id']===$user['id']) {
	$edit = true;
} else {
	$edit = false;
}
?>
<h2>
    Profil
    <?php if ($user['id']===$player['id'] && $mode=="info" && !$edit) { ?><a href="/game.php?village=<?php echo $village['id']; ?>&edit=1&screen=info_player" class="btn float_right">Edycja profilu</a><?php } ?>
</h2>

<?php if ($user['id']===$player['id']) { ?>
<table class="vis modemenu">
	<tr>
		<?php
		foreach($modes as $m1 => $m2) {
			if ($mode === $m1) {
				$class = "class=\"selected\"";
			} else {
				$class = "";
			}
			echo "<td {$class} style=\"min-width: 80px\"><a href=\"/game.php?village={$village['id']}&mode={$m1}&screen={$screen}\">{$m2} </a></td>";
		}
		?>
		</tr>
</table>
<br />
<?php } 
require_once PATH . "/game/{$screen}.{$mode}.mode.php";
?>
