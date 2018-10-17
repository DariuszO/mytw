<?php
/**********************************/
/*           TribalWars           */
/*             My-TW              */
/*         by Bartekst222         */
/**********************************/

require_once "./libraries/common.inc.php";

if (world===false) {
	$world = World::last_world();
	header("Location: http://{$world}.privek.tk/stat.php");
}

$total_players = DB::numrows(DB::Query("SELECT * FROM `{$DB}`.`users`"));
$total_villages = DB::numrows(DB::Query("SELECT * FROM `{$DB}`.`villages`"));

$total_player_vill = DB::numrows(DB::Query("SELECT * FROM `{$DB}`.`villages` WHERE `uid` != '-1'"));
$total_empty_vill = DB::numrows(DB::Query("SELECT * FROM `{$DB}`.`villages` WHERE `uid` = '-1'"));
$total_bonus_vill = DB::numrows(DB::Query("SELECT * FROM `{$DB}`.`villages` WHERE `bonus` != '0'"));

$total_mails = DB::numrows(DB::Query("SELECT * FROM `{$DB}`.`mails`"));
if ($total_mails>1000000000) {
	$mails_view = round($total_mails/1000000000,2) . " mld";
} elseif ($total_mails>1000000) {
	$mails_view = round($total_mails/1000000,2) . " mln";
}
$mails_per_player = $total_mails/$total_players;

$total_movements = DB::numrows(DB::Query("SELECT * FROM `{$DB}`.`movements`"));

$total_ally = DB::numrows(DB::Query("SELECT * FROM `{$DB}`.`ally`"));
$total_ally_players = DB::numrows(DB::Query("SELECT * FROM `{$DB}`.`users` WHERE `ally` != '-1'"));

$total_points = DB::fetch(DB::Query("SELECT SUM(`points`) FROM `{$DB}`.`users`"),"array")[0];
if ($total_points>1000000000) {
	$points_view = round($points_mails/1000000000,2) . " mld";
} elseif ($total_points>1000000) {
	$points_view = round($points_mails/1000000,2) . " mln";
}

$no_paladin = true;
require_once PE . "/index_top.php";

