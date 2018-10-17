<?php
/**********************************/
/*           TribalWars           */
/*             My-TW              */
/*         by Bartekst222         */
/**********************************/
/*		    Register     		  */
/**********************************/

require_once "./libraries/common.inc.php";

$ajax = $_GET['ajax'];

if ($ajax == "check_name") {
	$JSON = array();
	$name = cmp_str($_POST['name'],4,24);
	if ($name == "SHORT") {
		$JSON['errors'][] = "nickname_too_short";
	}
	if ($name == "LONG") {
		$JSON['errors'][] = "nickname_too_long";
	}
	if ($name == "SPACES") {
		$JSON['errors'][] = "nickname_bad_char";
	}
	$check = DB::numrows(DB::Query("SELECT * FROM `users` WHERE `name` = '{$name}'"));
	if ($check > 0) {
		$JSON['errors'][] = "nickname_conflict";
		$JSON['suggestions'] = array(
			"Lord {$_POST['name']}",
			"Lady {$_POST['name']}",
			"Sir {$_POST['name']}",
			"Madame {$_POST['name']}",
			"{$_POST['name']}1",
			"{$_POST['name']}13",
			"{$_POST['name']}17",
			"{$_POST['name']}25",
			"{$_POST['name']}77",
			"{$_POST['name']}99",
			"{$_POST['name']}666",
			"{$_POST['name']}999",
			"{$_POST['name']}1337",
			"{$_POST['name']}9000",
			"{$_POST['name']}701",
			"{$_POST['name']}451",
			"{$_POST['name']}993",
			"{$_POST['name']}817",
			"{$_POST['name']}172",
			"{$_POST['name']}692",
			"{$_POST['name']}454",
			"{$_POST['name']}474",
			"{$_POST['name']}900",
			"{$_POST['name']}496",
			"{$_POST['name']}262",
			"{$_POST['name']}123"
		);
	}
	if (!empty($JSON['errors'])) {
		$JSON['status'] = "ERROR";
	}
	MyTW_json_exit($JSON);
	
}

if ($ajax == "check_input") {
	$type = $_POST['type'];
	$val = $_POST['value'];
	$JSON = array();
	if ($type == "password") {
		if (strlen($val) < 4) {
			$JSON['status'] = "ERROR";
			$JSON['message'][] = "Hasło musi się składać z minimum 4 znaków!";
		}
	} elseif ($type == "email") {
		$MAIL = $val;
		$MINMAX = [5,60];
		if (strlen($MAIL) < $MINMAX[0]) {
			$JSON['status'] = "ERROR";
			$JSON['message'][] = "Adres E-mail za krótki! Minimum {$MINMAX[0]} znaków!";
		}
		if (strlen($MAIL) > $MINMAX[1]) {
			$JSON['status'] = "ERROR";
			$JSON['message'][] = "Adres E-mail za długi! Maximu {$MINMAX[1]} znaków!";
		}
		if (!filter_var($MAIL, FILTER_VALIDATE_EMAIL)) {
			$JSON['status'] = "ERROR";
			$JSON['message'][] = "Adres e-mail wydaje się nieprawidłowy. Wprowadź adres w formacie „nazwa@przykładowadomena.com”.";
		}
		$PARSEMAIL = parse($MAIL);
		$SQLCheck = DB::numrows(DB::Query("SELECT `id` FROM `users` WHERE `email` = '{$PARSEMAIL}'"));
		if ($SQLCheck > 0) {
			$JSON['status'] = "ERROR";
			$JSON['message']["email_conflict"] = "Adres „{$val}” jest już zarejestrowany. Wprowadź inny adres e-mail.";
		}
	}
	
	
	MyTW_json_exit($JSON);
}

$action = $_GET['action'];
$ERRORS = Array();
if ($action == "validate") {
	
	$name = cmp_str($_POST['name'],4,14);
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
}

