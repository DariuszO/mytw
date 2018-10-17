<?php

define("PATH",dirname(dirname(__DIR__)));

function checkdir($FILE) {

	$DIR = dirname($FILE);
	if (is_dir($DIR)) {
		return true;
	} else {
		if (!is_dir(dirname($DIR))) {
			checkdir(dirname($DIR));
			@mkdir($DIR,0777,true);
			@chmod($DIR,0777);
		} else {
			@mkdir($DIR,0777,true);
			@chmod($DIR,0777);
		}
		return true;
	}

}

$file = $_SERVER['REDIRECT_URL'];

function NewLog($LOG,$TYPE="INFO",$FILE="/logs.log") {
	$FILE = PATH . $FILE;
	$DATE = date("y-m-d H:i:s");
	$LOG = "[{$TYPE}][{$DATE}] {$LOG}";
	if (!file_exists($FILE)) {
		file_put_contents($FILE,$LOG);
	} else {
		$F = FOpen($FILE,"r+");
		$OldLogs = @fread($F,filesize($FILE));
		$LOGS = "\n" . $LOG;
		FWrite($F,$LOGS);
		fClose($F);
	}
	return true;
}

newlog("Znaleziony plik: {$file}","INFO","/logs/pages.log");


if (!file_exists(PATH . $file)) {
	$W = @file_get_contents("http://plemiona.pl".$file);
	if (empty($W)) {
		$fileO = str_replace("/cdn","",$file);
		$W = @file_get_contents("http://dspl.innogamescdn.com/8.30/23662/".$fileO);
	}
	if (!empty($W)) {
		checkdir(PATH . $file);
		$FEXC = explode(".",$file);
		$FEXC = $FEXC[count($FEXC)-1];
		$set1 = array (
			"http://plemiona.pl",
			"http://www.plemiona.pl",
			"http://dspl.innogamescdn.com/8.30.1/23822/",
			"&amp"
		);
		if ($FEXC != "php" || $FEXC != "html") {
			$set2 = array (
				"http://privek.tk",
				"http://privek.tk",
				"http://cdn.privek.tk/",
				"&"
			);
		} else {
			$set2 = array (
				"<?php echo \$cfg[\"host\"]; ?>",
				"<?php echo \$cfg[\"host\"]; ?>",
				"<?php echo \$cfg[\"cdn\"]; ?>",
				"&"
			);
		}
		$W = str_replace($set1,$set2,$W);
		@file_put_contents(PATH . $file,$W);
	}
}
?>