<?php
$rules_categories = DB::Query("SELECT * FROM `rules` WHERE `type` = '1'");
$i = 0;
$subs = [];
$rules_h = "";
while ($row = DB::Fetch($rules_categories)) {
	$i++;
	$ii = 0;
	$subs[$i] = 0;
	$rules_h .= "<div class=\"content-box l-clearfix\"> <div class=\"post-meta post-meta-alt l-align-left\"><span>&sect;{$i}</span></div> <div class=\"summary\"> <h1>". entparse($row['text']) ."</h1> <div>";
	$rules = DB::Query("SELECT * FROM `rules` WHERE `type` = '0' AND `c` = '{$row['id']}'");
	while($rrow = DB::Fetch($rules)) {
		$rt = entparse($rrow['text']);
		$ii++;
		if ($rrow['sub']==="Y") {
			$subs[$i]++;
			if ($subs[$i]===1) {
				$rules_h .= "<ul>";
			}
			$rules_h .= "<li>{$rt}</li>";
		} else {
			$rules_h .= "{$i}.{$ii}) {$rt} <br />";
		}
	}
	if ($subs[$i] > 0) {
		$rules_h .= "</ul>";
	}
	$rules_h .= "</div> </div></div><!--end .content-box--><div class=\"l-secondary-divider\"></div>";
}


$PAGE_CONTENT = "<div class=\"logo \"> <img src=\"{$cfg['cdn']}/graphic/start/logos/logo-pl.png?3f344\" alt=\"Plemiona\" /> </div> <div class=\"logo-branding\"> <img src=\"{$cfg['cdn']}/graphic/start/logos/sublogo-en.png?34603\" alt=\"Tribal Wars\"> </div> <!-- end .logo --> </div> <!-- end .l-constrained --></nav></header><!-- MAIN CONTENT --><section class=\"l-content\"><div class=\"ornament ornament-top-right\"></div><!-- end ornament-top-right --><div class=\"ornament ornament-top-left\"></div><!-- end ornament-top-left --><div class=\"ornament ornament-middle-right\"></div><!-- end ornament-top-right --><div class=\"ornament ornament-middle-left\"></div><!-- end ornament-top-left --><div class=\"ornament ornament-bottom-left\"></div><!-- end .ornament ornament-bottom-left --><div class=\"ornament ornament-bottom-right\"></div><!-- end .ornament ornament-bottom-right --><div class=\"l-section-divider\"></div><div class=\"l-constrained\"><div class=\"l-clearfix\"><div class=\"paged-content\"><h2 class=\"l-align-center\">Zasady gry</h2>{$rules_h}</div><!-- end .paged-content --></div><!--end .lcontent--></div><!-- .l-constrained --></section>";
?>