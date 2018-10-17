<?php
if (!isset($_POST['preview'])) {
	$text = $_POST['personal_text'];
	if (strlen($text) > 20000) {
		$errors[] = "Tekst osobisty może zawierać maksymalnie dwadzieścia tysięcy znaków";
	} else {
		$bb_parse = BB::parse($text,$user,["img","size","claim"]);
		$BB_e = BB::error();
		if ($BB_e!==false) {
			$errors[] = $BB_e;
		} else {
			$return = User::Update($user['id'],["personal_text","personal_text_bb"],[$bb_parse,parse($text)]);
			if ($return===false) {
				$errors[] = "Nie udało się zaktualzować profilu.";
			} else {
				setcookie("success_message","Twój profil został zaktualizowany.");
				header("LOCATION: /game.php?village={$village['id']}&screen={$screen}");
			}
		}
	}
}
?>