require_once PE . "/index_top.php";
?>
			
			<script type="text/javascript">
			//<![CDATA[
			Register.messages = {
				nickname_too_short : 'Nick musi zawierać co najmniej cztery znaki!',
				nickname_too_long : 'Nick może zawierać maksymalnie dwadzieścia cztery znaki!',
				nickname_bad_char : 'Niewłaściwa nazwa',
				nickname_blocked : 'Niewłaściwa nazwa',
				nickname_conflict : 'Nazwa gracza już w użyciu!',
				unknown : 'Wystąpił nieznany błąd, prosimy spróbować później.'
			};

			$(document).ready(function() {
				Register.checkName($('#name').val());
							});

			//]]>
			</script>

			<div id="content">
				<div id="screenshot" style="visibility:hidden" onclick="hide_screenshot();">
					<div id="screenshot_image"></div>
				</div>
				<div class="container-block-full">
					<div class="container-top-full"></div>
					<div class="container">
						<div class="info-block register" style="margin-left:10px">
														<!--<a class="play-with" id="play-with-facebook" href="http://ipp-facebook.innogames.de/?game=staemme&;market=pl&;ref=&;">Zarejestruj z Facebook</a>-->
							
							<h2 class="register" style="margin-bottom: 10px">Zarejestruj się teraz!</h2>

							
														
							<h3 class="error"><?php
							$totalerr = count($ERRORS);
							$errI = 0;
							foreach ($ERRORS as $err) {
								$errI++;
								echo $err;
								if ($errI!=$totalerr) {
									echo "<br />";
								}
							}
							?></h3>

							<form id="register_form" action="register.php?mode=new_account&action=validate" method="post">
								<input type="hidden" name="apt" value="" />
								<script>
									$('input[name=apt]').val(Index.getIdent());
								</script>
								
								<label for="name">Nazwa gracza:</label><br />
																<input id="name" autocomplete="off" autofocus="autofocus" name="name" type="text" value="" onchange="Register.checkName(this.value)" />
								<span id="name_error" class="error"></span><br />

								<div id="name-suggestions" style="display: none; padding: 8px;  margin-top: 8px; border: 1px solid #654; width: 30em; margin-bottom: 8px;">
									<h3 class="error">Proponowana nazwa:</h3>
									<ul id="name-suggestion-list">
									</ul>
								</div>

								<label for="password">Hasło:</label><br />
																<input id="password" name="password" type="password" value="" onchange="Register.checkInputEqual('name', this.value);Register.checkInput('password', this.value)" />
								<span id="password_error" class="error"></span> <span id="password_errors" class="error"></span> <span id="password_info" class="info"></span><br />
								<label for="password_confirm">Powtórz hasło:</label><br />
																<input id="password_confirm" name="password_confirm" type="password" value="" onchange="Register.checkInputEqual('password', this.value)" />
								<span id="password_confirm_error" class="error"></span><br />

								<label for="email">E-mail:</label><br />
								<span class="small">(Potrzebne do aktywacji)</span><br />
								<input id="email" name="email" type="text" value="" size="40" onchange="Register.checkInput('email', this.value)" /><br />
								<input type="hidden" name="email_hash" value="" />
								<div id="email_error" class="error" style="margin-bottom: 10px;"></div>

								<div class="info_box" id="recover_account" style="display: none; margin-bottom: 5px">
								Chcesz odzyskać konto? Kliknij <a href="/lost_pw.php">tutaj</a> aby poprosić o maila z przypomnieniem.
								</div>

								<div>
								 <table width="100%">
								  <tr>
									<td valign="top" width="20px"><input id="agb" name="agb" type="checkbox" value="true" /></td>
																											<td>
										Rejestrując się w grze akceptuję <a href="javascript:popup_scroll('<?php echo $cfg['host'];?>/popup_rules.php', 920, 600)">Regulamin</a> oraz <a href="javascript:popup_scroll('http://legal.innogames.com/staemme/pl/privacy', 920, 600)">zasady ochrony danych</a>.
									</td>
								  </tr>
								 </table>
								</div><br />

								
								<input id="register_button" type="submit" value="Zarejestruj" style="margin-top:8px;" />
							</form>
						</div>
					</div>
					<div class="container-bottom-full"></div>
				</div>
			</div><!-- content -->
<?php 
require_once PE . "/index_footer.php";
?>