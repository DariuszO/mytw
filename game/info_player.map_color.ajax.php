<?php
$json = Array();

$result = DB::Query("SELECT * FROM `{$DB}`.`map_groups` WHERE `uid` = '{$user['id']}' AND `group_type` = '0'");
$check = DB::numrows($result);
if ($check > 0) {
	$my_group .= "<form id=\"map_group_management\" action=\"/game.php?village={$village['id']}&id={$player['id']}&action=map_colors&h={$hkey}&screen=info_player\" method=\"post\">
        <strong style=\"margin-left:3px; padding:3px;\">Użyj istniejące zaznaczenie</strong>
        <table class=\"vis\" style=\"background-color:#EDDEB9; width:100%; margin-top:3px;\">
                            <tbody>";
}
while($group = DB::Fetch($result)) {
	$my_group .= "<tr>
                    <td>
                        <label>
                            <input name=\"map_group_{$group['id']}\" type=\"checkbox\">
                            ". entparse($group['name']) ."
                            <span class=\"map_group_colorbox\" style=\"background-color:rgb({$group['r']}, {$group['g']}, {$group['b']});\"></span>
                        </label>
                    </td>
                </tr>";
}
if ($check > 0) {
	$my_group .= "<tr><td><input class=\"btn btn-default\" value=\"Zapisz\" type=\"submit\"></td></tr>
        </tbody></table>

    </form>";
}
$json['content'] = "<script type=\"text/javascript\">
        //<![CDATA[

        $(function() {
            $('.color_picker_toggle').click(function(event) {
                event.preventDefault();
                $('#color_picker, #color_picker_container').toggle();
            });
        });

        //]]>
    </script>


<style>
    .map_group_colorbox {
        display:inline-block;
        float: right;
        vertical-align: middle;
        width:16px;
        height:16px;
        border: 1px solid black;
        margin-left: 5px;
    }
</style>

<div id=\"map_color_error\"></div>
<form action=\"/game.php?village={$village['id']}&id={$player['id']}&action=create_map_color&h={$hkey}&screen=info_player\" method=\"post\">
    <input name=\"id\" value=\"{$_GET['id']}\" type=\"hidden\">
    <table class=\"vis\" style=\"width:100%;\">
        <tbody><tr><td><strong>Nowe zaznaczenie</strong></td></tr>
        <tr>
            <td>
                <label style=\"margin-left:3px;\">Nazwa:</label>
                <input name=\"name\" value=\"\" type=\"text\">
                <span id=\"color\" style=\"cursor: pointer; background-color: rgb(255, 0, 255); background-image: none;\" class=\"map_group_colorbox color_picker_toggle\"></span>
            </td>
        </tr>
        <tr id=\"color_picker_container\" style=\"display:none;\"><td><script type=\"text/javascript\">
