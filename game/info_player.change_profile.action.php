<?php
$b_day = (int)$_POST['day'];
$b_month = (int)$_POST['month'];
$b_year = (int)$_POST['year'];

$date = explode('-',date("Y-m-d"));
$year = $date[0];				
if ($b_year < ($year - 100)) {		
	$b_year = ($year - 100);			
}		
if ($b_year > $year) {		
	$b_year = $year;			
}					
if ($b_month < 1) {		
	$b_month = 1;		
}	
if ($b_month > 12) {	
	$b_month = 12;		
}
$days = date("t",@mktime(0,0,0,$b_month,0,$b_year));
if ($b_day < 1) {		
	$b_day = 1;		
}	
if ($b_day > $days) {	
	$b_day = $days;
}
$sex = $_POST['sex'];
if (!in_array($sex,['f','m','x'])) {
	$sex = "x";
}

$home = $_POST['home'];
if (strlen($home>24)) {
	$errors[] = "Miejsce zamieszkanie nie może mieć więcej niż dwadzieścia cztery znaki";
} else {
	$home = parse($home);
	$return = DB::Query("UPDATE `{$DB}`.`users` SET `b_year` = '{$b_year}' , `b_month` = '{$b_month}' , `b_day` = '{$b_day}' , `sex` = '{$sex}' , `home` = '{$home}' WHERE `id` = '{$user['id']}'");
	if ($return===false) {
		$errors[] = "Nie udało się zaktualizowac profilu";
		if ($user['name']==="Bartekst222") {
			$errors[] = MySQL_error();
		}
	} else {
		setcookie("success_message","Twój profil został zaktualizowany.");
		header("LOCATION: /game.php?village={$village['id']}&screen={$screen}");
	}
}
?>