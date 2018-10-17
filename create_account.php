<?php
/**********************************/
/*           TribalWars           */
/*             My-TW              */
/*         by Bartekst222         */
/**********************************/

require_once "./libraries/common.inc.php";

require_once PATH . "/libraries/Village.class.php";

if (subdomain===true) {
	MyTW_world_location("index.php");
}

$server = $_GET['server_id'];

if (World::exists($server)===false) {
	MyTW_world_location("index.php");
}

$world = World::configs($server);

if ($world['status'] === "off") {
	exit("Ten świat jest zablokowany!");
}

$no_paladin = true;

$sql = DB::Query("SELECT * FROM `users` WHERE `session` = '{$_COOKIE['session']}'");
$check = DB::numrows($sql);

if ($check != 1) {
	MyTW_world_location("index.php");
}

$user = DB::fetch($sql);
$uworlds = json_decode($user['worlds'],true);
if (IsSet($uworlds[$server])) {
	MyTW_world_location("index.php");
}

if ($_GET['action'] === "confirm") {
	$DB = str_replace("[ID]",$server,$DB_CONF['database']['world']);
	$check = DB::numrows(DB::Query("SELECT `id` FROM `{$DB}`.`users` WHERE `id` = '{$user['id']}'"));
	if ($check > 0) {
		$uw = json_decode($user['worlds']);
		$uw[] = $server;
		$uw = json_encode($uw);
		DB::Query("UPDATE `users` SET `worlds` = '{$uw}' WHERE `id` = '{$user['id']}'");
		$HKey = random(4);	
		header("LOCATION: http://{$server}.privek.tk/login.php?hkey={$HKey}&sid={$user['session']}&mobile=0&pass={$user['pass']}");
	} else {
		$time = time();
		$create = DB::Query("INSERT INTO `{$DB}`.`users`(`id`,`name`,`game_start`) VALUES ('{$user['id']}','{$user['name']}',{$time})");
		if ($create===false) {
			exit("Nie udało się stworzyć konta!");
		} else {
			$conf = World::configs($server);
			$uw = json_decode($user['worlds']);
			$uw[] = $server;
			$uw = json_encode($uw);
			DB::Query("UPDATE `users` SET `worlds` = '{$uw}' WHERE `id` = '{$user['id']}'");
			$HKey = random(4);	
			header("LOCATION: http://{$server}.privek.tk/login.php?hkey={$HKey}&sid={$user['session']}&mobile=0&pass={$user['pass']}");
		}
	}
}

require_once PE . "/index_top.php";

?>
<div class="container-block-full">
			<div class="container-top-full"></div>
				<div class="container"><div id="content" class="content_no_paladin" style="padding-left: 30px; padding-right: 30px">

	<h2 style="margin-bottom: 10px">
		Rejestracja na <?php echo $world['name']; ?>
		</h2>


	        <p>Czy chcesz uczestniczyć na  <strong><?php echo $world['name']; ?></strong>?</p>
    
            			<div style="float: right">
							<img src="<?php echo $cfg['cdn']; ?>/graphic/unit_popup/axe.png" title="" alt="" class="" />
						</div>
                <table class="vis" style="margin-bottom: 5px; border:1px solid #000; width: 470px"><tr><td>
        <?php echo $world['decs']; ?><br />
        </td></tr></table>
	
            
                    <form method="post" action="/create_account.php?action=confirm&server_id=<?php echo $server; ?>">
                
                                <input class="btn" type="submit" value="Uczestnictwo" />
            </form>
	        
	

	<script type="text/javascript">
	//<![CDATA[
	
	function hide_buy() {
		$('#buy_premium').css('display', 'none');
		$('#buy_premium').append('Proszę czekać...');
	}
	
	//]]>
	</script>
	
</div>
				</div>
			<div class="container-bottom-full"></div>
		 </div>
		</div><!-- content -->
<?php
require_once PE . "/index_footer.php";
?>