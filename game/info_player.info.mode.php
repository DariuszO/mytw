
<script type="text/javascript">


    //todo: move this into InfoPlayer
    var Player = {
        getAllVillages: function(anchor, link) {
            $.get(link, { }, function(data) {
                $('#villages_list tbody').append(data.villages);
                $(anchor).parent().parent().remove();

                if (game_data.player.id) {
                    VillageContext.init();
                    UI.ToolTip('.tooltip');
                }
            }, 'json');
        }
    };


    $(document).ready(function() {
        Toggler.register('#embedmap_player', '#map_toggler', function() {
            if (TWMap.minimap) {
                TWMap.minimap.resize();
            }
        });

        InfoPlayer.player_id = <?php echo $player['id'];?>;
        InfoPlayer.init();
    });
</script>

<table style="width: 100%">
	<tr>
		<td valign="top" style="width: 50%">
			<table class="vis" id="player_info" width="100%">
				<tr>
					<th colspan="2">
                        <img src="<?php echo $cfg['cdn']; ?>/graphic/welcome/player_points.png" style="vertical-align:middle; margin-bottom:1px;" alt="" class="" />
                        <?php echo User::name($player['id'],$user['id'],"/game.php","{FRIEND_STATUS} {NAME}"); ?>						<img class="float_right tooltip" style="cursor: pointer;" src="graphic/map_toggle.png" id="map_toggler" title="Przełącz widzialność mapy">					</th>
				</tr>
												<td colspan="2" style="padding: 0" id="embedmap_player" data-name="embedmap_player">
					<div id="minimap" style="overflow:hidden; position:relative; box-sizing: border-box; padding:0px;width:100%; height:200px;">
						<div id="minimap_viewport"></div>
					</div>
					<script>
						$(function(){
							<?php 
							$first_village = Village::get_first($player['id']);
							$vill = Village::get($first_village);
							?>
							TWMap.showEmbeddedMap('<?php echo rand(10000000000,99999999999);?>', 0, <?php echo $vill['x']; ?>, <?php echo $vill['y']; ?>, <?php echo $vill['id']?>);
						});
					</script>
				</td>
								<tr><td width="80">Punkty:</td><td><?php echo format_number($player['points']); ?></td></tr>
				<tr><td>Ranking:</td><td><?php echo $player['rank']; ?></td></tr>
								<tr>
					<td>Pokonani przeciwnicy:</td>
					<td class="tooltip" title="<?php
					if ($player['kill_attack_rank']<$player['kill_defense_rank']) {
						$r = HTMLSpecialChars("Jako obrońca: ". format_number($player['kill_defense_points']) ." ({$player['kill_defense_rank']}.)");
						$r .= " :: ";
						$r .= HTMLSpecialChars("Jako agresor: ". format_number($player['kill_attack_points']) ." ({$player['kill_attack_rank']}.)");
					} else {
						$r = HTMLSpecialChars("Jako agresor: ". format_number($player['kill_attack_points']) ." ({$player['kill_attack_rank']}.)");					
						$r .= " :: ";
						$r .= HTMLSpecialChars("Jako obrońca: ". format_number($player['kill_defense_points']) ." ({$player['kill_defense_rank']}.)");
					}
					echo $r;
					?>">
						<?php echo format_number($player['kill_points']); ?> (<?php echo format_number($player['kill_rank']); ?>.)
					</td>
				</tr>
					<?php
					if ($player['ally']!=="-1") { 
						$player_ally = DB::Fetch(DB::Query("SELECT * FROM `{$DB}`.`ally` WHERE `id` = '{$player['ally']}'"));
					?>
					<tr><td>Plemię:</td><td>
						<a href="/game.php?village=<?php echo $village['id']; ?>&id=<?php echo $player_ally['id']; ?>&screen=info_ally"><?php echo entparse($player_ally['short']);?></a>
					</td></tr>
					<?php } ?>

                			</table>

            <!-- actions -->
            <?php
			if ($player['id']!==$user['id']) { 
			?>
			<table width="100%" class="vis" style="margin-top:10px;">
                    <tr><th>Akcje</th></tr>

                                            <tr><td colspan="2">
                                <a href="/game.php?village=<?php echo $village['id']; ?>&mode=new&player=<?php echo $player['id']; ?>&name=<?php echo $player['name']; ?>&screen=mail">
                                    <span class="action-icon-container"><span class="icon header new_mail" style="vertical-align:middle;"></span></span> Napisz wiadomość
                                </a></td></tr>
								<?php if ($user['ally_invite'] === 1 && $player['ally']!=$user['ally']) {?>
											<tr><td colspan="2">
                                <a href="/game.php?village=<?php echo $village['id']; ?>&mode=invite&action=invite_id&h=<?php echo $hkey; ?>&id=<?php echo $player['id']; ?>&screen=ally" class="evt-confirm" data-confirm-msg="Czy na pewno chcesz zaprosić <?php echo entparse($player['name']); ?>?">
                                    <span class="action-icon-container"><span class="icon header send_invite"></span></span> Zaproś do plemienia
                                </a></td></tr>                    
								<?php } ?>
                                            <tr><td colspan="2">
                                <a href="/game.php?village=<?php echo $village['id']; ?>&id=<?php echo $player['id']; ?>&action=add_friend&h=<?php echo $hkey; ?>&screen=info_player">
                                    <span class="action-icon-container"><span class="icon buddy_add"></span></span> Dodaj jako przyjaciela
                                </a></td></tr>
                    
                                            <tr><td colspan="2">
                                <a href="/game.php?village=<?php echo $village['id']; ?>&mode=block&action=block&h=<?php echo $hkey; ?>&id=<?php echo $player['id']; ?>&screen=info_player">
                                    <span class="action-icon-container"><span class="icon block_communication"></span></span> Zablokuj możliwość komunikacji
                                </a></td></tr>
								          <tr><td colspan="2">
                                <a href="/game.php?village=<?php echo $village['id']; ?>&mode=address&action=add_address_id&h=<?php echo $hkey; ?>&address_id=<?php echo $player['id']; ?>&screen=mail">
                                    <span class="action-icon-container">&nbsp;»</span> Do książki adresowej
                                </a></td></tr>
                                                                <tr><td colspan="2">
                                <div id="map_color_assignment" style="display:none"></div>

                                <a href="#" class="info_map_color_toggler">
                                    <span class="action-icon-container">&nbsp;&raquo;</span> Zarządzaj zaznaczeniami mapy</a></td></tr>
                    
                                            <tr class="tooltip" title="Funkcja zostanie wprowadzona w przyszłości..."><td colspan="2">
                                <a href="#" data-old-href="/game.php?village=<?php echo $village['id']; ?>&mode=awards&compare=<?php echo $player['id']; ?>&screen=info_player">
                                    <span class="action-icon-container">&nbsp;&raquo;</span> Porównaj odznaczenia
                                </a></td> </tr>
                    
                                    </table>
			<?php } ?>
			<br />

						<table id="villages_list" class="vis" width="100%">
				<thead>
					<tr><th width="180">Wioski (<?php echo format_number($player['villages']); ?>)</th><th width="80">Współrzędne</th><th>P.</th></tr>
				</thead>
				<tbody>
				<?php
				$result = DB::Query("SELECT * FROM `{$DB}`.`villages` WHERE `uid` = '{$player['id']}' ORDER BY `name` LIMIT 0 , 99");
				while($row = DB::Fetch($result)) {
					echo "<tr>
        <td>
            <span class=\"village_anchor\" data-id=\"{$row['id']}\" data-player=\"{$row['uid']}\"><a href=\"/game.php?village={$village['id']}&id={$row['id']}&screen=info_village\">". entparse($row['name']) ."</a></span>
            <img src=\"{$cfg['cdn']}/graphic/map/reserved_player.png\" id=\"reservation_{$row['id']}\" style=\"display: none; float:right;\" title=\"\" alt=\"\" class=\"tooltip\" />
        </td>
        <td>{$row['x']}|{$row['y']}</td>
        <td>". format_number($row['points']) ."</td>
    </tr>";
				}
				?>
				</tbody>
			</table>
					</td>
		<td valign="top" style="width: 50%">
