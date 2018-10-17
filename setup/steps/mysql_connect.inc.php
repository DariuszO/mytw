<?php

if (IsSet($_GET['check']) && IsSet($_GET['ajax'])) {
	$host = $_POST['host'];
	$user = $_POST['user'];
	$pass = $_POST['pass'];
	if (empty($host)) {
		MyTW_json_exit(["error"=>"Proszę podać host połączenia!"]);
	}
	if (empty($user)) {
		MyTW_json_exit(["error"=>"Proszę podać użytkownika!"]);
	}
	
	$connect = @mysql_connect($host,$user,$pass,"");
	if ($connect===false) {
		MyTW_json_exit(["error"=>"Nie można połączyć z MySQL!<br /><pre>Błąd <b>#". mysql_errno() ."</b>: <b style=\"color: red;\">". mysql_error() ."</b></pre>"]);						
	} else {
		$database = "mytw_index";
		$sql = mysql_query("CREATE DATABASE IF NOT EXISTS `{$database}`",$connect);
		if ($sql===false) {
			MyTW_json_exit(["error"=>"Ten użytkownik nie ma praw do tworzenia tabeli! Prosimy zalogować na administratora."]);	
		} else {
			$SQL_CREATE = @file_get_contents(PATH . "/setup/MySQL.sql");
			if ($SQL_CREATE===false) {
				MyTW_json_exit(["error"=>"Nie można wczytać pliku z bazą danych! Prosimy sprawdzić czy istnieje plik <b>". PATH ."\\setup\\MySQL.sql</b>"]);	
			} else {
				$go = mysql_query($SQL_CREATE);
				if ($go === false) {
					MyTW_json_exit(["error"=>"Wystąpił błąd podczas tworzenia bazy danych! Prosimy podesłać poniższe dane do naszego Centrum pomocy!<br /><pre>Błąd <b>#". mysql_errno() ."</b>: <b style=\"color: red;\">". mysql_error() ."</b></pre>"]);
				} else {
					$cfile = PATH . "/configs/MySQL.ini";
					if (file_exists($cfile)) {
					$delete = @unlink($cfile);
						if ($delete===false) {
							MyTW_json_exit(["error"=>"Wystąpił błąd podczas nadpisywania konfiguracji MySQL."]);
						}
					}
					$C = "[connect]\r\nhost=\"{$host}\"\r\nuser=\"{$user}\"\r\npassword=\"{$pass}\"\r\n\r\n[database]\r\nindex=\"mytw_index\"\r\nworld=\"mytw_world_[ID]\"";
					$create = @file_put_contents($cfile,$C);
					if ($create===false) {
						MyTW_json_exit(["error"=>"Nie można stworzyć pliku konfiguracji MySQL!"]);
					}
				}
			}
		}
	}
	MyTW_json_exit(["success"=>"Brak błędów."]);
}
?>
<h3 style="text-align: center">Połączenie z bazą danych</h3>
<p id="cinfo">Serwer wymaga dostępu do <i>roota</i> bazy danych. Jeśli posiadasz bazę danych bez pełnego dostępu, mogą wystąpił błędy. Konfigurację może zmienić właściciel w panelu administratora oraz w pliku konfiguracyjnym MySQL. <b>UWAGA!</b> Jeśli instalujesz silnik na serwerze lokalnym (<i>Localhost</i>) prosimy nie zmieniać poniższej konfiguracji.</p>
<br>
<table class="vis" width="100%">
	<tr>
		<th colspan="2" width="100%">
			Połączenie z bazą MySQL
		</th>
	</tr>
	<tr>
		<td width="25%">
			Host:
		</td>
		<td>
			<input id="host" name="host" type="text" value="127.0.0.1" placeholder="localhost" />
		</td>
	</tr>
	<tr>
		<td width="25%">
			Użytkownik:
		</td>
		<td>
			<input id="user" name="user" type="text" value="root" placeholder="root" />
		</td>
	</tr>
	<tr>
		<td width="25%">
			Hasło:
		</td>
		<td>
			<input id="pass" name="pass" type="text" value="root" placeholder="root" />
		</td>
	</tr>
</table>
<script type="text/javascript">
	$("#check_next_step").click(function() {
		var CheckData = {
			host : $("#host").val(),
			user : $("#user").val(),
			pass : $("#pass").val()
		};
		Setup.step_check('2',CheckData,'3');
	});
</script>
<div class="hof-footer">
	<div class="button-center-wrapper">
		<div class="the-red-button-border-right">
			<div class="the-red-button-border">
				<div class="the-red-button">
					<a href="#step3" id="check_next_step" onclick=" return false;">Następny krok</a>
				</div>
			</div>
		</div>
	</div>
</div>