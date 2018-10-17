<script type="text/javascript">
//<![CDATA[
	$(function(){
		JToggler.init('#content_value .vis input[type="checkbox"]');
	});
//]]>
</script>
<form action="/game.php?village=<?php echo $village['id']; ?>&mode=in&action=del_move_multiple&h=<?php echo $hkey; ?>&group_id=0&screen=mail" method="post">



<table class="vis">
	<tr>
		<td>
									<strong>&gt;Odbiorcza&lt;</strong>
							</td>
	</tr>
</table>


<table class="vis">
<tr><th width="300">Temat</th>
<th width="100"><a href="#" onclick="$('#filter').toggle(); return false">
<span id="filter_none" >Brak filtru</span>
<span id="filter_new" style="display:none"><img src="<?php echo $cfg['cdn']; ?>/graphic/new_mail.png?adbcf" title="Nowe" alt="" class="" /> Nowe</span>
<span id="filter_read" style="display:none"><img src="<?php echo $cfg['cdn']; ?>/graphic/read_mail.png?554a4" title="Przeczytane" alt="" class="" /> Przeczytane</span>
<span id="filter_answered" style="display:none"><img src="<?php echo $cfg['cdn']; ?>/graphic/answered_mail.png?7b94e" title="odpowiedź wysłana" alt="" class="" /> odpowiedź wysłana</span>
</a>
<table id="filter" class="vis" style="display:none; width: 150px; position:absolute; background-color: white; border: 1px solid;">
<tr><td><a href="/game.php?village=<?php echo $village['id']; ?>&action=set_filter&h=<?php echo $hkey; ?>&group_id=0&screen=mail&filter=none">Brak filtru</a></td></tr>
<tr><td><a href="/game.php?village=<?php echo $village['id']; ?>&action=set_filter&h=<?php echo $hkey; ?>&group_id=0&screen=mail&filter=new"><img src="<?php echo $cfg['cdn']; ?>/graphic/new_mail.png?adbcf" title="Nowe" alt="" class="" /> Nowe</a></td></tr>
<tr><td><a href="/game.php?village=<?php echo $village['id']; ?>&action=set_filter&h=<?php echo $hkey; ?>&group_id=0&screen=mail&filter=read"><img src="<?php echo $cfg['cdn']; ?>/graphic/read_mail.png?554a4" title="Przeczytane" alt="" class="" /> Przeczytane</a></td></tr>
<tr><td><a href="/game.php?village=<?php echo $village['id']; ?>&action=set_filter&h=<?php echo $hkey; ?>&group_id=0&screen=mail&filter=answered"><img src="<?php echo $cfg['cdn']; ?>/graphic/answered_mail.png?7b94e" title="odpowiedź wysłana" alt="" class="" /> odpowiedź wysłana</a></td></tr>
</table>
</th>
<th width="160">
	<a href="javascript:void(0)" onclick="UI.AjaxPopup(event, 'partner_filter', '/game.php?village=<?php echo $village['id']; ?>&ajax=filter_partner&group_id=0&screen=mail', 'Filtr'); return false;">Gracz</a>
</th>
<th width="140">Ostatni wpis</th>
</tr>

<?php
$result = DB::Query("SELECT * FROM `{$DB}`.`mails` WHERE (`from_id` = '{$user['id']}') OR (`to_id` = '{$user['id']}')",true);
while($row = DB::fetch($result)) {
	if ($row['to_id']===$user['id']) {
		if ($row['to_status']===1) {
			$img1 = "answered_mail";
			$title1 = "Odpowiedź wysłana";
		} elseif($row['to_status']===2) {
			$img1 = "read_mail";
			$title1 = "Przeczytane";
		} else {
			$img1 = "new_mail";
			$title1 = "Nowa wiadomość";
		}
		if ($row['from_status']===1) {
			$img2 = "answered_mail";
			$title2 = "Odpowiedź wysłana";
		} elseif($row['from_status']===2) {
			$img2 = "read_mail";
			$title2 = "Przeczytane";
		} else {
			$img2 = "new_mail";
			$title = "Nowa wiadomość";
		}
		
		if ($row['from_id']!=="-1") {
			$player = "<a href=\"/game.php?village={$village['id']}&id={$row['from_id']}&screen=info_player\">". entparse($row['from_name'])."</a>";
		} else {
			$player = $cfg['mail_admin'];
		}
	} else {	
		if ($row['to_status']===1) {
			$img2 = "answered_mail";
		} elseif($row['to_status']===2) {
			$img2 = "read_mail";
		} else {
			$img2 = "new_mail";
		}
		if ($row['from_status']===1) {
			$img1 = "answered_mail";
		} elseif($row['from_status']===2) {
			$img1 = "read_mail";
		} else {
			$img1 = "new_mail";
		}
		if ($row['to_id']!=="-1") {
			$player = "<a href=\"/game.php?village={$village['id']}&id={$row['to_id']}&screen=info_player\">". entparse($row['to_name'])."</a>";
		} else {
			$player = $cfg['mail_admin'];
		}
	}
	$time = date("d.m. H:i",$row['last_responde']);
	$mtitle = entparse($row['title']);
	echo "<tr>
	<td colspan=\"2\">
		<input name=\"ids[{$row['id']}]\" type=\"checkbox\" class=\"check\" /><a href=\"/game.php?village={$village['id']}&mode=view&view={$row['id']}&group_id=0&screen=mail\">
		<img src=\"{$cfg['cdn']}/graphic/{$img1}.png\" title=\"{$title1}\" alt=\"\" class=\"va_base tooltip\" /> 	{$mtitle}		</a>
	</td>
	<td class=\"nowrap\"><img src=\"{$cfg['cdn']}/graphic/{$img2}.png\" title=\"{$title2}\" alt=\"\" class=\"va_base tooltip\" />
			 {$player}
                </td>
	<td>{$time}</td>
</tr>";
}
?>
	<tr>
		<th colspan="4"><input name="all" style="margin: 0" type="checkbox" class="selectAll" id="select_all" onclick="selectAll(this.form, this.checked)"/> <label for="select_all">zaznacz wszystkie</label></th>
	</tr>

</table>

	<div ><table align="left" class="vis"><tr>
	<td><input class="btn btn-cancel" type="submit" value="Skasuj" name="del" /></td>
		</tr></table>
	</div>

<input type="hidden" value="0" name="from" />
<input type="hidden" value="3" name="num_igms" />

</form>

<div >
<form action="/game.php?village=<?php echo $village['id']; ?>&action=change_page_size&h=<?php echo $hkey; ?>&mode=in&group_id=0&from=$from&screen=mail" method="post">
<table class="vis">
	<tr>
		<th>Liczba wiadomości na stronie:</th>
		<td><input name="page_size" type="text" size="5" value="12" /></td>
		<td><input class="btn" type="submit" value="OK" /></td>
	</tr>
</table>
</form>
</div>