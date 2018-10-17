<?php

if (IsSet($_GET['check']) && IsSet($_GET['ajax'])) {
	$name = $_POST['name'];
	$mytwreg = $_POST['mytwreg'];
	$ipcontrol = $_POST['ipcontrol'];
	$cdn = $_POST['cdn'];
	
	$mytwreg = ($mytwreg==="true") ? "true":"false";
	$ipcontrol = ($ipcontrol==="true") ? "true":"false";
	
	if (strlen($name) < 4 || strlen($name) > 15) {
		MyTW_json_exit(["error"=>"Nazwa gry musi zawierać od 4 do 15 znaków!","input_error"=>"name"]);
	}
	
	$header = @get_headers($cdn);
	if($header===false) {
		$check = false;
	} elseif(!in_array("HTTP/1.1 200 OK",$header)) {
		$check = false;
	} else {
		$check = true;
	}
	
	if ($check === false) {
		MyTW_json_exit(["error"=>"URL Grafiki wydaje się być nieprawidłowy.","input_error"=>"cdn"]);
	}
	
	$newc = "#	User configs:
	#	Game name:
game_name=\"{$name}\"
	#	Worlds url:
	#	[ID] - World id!
	#	[HOST] - Server website!
	#	Default: \"http://[HOST]/[ID]\"
world_url=\"http://[HOST]/s/[ID]/\"
	#	MyTW Account import:
	#	True of false
mytw_register=\"{$mytwreg}\"
	#	Install success:
	#	True of false
install=\"true\"
	#	Ip control:
	#	True of false
ip_control=\"{$ipcontrol}\"
	#	License:
license=\"free_localhost_license\"
	# CSS, JS and graphic:
cdn=\"{$cdn}\"

#	DO NOT EDIT THIS CONFIGS:
	#	Author:
author=\"Bartekst222\"
	#	Actual version:
version=\"1.1\"
	#	MyTW website:
mytw_website=\"http://my-tw.tk\"";
	$cfile = PATH . "/configs/MyTW.ini";
	if (file_exists($cfile)) {
		$delete = @unlink($cfile);
		if ($delete===false) {
			MyTW_json_exit(["error"=>"Wystąpił błąd podczas nadpisywania konfiguracji."]);
		}
	}
	$create = @file_put_contents($cfile,$newc);
	if ($create===false) {
		MyTW_json_exit(["error"=>"Nie można stworzyć pliku konfiguracji!"]);
	}
	MyTW_json_exit(["success"=>"Brak błędów."]);
}
?>
<h3 style="text-align: center">Ustawienia podstawowe</h3>
<p id="cinfo">Te ustawienia można później zmienić w panelu administratora.</p>
<br>
<table class="vis" width="100%">
	<tr>
		<th colspan="2" width="100%">
			Tworzenie konfiguracji
		</th>
	</tr>
	<tr>
		<td width="25%">
			Nazwa gry:
		</td>
		<td>
			<input id="config_name" name="config_name" type="text" value="Plemiona" placeholder="Plemiona" />
		</td>
	</tr>
	<tr>
		<td width="25%">
			Rejestracja za pomocą konta MyTW:
		</td>
		<td>
			<input id="config_mytwreg" name="config_mytwreg" type="checkbox" value="true" checked /> <br /><i style="font-size: 0.9em;">Rejestracja za pomocą konta MyTW pozwala na zaoszczędzenie czasu rejestracji oraz importowanie danych konta z oficialnej strony MyTW, konto jest także automatycznie aktywowane.</i><br />
		</td>
	</tr>
	<tr>
		<td width="25%">
			Kontrola IP:
		</td>
		<td>
			<input id="config_ipcontrol" name="config_ipcontrol" type="checkbox" value="true" /> <br /><i style="font-size: 0.9em;">Kontrola IP blokuje adresy IP które nie znajdują się na liście. Adresy te można edytować w pliku <b><?php echo PATH;?>\configs\follow_ips.txt</b> oraz w panelu administratora.</i><br />
		</td>
	</tr>
	<tr>
		<td width="25%">
			Grafika:
		</td>
		<td>
			<input id="config_cdn" name="config_cdn" type="text" value="http://<?php echo $_SERVER['HTTP_HOST'];?>/cdn" placeholder="http://<?php echo $_SERVER['HTTP_HOST'];?>/cdn" /><br />
			<i style="font-size: 0.9em;">Powyższy link jest odnośnikiem do stron graficznych. Porsimy tego nie edytować, mogą wystąpić błędy z grafiką!</i>
		</td>
	</tr>
</table>
<script type="text/javascript">
	$("#check_next_step").click(function() {
		var CheckData = {
			name : $("#config_name").val(),
			mytwreg : $("#config_mytwreg:checked").val(),
			ipcontrol : $("#config_ipcontrol:checked").val(),
			cdn : $("#config_cdn").val()
		};
		Setup.step_check('1',CheckData,'2');
	});
</script>
<div class="hof-footer">
	<div class="button-center-wrapper">
		<div class="the-red-button-border-right">
			<div class="the-red-button-border">
				<div class="the-red-button">
					<a href="#step2" id="check_next_step" onclick=" return false;">Następny krok</a>
				</div>
			</div>
		</div>
	</div>
</div>