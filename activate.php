<?php

require_once "./libraries/common.inc.php";

echo "<?"; ?>xml version="1.0" encoding="UTF-8"?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title></title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />

	
	<link rel="stylesheet" type="text/css" href="/merged/game.css?1416326501" />

	<link rel="stylesheet" type="text/css" href="/css/game/premiumBenefits.css?1416326501" />

	
	<script type="text/javascript" src="/merged/game.js?1416326501"></script>

	<script type="text/javascript" src="/js/game/PremiumBenefits.js?1407850147"></script>

	
	
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
<h2>Wpisz kod aktywujący</h2>
<div id="error" class="error">Niewłaściwy kod</div>
<form action="/activate.php" method="get" target="_top">
<input type="hidden" name="action" value="enter_code" />
Kod aktywujący: <input type="text" size="10" name="code"/> <input class="btn" type="submit" value="OK" />
</form></td></tr></table>
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
