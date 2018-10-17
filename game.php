<?php
/*
*	game.php
*	My-TW by Bartekst222
*/
require_once "./libraries/common.inc.php";

require_once PATH . "/libraries/world_common.inc.php";

function sid_wrong() {
	header("LOCATION: /sid_wrong.php");
}

function url($sc=[]) {
	global $village,$screen,$mode;
	$URL = $_SERVER["PHP_SELF"];
	$URL .= "?";
	$GET = array_merge($_GET,$sc);
	$URL .= HTTP_BUILD_QUERY($GET);
	return $URL;
}

$server = w;
//NewLog($_SERVER['REQUEST_URI'],"URL","/logs/game_url.log");
if (isset($_GET['map_elements'])) {
	$MM = new Map(0,0);
	$MM->newDecoration($_GET['map_elements']);
}
$session = $_COOKIE['session'];
$hkey = $_COOKIE['hkey'];
$user_glob = @DB::fetch(@DB::Query("SELECT * FROM `users` WHERE `session` = '{$session}' LIMIT 1"));

if ($user_glob===false) {
	sid_wrong();
} else {
	$sid->new_db($DB);
	$sess = $sid->check_sid($session);
	if ($sess===false) {
		sid_wrong();
	} else {
		$user = DB::fetch(@DB::Query("SELECT * FROM `{$DB}`.`users` WHERE `id` = '{$sess['uid']}' LIMIT 1"));
		if ($user===false) {
			sid_wrong();
		}
	}
}


$vid = @$_GET['village'];
if (!is_numeric($vid{0})) {
	$vl = $vid{0};
	$vid = str_replace($vid{0},"",$vid);
}

if (empty($vid)) {
	$vid = Village::get_first($user['id']);
	$village = Village::get($vid);
	if ($village===false || $user['villages'] === 0) {
		header("Location: /create_village.php");
	}
} else {
	$village = Village::get($vid);
	if ($village===false || $user['villages'] === 0) {
		header("Location: /create_village.php");
	} elseif($village['uid'] != $user['id']) {
		$vid = Village::get_first($user['id']);
		$village = Village::get($vid);
		if ($village===false && $user['villages'] === 0) {
			header("Location: /create_village.php");
		}
	}
}

$ACT_group = $_COOKIE["global_group_id_{$user['id']}"];
$next = 1;
$prev = 1;
//setcookie("global_group_id_{$user['id']}","1");
$gc = false;
if ($user['villages']!=="1") {
	if ($ACT_group > 0 AND Groups::exists($ACT_group,$user['id'])===true) {
		$allvill = Groups::villlist($gid);
		$gc = true;
	} else {
		$allvill = DB::Query("SELECT * FROM `{$DB}`.`villages` WHERE `uid` = '{$user['id']}' ORDER BY `name`");
	}
	$i = 0;
	while($row = DB::Fetch($allvill)) {
		$i++;
		$villes[$i] = $row;
		if ($row['id']===$village['id']) {
			$next = $i + 1;
			$prev = $i - 1;
		}
	}
		
	if ($next > $user['villages']) {
		$next = 1;
	}
	if ($prev < 1) {
		$prev = 1;
	}
}

if($vl==="n") {
	$village = $villes[$next];
} elseif($vl==="p") {
	$village = $villes[$prev];
} elseif($vl==="j") {

}

$other_css = [
	"map" => [
		"/css/game/map.css",
		"/css/game/village_target.css"
	],
	"welcome" => [
		"/css/game/promo.css"
	],
	"info_player" => [
		"/css/game/image_upload.css"
	],
	"overview" => [
		"/css/game/overview.css"
	]
];


$other_js = [
	"map" => [
		"/merged/map.js",
		"/js/game/twmap_drag.js"
	],
	"welcome" => [
		"/js/game/PromoPopup.js",
		"/js/game/../jquery/excanvas-2.min.js",
		"/js/game/../jquery/jquery.flot-1.8.min.js",
		"/js/game/../jquery/jquery.flot.time.min.js"
	],
	"mail" => [
		"/js/game/IGM.js"
	],
	"info_player" => [
		"/js/game/InfoPlayer.js",
		"/js/game/COA.js",
		"/merged/map.js",
		"/js/game/twmap_drag.js"	
	],
	"overview" => [
		"/js/game/VillageOverview.js",
		"/js/game/upgrade_building.js"
	]
];

if (!empty($user['css'])) {
	$other_css[$screen] = $user['css'];
}
if (empty($user['graphic'])) {
	$graphic = $user['graphic'];
} else {
	$graphic = $cfg['cdn'] . "/graphic/";
}

$p_points = $user_glob['premium_points'];
$premium = false;

if ($cfg['premium']==="1") { 
	$p_start = $user['premium_start'];
	$p_end = $user['premium_end'];
	$p_auto = MyTW_or($user['premium_auto'],true,false,"1");
	if (!empty($p_start)) {
		if ($p_start <= $p_end) {
			$premium = false;
		} else {
			$premium = true;
		}
	} else {
		$premium = false;
	}
} else {
	$premium = true;
}

$screen = $_GET['screen'];
if (empty($screen)) {
	$screen = "welcome";
}
$SFile = PATH . "/game/{$screen}.screen.php";
if (!file_exists($SFile)) {
	$screen = "404";
}
$UPerm = ["welcome","overview","map","mail","main","report","ranking","api","settings","info_player"];
$user_perm = json_decode($user['permissions'],true);
if($user_perm['all']!=="Y" && $screen != "404") {
	if ($user_perm['user_packet']==="Y") {
		if (!in_array($screen,$UPerm) && !in_array($screen,$user_perm)) {
			$screen = "permissions_denied";
		}
	} else {
		if (!in_array($screen,$user_perm)) {
			$screen = "permissions_denied";
		}
	}
}
$mode = @$_GET['mode'];
$ajax = @$_GET['ajax'];
$ajaxaction = @$_GET['ajaxaction'];
$action = @$_GET['action'];
$errors = Array();
if (file_exists(PATH . "/game/{$screen}.api.php")) {
	require_once PATH . "/game/{$screen}.api.php";
}

if (file_exists(PATH . "/game/{$screen}.{$ajax}.ajax.php") && isset($_GET['ajax'])) {
	require_once PATH . "/game/{$screen}.{$ajax}.ajax.php";
}
if (file_exists(PATH . "/game/{$screen}.{$ajaxaction}.ajaxaction.php") && isset($_GET['ajaxaction'])) {
	hkey_check($_GET['h'],$hkey);
	require_once PATH . "/game/{$screen}.{$ajaxaction}.ajaxaction.php";
}