<?php if ($edit && $user['id']===$player['id']) { ?>
<form action="/game.php?village=<?php echo $village['id']; ?>&edit=1&action=change_profile&h=<?php echo $hkey; ?>&screen=info_player" enctype="multipart/form-data" method="post" >
	<table class="vis" style="width: 100%">
		<tr>
			<th colspan="2">Profil</th>
		</tr>
		<tr>
			<td>Data urodzenia:</td>
			<td>
				<input name="day" type="text" size="2" maxlength="2" value="<?php echo $user['b_day']; ?>" />
				<select name="month">
				<option value="1"<?php echo MyTW_or($user['b_month'],"selected=\"selected\"","","1");?>>Styczeń</option>
				<option value="2"<?php echo MyTW_or($user['b_month'],"selected=\"selected\"","","2");?>>Luty</option>
				<option value="3"<?php echo MyTW_or($user['b_month'],"selected=\"selected\"","","3");?>>Marzec</option>
				<option value="4"<?php echo MyTW_or($user['b_month'],"selected=\"selected\"","","4");?>>Kwiecień</option>
				<option value="5"<?php echo MyTW_or($user['b_month'],"selected=\"selected\"","","5");?>>Maj</option>
				<option value="6"<?php echo MyTW_or($user['b_month'],"selected=\"selected\"","","6");?>>Czerwiec</option>
				<option value="7"<?php echo MyTW_or($user['b_month'],"selected=\"selected\"","","7");?>>Lipiec</option>
				<option value="8"<?php echo MyTW_or($user['b_month'],"selected=\"selected\"","","8");?>>Sierpień</option>
				<option value="9"<?php echo MyTW_or($user['b_month'],"selected=\"selected\"","","9");?>>Wrzesień</option>
				<option value="10"<?php echo MyTW_or($user['b_month'],"selected=\"selected\"","","10");?>>Październik</option>
				<option value="11"<?php echo MyTW_or($user['b_month'],"selected=\"selected\"","","11");?>>Listopad</option>
				<option value="12"<?php echo MyTW_or($user['b_month'],"selected=\"selected\"","","12");?>>Grudzień</option>

				</select>
				<input name="year" type="text" size="4" maxlength="4" value="<?php echo $user['b_year'];?>" />
			</td>
		</tr>
		<tr>
			<td>Płeć:</td>
			<td><label><input type="radio" name="sex" value="f"<?php echo MyTW_or($user['sex']," checked=\"checked\"","","f"); ?> />żeńska</label>
				<label><input type="radio" name="sex" value="m"<?php echo MyTW_or($user['sex']," checked=\"checked\"","","m"); ?> />męska</label>
				<label><input type="radio" name="sex" value="x"<?php echo MyTW_or($user['sex']," checked=\"checked\"","","x"); ?> />nie podawać</label>
		</td>
		</tr>
		<tr>
			<td>Miejsce zamieszkania:</td>
			<td><input name="home" type="text" size="24" maxlength="32" value="<?php echo entparse($user['home']); ?>" /></td>
		</tr>
		<tr>
			<td colspan="2">
				<input class="btn" type="submit" value="Zapisz" />
			</td>
		</tr>
	</table>
</form>

<table class="vis" style="width: 100%; margin-top: 15px">
	<tr>
		<th>Godło</th>
	</tr>
	<tr>
		<td>
			                <div class="coa">
                                    </div>
                                <script>
                    $(function() {
                        COA.init('/game.php?village=<?php echo $village['id']; ?>&ajaxaction=upload_coa&h=<?php echo $hkey; ?>&type=player&screen=upload');

                                            });
                </script>
					</td>
	</tr>
</table>



	<form action="/game.php?village=<?php echo $village['id']; ?>&edit=1&action=change_text&h=<?php echo $hkey; ?>&screen=info_player" method="post" class="confirm_abandonment">
	<table class="vis" width="500" style="margin-top: 15px">
				<tr>
			<th colspan="2">Tekst osobisty</th>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<?php
					if (isset($_POST['preview']) && $_GET['action']==="change_text") {
						$t = $_POST['personal_text'];
						if (strlen($t) > 20000) {
							echo "Tekst osobisty może zawierać maksymalnie dwadzieścia tysięcy znaków";
						} else {
							echo entparse(BB::parse($_POST['personal_text'],$user,["img","size","claim"]),true);
						}
					} else {
						echo entparse($user['personal_text'],true);
					}
					?>
				</td>
			</tr>
				<tr>
			<td colspan="2">    
<?php
	BB::icons("message",["img","size","claim"]);
?>
</td>
		</tr>
		<tr>
			<td colspan="2">
				<textarea id="message" name="personal_text" cols="50" rows="10"><?php echo entparse($user['personal_text_bb']); ?></textarea>
			</td>
		</tr>
		<tr>
			<td>
				<input class="btn" type="submit" name="send" value="OK" />
				<input class="btn" type="submit" name="preview" value="Podgląd" />
			</td>
		</tr>
	</table>
</form>
<?php } else { ?>
	<?php if (strlen($player['personal_text']) > 0){ ?>
	<table class="vis" width="100%">
		<tr><th>Tekst osobisty</th></tr>
		<tr><td align="center"><?php echo entparse($player['personal_text'],true); ?></td></tr>
	</table>
	<?php } ?>
<?php } ?>
<br />

								</td>
	</tr>
</table>