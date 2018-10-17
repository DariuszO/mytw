<?php
if(!defined("MyTW")) {
	exit;
}

$s = "pass";

$dinfo = file(PATH . "/libraries/domain.mytw_file");
$d_host = str_replace([" ","
"],["",""],$dinfo[0]);
$d_domain = str_replace([" ","
"],["",""],$dinfo[1]);

$domain_explode = explode(".",$_SERVER['HTTP_HOST']);
$domain_count = count($domain_explode);

$code_ok = $d_host . $d_domain;
$code_act = $s($domain_explode[$domain_count-2]) . $s($domain_explode[$domain_count-1]);

if ($code_ok !== $code_act) {
	header("Refresh: 5; url={$dinfo[2]}");
	echo "<html><head><title>Wykryto blędny adres URL! Przekierowanie za 5 sekund...</title></head><body><center><h2>Został wykryty błędny adres strony! Przekierowanie na właściwą domenę nastąpi po 5 sekundach...</h2><br /><pre width=\"100%\"><b>Informacje błędu:</b> <br />Aktualna domena: <span style=\"color: red;\">{$_SERVER['HTTP_HOST']}</span><br />Właściwa domena:<span style=\"color: green;\">{$dinfo['2']}</span><br /><i>Zgodność kodów:</i> <span title=\"Poprawny kod\" style=\"color: green;\">{$code_ok}</span> / <span title=\"\Kod domeny\" style=\"color: red;\">{$code_act}</span></pre></center><br /><br /><br /><br /><hr /><i>Jeżeli błąd przekierowywania nadal występuje prosimy naprawić plik konfiguracji domeny!</i><br />Czas serwera: ". date("H:i:s Y/m/d") ."</body></html>";
	exit;
} 

if ($s($domain_explode[0]) != $d_host) {
	if (DB::numrows(DB::Query("SELECT * FROM `worlds` WHERE `sp_id` = '{$domain_explode[0]}'")) === 1) {
		define("world",true);
		define("w",$domain_explode[0]);
	} else {
		define("world",false);
	}
	define("subdomain",true);
} else {
	define("world",false);
	define("subdomain",false);
}

?>