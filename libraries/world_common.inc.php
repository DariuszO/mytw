<?php
/*
*	World common
*/
if (!defined("MyTW")) {
	exit;
}

if (!defined("CRON")) {
	if (!world) {
		MyTW_world_location("index.php");
	}

	if (!World::exists(w)) {
		MyTW_world_location("index.php");
	}


	$server = w;

	$DB = "mytw_world_{$server}";

	$conf = World::configs($server);
} else {
	$server = $C_server;

	$DB = "mytw_world_{$server}";

	$conf = World::configs($server);
}
/*
*	@File: Sid.class.php
*/
require_once PATH . "/libraries/Sid.class.php";
$sid = new Sid();

/*
*	@File: Village.class.php
*/
require_once PATH . "/libraries/Village.class.php";

/*
*	@File: User.class.php
*/
require_once PATH . "/libraries/User.class.php";

/*
*	@File: Builds.class.php
*/
require_once PATH . "/libraries/Builds.class.php";

/*
*	@File: Units.class.php
*/
require_once PATH . "/libraries/Units.class.php";

/*
*	@File: DataReload.class.php
*/
require_once PATH . "/libraries/DataReload.class.php";
$DataReload = new DataReload($server,$DB);

/*
*	@File: map.class.php
*/
require_once PATH . "/libraries/map.class.php";

/*
*	@File: BB.class.php
*/
require_once PATH . "/libraries/BB.class.php";

/*
*	@Function: hkey_check();
*/
function hkey_check($h,$oh) {
	if ($h!==$oh) {
		require_once PATH . "/game/hkey_err.err.php";
		exit;
		return false;
	} else {
		return true;
	}
}
?>