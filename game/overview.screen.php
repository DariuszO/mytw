<?php

$columns = Array();

$columns['show_summary'] = [
	entparse($village['name']) . " ({$village['points']} punktów)",
	true,
	"<table class=\"vis\" width=\"100%\"><tr><td>Wkrótce...</td></tr></table>"
];

if (time() - $user['game_start'] <= $conf['player_protect']*60) {
	$newbie_show = true;
} else {
	$newbie_show = false;
}

$columns['show_newbie'] = [
	"Ochrona początkowa",
	$newbie_show,
	"Twoja ochrona początkowa kończy się " . format_date(time() - $user['game_start'])
];

$columns['show_prod'] = [
	"Produkcja",
	true,
	"<table width=\"100%\">
			<tr class=\"nowrap\">
			<td width=\"70\">
								<a href=\"/game.php?village={$village['id']}&screen=wood\"><span class=\"icon header wood\"> </span></a> Drewno
							</td>
			<td>
				<strong> {$production_wood}</strong> na godzinę			</td>
		</tr>
			<tr class=\"nowrap\">
			<td width=\"70\">
								<a href=\"/game.php?village={$village['id']}&screen=stone\"><span class=\"icon header stone\"> </span></a> Glina
							</td>
			<td>
				<strong> {$production_stone}</strong> na godzinę			</td>
		</tr>
			<tr class=\"nowrap\">
			<td width=\"70\">
								<a href=\"/game.php?village={$village['id']}&screen=iron\"><span class=\"icon header iron\"> </span></a> Żelazo
							</td>
			<td>
				<strong> {$production_iron}</strong> na godzinę			</td>
		</tr>
	</table>"
];

if ($village['units_count'] > 0) {
	$units_show = true;
} else {
	$units_show = false;
}
$units_table = "";

$columns['show_units'] = [
	"Jednostki",
	$units_show,
	$units_table
];

$columns['show_mood'] = [
	"Poparcie",
	MyTW_or($village['agreement'],false,true,"100"),
	"<table class=\"vis\" width=\"100%\"><tr><td></td></tr></table>"
];


$buildqueue_show = false;
$buildqueue_table = "";

$columns['show_buildqueue'] = [
	"Kolejka budowy",
	$buildqueue_show,
	$buildqueue_table
];


$vnote = entparse(DB::Fetch(DB::Query("SELECT * FROM `{$DB}`.`notes` WHERE `type` = '2' AND `user` = '{$user['id']}' AND `own` = '{$village['id']}'"))['text']);

$columns['show_notes'] = [
	"Notatki",
	true,
	"
	<script type=\"text/javascript\">
//<![CDATA[
	function editNotesPopup(url) {
		var x = $('#edit_notes_link').offset().left - 300;
		var y = $('#edit_notes_link').offset().top - 300;
		UI.AjaxPopup(null, 'village_notes_popup', url, 'Notatki wioski', null, {dataType:'html', reload:true}, 400, 300, x, y);
	}
	function editNotes(edit_link) {
		var note = $('textarea[name=\"note\"]').val();

		$.post(edit_link, {note:note}, function(data) {
			$('#village_note').html(data.note_parsed).parent().show();
			$('#village_notes_popup').remove();
		}, 'json');
	}
//]]>
</script>


<table width=\"100%\">
	<tr style=\"display:none\">
		<td id=\"village_note\">{$vnote}</td>
	</tr>
	<tr><td><a id=\"edit_notes_link\" href=\"#\" onclick=\"editNotesPopup('/game.php?ajaxaction=edit_notes_popup&h={$hkey}&village={$village['id']}&screen=overview'); return false;\">&raquo; Edytuj</a></td></tr>
</table>"
];