if (isset($_GET['action'])) {
	$se = count($errors);
	hkey_check($_GET['h'],$hkey);
	if (file_exists(PATH . "/game/{$screen}.{$action}.action.php")) {
		require_once PATH . "/game/{$screen}.{$action}.action.php";
	} else {
		$errors[] = "Jeszcze nie zaimpletowano";
	}
}

$storage_max = Village::storage($village['id'],$server);
$pop_max = Village::pop($village['id'],$server);

$prod = Village::production($village['id'],$server);
$production = $prod['per_second'];
$production_wood = $prod['per_hour']['wood'];
$production_stone = $prod['per_hour']['stone'];
$production_iron = $prod['per_hour']['iron'];

$newres = Village::res_reload($village['id'],$server);
$village['wood_float'] = $newres[0];
$village['stone_float'] = $newres[1];
$village['iron_float'] = $newres[2];

$village_wood = floor($village['wood_float']);
$village_stone = floor($village['stone_float']);
$village_iron = floor($village['iron_float']);

if (isset($_GET['te'])) {
	echo "<form action=\"http://pl80.plemiona.pl/game.php?village=57773&ajaxaction=autocomplete&h=b3f5&screen=api\" method=\"POST\"><input name=\"type\" /><input name=\"text\"/><input type=\"submit\"/></form>";
	exit;
}


?>
<!DOCTYPE HTML>
<html>
<head>
	<title><?php echo entparse($village['name']) . " ({$village['x']}|{$village['y']}) - {$cfg['game_name']} - ".entparse($conf['name']);?> </title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<link id="favicon" rel="shortcut icon"  href="/favicon.ico" />

	<link rel="stylesheet" type="text/css" href="/merged/game.css" />
	<?php
	if (isset($other_css[$screen])) {
		foreach($other_css[$screen] as $css) {
			echo "
			<link rel=\"stylesheet\" type=\"text/css\" href=\"{$css}\" />
			";
		}
	}
	?>
	
	
	<script type="text/javascript" src="/merged/game.js"></script>
	
	<?php
	if (isset($other_js[$screen])) {
		foreach($other_js[$screen] as $js) {
			echo "
			<script type=\"text/javascript\" src=\"{$js}\"></script>
			";
		}
	}
	?>
		

	
	
	
	<script type="text/javascript">
        //<![CDATA[
        var sds = <?php echo MyTW_or($cfg['sds'],"true","false","1");?>;
		var image_base = "<?php echo $cfg['cdn']; ?>";
		var mobile = false;
		var mobile_on_normal = false;
        var mobiledevice = false;
		var premium = <?php echo MyTW_or($premium,"true","false",true); ?>;
		var server_utc_diff = 3600;
		<?php
		$game_data = [
			"player" => [
				"name" => entparse($user['name']),
				"ally" => MyTW_or($user['ally'],"-1",$user['ally'],"-1"),
				"sitter" => 0,
				"sleep_start" => 0,
				"sitter_type" => "normal",
				"sleep_end" => 0,
				"sleep_last" => 0,
				"interstitial" => 0,
				"email_valid" => 1,
				"villages" => $user['villages'],
				"incomings" => $user['attacks'],
				"supports" => $user['supports'],
				"knight_location" => $user['knight_location'],
				"rank" => $user['rank'],
				"points" => $user['points'],
				"date_started" => $user['game_start'],
				"is_guest" => 0,
				"id" => $user['id'],
				"quest_progress" => "0",
				"premium" => $premium,
				"account_manager" => true,
				"farm_manager" => false,
				"points_formatted" => format_number($user['points']),
				"rank_formatted" => format_number($user['rank']),
				"pp" => $p_points,
				"new_ally_application" => "0",
				"new_ally_invite" => "0",
				"new_buddy_request" => "0",
				"new_forum_post" => $user['new_forum'],
				"new_igm" => $user['new_mail'],
				"new_items" => $user['new_items'],
				"new_report" => $user['new_report'],
				"fire_pixel" => "0",
				"new_quest" => "0"
			],
			"village" => [
				"id" => $village['id'],
				"name" => entparse($village['name']),
				"wood_prod" => $production['wood'],
				"stone_prod" => $production['stone'],
				"iron_prod" => $production['iron'],
				"storage_max" => $storage_max,
				"pop_max" => $pop_max,
				"wood_float" => $village['wood_float'],
				"stone_float" => $village['stone_float'],
				"iron_float" => $village['iron_float'],
				"wood" => $village_wood,
				"stone" => $village_stone,
				"iron" => $village_iron,
				"pop" => $village['pop'],
				"x" => $village['x'],
				"y" => $village['y'],
				"trader_away" => "0",
				"bonus_id" => MyTW_or($village['bonus'],NULL,$village['bonus']),
				"bonus" => $village_bonus,
				"buildings" => [],
				"player_id" => $village['uid'],
				"res" => [$village_wood,$village['wood_float'],$village_stone,$village['stone_float'],$village_iron,$village['iron_float'],$storage_max,$village['pop'],$pop_max],
				"coord" => "{$village['x']}|{$village['y']}"
			],
			"nav" => [
				"parent" => 2
			],
			"link_base" => "/game.php?village={$village['id']}&screen=",
			"link_base_pure" => "/game.php?village={$village['id']}&screen=",
			"csfr" => $hkey,
			"world" => $server,
			"market" => "pl",
			"RTL" => false,
			"version" => $cfg['version'],
			"majorVersion" => $cfg['version'],
			"screen" => $screen,
			"mode" => MyTW_or($mode,null,$mode,""),
			"device" => "desktop"
		];
		foreach($cl_builds->get_array("dbname") as $build) {
			$game_data["village"]["buildings"][$build] = $village[$build];
		}
		?>
		var game_data = <?php echo json_encode($game_data); ?>;
	
		var csrf_token = '<?php echo $hkey; ?>';
			
		UI.AutoComplete.url = '/game.php?village=<?php echo $village['id']; ?>&ajaxaction=autocomplete&h=<?php echo $hkey; ?>&screen=api';
		ScriptAPI.url = '/game.php?village=<?php echo $village['id']; ?>&ajax=save_script&screen=api';
		ScriptAPI.version = parseFloat(game_data.majorVersion);

		
		var userCSS = false;
		
		var isIE7 = false;

		var topmenuIsAlwaysVisible = false;
					topmenuIsAlwaysVisible = true;
		
		
				VillageContext._urls.overview = '/game.php?village=__village__&screen=overview';
		VillageContext._urls.info = '/game.php?village=<?php echo $village['id']; ?>&id=__village__&screen=info_village';
		VillageContext._urls.fav = '/game.php?village=<?php echo $village['id']; ?>&id=__village__&ajaxaction=add_target&h=<?php echo $hkey; ?>&json=1&screen=info_village';
		VillageContext._urls.unfav = '/game.php?village=<?php echo $village['id']; ?>&id=__village__&ajaxaction=del_target&h=<?php echo $hkey; ?>&json=1&screen=info_village';
		VillageContext._urls.claim = '/game.php?village=<?php echo $village['id']; ?>&id=__village__&ajaxaction=toggle_reserve_village&h=<?php echo $hkey; ?>&json=1&screen=info_village';
		VillageContext._urls.market = '/game.php?village=<?php echo $village['id']; ?>&mode=send&target=__village__&screen=market';
		VillageContext._urls.place = '/game.php?village=<?php echo $village['id']; ?>&target=__village__&screen=place';
		VillageContext._urls.recruit = '/game.php?village=__village__&screen=train';
		VillageContext._urls.map = '/game.php?village=<?php echo $village['id']; ?>&beacon=1&id=__village__&screen=map';
		VillageContext._urls.unclaim = VillageContext._urls.claim;
        VillageContext.claim_enabled = false;
        VillageContext.igm_enabled = true;
        VillageContext.send_troops_enabled = true;
        VillageContext.send_attack_disabled = false;
				

		
		TribalWars._settings = {"sound":1,"map_casual_hide":1,"map_show_watchtower":0,"bn_attack":1,"bn_warehouse":1,"bn_mail":1,"bn_building":1};

		$(document).ready( function() {
			UI.ToolTip( $( '.group_tooltip' ), { delay: 1000 } );
			VillageContext.init();

		});

		
		//]]>
	</script>
	<!--[if IE 8]>
		<style type="text/css">
			/*
				Workaround for IE8 textarea scroll bug, see

				http://grantovich.net/posts/2009/06/that-weird-ie8-textarea-bug/

				You also need to set an absolute height for the element. since this depends
				on the location of the textarea, use an element style.
			*/
			textarea.ie8scrollfix { width: 300px !important; min-width: 98%; max-width: 98%;}
					</style>
	<![endif]-->
