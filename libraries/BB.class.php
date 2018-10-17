<?php
if(!defined("MyTW")) {
	exit;
}

class BB {

	static $_ERROR = NULL;
	static function icons($t,$bl=[]) {
		global $cfg;
		$bbs = [
			"b" => ["bold","Pogrubienie","0",false,"",""],
			"i" => ["italic","Kursywa","-20",false,"",""],
			"u" => ["underline","Podkreślenie","-40",false,"",""],
			"s" => ["strikethrough","Przekreślenie","-60",false,"",""],
			"quote" => ["quote","Cytuj","-140","Author","\\n","\\n"],
			"spoiler" => ["spoiler","Spoiler","-260","Spoiler"],
			"url" => ["url","Link","-160",false,"",""],
			"player" => ["player","Gracz","-80",false,"",""],
			"ally" => ["tribe","Plemię","-100",false,"",""],
			"coord" => ["coord","Koordynaty","-120",false,"",""],
			"report_display" => ["report_display","Raport","-240",false,"",""],
			"size" => ["size","Rozmiary czcionek","-220",false,"","","$('#bb_sizes').slideToggle(); BBCodes.placePopups(); return false"],
			"color" => ["color","Kolor","-200",false,"","","BBCodes.colorPickerToggle(); BBCodes.placePopups(); return false"],
			"table" => ["table","Lista","-280",false,"\\n[**]head1","[||]head2[/**]\\n[*]test1[|]test2\\n"],
			"claim" => ["claim","Zarezerwuj","-340",false,"",""],
			"unit" => ["units","Jednostki","-300",false,"","","BBCodes.unitPickerToggle(event); return false"],
			"building" => ["building","Budynki","-320",false,"","","BBCodes.buildingPickerToggle(event); return false"]
		];
		
		$sizes = [
			"6" => "Bardzo mały",
			"7" => "Mały",
			"9" => "Normalna",
			"12" => "Duży",
			"20" => "Bardzo duży"
		];
		$sizes_tbl = "<table id=\"bb_sizes\" style=\"display: none; clear:both; white-space:nowrap;\"><tr><td>";
		foreach($sizes as $size => $txt) {
			$sizes_tbl .= "<a href=\"#\" onclick=\"BBCodes.insert('[size={$size}]', '[/size]');$('#bb_sizes').slideToggle(); return false;\">&raquo; {$txt}</a>";
		}
		$sizes_tbl .= "</td></tr></table>";
		$bbs_html = "";
		foreach($bbs as $bb => $bb_c) {
			if (!in_array($bb,$bl)) {
				if (!empty($bb_c[6])) {
					$onclick = $bb_c[6];
				} else {
					$tag_open = "[{$bb}";
					
					if(isset($bb_c[3]) && $bb_c[3]!==false) {
						$tag_open .= "={$bb_c[3]}";
					}
					$tag_open .= "]{$bb_c[4]}";
					
					$tag_closed = "";
					$tag_closed .= "{$bb_c[5]}[/{$bb}]";
					$onclick = "BBCodes.insert('{$tag_open}', '{$tag_closed}');return false;";
				}
				$bbs_html .= "<a id=\"bb_button_bold\" title=\"{$bb_c[1]}\" href=\"#\" onclick=\"{$onclick}\" class=\"tooltip\"><span style=\"display:inline-block; zoom:1; *display:inline; background:url({$cfg['cdn']}/graphic//bbcodes/bbcodes.png?1) no-repeat {$bb_c[2]}px 0px; padding-left: 0px; padding-bottom:0px; margin-right: 2px; margin-bottom:3px; width: 20px; height: 20px\">&nbsp;</span></a>";
			}
		}
		
		$colors_tbl = "<div id=\"bb_color_picker\" class=\"bb_color_picker\" style=\"display: none; clear:both;\"><div class=\"popup_menu\" style=\"cursor:default\"><a onclick=\"$('#bb_color_picker').toggle();return false;\" href=\"#\">Zamknąć</a></div><div id=\"bb_color_picker_colors\"><div id=\"bb_color_picker_c0\" style=\"background:#f00\"></div><div id=\"bb_color_picker_c1\" style=\"background:#ff0\"></div><div id=\"bb_color_picker_c2\" style=\"background:#0f0\"></div><div id=\"bb_color_picker_c3\" style=\"background:#0ff\"></div><div id=\"bb_color_picker_c4\" style=\"background:#00f\"></div><div id=\"bb_color_picker_c5\" style=\"background:#f0f\"></div><br /></div><div id=\"bb_color_picker_tones\"><div id=\"bb_color_picker_10\"></div><div id=\"bb_color_picker_11\"></div><div id=\"bb_color_picker_12\"></div><div id=\"bb_color_picker_13\"></div><div id=\"bb_color_picker_14\"></div><div id=\"bb_color_picker_15\"></div><br style=\"clear: both\" /><div id=\"bb_color_picker_20\"></div><div id=\"bb_color_picker_21\"></div><div id=\"bb_color_picker_22\"></div><div id=\"bb_color_picker_23\"></div><div id=\"bb_color_picker_24\"></div><div id=\"bb_color_picker_25\"></div><br style=\"clear: both\" /><div id=\"bb_color_picker_30\"></div><div id=\"bb_color_picker_31\"></div><div id=\"bb_color_picker_32\"></div><div id=\"bb_color_picker_33\"></div><div id=\"bb_color_picker_34\"></div><div id=\"bb_color_picker_35\"></div><br style=\"clear: both\" /><div id=\"bb_color_picker_40\"></div><div id=\"bb_color_picker_41\"></div><div id=\"bb_color_picker_42\"></div><div id=\"bb_color_picker_43\"></div><div id=\"bb_color_picker_44\"></div><div id=\"bb_color_picker_45\"></div><br style=\"clear: both\" /><div id=\"bb_color_picker_50\"></div><div id=\"bb_color_picker_51\"></div><div id=\"bb_color_picker_52\"></div><div id=\"bb_color_picker_53\"></div><div id=\"bb_color_picker_54\"></div><div id=\"bb_color_picker_55\"></div><br style=\"clear: both\" /></div><div id=\"bb_color_picker_preview\">Text</div><input type=\"text\" id=\"bb_color_picker_tx\" /><input type=\"button\" value=\"OK\" id=\"bb_color_picker_ok\" onclick=\"BBCodes.colorPickerToggle(true);return false;\"/></div>";
		
		$html = "<div id=\"bb_bar\" style=\"text-align:left; overflow:visible; \" data-target=\"{$t}\">
		{$bbs_html}
		{$sizes_tbl}
	<div id=\"bb_popup_container\" class=\"bb_popup_container\">
		{$colors_tbl}
	</div><script type=\"text/javascript\">
	//<![CDATA[
		$(document).ready(function(){
			BBCodes.init({
				target : '#{$t}',
				ajax_unit_url: '/game.php?ajax=load_unit_icon_selector&screen=api',
				ajax_building_url: '/game.php?ajax=load_building_icon_selector&screen=api'
			});
		});
	//]]></script></div>";
		echo $html;
	}
	
