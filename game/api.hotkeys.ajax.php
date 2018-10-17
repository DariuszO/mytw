<?php
$json = Array();

if ($conf['premium']==="1") {
	$KP = "<a class=\"hotkeys-pa\" href=\"/game.php?village={$village['id']}&mode=help&feature=Premium&screen=premium\" title=\"Konto Premium\">KP</a>";
} else {
	$KP = "";
}

$hk = [
	"Mapa" => ["m"],
	"Przegląd wioski" => ["v"],
	"Do poprzedniej wioski" => ["a"],
	"Do następnej wioski" => ["d"],
	"Raport: pokaż poprzedni" => ["w"],
	"Raport: pokaż następny" => ["s"],
	"Pokaż skróty klawiaturowe" => ["shift","h"],
	"Zamknij okno" => ["Esc"],
	"Przewijanie mapy" => ["","","",""]
];

$json = Array (
	"dialog" => "<h2 class=\"popup_box_header\">Skróty klawiaturowe</h2>

<table class=\"hotkeys\">
    <colgroup>
        <col style=\"width: 35%\">
        <col style=\"width: 65%\">
    </colgroup>
        <tbody><tr>
        <td class=\"hotkeys-keys\">
                        <span class=\"key\">m</span>
                    </td>
        <td>
            Mapa                    </td>
    </tr>
        <tr>
        <td class=\"hotkeys-keys\">
                        <span class=\"key\">v</span>
                    </td>
        <td>
            Przegląd wioski                    </td>
    </tr>
        <tr>
        <td class=\"hotkeys-keys\">
                        <span class=\"key\">a</span>
                    </td>
        <td>
            Do poprzedniej wioski                         {$KP}
                    </td>
    </tr>
        <tr>
        <td class=\"hotkeys-keys\">
                        <span class=\"key\">d</span>
                    </td>
        <td>
            Do następnej wioski                           {$KP}
                    </td>
    </tr>
        <tr>
        <td class=\"hotkeys-keys\">
                        <span class=\"key\">w</span>
                    </td>
        <td>
            Raport: pokaż poprzedni                    </td>
    </tr>
        <tr>
        <td class=\"hotkeys-keys\">
                        <span class=\"key\">s</span>
                    </td>
        <td>
            Raport: pokaż następny                    </td>
    </tr>
        <tr>
        <td class=\"hotkeys-keys\">
                        <span class=\"key\">shift</span>
                        <span class=\"key\">h</span>
                    </td>
        <td>
            Pokaż skróty klawiaturowe                    </td>
    </tr>
        <tr>
        <td class=\"hotkeys-keys\">
                        <span class=\"key\">Esc</span>
                    </td>
        <td>
            Zamknij okno                    </td>
    </tr>
        <tr>
        <td class=\"hotkeys-keys\">
                        <span class=\"key\">←</span>
                        <span class=\"key\">↑</span>
                        <span class=\"key\">→</span>
                        <span class=\"key\">↓</span>
                    </td>
        <td>
            Przewijanie mapy                    </td>
    </tr>
    </tbody></table>"
);
	
MyTW_json_exit($json);
?>