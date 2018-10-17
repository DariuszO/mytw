<?php
if (isset($_GET['x']) && isset($_GET['y'])) {
	$x = (int)$_GET['x'];
	$y = (int)$_GET['y'];
} else {
	$x = $village['x'];
	$y = $village['y'];
}

?>	
<h2>Kontynent <span id="continent_id"><?php echo $village['continent']; ?></span></h2>

<script type="text/javascript">
//<![CDATA[

	/** General purpose map script variables **/

	TWMap.premium = <?php echo MyTW_or($premium,"true","false",true); ?>;
	TWMap.mobile = false;
	TWMap.morale = true;
	TWMap.night = false;
	TWMap.light = false;
	//Needed to display day borders if user activated classic graphics
	TWMap.classic_gfx = false;

	TWMap.scrollBound = [0, 0, 999, 999];
	TWMap.tileSize = [53, 38];

	TWMap.screenKey = '<?php echo $hkey; ?>';
	TWMap.topoKey = 4182149762;
	TWMap.con.CON_COUNT = 10;
	TWMap.con.SEC_COUNT = 20;
	TWMap.con.SUB_COUNT = 5;

	TWMap.image_base = '<?php echo $cfg['cdn']; ?>/graphic/';
	TWMap.graphics = '<?php echo $cfg['cdn']; ?>/graphic//map/<?php echo MyTW_or($user['map_old_style'],"","version2/","1") ?>';

			TWMap.currentVillage = <?php echo $village['id']; ?>;
		TWMap.cachePopupContents = true;

    TWMap.minimap_cache_stamp = 5;


	/** Context menu **/

	TWMap.urls.ctx = {};
	TWMap.urls.ctx.mp_overview = '/game.php?village=__village__&screen=overview';
	TWMap.urls.ctx.mp_info = '/game.php?village=<?php echo $village['id']; ?>&id=__village__&screen=info_village';
	TWMap.urls.ctx.mp_fav = '/game.php?village=<?php echo $village['id']; ?>&id=__village__&ajaxaction=add_target&h=<?php echo $hkey; ?>&json=1&screen=info_village';
	TWMap.urls.ctx.mp_unfav = '/game.php?village=<?php echo $village['id']; ?>&id=__village__&ajaxaction=del_target&h=<?php echo $hkey; ?>&json=1&screen=info_village';
	TWMap.urls.ctx.mp_lock = '/game.php?village=<?php echo $village['id']; ?>&id=__village__&ajaxaction=toggle_reserve_village&h=<?php echo $hkey; ?>&json=1&screen=info_village';
	TWMap.urls.ctx.mp_res = '/game.php?village=<?php echo $village['id']; ?>&mode=send&target=__village__&screen=market';
	TWMap.urls.ctx.mp_att = '/game.php?village=<?php echo $village['id']; ?>&target=__village__&screen=place';
	TWMap.urls.ctx.mp_recruit = '/game.php?village=__village__&screen=train';
	TWMap.urls.ctx.mp_profile = '/game.php?village=<?php echo $village['id']; ?>&id=__owner__&screen=info_player';
	TWMap.urls.ctx.mp_msg = '/game.php?village=<?php echo $village['id']; ?>&mode=new&player=__owner__&screen=mail';
	TWMap.urls.ctx.mp_unlock = TWMap.urls.ctx.mp_lock;
	TWMap.urls.ctx.mp_invite = '/game.php?village=<?php echo $village['id']; ?>&mode=ref&source=map&screen=settings';
	TWMap.urls.ctx.mp_invite_hide = '/game.php?village=<?php echo $village['id']; ?>&ajaxaction=map_hide_invitation&h=<?php echo $hkey; ?>&json=1&screen=settings';
	TWMap.urls.ctx.mp_farm_a = '/game.php?village=<?php echo $village['id']; ?>&mode=farm&ajaxaction=farm&h=<?php echo $hkey; ?>&template_id=a&target=__village__&source=__source__&json=1&screen=am_farm';
	TWMap.urls.ctx.mp_farm_b = '/game.php?village=<?php echo $village['id']; ?>&mode=farm&ajaxaction=farm&h=<?php echo $hkey; ?>&template_id=b&target=__village__&source=__source__&json=1&screen=am_farm';
	
		TWMap.ghost = false;
	
	TWMap.context.enabled = true;
			TWMap.context._showPremium = true;
	
	TWMap.centerList.enabled = true;

	/** Other URLs **/

	TWMap.urls.villageInfo = '/game.php?village=<?php echo $village['id']; ?>&id=__village__&screen=info_village';
	TWMap.urls.villagePopup = '/game.php?village=__village__&ajax=map_info&source=<?php echo $village['id']; ?>&screen=overview';
	TWMap.urls.sizeSave = '/game.php?village=<?php echo $village['id']; ?>&ajaxaction=set_map_size&h=<?php echo $hkey; ?>&screen=settings';
	TWMap.urls.changeShowBelief = '/game.php?village=<?php echo $village['id']; ?>&ajaxaction=change_topo_show_belief&h=<?php echo $hkey; ?>&screen=settings';
	TWMap.urls.changeShowPolitical = '/game.php?village=<?php echo $village['id']; ?>&ajaxaction=change_topo_show_political&h=<?php echo $hkey; ?>&screen=settings';
	TWMap.urls.changeUseContext = '/game.php?village=<?php echo $village['id']; ?>&ajaxaction=change_use_contextmenu&h=<?php echo $hkey; ?>&screen=settings';
	TWMap.urls.savePopup = '/game.php?village=<?php echo $village['id']; ?>&ajax=save_map_popup&screen=map';
	TWMap.urls.centerCoords = '/game.php?village=<?php echo $village['id']; ?>&mode=centerlist&screen=map';
	TWMap.urls.centerSave = '/game.php?village=<?php echo $village['id']; ?>&mode=centerlist&ajaxaction=save_center&h=<?php echo $hkey; ?>&screen=map';

	/** Attacked villages **/
	
	/** Village colors **/

			TWMap.colors['this'] = [255, 255, 255];
			TWMap.colors['player'] = [240, 200, 0];
			TWMap.colors['friend'] = [69, 255, 146];
			TWMap.colors['ally'] = [0, 0, 244];
			TWMap.colors['partner'] = [0, 160, 244];
			TWMap.colors['nap'] = [128, 0, 128];
			TWMap.colors['enemy'] = [244, 0, 0];
			TWMap.colors['other'] = [130, 60, 10];
			TWMap.colors['sleep'] = [0, 0, 0];
			TWMap.colors['grey'] = [150, 150, 150];
			TWMap.colors['highlight_village'] = [255, 0, 255];
			TWMap.colors['highlight_player'] = [239, 165, 239];
	
	TWMap.secrets = {};

	TWMap.inline_send.enabled = 1;

	TWMap.ignore_villages = [];

	TWMap.attackable_players = null;

	/** Some sector fun **/
	TWMap.sectorPrefech = [];