?>
			<div class="container-block-full">
			<div class="container-top-full"></div>
				<div class="container">
					<table width="100%">
						<tr>
							<td valign="top">
								<table class="vis" style="margin:0 18px 0 12px;">
									<?php
									foreach(World::worlds_list() as $server) {
										$s = World::configs($server);
										if ($s['status']==="off") {
											$class = " class=\"closed\"";
										} elseif ($server == w) {
											$class = " class=\"selected\"";
										} else {
											$class = "";
										}
										echo "<tr{$class}>
											<td  style=\"width:65px;\"><a href=\"http://{$server}.privek.tk/stat.php\">{$s['name']}</a></td>
										</tr>";
									}
									?>
																	</table>
							</td>
							<td valign="top" width="80%">
								<h2>Statystyka <?php echo $wconf['name']; ?></h2>
								<p><a href="/guest.php" target="_top">&raquo; Dostęp gościnny</a> <a href="?mode=settings">&raquo; Ustawienia świata</a></p>

								<table class="vis" width="98%">
									<tr><th width="150px">Liczba graczy:</th><th><?php echo format_number($total_villages); ?></th></tr>
									<tr><td>Liczba wiosek:</td><td><?php echo format_number($total_players); ?> (<?php echo round(format_number($total_villages/$total_players),2); ?> na gracza) </td></tr>
									<tr><td>Wioski gracza:</td><td><?php echo $total_player_vill; ?></td></tr>
									<tr><td>Wioski barbarzyńskie:</td><td><?php echo $total_empty_vill; ?></td></tr>
									<?php 
									if ($wconf['bonus_villages']==="true") {
									?><tr><td>Osady koczownicze:</td><td><?php echo $total_bouns_vill; ?></td></tr><?php } ?>
																	</table>
								<br />

								<table class="vis" width="98%">
									<tr><th width="150px">Poniższe dane zostały obliczone</th>
									<th><?php format_date(time());?></th></tr>
									<tr><td>Stan serwera:</td><td><?php echo MyTW_or($wconf['status'],"Otwarty","Zamknięty","on");?></td></tr>
									<tr><td>Czas pracy serwera:</td><td><?php echo ceil((time()-$wconf['start'])/(3600*24));?> dni</td></tr>
									<!--<tr><td>Liczba zalogowanych graczy:</td><td>2470</td></tr>-->
									<tr><td>Liczba wysłanych wiadomości:</td><td><?php echo $mails_view; ?> (<?php echo format_number($mails_per_player);?> na gracza) </td></tr>
									<!--<tr><td>Liczba wpisów na forum:</td><td>441.433 (9.2 na gracza) </td></tr>-->
									<tr><td>Ruchy wojsk:</td><td><?php echo format_number($total_movements);?> (<?php echo format_number($total_movements/$total_players);?> na gracza) </td></tr>
									<!--<tr><td>Działania handlowe:</td><td>13.793 (0.3 na gracza) </td></tr>-->
									<tr><td>Liczba plemion:</td><td><?php echo format_number($total_ally);?></td></tr>
									<tr><td>Liczba graczy w plemionach:</td><td><?php echo format_number($total_ally_player);?></td></tr>

									<tr><td>Liczba punktów (ogólnie):</td><td><?php echo $points_view;?> (<?php echo format_number($total_points/$total_players);?> na gracza, <?php echo format_number($total_villages/$total_players);?> na wioskę)</td></tr>

									<tr><td>Ilość surowców (ogólnie):</td><td><span class="nowrap"><span class="icon header wood" title="Drewno"> </span>432<span class="grey">.</span>766<span class="grey">.</span>493</span> <span class="nowrap"><span class="icon header stone" title="Glina"> </span>478<span class="grey">.</span>782<span class="grey">.</span>752</span> <span class="nowrap"><span class="icon header iron" title="Żelazo"> </span>488<span class="grey">.</span>195<span class="grey">.</span>285</span> </td></tr>
									<tr><td>Ludność (ogólnie):</td><td><span class="icon header population"> </span> 176,95 mln</td></tr>

									<tr>
										<td>Jednostki (ogólnie):</td>
										<td>
											<table width="100%">
												<tr>
													<th style="text-align:center"  width="14%"><img src="http://privek.tk/cdn/graphic/unit/unit_spear.png?48b3b" title="Pikinier" alt="" class="" /></th><th style="text-align:center"  width="14%"><img src="http://privek.tk/cdn/graphic/unit/unit_sword.png?b389d" title="Miecznik" alt="" class="" /></th><th style="text-align:center"  width="14%"><img src="http://privek.tk/cdn/graphic/unit/unit_axe.png?51d94" title="Topornik" alt="" class="" /></th><th style="text-align:center"  width="14%"><img src="http://privek.tk/cdn/graphic/unit/unit_archer.png?db2c3" title="Łucznik" alt="" class="" /></th><th style="text-align:center"  width="14%"><img src="http://privek.tk/cdn/graphic/unit/unit_spy.png?eb866" title="Zwiadowca" alt="" class="" /></th><th style="text-align:center"  width="14%"><img src="http://privek.tk/cdn/graphic/unit/unit_light.png?2d86d" title="Lekki kawalerzysta" alt="" class="" /></th>
												</tr>
												<tr>
													<td style="text-align:center"  class='unit-item'>22,36 mln.</td><td style="text-align:center"  class='unit-item'>15,17 mln.</td><td style="text-align:center"  class='unit-item'>14,43 mln.</td><td style="text-align:center"  class='unit-item'>3,94 mln.</td><td style="text-align:center"  class='unit-item'>3,99 mln.</td><td style="text-align:center"  class='unit-item'>12,00 mln.</td>
												</tr>
												<tr>
													<th style="text-align:center"  width="14%"><img src="http://privek.tk/cdn/graphic/unit/unit_marcher.png?ad3be" title="Łucznik na koniu" alt="" class="" /></th><th style="text-align:center"  width="14%"><img src="http://privek.tk/cdn/graphic/unit/unit_heavy.png?a83c9" title="Ciężki kawalerzysta" alt="" class="" /></th><th style="text-align:center"  width="14%"><img src="http://privek.tk/cdn/graphic/unit/unit_ram.png?2003e" title="Taran" alt="" class="" /></th><th style="text-align:center"  width="14%"><img src="http://privek.tk/cdn/graphic/unit/unit_catapult.png?5659c" title="Katapulta" alt="" class="" /></th><th style="text-align:center"  width="14%"><img src="http://privek.tk/cdn/graphic/unit/unit_knight.png?58dd0" title="Rycerz" alt="" class="" /></th><th style="text-align:center"  width="14%"><img src="http://privek.tk/cdn/graphic/unit/unit_snob.png?0019c" title="Szlachcic" alt="" class="" /></th><th style="text-align:center"  width="14%"><img src="http://privek.tk/cdn/graphic/unit/unit_militia.png?ff93f" title="Chłop" alt="" class="" /></th>
												</tr>
												<tr>
													<td style="text-align:center"  class='unit-item'>317.075</td><td style="text-align:center"  class='unit-item'>655.260</td><td style="text-align:center"  class='unit-item'>583.445</td><td style="text-align:center"  class='unit-item'>178.909</td><td style="text-align:center"  class='unit-item'>22.893</td><td style="text-align:center"  class='unit-item'>3.117</td><td style="text-align:center"  class='unit-item'>26.803</td>
												</tr>
											</table>
										</td>
									</tr>

									<tr>
										<td>Średnia jednostek na gracza:</td>
										<td>
											<table width="100%">
												<tr>
													<th style="text-align:center"  width="14%"><img src="http://privek.tk/cdn/graphic/unit/unit_spear.png?48b3b" title="Pikinier" alt="" class="" /></th><th style="text-align:center"  width="14%"><img src="http://privek.tk/cdn/graphic/unit/unit_sword.png?b389d" title="Miecznik" alt="" class="" /></th><th style="text-align:center"  width="14%"><img src="http://privek.tk/cdn/graphic/unit/unit_axe.png?51d94" title="Topornik" alt="" class="" /></th><th style="text-align:center"  width="14%"><img src="http://privek.tk/cdn/graphic/unit/unit_archer.png?db2c3" title="Łucznik" alt="" class="" /></th><th style="text-align:center"  width="14%"><img src="http://privek.tk/cdn/graphic/unit/unit_spy.png?eb866" title="Zwiadowca" alt="" class="" /></th><th style="text-align:center"  width="14%"><img src="http://privek.tk/cdn/graphic/unit/unit_light.png?2d86d" title="Lekki kawalerzysta" alt="" class="" /></th>
												</tr>
												<tr>
													<td style="text-align:center"  class='unit-item'>468</td><td style="text-align:center"  class='unit-item'>318</td><td style="text-align:center"  class='unit-item'>302</td><td style="text-align:center"  class='unit-item'>82</td><td style="text-align:center"  class='unit-item'>84</td><td style="text-align:center"  class='unit-item'>251</td>
												</tr>
												<tr>
													<th style="text-align:center"  width="14%"><img src="http://privek.tk/cdn/graphic/unit/unit_marcher.png?ad3be" title="Łucznik na koniu" alt="" class="" /></th><th style="text-align:center"  width="14%"><img src="http://privek.tk/cdn/graphic/unit/unit_heavy.png?a83c9" title="Ciężki kawalerzysta" alt="" class="" /></th><th style="text-align:center"  width="14%"><img src="http://privek.tk/cdn/graphic/unit/unit_ram.png?2003e" title="Taran" alt="" class="" /></th><th style="text-align:center"  width="14%"><img src="http://privek.tk/cdn/graphic/unit/unit_catapult.png?5659c" title="Katapulta" alt="" class="" /></th><th style="text-align:center"  width="14%"><img src="http://privek.tk/cdn/graphic/unit/unit_knight.png?58dd0" title="Rycerz" alt="" class="" /></th><th style="text-align:center"  width="14%"><img src="http://privek.tk/cdn/graphic/unit/unit_snob.png?0019c" title="Szlachcic" alt="" class="" /></th><th style="text-align:center"  width="14%"><img src="http://privek.tk/cdn/graphic/unit/unit_militia.png?ff93f" title="Chłop" alt="" class="" /></th>
												</tr>
												<tr>
													<td style="text-align:center"  class='unit-item'>7</td><td style="text-align:center"  class='unit-item'>14</td><td style="text-align:center"  class='unit-item'>12</td><td style="text-align:center"  class='unit-item'>4</td><td style="text-align:center"  class='unit-item hidden'>0</td><td style="text-align:center"  class='unit-item hidden'>0</td><td style="text-align:center"  class='unit-item'>1</td>
												</tr>
											</table>
										</td>
									</tr>

									<tr>
										<td>Średnia jednostek na wioskę:</td>
										<td>
											<table width="100%">
												<tr>
													<th style="text-align:center"  width="14%"><img src="http://privek.tk/cdn/graphic/unit/unit_spear.png?48b3b" title="Pikinier" alt="" class="" /></th><th style="text-align:center"  width="14%"><img src="http://privek.tk/cdn/graphic/unit/unit_sword.png?b389d" title="Miecznik" alt="" class="" /></th><th style="text-align:center"  width="14%"><img src="http://privek.tk/cdn/graphic/unit/unit_axe.png?51d94" title="Topornik" alt="" class="" /></th><th style="text-align:center"  width="14%"><img src="http://privek.tk/cdn/graphic/unit/unit_archer.png?db2c3" title="Łucznik" alt="" class="" /></th><th style="text-align:center"  width="14%"><img src="http://privek.tk/cdn/graphic/unit/unit_spy.png?eb866" title="Zwiadowca" alt="" class="" /></th><th style="text-align:center"  width="14%"><img src="http://privek.tk/cdn/graphic/unit/unit_light.png?2d86d" title="Lekki kawalerzysta" alt="" class="" /></th>
												</tr>
												<tr>
													<td style="text-align:center"  class='unit-item'>165</td><td style="text-align:center"  class='unit-item'>112</td><td style="text-align:center"  class='unit-item'>106</td><td style="text-align:center"  class='unit-item'>29</td><td style="text-align:center"  class='unit-item'>29</td><td style="text-align:center"  class='unit-item'>88</td>
												</tr>
												<tr>
													<th style="text-align:center"  width="14%"><img src="http://privek.tk/cdn/graphic/unit/unit_marcher.png?ad3be" title="Łucznik na koniu" alt="" class="" /></th><th style="text-align:center"  width="14%"><img src="http://privek.tk/cdn/graphic/unit/unit_heavy.png?a83c9" title="Ciężki kawalerzysta" alt="" class="" /></th><th style="text-align:center"  width="14%"><img src="http://privek.tk/cdn/graphic/unit/unit_ram.png?2003e" title="Taran" alt="" class="" /></th><th style="text-align:center"  width="14%"><img src="http://privek.tk/cdn/graphic/unit/unit_catapult.png?5659c" title="Katapulta" alt="" class="" /></th><th style="text-align:center"  width="14%"><img src="http://privek.tk/cdn/graphic/unit/unit_knight.png?58dd0" title="Rycerz" alt="" class="" /></th><th style="text-align:center"  width="14%"><img src="http://privek.tk/cdn/graphic/unit/unit_snob.png?0019c" title="Szlachcic" alt="" class="" /></th><th style="text-align:center"  width="14%"><img src="http://privek.tk/cdn/graphic/unit/unit_militia.png?ff93f" title="Chłop" alt="" class="" /></th>
												</tr>
												<tr>
													<td style="text-align:center"  class='unit-item'>2</td><td style="text-align:center"  class='unit-item'>5</td><td style="text-align:center"  class='unit-item'>4</td><td style="text-align:center"  class='unit-item'>1</td><td style="text-align:center"  class='unit-item hidden'>0</td><td style="text-align:center"  class='unit-item hidden'>0</td><td style="text-align:center"  class='unit-item hidden'>0</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr>
										<td>Najnowszy gracz:</td>
										<td>
																						<a href="guest.php?screen=info_player&;id=698762456">Gość762456</a>
																					</td>
									</tr>
									<tr>
										<td>Najnowsze plemię:</td>
										<td>
																						<a href="guest.php?screen=info_ally&;id=15200">sdd</a>
																					</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</div>
			<div class="container-bottom-full"></div>
		 </div>
		</div><!-- content -->
<?php
require_once PE . "/index_footer.php";
?>