	static function parse($text,$user,$bl=[]) {
		if (substr_count($text,"[") > 10000) {
			self :: $_ERROR = "Znaku \"[\" - nawiasu można użyć maksymalnie 10000 razy.";
			return false;
		}
		$return = HTMLSpecialChars($text);
		$bb_default_tags = [
				'code' => ['/\[code\](.*?)\[\/code\]/is','<pre>$1</pre>'],
				'b' => ['/\[b\](.*?)\[\/b\]/is','<b>$1</b>'],
				'i' => ['/\[i\](.*?)\[\/i\]/is','<i>$1</i>'],
				'u' => ['/\[u\](.*?)\[\/u\]/is','<u>$1</u>'],
				's' => ['/\[s\](.*?)\[\/s\]/is','<s>$1</s>'],
				'url' => ['/\[url\=(.*?)\](.*?)\[\/url\]/is','<a style="color: #4040D0" href="/redir.php?r=$1" target="_blank">$2</a>'],
				'url' => ['/\[url\](.*?)\[\/url\]/is','<a style="color: #4040D0" href="/redir.php?r=$1" target="_blank">$1</a>'],
				'spoiler' => ['/\[spoiler\](.*?)\[\/spoiler\]/is','<div class="spoiler"><input type="button" value="Spoiler" onclick="toggle_spoiler(this)" /><div><span style="display:none">$1</span></div></div>'],
				'spoiler' => ['/\[spoiler\=(.*?)](.*?)\[\/spoiler\]/is','<div class="spoiler"><input type="button" value="$1" onclick="toggle_spoiler(this)" /><div><span style="display:none">$2</span></div></div>'],
				'quote' => ['/\[quote\=(.*?)\](.*?)\[\/quote\]/is','<table class="quote"><tbody><tr><td></td><td class="quote_author">$1 napisał:</td></tr><tr><td width="10"></td><td class="quote_message"><br>$2<br></td></tr></tbody></table>'],
				'quote' => ['/\[quote\](.*?)\[\/quote\]/is','<table class="quote"><tbody><tr><td width="10"></td><td class="quote_message"><br>$1<br></td></tr></tbody></table>'],
				'img' => ['/\[img\](.*?)\[\/img\]/is','<img src="$1" alt="Obrazek" />'],
				'color' => ['/\[color\=(.*?)\](.*?)\[\/color\]/is','<span style="color: $1">$2</span>'],				
				'size' => ['/\[size\=(.*?)\](.*?)\[\/size\]/is','<span style="font-size: $1px;">$2</span>']
		];
		foreach ($bb_default_tags as $TAG => $txt) {
			if (!in_array($TAG,$bl)) {
				$return = preg_replace($txt[0],$txt[1],$return);
			}
		}
		
		return parse($return,true);
	}
	
	static function error() {
		if (self :: $_ERROR === NULL) {
			return false;
		} else {
			return self :: $_ERROR;
		}
	}
}
?>