//]]>
</script>


<table cellspacing="0" cellpadding="0">
    <tr>
	<td  id="map_big" class="map_big visible" valign="top">
			<div id="worldmap" class="popup_style" style="">
	<form name="worldmap" action="" method="post">
		<!--  WORLDMAP HEAD -->
		<div id="worldmap_header">
			<div class="close popup_menu">
				<a href="javascript:void(0);" onclick="Worldmap.toggle(); return false;">Zamknąć</a>
			</div>

						<fieldset id="worldmap_settings">
				<input type="checkbox" name="worldmap_barbarian_toggle" id="worldmap_barbarian_toggle" checked="checked" onclick="Worldmap.reload();" />
				<label for="worldmap_barbarian_toggle">Barbarzyńcy</label>
				<input type="checkbox" name="worldmap_ally_toggle" id="worldmap_ally_toggle" checked="checked" onclick="Worldmap.reload();" />
				<label for="worldmap_ally_toggle">Własne plemię</label>
				<input type="checkbox" name="worldmap_partner_toggle" id="worldmap_partner_toggle" checked="checked" onclick="Worldmap.reload();" />
				<label for="worldmap_partner_toggle">Sprzymierzeńcy</label>
				<input type="checkbox" name="worldmap_nap_toggle" id="worldmap_nap_toggle" checked="checked" onclick="Worldmap.reload();" />
				<label for="worldmap_nap_toggle">Pakty o nieagresji</label>
				<input type="checkbox" name="worldmap_enemy_toggle" id="worldmap_enemy_toggle" checked="checked" onclick="Worldmap.reload();" />
				<label for="worldmap_enemy_toggle">Wrogowie</label>

								<input type="checkbox" name="worldmap_secrets_toggle" id="worldmap_secrets_toggle" checked="checked" onclick="$('#secrets').toggle();" />
				<label for="worldmap_secrets_toggle">Odkrycia</label>
							</fieldset>
			
			<input type="hidden" name="min_x" value="1" />
			<input type="hidden" name="min_y" value="1" />
		</div>

		<img src="<?php echo $cfg['cdn']; ?>/graphic/throbber.gif?3286b" id="worldmap-throbber" alt="Loading..." style="display:none" class="" />

		<div id="worldmap_body">
			<div id="worldmap_image">
				<input type="image" src="/graphic/transparent.png" />
			</div>

							<div id="secrets">
									</div>
					</div>

		<div id="worldmap_footer">
			<table style="text-align:left;display:inline;">
				<?php
				$total_vill = DB::numrows(DB::Query("SELECT * FROM `{$DB}`.`villages`"));
				$total_barbian = DB::numrows(DB::Query("SELECT * FROM `{$DB}`.`villages` WHERE `uid` = '-1'"));
				$barbian_proc = round($total_barbian/$total_vill,4)*100;
				?>
				<tr>
					<th>Wioski</th>
					<th>Barbarzyńcy</th>
					<th>%</th>
					<th>Własne plemię</th>
					<th>%</th>
					<th>Własne</th>
					<th>%</th>
				</tr>
				<tr>
					<td><?php echo $total_vill;?></td>
					<td><?php echo $total_barbian;?></td>
					<td><?php echo $barbian_proc;?></td>
					<td></td>
					<td>0</td>
					<td>7</td>
					<td>0</td>
				</tr>
			</table>
		</div>
	</form>
</div>

<script type="text/javascript">
//<![CDATA[
	$(document).ready(function() {
		Worldmap.init(0);
	});