function color_picker_choose(r, g, b, ignore_transparency) {
	$(\"#color_picker_r\").val(r);
	$(\"#color_picker_g\").val(g);
	$(\"#color_picker_b\").val(b);
	color_picker_change(ignore_transparency);
}

function color_picker_change(ignore_transparency) {
	var r = $(\"#color_picker_r\").val();
	var g = $(\"#color_picker_g\").val();
	var b = $(\"#color_picker_b\").val();
	$(\"#color\").css('background-color', \"rgb(\"+r+\", \"+g+\", \"+b+\")\");
	$(\"#color\").css('background-image','none');
	if (ignore_transparency !== true)
		$('#trans_color_input').attr('checked', false);
}
function color_picker_ok() {
	color_picker_change(false);
}
</script><table id=\"color_picker\" style=\"border-spacing:0px; display:none\"><tbody><tr><td>czerwony:</td><td><input onclick=\"this.focus();\" name=\"color_picker_r\" id=\"color_picker_r\" style=\"font-size:10px; \" onchange=\"color_picker_change()\" onkeyup=\"color_picker_change()\" size=\"4\" type=\"text\"></td><td style=\"background-color:rgb(0,0,0); background-image:none\" onclick=\"color_picker_choose(0,0,0)\" width=\"15\">&nbsp;</td><td style=\"background-color:rgb(0,0,127); background-image:none\" onclick=\"color_picker_choose(0,0,127)\" width=\"15\">&nbsp;</td><td style=\"background-color:rgb(0,0,254); background-image:none\" onclick=\"color_picker_choose(0,0,254)\" width=\"15\">&nbsp;</td><td style=\"background-color:rgb(0,127,0); background-image:none\" onclick=\"color_picker_choose(0,127,0)\" width=\"15\">&nbsp;</td><td style=\"background-color:rgb(0,127,127); background-image:none\" onclick=\"color_picker_choose(0,127,127)\" width=\"15\">&nbsp;</td><td style=\"background-color:rgb(0,127,254); background-image:none\" onclick=\"color_picker_choose(0,127,254)\" width=\"15\">&nbsp;</td><td style=\"background-color:rgb(0,254,0); background-image:none\" onclick=\"color_picker_choose(0,254,0)\" width=\"15\">&nbsp;</td><td style=\"background-color:rgb(0,254,127); background-image:none\" onclick=\"color_picker_choose(0,254,127)\" width=\"15\">&nbsp;</td><td style=\"background-color:rgb(0,254,254); background-image:none\" onclick=\"color_picker_choose(0,254,254)\" width=\"15\">&nbsp;</td></tr>
<tr><td>zielony:</td><td><input onclick=\"this.focus();\" name=\"color_picker_g\" id=\"color_picker_g\" style=\"font-size:10px; \" onchange=\"color_picker_change()\" onkeyup=\"color_picker_change()\" size=\"4\" type=\"text\"></td><td style=\"background-color:rgb(127,0,0); background-image:none\" onclick=\"color_picker_choose(127,0,0)\" width=\"15\">&nbsp;</td><td style=\"background-color:rgb(127,0,127); background-image:none\" onclick=\"color_picker_choose(127,0,127)\" width=\"15\">&nbsp;</td><td style=\"background-color:rgb(127,0,254); background-image:none\" onclick=\"color_picker_choose(127,0,254)\" width=\"15\">&nbsp;</td><td style=\"background-color:rgb(127,127,0); background-image:none\" onclick=\"color_picker_choose(127,127,0)\" width=\"15\">&nbsp;</td><td style=\"background-color:rgb(127,127,127); background-image:none\" onclick=\"color_picker_choose(127,127,127)\" width=\"15\">&nbsp;</td><td style=\"background-color:rgb(127,127,254); background-image:none\" onclick=\"color_picker_choose(127,127,254)\" width=\"15\">&nbsp;</td><td style=\"background-color:rgb(127,254,0); background-image:none\" onclick=\"color_picker_choose(127,254,0)\" width=\"15\">&nbsp;</td><td style=\"background-color:rgb(127,254,127); background-image:none\" onclick=\"color_picker_choose(127,254,127)\" width=\"15\">&nbsp;</td><td style=\"background-color:rgb(127,254,254); background-image:none\" onclick=\"color_picker_choose(127,254,254)\" width=\"15\">&nbsp;</td></tr>
<tr><td>niebieski:</td><td><input onclick=\"this.focus();\" name=\"color_picker_b\" id=\"color_picker_b\" style=\"font-size:10px; \" onchange=\"color_picker_change()\" onkeyup=\"color_picker_change()\" size=\"4\" type=\"text\"></td><td style=\"background-color:rgb(254,0,0); background-image:none\" onclick=\"color_picker_choose(254,0,0)\" width=\"15\">&nbsp;</td><td style=\"background-color:rgb(254,0,127); background-image:none\" onclick=\"color_picker_choose(254,0,127)\" width=\"15\">&nbsp;</td><td style=\"background-color:rgb(254,0,254); background-image:none\" onclick=\"color_picker_choose(254,0,254)\" width=\"15\">&nbsp;</td><td style=\"background-color:rgb(254,127,0); background-image:none\" onclick=\"color_picker_choose(254,127,0)\" width=\"15\">&nbsp;</td><td style=\"background-color:rgb(254,127,127); background-image:none\" onclick=\"color_picker_choose(254,127,127)\" width=\"15\">&nbsp;</td><td style=\"background-color:rgb(254,127,254); background-image:none\" onclick=\"color_picker_choose(254,127,254)\" width=\"15\">&nbsp;</td><td style=\"background-color:rgb(254,254,0); background-image:none\" onclick=\"color_picker_choose(254,254,0)\" width=\"15\">&nbsp;</td><td style=\"background-color:rgb(254,254,127); background-image:none\" onclick=\"color_picker_choose(254,254,127)\" width=\"15\">&nbsp;</td><td style=\"background-color:rgb(254,254,254); background-image:none\" onclick=\"color_picker_choose(254,254,254)\" width=\"15\">&nbsp;</td></tr>
</tbody></table><script type=\"text/javascript\">
$(\"#color_picker_r\").val(255);
$(\"#color_picker_g\").val(0);
$(\"#color_picker_b\").val(255);
color_picker_change();
</script></td></tr>
        <tr>
            <td>
                <input class=\"btn btn-default\" value=\"Utwórz\" type=\"submit\">
                <a class=\"color_picker_toggle\" style=\"float:right;\" href=\"#\">» Kolor</a>
            </td>
        </tr>
    </tbody></table>
</form>
<br>
{$my_group}";
echo json_encode($json);
exit;
?>