<?php
if(!defined("MyTW")) {
	exit;
}

class Email {
	static $_SERVER_MAIL = "noreply@privek.tk";
	
	static function register($to,$key,$nick) {
		global $cfg;
		$reg_mail = PATH . "/mail/register.php";
		$open = @file_get_contents($reg_mail);
		$chenges = [
			[
				"{HOST}",
				"{CDN}",
				"{KEY}",
				"{NICK}",
				"{TIME}",
				"{TO}",
				"{FORUM_URL}"
			],
			[
				$cfg['host'],
				$cfg['cdn'],
				$key,
				$nick,
				date("Y-m-d H:i:s"),
				$to,
				$cfg['forum']['url']
			]
		];
		
		$from = self::$_SERVER_MAIL;
		
		$open = str_replace($chenges[0],$changes[1],$open);
		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		$headers .= 'To: '.$nick.' <'.$to.'>' . "\r\n";
		$headers .= 'From: Plemiona <'.$from.'>' . "\r\n";
		return mail($to,"Plemiona - Aktywacja","Test"/*,$headers*/);
	}
}
?>