//]]>
</script>		<div class="containerBorder narrow" id="map_whole">
	<table cellspacing="0" cellpadding="0" class="map_container" style="border-spacing: 0">
		<tr>
			<td></td>
			<td align="center" onclick="TWMap.scrollBlock(0, -1); return false;" class="map_navigation">
				<img src="<?php echo $cfg['cdn']; ?>/graphic/map/map_n.png" alt="map/map_n.png" style="z-index:1; position:relative;" class="" />
			</td>
			<td></td>
		</tr>
		<tr>
			<td align="center" onclick="TWMap.scrollBlock(-1, 0); return false;" class="map_navigation">
				<img src="<?php echo $cfg['cdn']; ?>/graphic/map/map_w.png" alt="map/map_w.png" style="z-index:1; position:relative;" class="" />
			</td>

			<td style="padding: 0">
				<div id="map_wrap" style="position:relative;">
				 	<div id="map_coord_y_wrap" style="height:<?php echo $user['map_size_y']*38; ?>px;">
						<div id="map_coord_y" style="position:absolute; left:0px; top:0px; height:38000px; overflow: visible;"></div>					</div>
					<div id="map_coord_x_wrap" style="width:<?php echo $user['map_size_x']*53; ?>px; ">
						<div id="map_coord_x" style="position:absolute; left:0px; top:0px; width:53000px; overflow: visible;"></div>					</div>
					<img src="<?php echo $cfg['cdn']; ?>/graphic/fullscreen.png" id="fullscreen" onclick="TWMap.goFullscreen()" alt="" class="" />
					<a class="mp" id="mp_res" title="Wyślij surowce" href="/game.php?screen=map"></a>
					<a class="mp" id="mp_att" title="Wyślij wojska" href="/game.php?screen=map"></a>
					<a class="mp" id="mp_lock" title="Zarezerwuj wioskę" href="/game.php?screen=map"></a>
					<a class="mp" id="mp_unlock" title="Usuń rezerwację" href="/game.php?screen=map"></a>
					<a class="mp" id="mp_fav" title="Dodaj do ulubionych" href="/game.php?screen=map"></a>
					<a class="mp" id="mp_unfav" title="Usuń z ulubionych" href="/game.php?screen=map"></a>
					<a class="mp" id="mp_msg" title="Napisz wiadomość" href="/game.php?screen=map"></a>
					<a class="mp" id="mp_profile" title="Pokaż profil gracza" href="/game.php?screen=map"></a>
					<a class="mp" id="mp_overview" title="Przegląd wioski" href="/game.php?screen=map"></a>
					<a class="mp" id="mp_recruit" title="Rekrutacja" href="/game.php?screen=map"></a>
					<a class="mp" id="mp_tab" title="Pokaż w nowej zakładce" href="/game.php?screen=map"></a>
					<a class="mp" id="mp_info" title="Informacje o wiosce" href="/game.php?screen=map"></a>
										<a class="mp" id="mp_invite" title="Zaproś gracza" href="/game.php?screen=map"></a>
					<a class="mp" id="mp_invite_hide" title="Ukryj podpowiedź o zaproszeniach" href="/game.php?screen=map"></a>
					<?php if ($user['am_farm_a']!=="[]") { ?>
						<a class="mp farmassistant-tooltip" data-minspeed="0.0007575757576" id="mp_farm_a" href="/game.php?screen=map" data-tooltip-tpl="<?php
						$units = @json_decode($user['am_farm_a'],true);
						$res = 0;
						$html = "";
						foreach($units as $unit => $number) {
							$html .= "<img src=\"{$cfg['cdn']}/graphic/unit/unit_{$unit}.png\" /> {$number} <br />";
							$res += $cl_units->get_res($unit,$number);
						}
						echo HTMLSpecialChars($html);
						?>"></a>
																<a class="mp" id="mp_invite" title="Zaproś gracza" href="/game.php?screen=map"></a>
					<a class="mp" id="mp_invite_hide" title="Ukryj podpowiedź o zaproszeniach" href="/game.php?screen=map"></a>
																<a class="mp" id="mp_invite" title="Zaproś gracza" href="/game.php?screen=map"></a>
					<a class="mp" id="mp_invite_hide" title="Ukryj podpowiedź o zaproszeniach" href="/game.php?screen=map"></a>
					<?php } ?>
					                        <a id="map" href="#" style="width:<?php echo $user['map_size_x']*53; ?>px; height:<?php echo $user['map_size_y']*38; ?>px;overflow:hidden;position:relative;background-image:url('<?php echo $cfg['cdn']; ?>/graphic/map/version2/gras4.png');">
                            <div id="map_blend" style="position:absolute; top:0px; left:0px; width:100%; height:100%; background-color:black; z-index: 20; opacity:0;  "></div>
                        </a>
                        <div id="special_effects_container"></div>
					

				</div>
			</td>

			<td align="center" onclick="TWMap.scrollBlock(1, 0); return false;" class="map_navigation">
				<img src="<?php echo $cfg['cdn']; ?>/graphic/map/map_e.png" alt="map/map_e.png" style="z-index:1; position:relative;" class="" />
			</td>
		</tr>


		<tr>
			<td></td>

			<td align="center" onclick="TWMap.scrollBlock(0, 1); return false;" class="map_navigation">
				<img src="<?php echo $cfg['cdn']; ?>/graphic/map/map_s.png" alt="map/map_s.png" style="z-index:1; position:relative;" class="" />
			</td>

			<td></td>
		</tr>
	</table>
	</div>
				<br/>
		<div class="containerBorder" style="float: left; margin-bottom: 15px;">
<table style="border:solid 1px #8c5f0d; background-color: #f4e4bc; margin-left: 0px; border-collapse:separate; text-align:left;">
	<tr class="nowrap">
		<td class="small" valign="top">Standard:</td>
		<td>
			<div class="map_legend">
				<div style="background-color:rgb(255,255,255)"></div> <span>Wybrane</span>
			</div>
			<div class="map_legend">
				<div style="background-color:rgb(240,200,0)"></div> <span>Własne wioski</span>
			</div>
            <div class="map_legend">
                <div style="background-color:rgb(69,255,146)"></div> <span>Przyjaciele</span>
            </div>
			<div class="map_legend" style="clear: both">
				<div style="background-color:rgb(0,0,244)"></div> <span>Własne plemię</span>
			</div>
			<div class="map_legend" >
				<div style="background-color:rgb(150,150,150)"></div> <span>Barbarzyńskie</span>
			</div>
			<div class="map_legend">
				<div style="background-color:rgb(130,60,10)"></div> <span>Inne</span>
			</div>
		</td>
	</tr>
	<?php if ($user['ally'] !== "-1") { ?>
	<tr class="nowrap">
		<td class="small" valign="top">Plemię:</td>
		<td>
			<div class="map_legend">
				<div style="background-color:rgb(0,160,244)"></div> <span>Sprzymierzeńcy</span>
			</div>
			<div class="map_legend">
				<div style="background-color:rgb(128,0,128)"></div> <span>Pakty o nieagresji</span>
			</div>
			<div class="map_legend">
				<div style="background-color:rgb(244,0,0)"></div> <span>Wrogowie</span>
			</div>
		</td>
	</tr>
	<?php
	}
	$result = DB::Query("SELECT * FROM `{$DB}`.`map_groups` WHERE `uid` = '{$user['id']}' AND `group_type` = '0'");
	if (DB::Numrows($result) > 0) {
	?>
	<tr class="nowrap">
		<td class="small" valign="top">Inne:</td>
		<td>
			<?php
			$i = 0;
			while($row = DB::fetch($result)) {
				$i++;
				if ($i%3===0) {
					$s = " style=\"clear: both\"";
				} else {
					$s = "";
				}
				echo "<div class=\"map_legend\"{$s}>
				<div style=\" background-color:rgb({$row['r']}, {$row['g']}, {$row['b']})\"></div> <span>". entparse($row['name'])."</span>
			</div>";
			}
			?>
				</td>
	</tr>
	<?php } ?>
			</table>