</head><body id="ds_body" class=" ">
	<script type="text/javascript">
    dataLayer = [{"campaignRef":"none","pageArea":"gamepage","pageMarket":"pl","pageName":"login_success","pagePool":"Tribal Wars","pageScope":"home","pageType":"game","pageVersion":"v1","visitorGameId":"","visitorLoginState":false,"visitorState":""}];
</script>

<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-M4ZWXP" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        '//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-M4ZWXP');
</script>
<!-- End Google Tag Manager -->
	
	<div class="top_bar">
		<div class="bg_left"> </div>
		<div class="bg_right"> </div>
	</div>
	<div class="top_shadow"> </div>
	<div class="top_background"> </div>
    <div class="questlog_placeholder">&nbsp;</div>

	<table id="main_layout" cellspacing="0">
		<tr style="height: 48px;">
			<td class="topbar left fixed"></td>
			<td class="topbar center fixed">
				<div id="topContainer">
					<table id="topTable" style="text-align: center;" cellspacing="0">
						<tr>
							<td style="text-align: center;">
								<table class="menu nowrap" style="white-space: nowrap; ">
									<tr id="menu_row">
										<td class="menu-side"></td>
										<td class="menu-item"><a href="/game.php?village=<?php echo $village['id']; ?>&screen=overview_villages" >Przeglądy</a></td>
										<td class="menu-item tooltip-delayed" title="Mapa<br/> :: Skrót klawiaturowy: &lt;b&gt;m&lt;/b&gt;"><a href="/game.php?village=<?php echo $village['id']; ?>&screen=map">Mapa</a></td>
										<td class="menu-item">
											<a href="/game.php?village=<?php echo $village['id']; ?>&screen=report">
												<span id="new_report" class="icon header new_report_faded"></span>
												Raporty
												<span id="menu_report_count" class="badge badge-report"></span>
											</a>
											<table cellspacing="0" class="menu_column"><tr><td class="menu-column-item"><a href="/game.php?village=<?php echo $village['id']; ?>&mode=all&screen=report">Wszystkie<span class="badge badge-report"> </span></a></td></tr><tr><td class="menu-column-item"><a href="/game.php?village=<?php echo $village['id']; ?>&mode=attack&screen=report">Atak<span class="badge "> </span></a></td></tr><tr><td class="menu-column-item"><a href="/game.php?village=<?php echo $village['id']; ?>&mode=defense&screen=report">Obrona<span class="badge "> </span></a></td></tr><tr><td class="menu-column-item"><a href="/game.php?village=<?php echo $village['id']; ?>&mode=support&screen=report">Wsparcie<span class="badge "> </span></a></td></tr><tr><td class="menu-column-item"><a href="/game.php?village=<?php echo $village['id']; ?>&mode=trade&screen=report">Handel<span class="badge "> </span></a></td></tr><tr><td class="menu-column-item"><a href="/game.php?village=<?php echo $village['id']; ?>&mode=other&screen=report">Inne<span class="badge "> </span></a></td></tr><tr><td class="menu-column-item"><a href="/game.php?village=<?php echo $village['id']; ?>&mode=forwarded&screen=report">Skierowane dalej<span class="badge "> </span></a></td></tr><tr><td class="menu-column-item"><a href="/game.php?village=<?php echo $village['id']; ?>&mode=public&screen=report">Opublikowane<span class="badge "> </span></a></td></tr><tr><td class="menu-column-item"><a href="/game.php?village=<?php echo $village['id']; ?>&mode=filter&screen=report">Filtr<span class="badge "> </span></a></td></tr><tr><td class="bottom"><div class="corner"></div><div class="decoration"></div></td></tr></table>
										</td>

                                        <!-- mail -->
                                                                                    <td class="menu-item">
                                                <a href="/game.php?village=<?php echo $village['id']; ?>&screen=mail">
                                                    <span id="new_mail" class="icon header new_mail_faded"></span>
                                                    Wiadomości
                                                    <span id="menu_mail_count" class="badge badge-mail"></span>
                                                </a>
                                                <table cellspacing="0" class="menu_column"><tr><td class="menu-column-item"><a href="/game.php?village=<?php echo $village['id']; ?>&mode=in&screen=mail">Wiadomości<span class="badge badge-mail"> </span></a></td></tr><tr><td class="menu-column-item"><a href="/game.php?village=<?php echo $village['id']; ?>&mode=mass_out&screen=mail">Wiadomość grupowa<span class="badge "> </span></a></td></tr><tr><td class="menu-column-item"><a href="/game.php?village=<?php echo $village['id']; ?>&mode=new&screen=mail">Napisz wiadomość<span class="badge "> </span></a></td></tr><tr><td class="bottom"><div class="corner"></div><div class="decoration"></div></td></tr></table>
                                            </td>
                                        
													<td>
																		<a class="manager_icon" style="background-image:url('<?php echo $cfg['cdn']; ?>/graphic/icons/farm_assistent.png')" href="/game.php?village=<?php echo $village['id']; ?>&screen=am_farm" title="Asystent Farmera">&nbsp;</a>
																		</td>
																				<td class="menu-item lpad"> </td>
																				<td class="menu-item" id="topdisplay">
											<div class="bg">
												<a href="/game.php?village=<?php echo $village['id']; ?>&screen=ranking">Ranking</a>
												<div class="rank">(<span id="rank_rank"><?php echo format_number($user['rank']); ?></span>.|<span id="rank_points"><?php echo format_number($user['points']); ?></span> P)</div>
												<table cellspacing="0" class="menu_column"><tr><td class="menu-column-item"><a href="/game.php?village=<?php echo $village['id']; ?>&mode=ally&screen=ranking">Plemiona<span class="badge "> </span></a></td></tr><tr><td class="menu-column-item"><a href="/game.php?village=<?php echo $village['id']; ?>&mode=player&screen=ranking">Gracze<span class="badge "> </span></a></td></tr><tr><td class="menu-column-item"><a href="/game.php?village=<?php echo $village['id']; ?>&mode=secrets&screen=ranking">Odkrycia<span class="badge "> </span></a></td></tr><tr><td class="menu-column-item"><a href="/game.php?village=<?php echo $village['id']; ?>&mode=con_ally&screen=ranking">Plemiona na kontynencie<span class="badge "> </span></a></td></tr><tr><td class="menu-column-item"><a href="/game.php?village=<?php echo $village['id']; ?>&mode=con_player&screen=ranking">Gracze na kontynencie<span class="badge "> </span></a></td></tr><tr><td class="menu-column-item"><a href="/game.php?village=<?php echo $village['id']; ?>&mode=kill_ally&screen=ranking">Pokonani przeciwnicy (plemię)<span class="badge "> </span></a></td></tr><tr><td class="menu-column-item"><a href="/game.php?village=<?php echo $village['id']; ?>&mode=kill_player&screen=ranking">Pokonani przeciwnicy<span class="badge "> </span></a></td></tr><tr><td class="menu-column-item"><a href="/game.php?village=<?php echo $village['id']; ?>&mode=awards&screen=ranking">Odznaczenia<span class="badge "> </span></a></td></tr><tr><td class="menu-column-item"><a href="/game.php?village=<?php echo $village['id']; ?>&mode=wars&screen=ranking">Wojny<span class="badge "> </span></a></td></tr><tr><td class="bottom"><div class="corner"></div><div class="decoration"></div></td></tr></table>
											</div>
										</td>
																				<td class="menu-item rpad"> </td>

                                        <!-- tribe -->
                                                                                    <td class="menu-item">
                                                <a href="/game.php?village=<?php echo $village['id']; ?>&screen=ally">
                                                                                                        Plemię
                                                    <span id="menu_counter_ally" class="badge badge-ally-forum"></span>
                                                </a>
                                                                                                                                            </td>
                                        
										<td class="menu-item">
											<a href="/game.php?village=<?php echo $village['id']; ?>&screen=info_player">
												Profil <span id="menu_counter_profile" class="badge"></span>
											</a>
											<table cellspacing="0" class="menu_column"><tr><td class="menu-column-item"><a href="/game.php?village=<?php echo $village['id']; ?>&screen=info_player"><?php echo entparse($user['name']); ?><span class="badge "> </span></a></td></tr><tr><td class="menu-column-item"><a href="/game.php?village=<?php echo $village['id']; ?>&screen=inventory">Inwentarz<span class="badge badge-inventory"> </span></a></td></tr><tr><td class="menu-column-item"><a href="/game.php?village=<?php echo $village['id']; ?>&mode=awards&screen=info_player">Odznaczenia<span class="badge "> </span></a></td></tr><tr><td class="menu-column-item"><a href="/game.php?village=<?php echo $village['id']; ?>&mode=stats_own&screen=info_player">Statystyki<span class="badge "> </span></a></td></tr><tr><td class="menu-column-item"><a href="/game.php?village=<?php echo $village['id']; ?>&screen=buddies">Przyjaciele<span class="badge badge-buddy"> </span></a></td></tr><tr><td class="menu-column-item"><a href="/game.php?village=<?php echo $village['id']; ?>&mode=block&screen=info_player">Czarna lista<span class="badge "> </span></a></td></tr><tr><td class="bottom"><div class="corner"></div><div class="decoration"></div></td></tr></table>
										</td>
										<?php if ($conf['premium']===1) {?>
										<td class="menu-item">
											<a href="/game.php?village=<?php echo $village['id']; ?>&screen=premium">
												<span class="coinbag coinbag-header"></span>&nbsp;<span id="premium_points"><?php echo $p_points; ?></span>
												<span id="premium_points_buy"></span>
											</a>
											<table cellspacing="0" class="menu_column"><tr><td class="menu-column-item"><a href="/game.php?village=<?php echo $village['id']; ?>&mode=use&screen=premium">Subskrypcje<span class="badge "> </span></a></td></tr><tr><td class="menu-column-item"><a href="/game.php?village=<?php echo $village['id']; ?>&mode=premium&screen=premium">Kupno<span class="badge "> </span></a></td></tr><tr><td class="menu-column-item"><a href="/game.php?village=<?php echo $village['id']; ?>&mode=transfer&screen=premium">Przeniesienie<span class="badge "> </span></a></td></tr><tr><td class="menu-column-item"><a href="/game.php?village=<?php echo $village['id']; ?>&mode=log&screen=premium">Log punktów<span class="badge "> </span></a></td></tr><tr><td class="menu-column-item"><a href="/game.php?village=<?php echo $village['id']; ?>&mode=feature_log&screen=premium">Log funkcji<span class="badge "> </span></a></td></tr><tr><td class="bottom"><div class="corner"></div><div class="decoration"></div></td></tr></table>
										</td>
										<?php } else { ?>
										<td class="menu-item">
											<a href="/game.php?village=<?php echo $village['id']; ?>&screen=premium">
												<span class="coinbag coinbag-header"></span>&nbsp;<span id="premium_points">Dotacje</span>
											</a>
										</td>										
										<?php } ?>
										<td class="menu-item"><a href="/game.php?village=<?php echo $village['id']; ?>&screen=settings">Ustawienia</a><table cellspacing="0" class="menu_column"><tr><td class="menu-column-item"><a href="/game.php?village=<?php echo $village['id']; ?>&mode=settings&screen=settings">Opcje gry<span class="badge "> </span></a></td></tr><tr><td class="menu-column-item"><a href="/game.php?village=<?php echo $village['id']; ?>&mode=account&screen=settings">Konto<span class="badge "> </span></a></td></tr><tr><td class="menu-column-item"><a href="/game.php?village=<?php echo $village['id']; ?>&mode=move&screen=settings">Zacznij od nowa<span class="badge "> </span></a></td></tr><tr><td class="menu-column-item"><a href="/game.php?village=<?php echo $village['id']; ?>&mode=notify&screen=settings">Powiadomienia<span class="badge "> </span></a></td></tr><tr><td class="menu-column-item"><a href="/game.php?village=<?php echo $village['id']; ?>&mode=share&screen=settings">Dzielenie łącza<span class="badge "> </span></a></td></tr><tr><td class="menu-column-item"><a href="/game.php?village=<?php echo $village['id']; ?>&mode=vacation&screen=settings">Zastępstwo<span class="badge "> </span></a></td></tr><tr><td class="menu-column-item"><a href="/game.php?village=<?php echo $village['id']; ?>&mode=logins&screen=settings">Logowania<span class="badge "> </span></a></td></tr><tr><td class="menu-column-item"><a href="/game.php?village=<?php echo $village['id']; ?>&mode=poll&screen=settings">Ankiety<span class="badge "> </span></a></td></tr><tr><td class="menu-column-item"><a href="/game.php?village=<?php echo $village['id']; ?>&mode=push&screen=settings">Push notifications<span class="badge "> </span></a></td></tr><tr><td class="menu-column-item"><a href="/game.php?village=<?php echo $village['id']; ?>&mode=browser_notifications&screen=settings">Powiadomienia w przeglądarce<span class="badge "> </span></a></td></tr><tr><td class="menu-column-item"><a href="/game.php?village=<?php echo $village['id']; ?>&mode=command_sharing&screen=settings">Dzielenie się komendami<span class="badge "> </span></a></td></tr><tr><td class="menu-column-item"><a href="/game.php?village=<?php echo $village['id']; ?>&mode=ticket&screen=settings" target="_blank">Pytanie do Supportu<span class="badge "> </span></a></td></tr><tr><td class="bottom"><div class="corner"></div><div class="decoration"></div></td></tr></table></td>
										<td class="menu-side"><img src="<?php echo $cfg['cdn']; ?>/graphic/loading.gif" id="loading_content" style="display: none" alt="" class="" /></td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</div>
			</td>
			<td class="topbar right fixed"> </td>

		</tr>
		<tr class="shadedBG">

			<td class="bg_left" id="SkyScraperAdCellLeft">
				<div id="SkyScraperAdLeft"></div>				<div class="bg_left"> </div>
			</td>

			<td class="maincell" style="width: 850px;">
							<div style="position:fixed;">
					<!--<div id="questlog" class="questlog">
																		<div 
								id="quest_39" 
								data-id="39"
								data-progress="6" 
								data-goals="7"
								data-url="/game.php?village=<?php echo $village['id']; ?>&ajax=quest_show&quest=39&screen=api"
								class="quest opened  " 
								title="Boom nadchodzi"
								style="background-image:url( '<?php echo $cfg['cdn']; ?>/graphic/icons/storage.png?9951d' );">
								<div class="quest_progress"></div>
								<img src="<?php echo $cfg['cdn']; ?>/graphic/quests/check.png?29f73" border="0" style="position: absolute; left: 12px; top: 12px; display: none" alt="" class="" />
															</div>
												<script>
						$(function() {
							Quests.init();
						});
						</script>					</div>-->
				</div>
			
			
			<br class="newStyleOnly" />
				        			<table id="quickbar_outer" align="center" width="100%" cellspacing="0">
	            <tr>
	                <td>
						<table id="quickbar_inner" style="border-collapse: collapse;" width="100%">
							<tr class="topborder">
								<td class="left"> </td>
								<td class="main"> </td>
								<td class="right"> </td>
							</tr>
	                        <tr>
								<td class="left"> </td>
								<td id="quickbar_contents" class="main">
									<ul class="menu quickbar">
																					                                                 
                                                <li  class="quickbar_item" >
                                                    <span>
                                                        <a class="quickbar_link" href="/game.php?village=<?php echo $village['id']; ?>&screen=main"  >
                                                            <img src="<?php echo $cfg['cdn']; ?>/graphic//buildings/main.png" alt="Ratusz" />Ratusz
                                                        </a>
                                                    </span>
                                                </li>
                                                																																                                                 
                                                <li  class="quickbar_item" >
                                                    <span>
                                                        <a class="quickbar_link" href="/game.php?village=<?php echo $village['id']; ?>&screen=train"  >
                                                            <img src="<?php echo $cfg['cdn']; ?>/graphic//buildings/barracks.png" alt="Rekrutacja" />Rekrutacja
                                                        </a>
                                                    </span>
                                                </li>
                                                																																                                                 
                                                <li  class="quickbar_item" >
                                                    <span>
                                                        <a class="quickbar_link" href="/game.php?village=<?php echo $village['id']; ?>&screen=church"  >
                                                            <img src="<?php echo $cfg['cdn']; ?>/graphic//buildings/church.png" alt="Kościół" />Kościół
                                                        </a>
                                                    </span>
                                                </li>
                                                																																                                                 
                                                <li  class="quickbar_item" >
                                                    <span>
                                                        <a class="quickbar_link" href="/game.php?village=<?php echo $village['id']; ?>&screen=snob"  >
                                                            <img src="<?php echo $cfg['cdn']; ?>/graphic//buildings/snob.png" alt="Pałac" />Pałac
                                                        </a>
                                                    </span>
                                                </li>
                                                																																                                                 
                                                <li  class="quickbar_item" >
                                                    <span>
                                                        <a class="quickbar_link" href="/game.php?village=<?php echo $village['id']; ?>&screen=smith"  >
                                                            <img src="<?php echo $cfg['cdn']; ?>/graphic//buildings/smith.png" alt="Kuźnia" />Kuźnia
                                                        </a>
                                                    </span>
                                                </li>
                                                																																                                                 
                                                <li  class="quickbar_item" >
                                                    <span>
                                                        <a class="quickbar_link" href="/game.php?village=<?php echo $village['id']; ?>&screen=place"  >
                                                            <img src="<?php echo $cfg['cdn']; ?>/graphic//buildings/place.png" alt="Plac" />Plac
                                                        </a>
                                                    </span>
                                                </li>
                                                																																                                                 
                                                <li  class="quickbar_item" >
                                                    <span>
                                                        <a class="quickbar_link" href="/game.php?village=<?php echo $village['id']; ?>&screen=market"  >
                                                            <img src="<?php echo $cfg['cdn']; ?>/graphic//buildings/market.png" alt="Rynek" />Rynek
                                                        </a>
                                                    </span>
                                                </li>
                                                																														</ul>
								</td>
								<td class="right"> </td>
							</tr>
							<tr class="bottomborder">
								<td class="left"> </td>
								<td class="main"> </td>
								<td class="right"> </td>
							</tr>
							<tr>
								<td class="shadow" colspan="3">
									<div class="leftshadow"> </div>
									<div class="rightshadow"> </div>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<hr class="oldStyleOnly" />

			<table id="header_info" align="center" width="100%" cellspacing="0">
				<colgroup>
					<col width="1%" />
					<col width="96%" />
					<col width="1%" />
					<col width="1%" />
					<col width="1%" />
				</colgroup>
				<tr>
					<td class="topAlign">
						<table class="header-border">
	                        <tr>
	                            <td>
									<table class="box menu nowrap">
	                                    <tr id="menu_row2">
											<?php if ($user['villages'] > 1) { ?>
											<td class="box-item icon-box separate arrowCell">
												<a id="village_switch_left" class="village_switch_link" href="<?php echo url(["village"=>"p{$village['id']}"]);?>" accesskey="a">
													<span class="<?php echo MyTW_or($gc,"group","arrow",true); ?>Left tooltip" title="Poprzednia wioska<br/> :: Skrót klawiaturowy: &lt;b&gt;a&lt;/b&gt;"> </span>
												</a>
											</td>
											<td class="box-item icon-box arrowCell">
												<a id="village_switch_right" class="village_switch_link" href="<?php echo url(["village"=>"n{$village['id']}"]);?>" accesskey="d">
													<span class="<?php echo MyTW_or($gc,"group","arrow",true); ?>Right tooltip" title="Następna wioska<br/> :: Skrót klawiaturowy: &lt;b&gt;d&lt;/b&gt;"> </span>
												</a>
											</td>
											<?php } ?>																																	<td style="white-space:nowrap;" id="menu_row2_village" class="firstcell box-item icon-box nowrap">
												<a class="nowrap tooltip-delayed" title="Przegląd wioski<br/> :: Skrót klawiaturowy: &lt;b&gt;v&lt;/b&gt;" href="/game.php?village=<?php echo $village['id']; ?>&screen=overview"><span class="icon header village"></span><?php echo entparse($village['name']);?></a>
											</td>
											<td class="box-item" style="padding-right: 6px"><b class="nowrap"><?php echo "({$village['x']}|{$village['y']}) K{$village['continent']}";?></b></td>
											
											<?php
											if ($premium===true && $user['villages'] > 1) {
											?>
											<td class="box-item">
	                                        	<script type="text/javascript">
												//<![CDATA[
	                                        		villageDock.saveLink = '/game.php?village=<?php echo $village['id']; ?>&ajaxaction=dockVillagelist&h=<?php echo $hkey; ?>&screen=overview';		                                        	villageDock.loadLink = '/game.php?village=<?php echo $village['id']; ?>&mode=overview&ajax=load_groups&screen=groups';
		                                        	villageDock.docked = 0;

													$(function() {
				                                        if(villageDock.docked) {
					                                        villageDock.open();
				                                        }
													});
		                                        //]]>
		                                        </script>
	                                        	<a style="display: inline;" href="#" id="open_groups" onclick="return villageDock.open(event);"><span class="icon header arr_down"></span></a>
												<a href="#" id="close_groups" onclick="return villageDock.close(event);" style="display: none;"><span class="icon header arr_up"></span></a>
	                                            <input id="popup_close" value="Zamknąć" type="hidden">
	                                            <input value="/game.php?village=<?php echo $village['id']; ?>&ajax=load_villages_from_group&mode=overview&screen=groups" id="show_groups_villages_link" type="hidden">
	                                            <input value="/game.php?screen=welcome" id="village_link" type="hidden">
	                                            <input value="overview" id="group_popup_mode" type="hidden">
	                                            <input value="Grupa:" id="group_popup_select_title" type="hidden">
	                                            <input value="Wioska" id="group_popup_villages_select" type="hidden">
	                                        </td>
											<?php } ?>
												                                    </tr>
	                                </table>
	                            </td>
	                        </tr>
							<tr class="newStyleOnly">
								<td class="shadow">
									<div class="leftshadow"> </div>
									<div class="rightshadow"> </div>
								</td>
							</tr>
	                    </table>
                	</td>

				<td align="right" class="topAlign"> </td><!-- flexible gap -->

				<td align="right" class="topAlign">
				

                
                </td>
                <td align="right" class="topAlign">
					<table align="right" class="header-border menu_block_right">
						<tr>
							<td>
								<table class="box smallPadding" cellspacing="0" style="empty-cells:show;">
									<tr style="height: 20px;">
										<td class="box-item icon-box firstcell">
											<a href="/game.php?village=<?php echo $village['id']; ?>&screen=wood" title="Drewno - <?php echo $production_wood; ?> na godzinę"><span class="icon header wood"> </span></a>
										</td>
                                        <td class="box-item" style="position: relative">
                                        	<span id="wood" title="Drewno - <?php echo $production_wood; ?> na godzinę" <?php 
												echo MyTW_or($village['wood_float']," class=\"warn\"","",$storage_max);
											?>><?php echo $village_wood; ?></span>
                                        </td>
                                        <td class="box-item icon-box">
                                        	<a href="/game.php?village=<?php echo $village['id']; ?>&screen=stone" title="Glina - <?php echo $production_stone; ?> na godzinę"><span class="icon header stone"> </span></a>
                                        </td>
                                        <td class="box-item">
                                        	<span id="stone" title="Glina - <?php echo $production_stone; ?> na godzinę" <?php 
												echo MyTW_or($village['stone_float']," class=\"warn\"","",$storage_max);
											?>><?php echo $village_stone; ?></span>
                                        </td>
                                        <td class="box-item icon-box">
                                        	<a href="/game.php?village=<?php echo $village['id']; ?>&screen=iron" title="Żelazo - <?php echo $production_iron; ?> na godzinę"><span class="icon header iron" > </span></a>
                                        </td>
										<td class="box-item">
											<span id="iron" title="Żelazo - <?php echo $production_iron; ?> na godzinę" <?php 
												echo MyTW_or($village['iron_float']," class=\"warn\"","",$storage_max);
											?>><?php echo $village_iron; ?></span>
										</td>
                                        <td class="box-item icon-box">
                                        	<a href="/game.php?village=<?php echo $village['id']; ?>&screen=storage" title="Pojemność spichlerza"><span class="icon header ressources"> </span></a>
                                        </td>
                                        <td class="box-item">
                                        	<span id="storage" title="Pojemność spichlerza"><?php echo $storage_max;?></span>
                                        </td>
									</tr>
								</table>
							</td>
						</tr>
						<tr class="newStyleOnly">
							<td class="shadow">
								<div class="leftshadow"> </div>
								<div class="rightshadow"> </div>
							</td>
						</tr>
					</table>
				</td>
				<td align="right" class="topAlign">
					<table class="header-border menu_block_right">
						<tr>
							<td>
								<table class="box smallPadding" cellspacing="0">
									<tr>
										<td class="box-item icon-box firstcell"><a href="/game.php?village=<?php echo $village['id']; ?>&screen=farm" title="Zagroda"><span class="icon header population"> </span></a></td>
                                        <td class="box-item" align="center" style="margin:0;padding:0;" title="Zagroda">
                                        	<span id="pop_current_label"><?php echo $village['pop']; ?></span>/<span id="pop_max_label"><?php echo $pop_max; ?></span>
                                        	<span style="display:none">
                                        		<span id="pop_current"><?php echo $village['pop']; ?></span>/<span id="pop_max"><?php echo $pop_max; ?></span>
                                        	</span>
                                        </td>
                                    </tr>
								</table>
							</td>
						</tr>
						<tr class="newStyleOnly">
							<td class="shadow">
								<div class="leftshadow"> </div>
								<div class="rightshadow"> </div>
							</td>
						</tr>
					</table>
				</td>
								<td align="right" class="topAlign">
					<table class="header-border menu_block_right" style="border-collapse: collapse;">
						<tr>
							<td>
								<table class="box" cellspacing="0">
									<tr>
																				<td class="box-item firstcell" style="white-space:nowrap;">
                                            <a title="Flagi" href="/game.php?village=<?php echo $village['id']; ?>&screen=flags" style="vertical-align:middle;">
                                                <span class="icon header flags"></span>                                            </a>
                                        </td>
																														<td class="box-item icon-box"><a title="Rycerz" href="/game.php?mode=inventory&village=<?php echo $village['id']; ?>&screen=statue"><span class="icon header knight"></span></a></td>
																			</tr>
								</table>
							</td>
						</tr>
						<tr class="newStyleOnly">
							<td class="shadow">
								<div class="leftshadow"> </div>
								<div class="rightshadow"> </div>
							</td>
						</tr>
					</table>
								<td class="topAlign  " id="header_commands">
					<table class="header-border menu_block_right">
						<tr>
							<td>
								<table class="box smallPadding no-gap" cellspacing="0">
									<tr>

										<td id="incomings_cell" style="text-align: center; padding: 0 4px" class="box-item firstcell nowrap">
											<img src="<?php echo $cfg['cdn']; ?>/graphic/unit/att.png?1bdd4" title="Nadchodzące ataki" style="vertical-align: -2px" alt="" class="" />
											<span id="incomings_amount">0</span>
																					</td>

										<td id="supports_cell" style="text-align: center; padding: 0 4px" class="box-item separate nowrap">
											<a href="">
												<img src="<?php echo $cfg['cdn']; ?>/graphic/command/support.png?90fdb" title="Nadciągające wsparcie" style="vertical-align: -2px" alt="" class="" />
												<span id="supports_amount"></span>
											</a>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr class="newStyleOnly">
							<td class="shadow">
								<div class="leftshadow"> </div>
								<div class="rightshadow"> </div>
							</td>
						</tr>
					</table>
				</td>

			</tr>
		</table>

		
		
		
		
		<div id="script_warning" class="info_box" style="display: none;" >
			Aktywowane skrypty mogą być niekompatybilne z obecną wersją gry.<br />
			Jeżeli problemy będą ciągle występować, proszę wyłączyć albo zaktualizować skrypty.<br />
			Jeśli problemy będą ciągle występować, proszę skontaktować się z autorem skryptu. <ul id="script_list"></ul>
		</div>

				<?php if (isset($_GET['intro'])) {
				$ll = DB::fetch(DB::Query("SELECT * FROM `{$DB}`.`logins` WHERE `uid` = '{$user['id']}' ORDER BY `time` DESC LIMIT 1 , 1"));
					if ($ll!==false) {
					?>
										<div class="info_box">
							Ostatnie logowanie <b><?php echo format_date($ll['time']);?></b> z IP <b><?php echo $ll['ip'];?></b>
					</div>
					<!--			<div class="info_box">
							Wydarzenie Handlarze 2014 aktywne dnia 11.11. o 11:00 - dnia 02.12. o 11:00.
					</div>
								<div class="info_box">
							Użyj Konta Premium aby skorzystać wielu ułatwień w obsłudze gry.
							<a href="/game.php?village=<?php echo $village['id']; ?>&mode=help&screen=premium">&raquo; Konto Premium</a>
					</div>-->
					<?php 
					}
				} ?>
		    	    
	    
		<!-- *********************** CONTENT BELOW ************************** -->
		<table align="center" id="contentContainer" width="100%">
	        <tr>
	            <td>
					<table class="content-border" width="100%" cellspacing="0">
	                    <tr>
	                        <td id="inner-border">
								<table class="main" align="left">
	                                <tr>
										<td id="content_value">
											<?php
												if (count($errors) > 0) {
													$error = implode("<br />",$errors);
													echo "<div class=\"error_box\">{$error}</div>";
												}
												require_once PATH . "/game/{$screen}.screen.php";
											?>
	                               		</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				
				</td>
			</tr>
		</table>

		<p class="server_info">
			Czas: <span id="serverTime"><?php echo date("H:i:s");?></span> <span id="serverDate"><?php echo date("d/m/Y");?></span>
			<span id="dev_console"><b>|</b> <a href="?screen=74:72:69:62:61:6c:77:61:72:73">developer console</a></span>
					</p>

	</td>
	<td class="bg_right" id="SkyScraperAdCell">
		<div class="bg_right"> </div>
			</td>
