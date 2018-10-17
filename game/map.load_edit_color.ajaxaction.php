<?php
$r = $_GET['r'];
$g = $_GET['g'];
$b = $_GET['b'];
NewLog(json_encode($_POST),"POST","/logs/autocomplete.log");
?>
<div id="color_picker_popup" style=" padding:10px;background-image:url('<?php echo $cfg['cdn']; ?>/graphic//background/content.jpg')">
	<form id="editcolorform" method="post" action="/game.php?village=57773&action=change_group_color&h=<?php echo $hkey; ?>&screen=map">
		<strong>Zmień zaznaczenie</strong>
		<table style="margin-top:5px;">
			<tr>
				<td width="10">Kolor:</td>
				<td id="color" width="20"></td>
				<td>

					<span id="trans_color">
					<label>
						<input type="checkbox"  onchange="this.checked ? $('#color').css('background-color', 'transparent' ) : color_picker_change();" name="transparent" value="1" id="trans_color_input" />
						przezroczysty
					</label>
					</span>
					&nbsp;
				</td>
			</tr>
		</table>
		<script type="text/javascript">
function color_picker_choose(r, g, b, ignore_transparency) {
	$("#color_picker_r").val(r);
	$("#color_picker_g").val(g);
	$("#color_picker_b").val(b);
	color_picker_change(ignore_transparency);
}