</div>
<br />

<div style="width:100%; text-align:left; clear:both;">
<a onclick="$('#village_colors').toggle();" href="javascript:void(0);">&raquo; Zarządzaj grupami</a>
</div>
<br />
<div id="village_colors" class="containerBorder" style="display:none; float: left; clear:both;">
<table style="background-color: #f4e4bc; border:solid 1px #8c5f0d;">
<tr>
 <td valign="top">
  <h5>Własne wioski</h5>
      <br />
  <!--<div id="own_villages" style="border-width:2px; border-style: solid; border-color:#804000; background-color:#DED3B9; position:absolute;
left:700px;
top:200px;
width:290px; z-index:9999; display:none">
	<div id="edit_color_popup_menu" class="popup_menu"><a id="tut_min" href="#" onclick="ColorGroups.own_villages_toggle(event);return false;">Zamknąć</a></div>
	
	<div style="padding:10px;background-image:url('<?php echo $cfg['cdn']; ?>/graphic//background/content.jpg')">
	 <strong>Wybierz grupę</strong><br /><br />
	 <form method="post" action="/game.php?village=<?php echo $village['id']; ?>&action=add_own_group&h=<?php echo $hkey; ?>&screen=map">
	 <select name="add_group">
	 	  <option value="10862">Ma szlachcica</option>
	 	  <option value="10861">Nadchodzący atak</option>
	 	  <option value="10860">Pełny atak</option>
	 	 </select>
	 <input class="btn" type="submit" value="Dodaj"/>
	 </form>
	</div>
</div>-->  <a href="#" onclick="ColorGroups.own_villages_toggle(event);return false;" class="tooltip" title="Już niedługo...">&raquo; Dodaj własną grupę</a>
   </td>
 <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
 <td valign="top">
  <h5>Inne wioski</h5>
  <form method="post" action="/game.php?village=<?php echo $village['id']; ?>&type=for&action=activate_group&h=<?php echo $hkey; ?>&screen=map">
  <table class="vis" id="for_groups">
   <tbody>
	<?php
	$result = DB::Query("SELECT * FROM `{$DB}`.`map_groups` WHERE `uid` = '{$user['id']}' AND `group_type` = '0'");
	while($row = DB::fetch($result)) {
	?>
	<tr>
	 <td><input checked="checked" type="checkbox" name="group_<?php echo $row['id'];?>"/></td>
	 <td style="padding-right:10px" class="small" id="groupname_<?php echo $row['id'];?>"><?php echo entparse($row['name']);?></td>
	 <td class="small" width="15">
		<a href="#" onclick="ColorGroups.edit_color_toggle($(this), '/game.php?village=<?php echo $village['id']; ?>&ajaxaction=load_edit_color&h=<?php echo $hkey; ?>&screen=map', <?php echo $row['id'];?>, <?php echo $row['r'];?>, <?php echo $row['g'];?>, <?php echo $row['b'];?>, null, false);return false;" style="display: block;width:29px;height:18px;background-image:url('/graphic/colorpicker.png')">
		  <span style="display:block;position:relative;left:3px;top:3px;width:12px;height:12px;background-color:rgb(<?php echo $row['r'];?>, <?php echo $row['g'];?>, <?php echo $row['b'];?>);">&nbsp;</span>
		</a>
	 </td>
	 <td><input type="button" value="Edytuj" class="btn" onclick="ColorGroups.for_villages_toggle($(this), <?php echo $row['id'];?>, '/game.php?village=<?php echo $village['id']; ?>&ajaxaction=load_for_groups&h=<?php echo $hkey; ?>&screen=map'); return false;"/></td>
	 <td><a href="/game.php?village=<?php echo $village['id']; ?>&action=del_group&h=<?php echo $hkey; ?>&screen=map&group_id=<?php echo $row['id'];?>" class="evt-confirm" data-confirm-msg="Czy na pewno chcesz usunąć tę grupę?"><img src="<?php echo $cfg['cdn']; ?>/graphic/delete.png" alt="Skasuj" class="" /></a></td>
	</tr>
	<?php
	}
	?>
		<tr id="new_group" style="display:none">
	 <td colspan="5">
	  <input type="text" name="new_group_name" onkeydown="if (event.keyCode == 13) $('#for_new_group').click();"/>
	  <input class="btn" type="submit" name="for_new_group" id="for_new_group" value="OK"/>
	 </td>
	</tr>
   </tbody>
  </table>
    <input type="hidden" name="type" value="for"/>
  <input class="btn" type="submit" value="Zapisz" style="margin-top:5px;"/>
    </form>
  <br />
  <a href="#" onclick="javascript:ColorGroups.add_for_village();return false">&raquo; Utwórz nową grupę</a>
 </td>
