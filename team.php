<?php
/**********************************/
/*           TribalWars           */
/*             My-TW              */
/*         by Bartekst222         */
/**********************************/

require_once "./libraries/common.inc.php";

if (subdomain===true) {
	MyTW_world_location("team.php");
}

require_once PE . "/index_top.php";

?>
			<div id="content">
  <div class="container-block-full">
    <div class="container-top-full"></div>
    <div class="container">
      <div class="info-block register">
        <h2 class="register">
         Zespół
        </h2>

        <h3 style="font-weight: bold;">
          Pytania dotyczące gry proszę kierować wyłącznie poprzez system Supportu!<br />
        </h3>
        <a href="ticket.php">&raquo; Utwórz pytanie do Supportu</a>

        <div style="margin-top: 50px;">
	             <br />   
		<h2>Prowadzenie projektu</h2>
	<table class="vis">
		<tr>
			<td width="300"><b>Justyna</b></td>
			<td width="250"><b>Administrator Światów, Sponsor</b></td>
		</tr>
		<tr>
			<td width="300">Bartekst222</td>
			<td width="250">Technik, Polska</td>
		</tr>
		<tr>
			<td width="300">maxis27</td>
			<td width="250">Technik, Polska</td>
		</tr>
	</table>
<br />        </div>
      </div>
    </div>
    <div class="container-bottom-full"></div>
  </div>
</div>
<?php
require_once PE . "/index_footer.php";
?>