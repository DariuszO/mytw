<?php

if (IsSet($_GET['ajax'])&&IsSet($_GET['check'])) {
	$name = $_POST['name'];
	$pass = $_POST['password'];
	$pass2 = $_POST['password2'];
	$mail = $_POST['mail'];
	
}
?>
<h2>Konto głównego administratora</h2>
<p id="cinfo">Aby dokończyć proces instalacji porsimy o stworzenie konta administratora.</p>
<table class="vis" width="100%">
	<tr width="100%">
		<th colspan="2">
			Tworzenie nowego konta
		</th>
	</tr>
	<tr>
		<td>
			Nazwa:
		</td>
		<td>
			<input type="text" name="name" id="name" value="" placeholder="Nazwa administratora" />
		</td>
	</tr>
	<tr>
		<td>
			Hasło:
		</td>
		<td>
			<input type="password" name="password" id="password" value="" placeholder="Hasło" />
		</td>
	</tr>
	<tr>
		<td>
			Powtórz hasło:
		</td>
		<td>
			<input type="password" name="password2" id="password2" value="" placeholder="Powtórz hasło" />
		</td>
	</tr>
		<tr>
		<td>
			E-mail:
		</td>
		<td>
			<input type="text" name="mail" id="mail" value="" placeholder="E-mail" />
		</td>
	</tr>
</table>

<script type="text/javascript">
	$("#check_next_step").click(function() {
		var CheckData = {
			name : $("#name").val(),
			password : $("#password").val(),
			password2 : $("#password2").val(),
			mail : $("#mail").val()
		};
		Setup.step_check('3',CheckData,'end');
	});
</script>
<div class="hof-footer">
	<div class="button-center-wrapper">
		<div class="the-red-button-border-right">
			<div class="the-red-button-border">
				<div class="the-red-button">
					<a href="#end" id="check_next_step" onclick=" return false;">Zakończ instalację</a>
				</div>
			</div>
		</div>
	</div>
</div>