$columns['show_events'] = [
	"Wydarzenia",
	$EVENT_STATUS,
	"---"
];
?>
      		<table cellspacing="0" cellpadding="0" id="overviewtable" align="center">
	<tr>
		<td valign="top" id="leftcolumn" width="612">
			<?php
			$left = json_decode($user['overview_leftcolumn'],true);
			if (!is_array($left)) {
				$left = [];
			}
			foreach($left as $column) {
				$c = $columns[$column];
				if (strlen($c[0]) > 0) {
					if ($c[1]===true) {
						echo "<div id=\"{$column}\" class=\"vis moveable widget\">
					<h4 class=\"head\">";
						if ($user["overview_{$column}"]==="0") {
							echo "<img style=\"float: right; cursor: pointer;\" onclick=\"return VillageOverview.toggleWidget( '{$column}', this );\" src=\"graphic/minus.png\" />";
							$d = "block";
						} else {
							echo "<img style=\"float: right; cursor: pointer;\" onclick=\"return VillageOverview.toggleWidget( '{$column}', this );\" src=\"graphic/plus.png\" />";
							$d = "none";
						}
						echo "{$c[0]} \r\n 					</h4>
						<div class=\"widget_content\" style=\"display: {$d};\">{$c[2]}</div>
						</div>";
						
					} else {
						echo "<div id=\"{$column}\" class=\"vis moveable hidden_widget\" style=\"display: none;\">
					<h4 class=\"head\">
						{$c[0]}
					</h4>
					</div>";
					}
				}
			}
			?>
		</td>
		<td valign="top" id="rightcolumn" width="612">
			<?php
			$right = json_decode($user['overview_rightcolumn']);
			if (!is_array($right)) {
				$right = [];
			}
			foreach($right as $column) {
				$c = $columns[$column];
				if (strlen($c[0]) > 0) {
					if ($c[1]===true) {
						echo "<div id=\"{$column}\" class=\"vis moveable widget\">
					<h4 class=\"head\">";
						if ($user["overview_{$column}"]==="0") {
							echo "<img style=\"float: right; cursor: pointer;\" onclick=\"return VillageOverview.toggleWidget( '{$column}', this );\" src=\"graphic/minus.png\" />";
							$d = "block";
						} else {
							echo "<img style=\"float: right; cursor: pointer;\" onclick=\"return VillageOverview.toggleWidget( '{$column}', this );\" src=\"graphic/plus.png\" />";
							$d = "none";
						}
						echo "{$c[0]} \r\n 					</h4>
						<div class=\"widget_content\" style=\"display: {$d};\">{$c[2]}</div>
						</div>";
						
					} else {
						echo "<div id=\"{$column}\" class=\"vis moveable hidden_widget\" style=\"display: none;\">
					<h4 class=\"head\">
						{$c[0]}
					</h4>
					</div>";
					}
				}
			}
			?>
		</td>
	</tr>
</table>

    <a href="/game.php?village=<?php echo $village['id']; ?>&action=reset&h=<?php echo $hkey; ?>&screen=overview">&raquo; Zresetuj podgląd</a>

<style type="text/css">
	.placeholder {
		height: 20px;
	}

	.moveable h4 {
		cursor:move;
	}
</style>

<script type="text/javascript">
//<![CDATA[
$( function() {
	VillageOverview.urls.reorder = '/game.php?village=<?php echo $village['id']; ?>&ajaxaction=reorder&h=<?php echo $hkey; ?>&screen=overview';
	VillageOverview.urls.toggle = '/game.php?village=<?php echo $village['id']; ?>&ajaxaction=toggle&h=<?php echo $hkey; ?>&screen=overview';
	VillageOverview.init();
});
//]]>
</script>

<script type="text/javascript" src="/js/game/unit_popup.js?1417014857"></script>