</tr>
</table>
</div>

		<script type="text/javascript">
		//<![CDATA[
		<?php 
		$result = DB::Query("SELECT * FROM `{$DB}`.`map_groups` WHERE `uid` = '{$user['id']}' AND `group_type` = '0'");
		while($row = DB::fetch($result)) {
			$colors = DB::Query("SELECT * FROM `{$DB}`.`map_colors` WHERE `group` = '{$row['id']}'");
			while($color = DB::fetch($colors)) {
				if ($color['type']==="1") $type = "ally";
				if ($color['type']==="2") $type = "player";
				if ($color['type']==="3") $type = "village";
				$colors_js = json_encode([
					$row['r'],
					$row['g'],
					$row['b']
				]);
				echo "TWMap.{$type}Groups[{$color['value']}] = {$colors_js};\r\n";
			}
		}
		?>
		//]]>
		</script>
			</td>

	<td id="map_topo" class="map_topo" valign="top">
		<div class="containerBorder" id="minimap_whole">
		<table cellspacing="0" cellpadding="0" class="map_container minimap_container" style="border-spacing: 0">
			<tr>
				<td align="center">
					<img alt="Północny zachód" class="dir_arrow" onclick="TWMap.scrollBlock(-1, -1); return false;" style="z-index: 1; position: relative;" src="/graphic/map/map_nw.png" />
				</td>
				<td align="center">
					<img alt="Północ" class="dir_arrow" onclick="TWMap.scrollBlock(0, -1); return false;" style="z-index: 1; position: relative;" src="/graphic/map/map_n.png" />
				</td>
				<td align="center">
					<img alt="Północny wschód" class="dir_arrow" onclick="TWMap.scrollBlock(1, -1); return false;" style="z-index: 1; position: relative;" src="/graphic/map/map_ne.png" />
				</td>
			</tr>
			<tr>
				<td align="center">
					<img alt="Zachód" class="dir_arrow" onclick="TWMap.scrollBlock(-1, 0); return false;" style="z-index: 1; position: relative;" src="/graphic/map/map_w.png" />
				</td>
				<td style="padding: 0" id="minimap_cont">
					<div id="minimap" style="overflow:hidden; position:relative; padding:0px;width:<?php echo $user['map_mini_size_x']*5;?>px; height:<?php echo $user['map_mini_size_y']*5;?>px">
						<div id="minimap_viewport" style="border:1px solid white; position: absolute; z-index:10;"></div>
					</div>
				</td>
				<td align="center">
					<img alt="Wschód" class="dir_arrow" onclick="TWMap.scrollBlock(1, 0); return false;" style="z-index: 1; position: relative;" src="/graphic/map/map_e.png" />
				</td>
			</tr>
			<tr>
				<td align="center">
					<img alt="Południowy zachód" class="dir_arrow" onclick="TWMap.scrollBlock(-1, 1); return false;" style="z-index: 1; position: relative;" src="/graphic/map/map_sw.png" />
				</td>
				<td align="center">
					<img alt="Południe" class="dir_arrow" onclick="TWMap.scrollBlock(0, 1); return false;" style="z-index: 1; position: relative;" src="/graphic/map/map_s.png" />
				</td>
				<td align="center">
					<img alt="Południowy wschód" class="dir_arrow" onclick="TWMap.scrollBlock(1, 1); return false;" style="z-index: 1; position: relative;" src="/graphic/map/map_se.png" />
				</td>
			</tr>
		</table>
		</div>
		<div id="map_config">
					<div style="margin-top:10px;margin-bottom:10px;">
							<a href="javascript:void(0);" onclick="Worldmap.toggle()">&raquo; Pokaż mapę świata</a><br/>
			
			</div>
		

			<table class="vis" style="border-spacing:0px;border-collapse:collapse;" width="100%">
		<tr>
			<th colspan="3">Opcje wyświetlania</th>
		</tr>
		
					<tr>
	<td>
		<input type="checkbox" id="show_popup" <?php echo MyTW_or($user['map_popup_show'],"checked","","1");?> />
	</td>
	<td>
		<label for="show_popup">Pokaż wyskakujące okienko</label>
	</td>
	<td width="18">
		<img class="popup_options_toggler" src="" />	</td>
</tr>
<tr id="popup_options">
	<td colspan="3" style="padding-left:8px">
	<form id="form_map_popup">
        <table>
            <tr>
                <td>
                    <input type="checkbox" id="map_popup_attack" name="map_popup_attack" <?php echo MyTW_or($user['map_popup_attack'],"checked","","1");?> />
                </td>
                <td>
                    <label for="map_popup_attack">Pokaż ostatni atak</label>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="checkbox" id="map_popup_attack_intel" name="map_popup_attack_intel" <?php echo MyTW_or($user['map_popup_attack_intel'],"checked","","1");?> />
                </td>
                <td>
                    <label for="map_popup_attack_intel">Pokaż informacje z przesłanych ataków</label>
                </td>
            </tr>

			            <tr>
                <td>
                    <input type="checkbox" id="map_popup_moral" name="map_popup_moral"  checked="checked" <?php echo MyTW_or($user['map_popup_moral'],"checked","","1");?> />
                </td>
                <td>
                    <label for="map_popup_moral">Pokaż morale</label>
                </td>
            </tr>
			            <tr>
                <td>
                    <input type="checkbox" id="map_popup_res" name="map_popup_res" <?php echo MyTW_or($user['map_popup_res'],"checked","","1");?> />
                </td>
                <td>
                    <label for="map_popup_res">Pokaż surowce</label>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="checkbox" id="map_popup_pop" name="map_popup_pop" <?php echo MyTW_or($user['map_popup_pop'],"checked","","1");?> />
                </td>
                <td>
                    <label for="map_popup_pop">Ludność (ogólnie)</label>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="checkbox" id="map_popup_trader" name="map_popup_trader" <?php echo MyTW_or($user['map_popup_trader'],"checked","","1");?> />
                </td>
                <td>
                    <label for="map_popup_trader">Pokaż kupców</label>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="checkbox" id="map_popup_reservation" name="map_popup_reservation" <?php echo MyTW_or($user['map_popup_reservation'],"checked","","1");?> />
                </td>
                <td>
                    <label for="map_popup_reservation">Pokaż rezerwacje</label>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="checkbox" id="map_popup_units" name="map_popup_units" onclick="$('#map_popup_units_home').prop('disabled', this.checked ? '' : 'disabled').attr('checked', '')" <?php echo MyTW_or($user['map_popup_units'],"checked","","1");?> />
                </td>
                <td>
                    <label for="map_popup_units">Pokaż wojska</label>
                </td>
            </tr>
			<tr>
                <td>
                    <input type="checkbox" id="map_popup_units_home" name="map_popup_units_home" <?php echo MyTW_or($user['map_popup_units'],"disabled=\"disabled\"","","0");?> <?php echo MyTW_or($user['map_popup_units_home'],"checked","","1");?> />
                </td>
                <td>
                    <label for="map_popup_units_home">Pokaż wojska w wiosce</label>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="checkbox" id="map_popup_units_times" name="map_popup_units_times" <?php echo MyTW_or($user['map_popup_times'],"checked","","1");?> />
                </td>
                <td>
                    <label for="map_popup_units_times">Pokaż czas podróży</label>
                </td>
            </tr>

						<tr>
                <td>
                    <input type="checkbox" id="map_popup_flag" name="map_popup_flag" <?php echo MyTW_or($user['map_popup_flag'],"checked","","1");?> />
                </td>
                <td>
                    <label for="map_popup_flag">Pokaż flagę</label>
                </td>
            </tr>
			
            <tr>
                <td>
                    <input type="checkbox" id="map_popup_notes" name="map_popup_notes" <?php echo MyTW_or($user['map_popup_notes'],"checked","","1");?> />
                </td>
                <td>
                    <label for="map_popup_notes">Pokaż notatnik wioski</label>
                                    </td>
            </tr>
        </table>
	</form>
	</td>