function color_picker_change(ignore_transparency) {
	var r = $("#color_picker_r").val();
	var g = $("#color_picker_g").val();
	var b = $("#color_picker_b").val();
	$("#color").css('background-color', "rgb("+r+", "+g+", "+b+")");
	$("#color").css('background-image','none');
	if (ignore_transparency !== true)
		$('#trans_color_input').attr('checked', false);
}
function color_picker_ok() {
	color_picker_change(false);
}
</script><table id="color_picker" style="border-spacing:0px; display:none"><tr><td>czerwony:</td><td><input onclick="this.focus();" name="color_picker_r" id="color_picker_r" style="font-size:10px; " onchange="color_picker_change()" onkeyup="color_picker_change()" size="4" type="text" /></td><td style="background-color:rgb(0,0,0); background-image:none" width="15" onclick="color_picker_choose(0,0,0)">&nbsp;</td><td style="background-color:rgb(0,0,127); background-image:none" width="15" onclick="color_picker_choose(0,0,127)">&nbsp;</td><td style="background-color:rgb(0,0,254); background-image:none" width="15" onclick="color_picker_choose(0,0,254)">&nbsp;</td><td style="background-color:rgb(0,127,0); background-image:none" width="15" onclick="color_picker_choose(0,127,0)">&nbsp;</td><td style="background-color:rgb(0,127,127); background-image:none" width="15" onclick="color_picker_choose(0,127,127)">&nbsp;</td><td style="background-color:rgb(0,127,254); background-image:none" width="15" onclick="color_picker_choose(0,127,254)">&nbsp;</td><td style="background-color:rgb(0,254,0); background-image:none" width="15" onclick="color_picker_choose(0,254,0)">&nbsp;</td><td style="background-color:rgb(0,254,127); background-image:none" width="15" onclick="color_picker_choose(0,254,127)">&nbsp;</td><td style="background-color:rgb(0,254,254); background-image:none" width="15" onclick="color_picker_choose(0,254,254)">&nbsp;</td></tr>
<tr><td>zielony:</td><td><input onclick="this.focus();" name="color_picker_g" id="color_picker_g" style="font-size:10px; " onchange="color_picker_change()" onkeyup="color_picker_change()" size="4" type="text" /></td><td style="background-color:rgb(127,0,0); background-image:none" width="15" onclick="color_picker_choose(127,0,0)">&nbsp;</td><td style="background-color:rgb(127,0,127); background-image:none" width="15" onclick="color_picker_choose(127,0,127)">&nbsp;</td><td style="background-color:rgb(127,0,254); background-image:none" width="15" onclick="color_picker_choose(127,0,254)">&nbsp;</td><td style="background-color:rgb(127,127,0); background-image:none" width="15" onclick="color_picker_choose(127,127,0)">&nbsp;</td><td style="background-color:rgb(127,127,127); background-image:none" width="15" onclick="color_picker_choose(127,127,127)">&nbsp;</td><td style="background-color:rgb(127,127,254); background-image:none" width="15" onclick="color_picker_choose(127,127,254)">&nbsp;</td><td style="background-color:rgb(127,254,0); background-image:none" width="15" onclick="color_picker_choose(127,254,0)">&nbsp;</td><td style="background-color:rgb(127,254,127); background-image:none" width="15" onclick="color_picker_choose(127,254,127)">&nbsp;</td><td style="background-color:rgb(127,254,254); background-image:none" width="15" onclick="color_picker_choose(127,254,254)">&nbsp;</td></tr>
<tr><td>niebieski:</td><td><input onclick="this.focus();" name="color_picker_b" id="color_picker_b" style="font-size:10px; " onchange="color_picker_change()" onkeyup="color_picker_change()" size="4" type="text" /></td><td style="background-color:rgb(254,0,0); background-image:none" width="15" onclick="color_picker_choose(254,0,0)">&nbsp;</td><td style="background-color:rgb(254,0,127); background-image:none" width="15" onclick="color_picker_choose(254,0,127)">&nbsp;</td><td style="background-color:rgb(254,0,254); background-image:none" width="15" onclick="color_picker_choose(254,0,254)">&nbsp;</td><td style="background-color:rgb(254,127,0); background-image:none" width="15" onclick="color_picker_choose(254,127,0)">&nbsp;</td><td style="background-color:rgb(254,127,127); background-image:none" width="15" onclick="color_picker_choose(254,127,127)">&nbsp;</td><td style="background-color:rgb(254,127,254); background-image:none" width="15" onclick="color_picker_choose(254,127,254)">&nbsp;</td><td style="background-color:rgb(254,254,0); background-image:none" width="15" onclick="color_picker_choose(254,254,0)">&nbsp;</td><td style="background-color:rgb(254,254,127); background-image:none" width="15" onclick="color_picker_choose(254,254,127)">&nbsp;</td><td style="background-color:rgb(254,254,254); background-image:none" width="15" onclick="color_picker_choose(254,254,254)">&nbsp;</td></tr>
</table>
		<br/>
		<table id="icon_picker" style="border-spacing:0px"><tr><td>Symbol-URL: &nbsp;<input id='icon_url' name='icon_url' value='' /></td></tr><tr><td><img src='<?php echo $cfg['cdn']; ?>/graphic/unit_map/spear.png?1e448' style="cursor: pointer" onclick="$('#icon_url').val('/graphic/unit_map/spear.png');" /><img src='<?php echo $cfg['cdn']; ?>/graphic/unit_map/sword.png?5a9e6' style="cursor: pointer" onclick="$('#icon_url').val('/graphic/unit_map/sword.png');" /><img src='<?php echo $cfg['cdn']; ?>/graphic/unit_map/axe.png?538b1' style="cursor: pointer" onclick="$('#icon_url').val('/graphic/unit_map/axe.png');" /><img src='<?php echo $cfg['cdn']; ?>/graphic/unit_map/archer.png?0cb28' style="cursor: pointer" onclick="$('#icon_url').val('/graphic/unit_map/archer.png');" /><img src='<?php echo $cfg['cdn']; ?>/graphic/unit_map/spy.png?521cb' style="cursor: pointer" onclick="$('#icon_url').val('/graphic/unit_map/spy.png');" /><img src='<?php echo $cfg['cdn']; ?>/graphic/unit_map/light.png?0af57' style="cursor: pointer" onclick="$('#icon_url').val('/graphic/unit_map/light.png');" /><img src='<?php echo $cfg['cdn']; ?>/graphic/unit_map/marcher.png?5702d' style="cursor: pointer" onclick="$('#icon_url').val('/graphic/unit_map/marcher.png');" /><img src='<?php echo $cfg['cdn']; ?>/graphic/unit_map/heavy.png?85dae' style="cursor: pointer" onclick="$('#icon_url').val('/graphic/unit_map/heavy.png');" /><img src='<?php echo $cfg['cdn']; ?>/graphic/unit_map/ram.png?a7134' style="cursor: pointer" onclick="$('#icon_url').val('/graphic/unit_map/ram.png');" /><img src='<?php echo $cfg['cdn']; ?>/graphic/unit_map/catapult.png?8f24e' style="cursor: pointer" onclick="$('#icon_url').val('/graphic/unit_map/catapult.png');" /><img src='<?php echo $cfg['cdn']; ?>/graphic/unit_map/knight.png?b9d02' style="cursor: pointer" onclick="$('#icon_url').val('/graphic/unit_map/knight.png');" /><img src='<?php echo $cfg['cdn']; ?>/graphic/unit_map/snob.png?46f95' style="cursor: pointer" onclick="$('#icon_url').val('/graphic/unit_map/snob.png');" /><img src='<?php echo $cfg['cdn']; ?>/graphic/unit_map/militia.png?ff93f' style="cursor: pointer" onclick="$('#icon_url').val('/graphic/unit_map/militia.png');" /></td></tr></table>
		<br/>
		<input type="hidden" name="group_id" id="color_group_id" value="">
		<input class="btn" type="submit" value="Zmień zaznaczenie i wczytaj ponownie mapę" style="margin-top:5px;">
	</form>
</div>
<?php 
exit;
?>