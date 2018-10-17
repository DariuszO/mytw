			<div class="footer-links">
				<br />
				<?php
					$CheckVersion = MyTW_check_version();
					if($CheckVersion !== false) {
						echo "<div class=\"info_box\" style=\"margin-bottom: 5px; font-size: 1.25em; color: red\">Wykryto aktualizację silnika My-TW!<br />Twoja aktualna wersja: <b>{$cfg['version']}</b><br />Nowa wersja: <b>{$CheckVersion['v']}</b> wydana dnia <b>{$CheckVersion['date']}</b><br /><a style=\"text-align: center;\" href=\"{$CheckVersion['url_download']}\">&raquo; Pobierz aktualizację</a> </div>";
					}
			?>
				<hr />

									<div class="footer-links-container">
						<div>
							<h6>Gra</h6>
							<ul>
				<li><a href="<?php echo $cfg['host']; ?>/rules.php" >Zasady</a></li>
																																				<li><a href="<?php echo $cfg['host']; ?>/hall_of_fame.php" >Komnata</a></li>
																																				<li><a href="<?php echo $cfg['host']; ?>/stat.php?mode=settings" >Ustawienia świata</a></li>
																																				<li><a href="<?php echo $cfg['host']; ?>/stat.php" >Statystyki</a></li>
																																				<li><a href="<?php echo $cfg['host']; ?>/sds_rounds.php" >Rundy Szybkich</a></li>
																																				<li><a href="<?php echo $cfg['host']; ?>/wallpapers.php" >Tapety</a></li>
																								</ul>
						</div>
					</div>
									<div class="footer-links-container">
						<div>
							<h6>Społeczność</h6>
							<ul>
				<li><a href="http://forum.privek.tk" target="_blank">Forum</a></li>
																																				<li><a href="https://www.facebook.com/Plemiona" target="_blank">Facebook Plemiona</a></li>
																																				<li><a href="https://www.facebook.com/Privek" target="_blank">Facebook Privek</a></li> 																			
																								</ul>
						</div>
					</div>
									<div class="footer-links-container">
						<div>
							<h6>Pomoc & Support</h6>
							<ul>
								<?php if (Isset($cfg['help'])) { ?><li><a href="<?php echo $cfg['help']['url']; ?>" target="_blank">Pomoc</a></li><?php } ?>
																																								<li><a href="/ticket.php" target="_blank">Utwórz pytanie do Supportu</a></li>
																																								<li><a href="#" target="_blank">Pytania na forum</a></li>
																								</ul>
						</div>
					</div>
									<div class="footer-links-container">
						<div>
							<h6>Team</h6>
							<ul>
				<li><a href="http://www.innogames.com/pl" target="_blank">InnoGames</a></li>
																																				<li><a href="<?php echo $cfg['host']; ?>/team.php" >Zespół gry</a></li>
																																				<li><a href="<?php echo $cfg['host']; ?>/gamecredits.php" >Twórcy gry</a></li>
																								</ul>
						</div>
					</div>
							</div>
						<div class="closure">
								<hr />
								&copy; 2014 - <?php echo date("Y"); ?>
				<a target="_blank" href="http://www.innogames.com/pl">InnoGames GmbH</a> &middot;
				<a href="/contact.php" target="_blank">Kontakt</a> &middot;
				<a href="http://legal.innogames.com/staemme/pl/privacy" target="_blank">Ochrona prywatności</a>&middot;
				<a href="http://legal.innogames.com/staemme/pl/agb" target="_blank">OWH</a>&middot; 
				<a href="<?php echo $cfg['host']; ?>/news.php?type=rss2.0"><img src="<?php echo $cfg['host']; ?>/cdn/graphic/index/icon_rss.png" alt="RSS" border="0" style="vertical-align:text-bottom;" class="" /></a><br />

                                <center><iframe src="http://www.facebook.com/plugins/like.php?app_id=235693739791639&href=http%3A%2F%2Fwww.facebook.com%2FSilnikMyTW&send=false&layout=button_count&width=130&show_faces=false&action=like&colorscheme=light&font=lucida+grande&height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:130px; height:21px;" allowTransparency="true"></iframe>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<script type="text/javascript" src="https://apis.google.com/js/plusone.js">
  {lang: 'pl'}
</script>
<g:plusone size="medium" href="http://my-tw.tk"></g:plusone>
</center>
                
                			</div>
			</div><!-- main -->

			<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-1897727-4']);
  _gaq.push(['_trackPageview']);
  _gaq.push(['_gat._anonymizeIp']);


  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(ga);
  })();

</script>			<div id="screenshot" style="display:none" onclick="Index.hide_screenshot();">
				<div id="screenshot_image"></div>
			</div>
		</div>
		
	</body>
</html>