</tr>
		
		</table>
		</div>
		<br />
		<form action="" method="post">
		    <table class="vis"  width="100%" style="border-spacing:0px;border-collapse:collapse;">
			<tr>
			    <th colspan="3">Scentruj mapę</th>
			</tr>
			<tr>
			    <td class="nowrap">
			    x:&nbsp;<input type="text" name="x" id="mapx" class="centercoord" value="<?php echo $x; ?>" style="width: 30px" onkeyup="xProcess('mapx', 'mapy')" />
			    y:&nbsp;<input type="text" name="y" id="mapy" class="centercoord" value="<?php echo $y; ?>" style="width: 30px" />
			    </td>
			    <td>
				<input class="btn" type="submit" onclick="return TWMap.focusSubmit();" value="OK" />
			    </td>
				<td width="18">
					<img src="" class="map-slider centercoords_toggler"/>
				</td>
			</tr>
			<tr id="centercoords">
			</tr>
		    </table>
		</form>
					<br />
<table class="vis" width="100%">
	<tr>
		<th colspan=2>Zmień rozmiar mapy</th>
	</tr>
	<tr>
		<td><table cellspacing="0"><tr>
		<td width="80">Mapa:</td>
		<td>
			<select id="map_chooser_select" onchange="TWMap.resize(parseInt($('#map_chooser_select').val()), true)">
				<?php
				$sizes = [4,5,7,9,11,13,15,20,30];
				if ($user['map_size_x']===$user['map_size_y']) {
					if (in_array($user['map_size_x'],$sizes)) {
						$style = "style=\"display:none;\"";
					} else {
						$style = "selected=\"selected\"";
					}
					echo "<option id=\"current-map-size\" value=\"{$user['map_size_x']}x{$user['map_size_y']}\" {$style}>{$user['map_size_x']}x{$user['map_size_y']}</option>";
				} else {
					echo "<option id=\"current-map-size\" value=\"{$user['map_size_x']}x{$user['map_size_y']}\" selected=\"selected\">{$user['map_size_x']}x{$user['map_size_y']}</option>";
				}
				foreach($sizes as $size) {
					if ($user['map_size_x']==$size && $user['map_size_y']) {
						$sel = "selected=\"selected\"";
					} else {
						$sel = "";
					}
					echo "<option value=\"{$size}\" {$sel}>{$size}x{$size}</option>";
				}
				?>
											</select>
			</td>
						<td valign="middle">
				<img alt="" class="tooltip" src="<?php echo $cfg['cdn']; ?>/graphic//questionmark.png" width="13" height="13" title="Możesz dowolnie zmienić rozmiar mapy za pomocą myszki" />
			</td>
						</tr></table>
			<input type="hidden" value="/game.php?village=<?php echo $village['id']; ?>&ajaxaction=set_map_size&h=<?php echo $hkey; ?>&screen=settings" id="change_map_size_link" />
		</td>
	</tr>
		<tr>
		<td><table cellspacing="0"><tr>
		<td width="80">Minimapa:</td>
		<td colspan="2">
			<select id="minimap_chooser_select" onchange="TWMap.resizeMinimap(parseInt($('#minimap_chooser_select').val()), true)">
					<?php
				$sizes = [20,30,40,50,60,70,80,90,100,110,120];
				if ($user['map_mini_size_x']===$user['map_mini_size_y']) {
					if (in_array($user['map_mini_size_x'],$sizes)) {
						$style = "style=\"display:none;\"";
					} else {
						$style = "selected=\"selected\"";
					}
					echo "<option id=\"current-minimap-size\" value=\"{$user['map_mini_size_x']}x{$user['map_mini_size_y']}\" {$style}>{$user['map_mini_size_x']}x{$user['map_mini_size_y']}</option>";
				} else {
					echo "<option id=\"current-minimap-size\" value=\"{$user['map_mini_size_x']}x{$user['map_mini_size_y']}\" selected=\"selected\">{$user['map_mini_size_x']}x{$user['map_mini_size_y']}</option>";
				}
				foreach($sizes as $size) {
					if ($user['map_mini_size_x']==$size && $user['map_mini_size_y']) {
						$sel = "selected=\"selected\"";
					} else {
						$sel = "";
					}
					echo "<option value=\"{$size}\" {$sel}>{$size}x{$size}</option>";
				}
				?>
							</select>
			</td>
			</tr></table>
			<input type="hidden" value="/game.php?village=<?php echo $village['id']; ?>&ajaxaction=set_map_size&h=<?php echo $hkey; ?>&screen=settings" id="change_map_size_link" />
		</td>
	</tr>
	</table>

		


	</td>
    </tr>
