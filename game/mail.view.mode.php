<?php
$mid = $_GET['view'];
$pages = 0;
$sql = DB::Query("SELECT * FROM `{$DB}`.`mails` WHERE (`id` = '{$mid}') AND (`from_id` = '{$user['id']}' OR `to_id` = '{$user['id']}')");
$check = DB::numrows($sql);
if ($check!==1) {
	echo "Ta wiadomość nie istnieje";
} else {
	$mail = DB::fetch($sql);
	if ($mail['from_id']===$user['id']) {
		$T = "to";
	} else {
		$T = "from";
	}
	if ($mail["{$T}_status"]===1) {
		$img = "answered_mail";
		$title = "Odpowiedź wysłana";
	} elseif($mail["{$T}_status"]===2) {
		$img = "read_mail";
		$title = "Przeczytane";
	} else {
		$img = "new_mail";
		$title = "Nowa wiadomość";
	}
	
	$respondes = DB::Query("SELECT * FROM `{$DB}`.`mails_responde` WHERE `mail` = '{$mail['id']}' ORDER BY `time` DESC");
	if (DB::Numrows($respondes) > 5) {
		$from = $_GET['from'];
		if (!isset($_GET['from'])) {
			$from = 0;
		}
		$pages = round(DB::numrows($respondes)/5);
		if ($from!=="-1") {
			$acp = floor($from/5)+1;
			$respondes = DB::Query("SELECT * FROM `{$DB}`.`mails_responde` WHERE `mail` = '{$mail['id']}' ORDER BY `time` DESC LIMIT {$from} , 5");
		} else {
			$acp = "all";
		}
	}
?>
<form method="post" action="/game.php?village=<?php echo $village['id']; ?>&mode=view&view=<?php echo $mail['id']; ?>&action=answer&h=<?php echo $hkey; ?>&read_time=<?php echo time(); ?>&screen=mail" onsubmit="return IGM.submitReply(this)" class="confirm_abandonment">

<table class="vis">
	<tr>
		<th width="170">Temat</th>
		<th width="300">123321 </th>
			</tr>
		<tr>
		<td>Gracz</td>
		<td>
			<img src="<?php echo $cfg['cdn']; ?>/graphic/<?php echo $img; ?>.png" title="<?php echo $title; ?>" alt="" class="tooltip" />
			            <a href="/game.php?village=<?php echo $village['id']; ?>&id=<?php echo $mail["{$T}_id"]; ?>&screen=info_player"><?php echo $mail["{$T}_name"];?></a>
                    </td>
	</tr>
	    
		<tr id="action_row">
		<td colspan="2">
			<table class="vis" width="100%">
				<tr>
										<td width="25%" align="center">
						<a href="javascript:IGM.view.beginReply();"><img src="<?php echo $cfg['cdn']; ?>/graphic/igm/reply.png?61736" title="Odpowiedź" alt="" class="" /> Odpowiedź</a>
					</td>
															<td  width="25%" align="center">
						<a href="/game.php?village=<?php echo $village['id']; ?>&mode=view&action=forward_redirect&h=<?php echo $hkey; ?>&read_time=<?php echo time(); ?>&view=<?php echo $mail['id']; ?>&screen=mail"><img src="<?php echo $cfg['cdn']; ?>/graphic/igm/forward.png?642f4" title="Prześlij" alt="" class="" /> Prześlij</a>
					</td>
										<td width="25%" align="center">
						<a href="/game.php?village=<?php echo $village['id']; ?>&mode=view&action=delete&h=<?php echo $hkey; ?>&read_time=<?php echo time(); ?>&view=<?php echo $mail['id']; ?>&show=5214169&screen=mail" class="evt-confirm" data-confirm-msg="Na pewno chcesz skasować tę wiadomość?">
							<img src="<?php echo $cfg['cdn']; ?>/graphic/igm/delete.png?51634" title="Skasuj" alt="" class="" /> Skasuj
						</a>
					</td>
					<td width="25%" align="center">
								<a href="/game.php?village=<?php echo $village['id']; ?>&mode=export&igm_id=<?php echo $mail['id']; ?>&screen=mail"><img src="<?php echo $cfg['cdn']; ?>/graphic/igm/export.png?fce73" title="Eksport" alt="" class="" /> Eksport</a>

											</td>
				</tr>

			</table>
		</td>
	</tr>
		<?php
		if ($pages > 1) {
			echo "<tr>
					<td colspan=\"4\" style=\"text-align:center;\">";
				for($p=1;$p<=$pages;$p++) {
					if ($acp===$p) {
						echo "<strong> &gt;{$p}&lt; </strong>";
					} else {
						$url = url(["view"=>$_GET['view'],"from"=>$p*5]);
						echo "<a class=\"paged-nav-item\" href=\"{$url}\"> [{$p}] </a>";
					}
				}
				if ($acp==="all") {
					echo "<strong> &gt;wszystkie&lt; </strong>";
				} else {
					$url = url(["view"=>$_GET['view'],"from"=>-1]);
					echo "<a class=\"paged-nav-item\" href=\"{$url}\"> [wszystkie] </a>";					
				}
			echo "</td>
			</tr>";
		}
		?>
            <tr id="answer_row1">
            <td colspan="2">
			<?php
				BB::icons("message",["img","size","claim"]);
			?>
			 <input type="hidden" name="igm_id" value="<?php echo $mail['id']; ?>" />

                <div style="clear: both;">
                    <textarea id="message" name="text" style="width: 98%; height: 150px"></textarea>
                </div>
            </td>
        </tr>
        <tr id="answer_row2">

            <td colspan="2">
                <input class="btn btn-default" type="submit" name="preview" value="Podgląd" />
                                <input class="btn btn-default" type="submit" name="answer" value="Odpowiedź" />

                <script type="text/javascript">
                //<![CDATA[
                                $('#answer_row1, #answer_row2').css('display', 'none');
                                //]]>
                </script>
          </td>
        </tr>
    
	<tr>
		<td colspan="2" style="max-width: 600px">
			<?php
			while($row = DB::fetch($respondes)) {
				if($row['author_id'] != "-1") {
					$author = "<a href=\"/game.php?village={$village['id']}&id={$row['author_id']}&screen=info_player\">". entparse($row['author_name']) ."</a>";
				} else {
					$author = $cfg['mail_admin'];
				}
				$time = format_date($row['time']);
				$text = entparse($row['text']);
				
				if($row['author_id']===$user['id']) {
					$class = " own";
				} else {
					$class = "";
				}
				echo "<div class=\"post{$class}\">
				<div class=\"igmline\">
										<span  class=\"author\">
							{$author}
					</span>
										<span class=\"date float_right\">{$time}</span>
				</div>
				<div class=\"text\">{$text}</div>
			</div>";
			}
			?>
					</td>
	</tr>
		</table>
<input type="hidden" id="input_field_size" name="input_field_size"/>
</form>

<script type="text/javascript">
$(function() {
	IGM.view.init(<?php echo $mail['id']; ?>);
});
</script>
<?php
}
?>