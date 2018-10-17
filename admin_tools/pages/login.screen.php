<!DOCTYPE html>
<html>
<head>
<title>MyTW Admintool</title>
<link rel="stylesheet" type="text/css" href="https://login.innogames.de/css/login.css?2014122020" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js"></script>
</head>

<body id="auth">
	<div id="auth_container">
		<div id="auth_header">
						<h3>MyTW Admintool</h3>
					</div>
		<div id="sep"></div>
		<div id="auth_content">
			
<p>Proszę się zalogowac używając swojej nazwy oraz hasła.</p>
<?php
if (count($Admin->errors) > 0) {
	echo "<div id=\"auth_login\">";
		foreach($Admin->errors as $error) {
			echo "<p style=\"color: #ab0202;\">{$error}</p>";
		}
	echo "</div>";
}
?>
<div id="auth_login">
	<form method="post">
		<table style="width: 94%">
						<tr>
				<td style="text-align: right">Użytkownik:</td>
				<td><input type="text" name="username" /></td>
			</tr>
			<tr>
				<td style="text-align: right">Hasło:</td>
				<td><input type="password" name="password" /></td>
			</tr>
			<tr class="additional_auth" style="display: none">
				<td style="text-align: right">Kod:</td>
				<td><input type="text" name="code" /></td>
			</tr>
					</table>
		<button class="btn btn-success" type="submit" style="margin-top: 30px">Zaloguj</button>
	</form>
</div>

<div id="auth_status" style="height: 30px">
</div>

<script type="text/javascript">
$(function() {
	$('input[type=submit]').attr('disabled', '');

	$.ajaxSetup({
		error:function(x,e){
			$('#auth_status').html('Wystąpił nieznany błąd. Prosimy spróbować ponownie później.').css('color', '#ab0202');
			$('form').find('input[type=submit]').attr('disabled', '');
		}
	});
		
	
	$('form').submit(function(e) {
		e.preventDefault();
		img = '<img src="https://login.innogames.de/img/ajax.gif" alt="" />';
		$this = $(this);
		
		$status = $('#auth_status').html(img + ' Weryfikacja danych.').css('color', 'black');
		$this.find('input[type=submit]').attr('disabled', 'disabled');

		$.post('&ajax=login', {
			username: $this.find('input[name=username]').val(), 
			password: $this.find('input[name=password]').val(),
			code: $this.find('input[name=code]').val(),}, 
			function(data) {
				if(typeof data.error != 'undefined') {
					$status = $('#auth_status').html(data.error).css('color', '#ab0202');
					$this.find('input[type=submit]').attr('disabled', '');

					if (typeof data.additional_auth != 'undefined') {
						$('.additional_auth').show();
					}
				}
				else {
					$status = $('#auth_status').html(img + ' Logowanie...').css('color', 'black');
					window.location.href = data.url;
				}
		}, 'json');
	});

	});
</script>

</html> 		</div>
	</div>
</body>