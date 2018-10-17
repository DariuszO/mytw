<?php
/**********************************/
/*           TribalWars           */
/*             My-TW              */
/*         by Bartekst222         */
/**********************************/

require_once "./libraries/common.inc.php";

if (subdomain===true) {
	MyTW_world_location("sds_rounds.php");
}

require_once PE . "/index_top.php";

?>
					<div class="container-block-full">
			<div class="container-top-full"></div>
				<div class="container">
					<div id="content" class="rounds" style="width: 650px;">
						  						<h2>Rundy Szybkich</h2>
  						<p>SP (Szybkie Plemiona), to modyfikacja oryginalnej wersji gry, która przebiega z podwyższoną prędkością (np. 120 razy) i w której jedna runda trwa od kilku godzin do kilku tygodni.</p>
 						  						<table cellspacing="0" cellpadding="0">
  							<tr>
  								<td valign="top">
  									<table class="vis">
 
 										<tr><td><a href="/sds_rounds.php?mode=past">Stare rundy</a></td></tr>
 										<tr><td class="selected"><a href="/sds_rounds.php?mode=present">Aktualne rundy</a></td></tr>
 										<tr><td><a href="/sds_rounds.php?mode=future">Zaplanowane rundy</a></td></tr>
 										  									</table>
  								</td>
  								<td style="padding-left: 10px" valign="top">
	<h3>#6811 Szybkie</h3>

<table cellspacing="0" cellpadding="0">
<tr><td>

<table class="vis">
<tr><td style="width:180px">Start:</td><td style="width:300px"><strong>wtorek, 11.11.2014 09:00</strong></td></tr>
<tr><td>Koniec:</td><td><strong>wtorek, 11.11.2014 13:00</strong></td></tr>
<tr><td>Opis:</td><td><li> Ochrona trwa:15 minut.
<li> Wioska startowa:36 punktów. 
<li> Chłopi:Nie.
<li> Rycerz:Nie.
<li> Kościół:Tak.
<li> Ilość Graczy w plemieniu:2 osoby.
<li> Możliwość opuszczenia plemienia: Nie.
<li> Technologia:1-3.
<li> Zwiadowcy: Widzą wszystko.
<li> Maksymalny zasięg szlachcica:1000.
<li> Szlachcic zbija poparcie: 20-35.
<li> Reguła zagrody:1000.
<li> Przesyłanie surowców i wsparcia tylko w ramach plemienia: Tak.
<li> Szlachta:Monety.</td></tr>
<tr><td>Limit graczy:</td><td>100</td></tr><tr><td>Warunki zwycięstwa:</td><td></td></tr>
<tr><td>Prędkość</td><td>400</td></tr>
<tr><td>Prędkość jednostek:</td><td>0.4</td></tr>
<tr><td>Tryb śpiący:</td><td>Nie</td></tr>
<tr><td>Zastępstwo:</td><td>Nie</td></tr>
<tr><td>Morale:</td><td>Tak</td></tr>
</table>

</td><td style="padding-left: 10px" valign="top">


<p><a href="http://pls1.plemiona.pl/guest.php">&raquo; Login jako gość</a></p>

	<form action="index.php?action=login" method="post">
	<table width="260">

	<tr><td align="right">Nazwa gracza:</td><td><input name="user" type="text" size="15" maxlength="30"></td></tr>
	<tr><td align="right">Hasło:</td><td><input name="clear" type="hidden" value="true"><input name="password" type="password" size="15" maxlength="20"></td></tr>

	<input id="server_sds" type="hidden" name="server" value="sds">
	<tr><td><input id="cookie" type="checkbox" name="cookie" value="true"><label for="cookie">Zalogować bez przerwy</label></td><td align="center"><input type="image" src="graphic/index/login_old.png"></td></tr>
	</table>
	</form>

</td></tr>
</table>

								</td>
							</tr>
						</table>
					</div>
				</div>
			<div class="container-bottom-full"></div>
		 </div>
		</div><!-- content -->
<?php
require_once PE . "/index_footer.php";
?>