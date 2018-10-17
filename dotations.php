<?php 
require_once "./libraries/common.inc.php";

if (count($_POST)) {
	NewLog(json_encode($_POST),"PAYPAL","/logs/dotations.log");
}
setlocale(LC_MONETARY, 'pl_PL');
$money_total = 0;
echo "<?"; ?>xml version="1.0" encoding="UTF-8"?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Privek - dotacje</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />

	
	<link rel="stylesheet" type="text/css" href="/merged/game.css" />

	<link rel="stylesheet" type="text/css" href="/css/game/premiumBenefits.css" />

	
	<script type="text/javascript" src="/merged/game.js"></script>

	<script type="text/javascript" src="/js/game/PremiumBenefits.js"></script>

	
	
	<script type="text/javascript">
	//<![CDATA[
		$(document).ready(function() {
			if (self!= top){
				$('.text a').each(function(i,link){
					$(link).attr('target', '_parent');
				});
			}
		});
	//]]>
	</script>
	
</head>

<body id="ds_body" class="header" >

<div style="margin: 10px">
<table class="content-border" style=" border-collapse: collapse; width: 800px; margin: 0 auto">
	<tr>
		<td>
			<table id="content_value" class="inner-border main" cellspacing="0">
				<tr>
					<td>
<h1>Dotacje na serwer</h1>


<p>Jeżeli chcesz wspomóc serwer <b>Privek</b> możesz przekazać dowolną ilość pieniędzy poprzez dotację PayPal. Pieniądze przekazane na serwer pomagają w rozwoju projektu, za wszystkie przekazane kwory dziękujemy.</p>
<center>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="return" value="/dotation.php?success">
<input type="hidden" name="notify_url" value="/dotation.php">
<input type="hidden" name="hosted_button_id" value="KXCREHXSVUP2W">
<input type="image" src="https://www.paypalobjects.com/pl_PL/PL/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal — Płać wygodnie i bezpiecznie">
<img alt="" border="0" src="https://www.paypalobjects.com/pl_PL/i/scr/pixel.gif" width="1" height="1">
</form>
<b>Zebraliśmy już: <font color="green"><?php echo money_format("%i",$money_total); ?> PLN</font></b>
</center>
</td></tr></table>
</div>
</td></tr></table><script type="text/javascript">
//<![CDATA[
	setImageTitles();
//]]>
</script>
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

</script>
        </body>
</html>