</tr>

						<tr>
				<td class="bg_leftborder"> </td>
				<td></td>
				<td class="bg_rightborder"> </td>
			</tr>
			<tr class="newStyleOnly">
				<td class="bg_bottomleft">&nbsp;</td>
				<td class="bg_bottomcenter">&nbsp;</td>
				<td class="bg_bottomright">&nbsp;</td>
			</tr>
							<tr><td colspan="3" align="center"><div id="AdBottom"></div></td></tr>
						</table><!-- .main_layout -->
					
	<!-- CHAT: -->
	<?php /*	
	<script type="text/javascript" src="/merged/chat.js"></script>
	<script type="text/javascript">
		Chat.width = <?php echo $user['chat_width'];?>;
		Chat.height = <?php echo $user['chat_height'];?>;
		Chat.active = <?php echo $user['chat_active'];?>;
		Chat.update = "/game.php?village=<?php echo $village['id']; ?>&h=<?php echo $hkey;?>&ajaxaction=set_chat_configs&screen=settings";
		
	</script>
	<?php if ($user['chat_active']==="1") { ?>
		<div id="chat-contentier" style="width: <?php echo $user['chat_width'];?>px; height: <?php echo $user['chat_height'];?>px; padding: 5px; position: absolute; right: 0; bottom: 0px; background: url('<?php echo $cfg['cdn']; ?>/graphic/popup/content_background.png'); border-left: 1px solid #9e4622; border-top: 1px solid #9e4622; cursor: auto;"><div class="content"><strong>Test</strong><p>Test</p></div></div>
	<?php } else { ?>
		<div id="chat-contentier" style="width: 50px; height: 40px; padding: 5px; position: absolute; right: 0; bottom: 0px; background: url('<?php echo $cfg['cdn']; ?>/graphic/popup/content_background.png'); border-left: 1px solid #9e4622; border-top: 1px solid #9e4622; cursor: auto;"><div class="content"><a href="#" onclick="return Chat.view();">CZAT</a></div></div>
	<?php } ?>
	*/ ?>
				<div id="world_selection_clicktrap" class="evt-world-selection-toggle">
		</div>
		<div id="world_selection_popup">
			<div class="servers-list-top"></div>
			<div id="servers-list-block">
			
			</div>
			<div class="servers-list-bottom"></div>
		</div>
		
		<div id="footer">
			<a href="#" id="unsupported-browser">
				<img src="<?php echo $cfg['cdn']; ?>/graphic/error.png?5db81" title="" alt="" class="" /> Niewspierana przeglądarka.
			</a>
			<div id="linkContainer">
								<a href="#" class="world_button_active evt-world-selection-toggle"><?php echo entparse($conf['name']); ?></a>
								<a href="http://forum.privek.tk" class="footer-link" target="_blank">Forum</a>
				&nbsp;-&nbsp;
				<a href="http://help.privek.tk" class="footer-link" target="_blank">Pomoc</a>
												&nbsp;-&nbsp;
				<a href="/game.php?village=<?php echo $village['id']; ?>&mode=ticket&screen=settings" class="footer-link" target="_blank">Support</a>
								                				&nbsp;-&nbsp;
				<a href="/game.php?village=<?php echo $village['id']; ?>&screen=memo" class="footer-link">Notatki</a>
                								&nbsp;-&nbsp;
				<a href="#" id="paris-opener" class="paris-badge" onclick="PARIS.open(); return false">Prześlij opinię</a>
								&nbsp;-&nbsp;
				<a href="/game.php?village=<?php echo $village['id']; ?>&action=logout&h=<?php echo $hkey; ?>&screen=" target="_top" class="footer-link">Wyloguj</a>
			</div>
		</div>
		