</table>

<!-- Translations -->
	<input type="hidden" id="newbieProt" value="Cel jeszcze ma ochronę początkową. Można zaatakować dopiero %s."/>
	<input type="hidden" id="barbarianVillage" value="wioska barbarzyńska"/>
	<input type="hidden" id="pointFormat" value="%s (%s punktów)"/>
	<input type="hidden" id="villageFormat" value="%name% (%x%|%y%) K%con%"/>
	<input type="hidden" id="villageNotes" value="Notatki"/>
	<input type="hidden" id="villageFavoriteAdded" value="Wioska została dodana do ulubionych."/>
	<input type="hidden" id="villageFavoriteRemoved" value="Wioska została usunięta z ulubionych."/>
	<input type="hidden" id="barbarianVillage" value="wioska barbarzyńska"/>
	<input type="hidden" id="changesSaved" value="Zmiany zostały zapisane."/>
	<input type="hidden" id="confirmCenterDelete" value="Czy na pewno chcesz usunąć "%name%"?"/>
	<input type="hidden" id="troopsSent" value="Wojska zostały wysłane."/>

	<script type="text/javascript">
//<![CDATA[

$(document).ready(function() {
	
		MapCanvas.churchData = [];
	MapCanvas.init();
	
	
	TWMap.autoPixelSize = $(window).width() - 100;
	TWMap.autoSize = Math.ceil(TWMap.autoPixelSize / TWMap.tileSize[0]);

			TWMap.size = <?php echo json_encode([$user['map_size_x'],$user['map_size_y']]);?>;
	
	TWMap.popup.extraInfo = true;
	
	TWMap.politicalMap.displayed = false;
	TWMap.politicalMap.filter = 25;
	TWMap.church.displayed = true;

	TWMap.init();

            TWMap.focus(<?php echo $x; ?>, <?php echo $y; ?>);
    	
	TWMap.context.init();

		TWMap.minimap.createResizer([20, 20], [120,120], 5);
	TWMap.map.createResizer([4,4], [30,30]);
	
	
	// Allow resize of map when iPhone/Android phone is flipped.

	if(mobile) {
		var resizeTimer = null;
		var flippingSupported = "onorientationchange" in window,
			flipEvent = flippingSupported ? "orientationchange" : "resize";

		window.addEventListener(flipEvent, function() {
			var autoSelected = (parseInt($('#map_chooser_select').val()) == 0);
			if(autoSelected) {
				if (resizeTimer === null) {
					resizeTimer = setTimeout(function() {
						TWMap.resize(0, false);
						resizeTimer = null;
					}, 500);
				}
			}
		}, false);
	}
	
});
//]]>
</script>

<script type="text/html" id="tpl_popup">

	<table id="info_content" class="vis" style="background-color: #e5d7b2; width:auto">