<script type="text/javascript">
//<![CDATA[
	$(function() {
		UnitPopup.unit_data = {"spear":{"name":"Pikinier\u00f3w","desc":"Pikinier jest najprostsz\u0105 jednostk\u0105. Jest efektywny w obronie przeciwko je\u017adzie.","wood":50,"stone":30,"iron":10,"pop":1,"speed":0.0009259259259,"attack":10,"attack_buildings":null,"defense":15,"defense_cavalry":45,"defense_archer":20,"carry":25,"tag_group":"infantry","can_attack":true,"can_support":true,"type":"infantry","image":"unit\/unit_spear.png","prod_building":"barracks","attackpoints":4,"defpoints":1,"build_time":1020,"shortname":"Pika","count":"93","reqs":[{"building_id":"barracks","building_link":"\/game.php?village=<?php echo $village['id']; ?>&screen=barracks","name":"Koszary","level":1}]},"sword":{"name":"Miecznik\u00f3w","desc":"Miecznicy s\u0105 efektywni w obronie przeciwko piechocie. Poruszaj\u0105 si\u0119 jednak bardzo wolno.","wood":30,"stone":30,"iron":70,"pop":1,"speed":0.0007575757576,"attack":25,"attack_buildings":null,"defense":50,"defense_cavalry":15,"defense_archer":40,"carry":15,"tag_group":"infantry","can_attack":true,"can_support":true,"type":"infantry","image":"unit\/unit_sword.png","prod_building":"barracks","attackpoints":5,"defpoints":2,"build_time":1500,"shortname":"Miecz","count":"47","reqs":[{"building_id":"smith","building_link":"\/game.php?village=<?php echo $village['id']; ?>&screen=smith","name":"Ku\u017ania","level":1}]},"axe":{"name":"Topornik\u00f3w","desc":"Topornik to mocna jednostka atakuj\u0105ca. Jak szaleni atakuj\u0105 wioski przeciwnik\u00f3w.","wood":60,"stone":30,"iron":40,"pop":1,"speed":0.0009259259259,"attack":40,"attack_buildings":null,"defense":10,"defense_cavalry":5,"defense_archer":10,"carry":10,"tag_group":"infantry","can_attack":true,"can_support":true,"type":"infantry","image":"unit\/unit_axe.png","prod_building":"barracks","attackpoints":1,"defpoints":4,"build_time":1320,"shortname":"Top\u00f3r","count":"3033","reqs":[{"building_id":"smith","building_link":"\/game.php?village=<?php echo $village['id']; ?>&screen=smith","name":"Ku\u017ania","level":2}],"tech_costs":{"wood":700,"stone":840,"iron":820}},"spy":{"name":"Zwiadowc\u00f3w","desc":"Zwiadowca atakuje wiosk\u0119 po to, by donie\u015b\u0107 informacje o jej wojsku, budynkach i surowcach.","wood":50,"stone":50,"iron":20,"pop":2,"speed":0.001851851852,"attack":0,"attack_buildings":null,"defense":2,"defense_cavalry":1,"defense_archer":2,"carry":0,"tag_group":"spy","can_attack":true,"can_support":true,"type":"other","image":"unit\/unit_spy.png","prod_building":"stable","attackpoints":1,"defpoints":2,"build_time":900,"shortname":"Zwiad","count":"1017","reqs":[{"building_id":"stable","building_link":"\/game.php?village=<?php echo $village['id']; ?>&screen=stable","name":"Stajnia","level":1}],"tech_costs":{"wood":560,"stone":480,"iron":480}},"light":{"name":"Lekkich kawalerzyst\u00f3w","desc":"Lekki kawalerzysta jest, dzi\u0119ki swojej szybko\u015bci, bardzo dobr\u0105 jednostk\u0105 do niespodziewanych atak\u00f3w.","wood":125,"stone":100,"iron":250,"pop":4,"speed":0.001666666667,"attack":130,"attack_buildings":null,"defense":30,"defense_cavalry":40,"defense_archer":30,"carry":80,"tag_group":"cavalry","can_attack":true,"can_support":true,"type":"cavalry","image":"unit\/unit_light.png","prod_building":"stable","attackpoints":5,"defpoints":13,"build_time":1800,"shortname":"LK","count":"1399","reqs":[{"building_id":"stable","building_link":"\/game.php?village=<?php echo $village['id']; ?>&screen=stable","name":"Stajnia","level":3}],"tech_costs":{"wood":2200,"stone":2400,"iron":2000}},"ram":{"name":"Tarany","desc":"Taran pomaga Ci w ataku na inne wioski, poniewa\u017c uszkadza mur obronny wroga.","wood":300,"stone":200,"iron":200,"pop":5,"speed":0.0005555555556,"attack":2,"attack_buildings":null,"defense":20,"defense_cavalry":50,"defense_archer":20,"carry":0,"tag_group":"siege","can_attack":true,"can_support":true,"type":"infantry","image":"unit\/unit_ram.png","prod_building":"garage","attackpoints":4,"defpoints":8,"build_time":4800,"shortname":"Taran","count":"93","reqs":[{"building_id":"garage","building_link":"\/game.php?village=<?php echo $village['id']; ?>&screen=garage","name":"Warsztat","level":1}],"tech_costs":{"wood":1200,"stone":1600,"iron":800}},"catapult":{"name":"Katapult","desc":"Katapulty nadaj\u0105 si\u0119 do niszczenia cudzych budynk\u00f3w.","wood":320,"stone":400,"iron":100,"pop":8,"speed":0.0005555555556,"attack":100,"attack_buildings":null,"defense":100,"defense_cavalry":50,"defense_archer":100,"carry":0,"tag_group":"siege","can_attack":true,"can_support":true,"type":"infantry","image":"unit\/unit_catapult.png","prod_building":"garage","build_time":7200,"attackpoints":12,"defpoints":10,"shortname":"Katapulta","count":"47","reqs":[{"building_id":"garage","building_link":"\/game.php?village=<?php echo $village['id']; ?>&screen=garage","name":"Warsztat","level":2},{"building_id":"smith","building_link":"\/game.php?village=<?php echo $village['id']; ?>&screen=smith","name":"Ku\u017ania","level":12}],"tech_costs":{"wood":1600,"stone":2000,"iron":1200}},"knight":{"name":"x_X","desc":"Rycerz chroni twoj\u0105 wiosk\u0119, jak r\u00f3wnie\u017c twoich sprzymierze\u0144c\u00f3w, przed obcymi napadami. Ka\u017cdy gracz mo\u017ce posiada\u0107 tylko jednego rycerza.","wood":20,"stone":20,"iron":40,"pop":10,"speed":0.001666666667,"attack":150,"attack_buildings":null,"defense":250,"defense_cavalry":400,"defense_archer":150,"carry":100,"tag_group":"infantry","can_attack":true,"can_support":true,"type":"cavalry","image":"unit\/unit_knight.png","prod_building":"statue","attackpoints":40,"defpoints":20,"build_time":21600,"shortname":"Rycerz"},"snob":{"name":"Szlachcic\u00f3w","desc":"Szlachcic mo\u017ce obni\u017cy\u0107 poparcie w wiosce atakowanej. Po obni\u017ceniu poparcia na zero lub ni\u017cej, wioska mo\u017ce by\u0107 zdobyta. Koszty szlachcica wzrastaj\u0105 z ka\u017cd\u0105 zdobyt\u0105 wiosk\u0105 oraz z ka\u017cdym posiadanym lub produkowanym szlachcicem.","wood":40000,"stone":50000,"iron":50000,"pop":100,"speed":0.0004761904762,"attack":30,"attack_buildings":null,"defense":100,"defense_cavalry":50,"defense_archer":100,"carry":0,"tag_group":"snob","can_attack":true,"can_support":true,"type":"infantry","image":"unit\/unit_snob.png","prod_building":"snob","attackpoints":200,"defpoints":200,"build_time":18000,"shortname":"Szlachcic","count":"3","reqs":[{"building_id":"snob","building_link":"\/game.php?village=<?php echo $village['id']; ?>&screen=snob","name":"Pa\u0142ac","level":1},{"building_id":"main","building_link":"\/game.php?village=<?php echo $village['id']; ?>&screen=main","name":"Ratusz","level":20},{"building_id":"smith","building_link":"\/game.php?village=<?php echo $village['id']; ?>&screen=smith","name":"Ku\u017ania","level":20},{"building_id":"market","building_link":"\/game.php?village=<?php echo $village['id']; ?>&screen=market","name":"Rynek","level":10}]}};
		UnitPopup.init();
			});
