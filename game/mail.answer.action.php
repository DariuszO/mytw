<?php
if ($mode==="view") {
	$mid = $_POST['igm_id'];
	$sql = DB::Query("SELECT * FROM `{$DB}`.`mails` WHERE (`id` = '{$mid}') AND (`from_id` = '{$user['id']}' OR `to_id` = '{$user['id']}')");
	$check = DB::numrows($sql);
	if ($check!==1) {
		$errors[] = "Ta wiadomość nie istnieje";
	} else {
		if (empty($_POST['text'])) {
			$errors[] = "Tekst nie może być pusty";
		} else {
			$mail = DB::fetch($sql);
			$re = $_GET['read_time'];
			$time = time();
			if ($re < $mail['last_responde']) {
				$errors[] = "Twój rozmówca napisał nową wiadomość";
			} else {
				$text = BB::Parse($_POST['text'],["img","size","claim"]);
				$bb_text = parse($text);
				$return = DB::Query("INSERT INTO `{$DB}`.`mails_responde`(`mail`,`time`,`author_id`,`author_name`,`text`,`bb_text`) VALUES('{$mail['id']}','{$time}','{$user['id']}','{$user['name']}','{$text}','{$bb_text}')");
				if ($return===false) {
					$errors[] = "Nie udało się wysłać wiadomości!";
				} else {
					header("LOCATION: ". url(["view"=>$mid,"group_id"=>"0"]));
				}
			}
		}
	}
}
?>