<!-- Google Code for Staemme PL Ingame 15 Remarketing List -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 1015132155;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "SxVECOW_zwIQ-9-G5AM";
var google_conversion_value = 0;
/* ]]> */
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1015132155/?label=SxVECOW_zwIQ-9-G5AM&guid=ON&script=0"/>
</div>
</noscript>


<!--
Start of DoubleClick Floodlight Tag: Please do not remove
Activity name of this tag: TW Global Active User and Unique Player ID
URL of the webpage where the tag is expected to be placed: http://om.die-staemme.de/
This tag must be placed between the <body> and </body> tags, as close as possible to the opening tag.
Creation Date: 05/19/2014
-->
<iframe src="http://4432873.fls.doubleclick.net/activityi;src=4432873;type=activsal;cat=twGLacs;qty=1;cost=[Revenue];u2={PLAYER_ID};ord=[OrderID]?" width="1" height="1" frameborder="0" style="display:none"></iframe>
<!-- End of DoubleClick Floodlight Tag: Please do not remove -->

<!-- Google Code for TW1 PL active player (30 days) -->
<!-- Remarketing tags may not be associated with personally identifiable information or placed on pages related to sensitive categories. For instructions on adding this tag and more information on the above requirements, read the setup guide: google.com/ads/remarketingsetup -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 965050924;
var google_conversion_label = "C_7xCPuwqlYQrISWzAM";
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/965050924/?value=1.00&currency_code=EUR&label=C_7xCPuwqlYQrISWzAM&guid=ON&script=0"/>
</div>
</noscript>




<script>
	$(document).ready(function() {
		TribalWars.initTab('fc4dad8386');
		Timing.init(<?php echo $_SERVER['REQUEST_TIME_FLOAT'];?>);



			WorldSwitch.init();
		WorldSwitch.worldsURL = '/game.php?village=<?php echo $village['id']; ?>&ajax=world_switch&screen=api';
	
			HotKeys.init();
	
			Connection.connect(8083, '2b18aa7dd079');
	
			UI.Notification.enabled = true;
	
	
	
		});
</script>


<div id="side-notification-container"></div>
        </body>
</html>
