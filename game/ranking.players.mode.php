<?php
$ppp = 25;
$rank = @$_GET['rank'];
if (empty($rank)) {
	$rank = $user['rank'];
}

if (isset($_GET['offset'])) {
	if ($_GET['offset'] < 0) {
		$_GET['offset'] = 0;
	}
	$rstart = $_GET['offset']-($_GET['offset']%$ppp);
} else {
	$rstart = $rank-($rank%$ppp);
}
$Q_WHERE = "";
$players = DB::numrows(DB::Query("SELECT * FROM `{$DB}`.`users`"));
if ($players < $rstart+$ppp) {
	$rstart = $players-($players%$ppp);
}
$search = false;
if (isset($_GET['name'])) {
	$_GET['name'] = parse($_GET['name']);
	$Q_WHERE = "WHERE `name` REGEXP '{$_GET['name']}'";
	$search = true;
	$players = DB::numrows(DB::Query("SELECT * FROM `{$DB}`.`users` {$Q_WHERE}"));
	if ($players < $rstart+$ppp) {
		$rstart = $players-($players%$ppp);
	}
}

$rank_html = "";
$result = DB::Query("SELECT * FROM `{$DB}`.`users` {$Q_WHERE} ORDER BY `rank` LIMIT {$rstart} , {$ppp}");
$pi = 0;
while($row = DB::fetch($result)) {
	$pi++;
	if ($pi===1) {
		$TOP_1 = "<a href=\"/game.php?village={$village['id']}&id={$row['id']}&screen=info_player\">". entparse($row['name']) ."</a>";
	} elseif ($pi===2) {
		$TOP_2 = "<a href=\"/game.php?village={$village['id']}&id={$row['id']}&screen=info_player\">". entparse($row['name']) ."</a>";
	} elseif($pi===3) {
		$TOP_3 = "<a href=\"/game.php?village={$village['id']}&id={$row['id']}&screen=info_player\">". entparse($row['name']) ."</a>";
	}
	if (($row['rank'] === $rank) OR ($search===true && $row['id']===$user['id'])) {
		$class = "class=\"lit\"";
	} elseif($row['ally']!=="-1" && $row['ally'] === $user['ally']) {
		$class = "class=\"lit\"";
	} else {
		$class = "";
	}
	if ($row['ally']!=="-1") {
		$ally_inf = Ally::get($row['ally']);
		$ally = "<a href=\"/game.php?village={$village['id']}&id={$ally_inf['id']}&screen=info_ally\">{$ally_inf['name']}</a>";
	} else {
		$ally = "";
	}
	$rank_html .= "		<tr {$class}>
		<td class=\"lit-item\">{$row['rank']}</td>
		<td class=\"lit-item\">
            <a href=\"/game.php?village={$village['id']}&id={$row['id']}&screen=info_player\">". entparse($row['name']) ."</a>
                    </td>
		<td class=\"lit-item\">{$ally}</td>
		<td class=\"lit-item\">". format_number($row['points']) ."</td>
		<td class=\"lit-item\">". format_number($row['villages']) ."</td>
		<td class=\"lit-item\">". @ceil($row['points'] / $row['villages']) ."</td>
			</tr>";
}
if ($rstart===0 && $pi >= 3) {
	echo "
<div class=\"ranking-top3\">
	<div class=\"gold\">
		{$TOP_1}
	</div>

	<div class=\"silver\">
		{$TOP_2}
	</div>

	<div class=\"bronze\">
		{$TOP_3}
	</div>
</div>";
}
?>
<table id="player_ranking_table" class="vis" width="100%">
	<tr>
		<th width="60">Ranking</th>
		<th width="180">Nazwa</th>
		<th width="100">Plemię</th>
		<th width="60">P.</th>
		<th>Wioski</th>
		<th>Punkty na wioskę</th>
	</tr>
	<?php
		echo $rank_html;
	?>
	</table><table class="vis" width="100%"><tr>
<td align="center" width="50%">
<?php if ($rstart-$ppp >= 0) { ?>
<a href="/game.php?village=<?php echo $village['id']; ?>&mode=player&offset=<?php echo $rstart-$ppp; echo MyTW_or($search,"","&name={$_GET['name']}",false);?>&screen=ranking">&lt;&lt;&lt; do góry</a><?php } ?></td>

<td align="center" width="50%">
<?php  if ($rstart+$ppp <= $players) { ?><a href="/game.php?village=<?php echo $village['id']; ?>&mode=player&offset=<?php echo $rstart+$ppp; echo MyTW_or($search,"","&name={$_GET['name']}",false);?>&screen=ranking">na dół &gt;&gt;&gt;</a><?php } ?></td>
</tr></table>
</div><table class="vis" width="100%"><tr>


<td style="padding-right:10px">
<form action="/game.php?village=<?php echo $village['id']; ?>&screen=ranking" method="get">
<input type="hidden" name="screen" value="ranking" />
Ranking: <input name="rank" type="text" value="" size="6" />
 <input class="btn" type="submit" value="OK" />
</form>
</td>

<td style="padding-right:10px">
<form action="/game.php?village=<?php echo $village['id']; ?>&screen=ranking" method="get">
<input type="hidden" name="screen" value="ranking" />
Szukaj:
<input name="name" type="text" value="" size="20" class="autocomplete" data-type="player" />
<input class="btn" type="submit" value="OK" />
</form>
</td>
</tr>

</table>