//]]>
</script>


<div class="popup_helper">
    <div id="inline_popup" class="hidden" style="width:700px;">
        <div id="inline_popup_menu">
            <span id="inline_popup_title"></span>
            <a id="inline_popup_close" href="javascript:inlinePopupClose()">X</a>
        </div>
        <div id="inline_popup_main" style="height: auto;">
            <div id="inline_popup_content"></div>
        </div>
    </div>
</div>

<div id="unit_popup_template" style="display: none">
		<div class="inner-border main content-border" style="border: none; font-weight: normal">
			<table style="float: left;width:450px">
			<tr>
				<td>
					<p class="unit_desc"></p>
				</td>
			</tr>
			<tr>
				<td>
					<table style="border: 1px solid #DED3B9;" class="vis" width="100%">
						<tr>
							<th width="180">Koszta</th>
							<th>Ludność</th>
							<th>Prędkość</th>
							<th>Ładowność</th>
						</tr>
						<tr class="center">
							<td><nobr><span class="icon header wood"> </span><span class="unit_wood"></span></nobr> <nobr><span class="icon header stone"> </span><span class="unit_stone"></span></nobr> <nobr><span class="icon header iron" > </span><span class="unit_iron"></span></nobr></td>
							<td><span class="icon header population"> </span><span class="unit_pop"></span></td>
							<td id="unit_speed"></td>
							<td class="unit_carry"></td>
						</tr>
					</table>
					<br />

					<table class="vis event_loot" style="display: none; width: 100%">
						<tr>
							<th colspan="2">Szczegóły wydarzenia</th>
						</tr>
						<tr>
							<td>Ładowność:</td>
							<td><span class="unit_event_loot"></span> <span class="unit_event_res_name"></span></td>
					</table>
					<br />

					<table class="vis has_levels_only" style="border: 1px solid #DED3B9;text-align:center" class="vis"  width="100%">
						<tr><th colspan="3">Statystyki bitewne</th></tr>
						<tr><td align="left">Siła napadu</td><td width="20px"><img src="<?php echo $cfg['cdn']; ?>/graphic/unit/att.png?1bdd4" alt="Siła napadu" class="" /></td><td><span class="unit_attack"></span></td></tr>
						<tr><td align="left">Obrona ogólnie</td><td><img src="<?php echo $cfg['cdn']; ?>/graphic/unit/def.png?12421" alt="Obrona ogólnie" class="" /></td><td><span class="unit_defense"></span></td></tr>
						<tr><td align="left">Obrona przeciwko kawalerii</td><td><img src="<?php echo $cfg['cdn']; ?>/graphic/unit/def_cav.png?46b3d" alt="Obrona przeciwko kawalerii" class="" /></td><td><span class="unit_defense_cavalry"></span></td></tr>
												<tr><td align="left">Obrona przeciwko łucznikom</td><td><img src="<?php echo $cfg['cdn']; ?>/graphic/unit/def_archer.png?faccf" alt="Obrona przeciwko łucznikom" class="" /></td><td><span class="unit_defense_archer"></span></td></tr>
											</table>
					<br />

					<div class="show_if_has_reqs">
						<table class="vis" width="100%">
							<tr><th id="reqs_count" colspan="1">Wymogi, by móc zbadać jednostkę</th></tr>
							<tr id="reqs"></tr>
						</table>
						<br />
					</div>

					<table class="unit_tech vis unit_tech_levels"  width="100%">
						<tr style="text-align:center">
							<th>Poziom technologiczny</th>
							<th width="350">Koszta badań (jeśli potrzebne)</th>
							<th width="30" style="text-align:center"><img src="<?php echo $cfg['cdn']; ?>/graphic/unit/att.png?1bdd4" alt="Siła napadu" class="" /></th>
							<th width="30" style="text-align:center"><img src="<?php echo $cfg['cdn']; ?>/graphic/unit/def.png?12421" alt="Obrona ogólnie" class="" /></th>
							<th width="30" style="text-align:center"><img src="<?php echo $cfg['cdn']; ?>/graphic/unit/def_cav.png?46b3d" alt="Obrona przeciwko kawalerii" class="" /></th>
							<th width="30" style="text-align:center"><img src="<?php echo $cfg['cdn']; ?>/graphic/unit/def_archer.png?faccf" alt="Obrona przeciwko łucznikom" class="" /></th>						</tr>
						<tr id="unit_tech_prototype" style="display: none;text-align:center">
							<td class="tech_level"></td>
							<td>
								<span class="grey tech_researched">juz zbadane</span>
								<span class="tech_res_list">
									<span class="icon header wood"> </span><span class="tech_wood"></span> <span class="icon header stone"> </span><span class="tech_stone"></span> <span class="icon header iron" > </span><span class="tech_iron"></span>
								</span>
							</td>
							<td class="tech_att"></td>
							<td class="tech_def"></td>
							<td class="tech_def_cav"></td>
														<td class="tech_def_archer"></td>
													</tr>
					</table>
					<table class="vis unit_tech unit_tech_cost"  width="100%">
						<tr><th>Koszta badań (jeśli potrzebne)</th></tr>
						<tr><td><span class="icon header wood"> </span><span class="tech_cost_wood"></span> <span class="icon header stone"> </span><span class="tech_cost_stone"></span> <span class="icon header iron" > </span><span class="tech_cost_iron"></span></td></tr>
					</table>
				</td>
			</tr>
		</table>
		<img style="margin-top: 60px; max-width: 200px; display: none" id="unit_image" src="graphic/map/empty.png" alt="" />
		</div>
	</div>