<% if (special == 'ghost') { %>
	<tr>
		<th colspan="2">Miejsce dla zaproszonego</th>
	</tr>
	<tr>
		<td colspan="2">Zaproś znajomego do gry w sąsiedztwie!</td>
	</tr>
<% } else { %>
<% if (bonus) { %>
	<tr id="info_bonus_image_row" >
		<td id="info_bonus_image" rowspan="14"><img src="<%= bonus.img %>" /></td>
	</tr>
<% } /* end bonus */ %>

	<tr>
		<th colspan="2"><%=name%> <%== '(%x%|%y%) K%continent%' %></th>
	</tr>


<% if (bonus) { %>
	<tr id="info_bonus_text_row">
		<td colspan="2"><strong id="info_bonus_text"><%= bonus.text %></strong></td>
	</tr>
<% } /* end bonus */ %>
<% if (points) { %>
	<tr id="info_points_row">
		<td width="100px">Punkty:</td>
		<td id="info_points"><%= points %></td>
	</tr>
<% } /* end points */ %>
<% if (owner) { %>
	<tr id="info_owner_row">
		<td>Właściciel:</td>
		<td><%== '%name% (%points% Punktów)', owner %></td>
	</tr>
<% } else if (points == 0) { %>
	<tr id="info_left_row">
		<td colspan="2">Lokalizacja specjalna</td>
	</tr>
<% } else { %>
	<tr id="info_left_row">
		<td colspan="2">Opuszczona</td>
	</tr>
<% } /* end owner */ %>

<% if (ally) { %>
	<tr id="info_ally_row">
		<td>Plemię:</td>
		<td><%== '%name% (%points% Punktów)', ally %></td>
	</tr>
<% } /* end ally */ %>
<% if (extra && extra.reservation && $('#map_popup_reservation').is(":checked")) { %>
	<tr><td>Rezerwacja dokonana przez:</td><td id="info_reserved_by"><%= extra.reservation.name %> [<%= extra.reservation.ally%>]</td></tr>
	<tr><td>Rezerwacja wygasa:</td><td id="info_reserved_till"><%= extra.reservation.expires_at %></td></tr>
<% } %>
<% if (extra && extra.attack && $('#map_popup_attack').is(":checked")) { %>
	<tr>
		<td>Ostatni atak:</td>
		<td id="info_last_attack">
			<img src="<?php echo $cfg['cdn']; ?>/graphic/<%= TWMap.popup.attackDots[extra.attack.dot]%>" title="" alt="" class="" />
			<% if (extra.attack.dot != 4) { %>
				<img src="<?php echo $cfg['cdn']; ?>/graphic/<%= TWMap.popup.attackMaxLoot[extra.attack.max_loot]%>" title="" alt="" class="" />
			<% } %>

			<%= extra.attack.time %>
		</td>
	</tr>
<% } %>
<% if (extra && extra.attack_intel && $('#map_popup_attack_intel').is(":checked")) { %>
	<tr>
		<td>Ostatnie dane:</td>
		<td id="info_last_attack_intel">
			<img src="<?php echo $cfg['cdn']; ?>/graphic/<%= TWMap.popup.attackDots[extra.attack_intel.dot]%>" title="" alt="" class="" />
			<% if (extra.attack_intel.dot != 4) { %>
				<img src="<?php echo $cfg['cdn']; ?>/graphic/<%= TWMap.popup.attackMaxLoot[extra.attack_intel.max_loot]%>" title="" alt="" class="" />
			<% } %>

			<%= extra.attack_intel.time %>
			<% if (extra.attack_intel.start_player) { %>
				<%== 'od %start_player%', extra.attack_intel %>
			<% } %>
		</td>
	</tr>
<% } %>
<% if (extra && extra.morale && $('#map_popup_moral').is(":checked") && TWMap.morale) { %>
	<tr id="info_moral_row">
		<td>Morale:</td>
		<td id="info_moral"><%= Math.round(100 * extra.morale) %>%</td>
	</tr>
<% } %>
<% if (extra && extra.groups && extra.groups.length) { %>
	<tr id="info_village_groups_row">
		<td>Grupy:</td>
		<td id="info_village_groups"><%= extra.groups.join(', ') %></td>
	</tr>
<% } %>
<% if (extra && extra.flag && $('#map_popup_flag').is(":checked")) { %>
	<tr id="info_flag">
		<td>Flaga:</td>
		<td id="info_village_flag"><img src="<%= extra.flag.image_path %>"></img> <%= extra.flag.short_desc %></td>
	</tr>
<% } %>
<% if (owner && owner.newbie_time) { %>
	<tr id="info_newbie_protect_row">
		<td colspan="2"><%== 'Cel ma jeszcze ochronę początkową. Można zaatakować dopiero %newbie_time%.', owner %></td>
	</tr>
<% } /* end newbie */ %>
<% if (extra && extra.resources && $('#map_popup_res').is(":checked")) { %>
	<tr>
		<td colspan="2">
			<table cellpadding="3" class="nowrap">
				<tr>
					<% if (extra.resources.wood) { %>
						<td><img src="<?php echo $cfg['cdn']; ?>/graphic/holz.png?a3702" title="" alt="" class="" /> <%= extra.resources.wood %></td>
					<% } %>
					<% if (extra.resources.stone) { %>
						<td><img src="<?php echo $cfg['cdn']; ?>/graphic/lehm.png?6c9bd" title="" alt="" class="" /> <%= extra.resources.stone %></td>
					<% } %>
					<% if (extra.resources.iron) { %>
						<td><img src="<?php echo $cfg['cdn']; ?>/graphic/eisen.png?0e9e5" title="" alt="" class="" /> <%= extra.resources.iron %></td>
					<% } %>
					<% if (extra.resources.max) { %>
						<td><img src="<?php echo $cfg['cdn']; ?>/graphic/res.png?0fdfc" title="" alt="" class="" /> <%= extra.resources.max %></td>
					<% } %>
				</tr>
			</table>
		</td>
	</tr>
<% } %>
<%
  var showPopulation = extra && extra.population && $('#map_popup_pop').is(":checked");
  var showTrader = extra && extra.trader && $('#map_popup_trader').is(":checked");
%>

<% if (showPopulation || showTrader) { %>
	<tr>
		<% if (showPopulation && showTrader) { %>
		<td>
		<% } else { %>
		<td colspan="2">
		<% } %>

		<% if (showPopulation) { %>
			<img src="<?php echo $cfg['cdn']; ?>/graphic/face.png?203fc" title="" alt="" class="" /> <%= extra.population.current %>/<%= extra.population.max %>
		<% } %>

		<% if (showPopulation && showTrader) { %> </td><td> <% } %>

		<% if (showTrader) { %>
			<img src="<?php echo $cfg['cdn']; ?>/graphic/overview/trader.png?4df99" title="" alt="" class="" /> <%= extra.trader.current %>/<%= extra.trader.total %>
		<% } %>
		</td>
	</tr>
<% } %>
<%
  var bg_colors = ['F8F4E8', 'DED3B9'];
  if (units.length > 0) {
%>
	<tr>
		<td colspan="2">
			<table style="border:1px solid #DED3B9" width="100%" cellpadding="0" cellspacing="0">
				<tr class="center">
					<% for (var i = 0; i < units.length; i++) { %>
					<td style="padding:2px;background-color:#<%= bg_colors[i%2] %>">
						<img src="<?php echo $cfg['cdn']; ?>/graphic/<%= units[i].image %>" title="" alt="" class="" />
					</td>
					<% } %>
				</tr>
				<% if (units_display.count) { %>
				<tr class="center">
					<% for (var i = 0; i < units.length; i++) { %>
					<td style="padding:2px;background-color:#<%= bg_colors[i%2] %>">
						<%= units[i].count %>
					</td>
					<% } %>
				</tr>
				<% } /* end unit count */ %>
				<% if (units_display.time) { %>
				<tr class="center">
					<% for (var i = 0; i < units.length; i++) { %>
					<td style="padding:2px;background-color:#<%= bg_colors[i%2] %>">
						<%= units[i].time %>
					</td>
					<% } %>
				</tr>
				<% } /* end unit times */ %>

			</table>
		</td>
	</tr>
<%
  } /* end units */
%>
<% if (extra && extra.notes && $('#map_popup_notes').is(':checked')) { %>
	<tr>
		<td colspan="2"><hr /><u>Notatki:</u> <%= extra.notes %></td>
	</tr>
<% } /* end notes */ %>
<% if (extra === false) { %>
	<tr>
		<td colspan="2"><table><tr><td><img src="<?php echo $cfg['cdn']; ?>/graphic/throbber.gif?3286b" title="" alt="" class="" /></td><td>Ładowanie informacji...</td></tr></table></td>
	</tr>
<% } %>

<% } %>

</table>
</script>
<div id="map_popup" class="nowrap" style="position:absolute; top:0px; left:0px; min-width:150px; display:none; z-index:20; direction:ltr;">
</div>

