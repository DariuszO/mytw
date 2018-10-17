<?php
if (!defined("MyTW")) {
	exit;
}

define("MYSQL_CONF", PATH . "/configs/MySQL.ini");

if (!file_exists(MYSQL_CONF)) {
	$cl_error->title("Nie odnaleziono konfiguracji MySQL!");
	$cl_error->error("Plik konfiguracji bazy danych MySQL <b>". MYSQL_CONF ."</b> nie został odnaleziony!");
	$cl_error->log();
	$cl_error->view();
	$cl_error->clear();
	exit;
}

$DB_CONF =  parse_ini_file(MYSQL_CONF,true);
$MySQL_connect_conf = [
	$DB_CONF['connect']['host'],
	$DB_CONF['connect']['user'],
	$DB_CONF['connect']['password'],
	$DB_CONF['database']['index']
];

$MySQL_connect = DB::connect($MySQL_connect_conf);
?>