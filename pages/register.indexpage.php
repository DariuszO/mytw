<?php
$ajax = $path_exp[3];

if ($ajax == "validate") {
	$type = $_POST['type'];
	$val = $_POST['value'];
	$JSON = ["status"=>"OK"];
	if ($type == "password") {
		if (strlen($val) < 4) {
			$JSON['status'] = "ERROR";
			$JSON['errors'][] = "Hasło musi się składać z minimum 4 znaków!";
		}
	} elseif ($type == "email") {
		$MAIL = $val;
		$MINMAX = [5,60];
		if (strlen($MAIL) < $MINMAX[0]) {
			$JSON['status'] = "ERROR";
			$JSON['errors'][] = "Adres E-mail za krótki! Minimum {$MINMAX[0]} znaków!";
		}
		if (strlen($MAIL) > $MINMAX[1]) {
			$JSON['status'] = "ERROR";
			$JSON['errors'][] = "Adres E-mail za długi! Maximu {$MINMAX[1]} znaków!";
		}
		if (!filter_var($MAIL, FILTER_VALIDATE_EMAIL)) {
			$JSON['status'] = "ERROR";
			$JSON['errors'][] = "Adres e-mail wydaje się nieprawidłowy. Wprowadź adres w formacie „nazwa@przykładowadomena.com”.";
		}
		$PARSEMAIL = parse($MAIL);
		$SQLCheck = DB::numrows(DB::Query("SELECT `id` FROM `users` WHERE `email` = '{$PARSEMAIL}'"));
		if ($SQLCheck > 0) {
			$JSON['status'] = "ERROR";
			$JSON['errors']["email_conflict"] = "Adres „{$val}” jest już zarejestrowany. Wprowadź inny adres e-mail.";
		}
	} elseif ($type === "name") {
		$name = cmp_str($_POST['value'],4,24);
		if ($name == "SHORT") {
			$JSON['status'] = "ERROR";
			$JSON['errors'][] = "Nick musi zawierać co najmniej cztery znaki!";
		}
		if ($name == "LONG") {
			$JSON['status'] = "ERROR";
			$JSON['errors'][] = "Nick może zawierać maksymalnie dwadzieścia cztery znaki!";
		}
		if ($name == "SPACES") {
			$JSON['status'] = "ERROR";
			$JSON['errors'][] = "Niewłaściwa nazwa";
		}
		$check = DB::numrows(DB::Query("SELECT * FROM `users` WHERE `name` = '{$name}'"));
		if ($check > 0) {
			$JSON['status'] = "ERROR";
			$JSON['error'] = "Nazwa gracza już w użyciu!";
			$JSON['suggestions'] = array(
				"Lord {$_POST['value']}",
				"Lady {$_POST['value']}",
				"Sir {$_POST['value']}",
				"Madame {$_POST['value']}",
				"{$_POST['value']}1",
				"{$_POST['value']}13",
				"{$_POST['value']}17",
				"{$_POST['value']}25",
				"{$_POST['value']}77",
				"{$_POST['value']}99",
				"{$_POST['value']}666",
				"{$_POST['value']}999",
				"{$_POST['value']}1337",
				"{$_POST['value']}9000",
				"{$_POST['value']}701",
				"{$_POST['value']}451",
				"{$_POST['value']}993",
				"{$_POST['value']}817",
				"{$_POST['value']}172",
				"{$_POST['value']}692",
				"{$_POST['value']}454",
				"{$_POST['value']}474",
				"{$_POST['value']}900",
				"{$_POST['value']}496",
				"{$_POST['value']}262",
				"{$_POST['value']}123"
			);
		}
	}
	MyTW_json_exit($JSON);
} else {
	$JSON = ["status"=>"OK","errors"=>[]];
	$name = cmp_str($_POST['register_username'],4,14);
	$pass = $_POST['register_password'];
	$MAIL = $_POST['register_email'];
	if ($name == "SHORT") {
		$ERRORS[] = "Nick musi zawierać co najmniej cztery znaki!";
	}
	if ($name == "LONG") {
		$ERRORS[] = "Nick może zawierać maksymalnie dwadzieścia cztery znaki!";
	}
	if ($name == "SPACES") {
		$ERRORS[] = "Niewłaściwa nazwa";
	}
	$check = DB::numrows(DB::Query("SELECT * FROM `users` WHERE `name` = '{$name}'"));
	if ($check > 0) {
		$ERRORS[] = "Nazwa gracza już w użyciu!'";
		$JSON['suggestions'] = array(
			"Lord {$_POST['value']}",
			"Lady {$_POST['value']}",
			"Sir {$_POST['value']}",
			"Madame {$_POST['value']}",
			"{$_POST['value']}1",
			"{$_POST['value']}13",
			"{$_POST['value']}17",
			"{$_POST['value']}25",
			"{$_POST['value']}77",
			"{$_POST['value']}99",
			"{$_POST['value']}666",
			"{$_POST['value']}999",
			"{$_POST['value']}1337",
			"{$_POST['value']}9000",
			"{$_POST['value']}701",
			"{$_POST['value']}451",
			"{$_POST['value']}993",
			"{$_POST['value']}817",
			"{$_POST['value']}172",
			"{$_POST['value']}692",
			"{$_POST['value']}454",
			"{$_POST['value']}474",
			"{$_POST['value']}900",
			"{$_POST['value']}496",
			"{$_POST['value']}262",
			"{$_POST['value']}123"
		);		
	}
	
	$pass_str = strlen($pass);
	if ($pass_str < 4) {
		$ERRORS[] = "Hasło musi się składać z minimum 4 znaków!";
	}
	
	if ($pass === $name) {
		$ERRORS[] = "Hasło nie może być takie samo jak twój nick!";
	}
		
	$MINMAX = [5,60];
	if (strlen($MAIL) < $MINMAX[0]) {
		$ERRORS[] = "Adres E-mail za krótki! Minimum {$MINMAX[0]} znaków!";
	}
	if (strlen($MAIL) > $MINMAX[1]) {
		$ERRORS[] = "Adres E-mail za długi! Maximu {$MINMAX[1]} znaków!";
	}
	if (!filter_var($MAIL, FILTER_VALIDATE_EMAIL)) {
		$ERRORS[] = "Adres e-mail wydaje się nieprawidłowy. Wprowadź adres w formacie „nazwa@przykładowadomena.com”.";
	}
	$PARSEMAIL = parse($MAIL);
	$SQLCheck = DB::numrows(DB::Query("SELECT `id` FROM `users` WHERE `email` = '{$PARSEMAIL}'"));
	if ($SQLCheck > 0) {
		$ERRORS[] = "Adres „{$MAIL}” jest już zarejestrowany. Wprowadź inny adres e-mail.";
	}
	
	if ($_POST['terms'] != "on") {
		$ERRORS[] = "Musisz zaakceptować warunki użytku";
	}
	
	if (count($ERRORS) === 0) {
		$password = pass($pass);
		$session = random(40);
		$key = random(10);
		$sql = DB::Query("INSERT INTO `users`(`name`,`pass`,`email`,`session`,`key`,`worlds`) VALUES ('{$name}','{$password}','{$PARSEMAIL}','{$session}','{$key}','[]')");
		if ($sql===false) {
			$ERRORS[] = "Wystąpił nieznany błąd, prosimy spróbować później.";
		} else {
			$newacc = DB::fetch(DB::Query("SELECT * FROM `users` ORDER BY `id` DESC LIMIT 1"),"array");
			$session = $newacc['session'];
			setcookie("session",$session,time()+3600*24*365,"/");
			$_COOKIE['session'] = $session;
			$JSON['status'] = "OK";
		}
	}
	if (count($ERRORS) > 0) {
		$JSON['status'] = "ERROR";
		$JSON['errors'] = $ERRORS;
	}
	MyTW_json_exit($JSON);
}
/*
if ($action == "validate") {
	$name = cmp_str($_POST['value'],4,14);
	$pass = $_POST['password'];
	$pass_confirm = $_POST['password_confirm'];
	$MAIL = $_POST['email'];
	if ($name == "SHORT") {
		$ERRORS[] = "Nick musi zawierać co najmniej cztery znaki!";
	}
	if ($name == "LONG") {
		$ERRORS[] = "Nick może zawierać maksymalnie dwadzieścia cztery znaki!";
	}
	if ($name == "SPACES") {
		$ERRORS[] = "Niewłaściwa nazwa";
	}
	$check = DB::numrows(DB::Query("SELECT * FROM `users` WHERE `name` = '{$name}'"));
	if ($check > 0) {
		$ERRORS[] = "Nazwa gracza już w użyciu!'";
	}
	
	$pass_str = strlen($pass);
	if ($pass_str < 4) {
		$ERRORS[] = "Hasło musi się składać z minimum 4 znaków!";
	}
	
	if ($pass === $name) {
		$ERRORS[] = "Hasło nie może być takie samo jak twój nick!";
	}
	
	if ($pass != $pass_confirm) {
		$ERRORS[] = "Musisz wpisać hasło dwa razy identycznie.";
	}
	
	$MINMAX = [5,60];
	if (strlen($MAIL) < $MINMAX[0]) {
		$ERRORS[] = "Adres E-mail za krótki! Minimum {$MINMAX[0]} znaków!";
	}
	if (strlen($MAIL) > $MINMAX[1]) {
		$ERRORS[] = "Adres E-mail za długi! Maximu {$MINMAX[1]} znaków!";
	}
	if (!filter_var($MAIL, FILTER_VALIDATE_EMAIL)) {
		$ERRORS[] = "Adres e-mail wydaje się nieprawidłowy. Wprowadź adres w formacie „nazwa@przykładowadomena.com”.";
	}
	$PARSEMAIL = parse($MAIL);
	$SQLCheck = DB::numrows(DB::Query("SELECT `id` FROM `users` WHERE `email` = '{$PARSEMAIL}'"));
	if ($SQLCheck > 0) {
		$ERRORS[] = "Adres „{$MAIL}” jest już zarejestrowany. Wprowadź inny adres e-mail.";
	}
	
	if ($_POST['agb'] != "true") {
		$ERRORS[] = "Musisz zaakceptować warunki użytku";
	}
	
	if (count($ERRORS) === 0) {
		$password = pass($pass);
		$session = random(40);
		$key = random(10);
		$sql = DB::Query("INSERT INTO `users`(`name`,`pass`,`email`,`session`,`key`,`worlds`) VALUES ('{$name}','{$password}','{$PARSEMAIL}','{$session}','{$key}','[]')");
		if ($sql===false) {
			$ERRORS[] = "Wystąpił nieznany błąd, prosimy spróbować później.";
		} else {
			$newacc = DB::fetch(DB::Query("SELECT * FROM `users` ORDER BY `id` DESC LIMIT 1"),"array");
			$session = $newacc['session'];
			setcookie("session",$session,time()+3600*24*365);
			setcookie("session_al","true",time()+3600*24*365);
			$_COOKIE['session'] = $session;
			$_COOKIE['session_al'] = "true";
			header("Location: /?activate_id={$newacc['id']}");
		}
	}
}*/
?>