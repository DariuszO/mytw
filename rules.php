<?php
/**********************************/
/*           TribalWars           */
/*             My-TW              */
/*         by Bartekst222         */
/**********************************/

require_once "./libraries/common.inc.php";

if (subdomain===true) {
	MyTW_world_location("rules.php");
}

require_once PE . "/index_top.php";

?>
					<div class="container-block-full">
			<div class="container-top-full"></div>
				<div class="container">
				<div id="content" style="margin-left:160px; width: 600px;">
					<h2>Zasady</h2>
					<script type="text/javascript">
//<![CDATA[
	
	/**
	 * @jQuery
	 */
	function toggleRule(rule_number) {
		$('#more_'+rule_number).slideToggle();
		$('#link_'+rule_number).slideToggle();

		return false;
	}
	
//]]>
</script>


<h4>§1) Jedno konto na gracza</h4>
<p>1.1) Każdy gracz może zarządzać na jednym świecie dokładnie jednym kontem (wyjątkiem jest zastępstwo).<br />
1.2) Przekazanie hasła innym graczom jest zakazane. Zakazane jest również proszenie/grożenie/nagabywanie innych graczy o przekazanie hasła.<br />
1.3) Przekazywanie i zamiana kont jest dozwolona i musi odbyć się w sposób opisany w <a href="http://forum.plemiona.pl/showpost.php?p=1057603&postcount=1" target="_blank">procedurze przekazania konta</a>.<br />
1.4) Zabroniony jest pushing, czyli masowe przesyłanie surowców od gracza słabszego do silniejszego (kryterium stanowi liczba punktów).<br />

<div id="more_1" style="display: none">	<ul>
<li>Kilku graczy może grać z jednego komputera / łącza. Należy uważać na ograniczenia wynikające z faktu dzielenia łącza (§2).</li>
<li>Zabronione jest używanie konta gracza, z którym dzieli się łącze internetowe, w czasie jego nieobecności. W takim wypadku należy uaktywnić moduł zastępstwa.</li>
<li>Zabronione jest powierzenie opieki nad kontem innemu graczowi w sposób inny niż poprzez moduł zastępstwa.</li>
<li>Nie wolno logować się do obcych kont. Również próby logowania się są zabronione.</li>
<li>Podczas przekazania konta nie może dojść do ujawnienia hasła do konta przekazywanego. Przekazanie hasła również w tym przypadku jest zabronione.</li>
</ul>
</div>

<span id="link_">
	<a id="link_1" href="?rule=1" onclick="return toggleRule(1);" style="font-size: x-small">&raquo; więcej</a>
</span>


</p>
<h4>§2) Więcej graczy z jednego połączenia internetowego</h4>
<p>2.1) Zabronione jest przesyłanie surowców, zorganizowane napady, napady na siebie i przesyłanie pomocy między graczami z tym samym komputerem / połączeniem internetowym podczas wspólnego użytku i 24 godziny po jego zaprzestaniu.<br />
2.2) Na Szybkich Plemionach z jednego komputera / łącza może korzystać maksymalnie jedno konto.<br />
2.3) Gracze logujący się z jednego łącza internetowego / komputera (więcej niż 4 razy tygodniowo), muszą to podać w "Ustawienia -> Dzielenie łącza".<br />

<div id="more_2" style="display: none">	Dokładne objaśnienie:<br />
Reguła dotyczy wszystkich bez wyjątków, którzy grają na tym samym komputerze lub wspólnej sieci. Nie ma różnicy, czy dzieje się to jednorazowo czy regularnie."Wspólna sieć" to na przykład ten sam dom, to samo miejsce pracy, lub szkoła a także (w niektórych przypadkach) ten sam dostawca usług internetowych. Wszystkie znane Ci osoby, grające z jednego łącza internetowego / komputera (więcej niż 4 razy tygodniowo), muszą to podać pod "Ustawienia -> Dzielenie łącza".<br />
<ul>
<li>Gracze z jednego łącza / komputera nie mogą atakować tego samego gracza.</li>
<li>Gracze z jednego łącza / komputera mogą być w jednym plemieniu.</li>
<li>Zabronione jest wysyłanie pomocy/ataków lub surowców do osoby, u której się gra w zastępstwie ze swojego konta oraz innych kont współdzielących łącze / komputer z kontem zastępcy.</li>
<li>Uruchomione "dzielenie łącza" nie legalizuje zarządzania więcej niż jednym kontem na świecie gry.</li>
</ul>
</div>

<span id="link_">
	<a id="link_2" href="?rule=2" onclick="return toggleRule(2);" style="font-size: x-small">&raquo; więcej</a>
</span>


</p>
<h4>§3) Zastępstwo</h4>
<p>3.1) Jeśli gracz ma zastępstwo, oba konta objęte są ograniczeniami podanymi w §2.<br />
3.2) Zabronione jest wykorzystywanie zastępowanego konta do własnych celów.<br />
3.3) Za działania zastępcy odpowiada właściciel konta, jednakże osoba zastępująca może odpowiedzieć także swoim kontem za wszelkie uchybienia na koncie zastępowanym, zwłaszcza jeżeli w wyniku przeprowadzonych działań odniosła pośrednie lub bezpośrednie korzyści.<br />
3.4) Konto, na którym jest zastępstwo trwające więcej niż 60 dni, lub na którym w ciągu ostatnich 120 dni właściciel konta przebywał mniej niż 60 dni, nie spełnia przewidzianego celu, czyli nie służy jego właścicielowi do gry, w związku z czym zostanie ono skasowane.<br />

<div id="more_3" style="display: none">	<ul>
<li>Dozwolone jest zdobywanie wiosek przez zastępcę.</li>
<li>Zabronione jest wysyłanie pomocy do gracza, którego zastępujesz z Twojego połączenia internetowego / komputera. Dotyczy to również przesyłania surowców.</li>
<li>Nie wolno atakować gracza, którego zastępujesz.</li>
<li>Zabronione jest wspieranie jednego gracza przez Ciebie z Twojego konta i równocześnie z konta, w którym jesteś zastępcą.</li>
<li>Zabronione jest jednoczesne atakowanie lub wspieranie tego samego gracza z Twojego konta i z konta na którym jesteś zastępcą, a także inne kombinacje tych czynności.</li>
<li>Dozwolone jest atakowanie dwóch różnych graczy z jednego plemienia przez Ciebie z Twojego konta i równocześnie z konta, w którym jesteś zastępcą.</li>
<li>Zastępstwo jest oddawane na własną odpowiedzialność, obsługa gry nie ponosi odpowiedzialności i nie jest stroną w przypadku utraty konta, poniesionych strat lub nadużycia zaufania ze strony zastępcy.</li>
</ul>
</div>

<span id="link_">
	<a id="link_3" href="?rule=3" onclick="return toggleRule(3);" style="font-size: x-small">&raquo; więcej</a>
</span>


</p>
<h4>§4) Komunikacja</h4>
<p>4.1) Zabronione jest obrażanie innych członków społeczności gry. Wyjątkiem jest określenie "noob" i forum plemienne, gdzie kwestia obraz i pozwolenia na ich używanie należy do administracji tego plemienia. Drugim wyjątkiem jest chat w grze, gdzie kwestia obraz i pozwolenia na ich używanie należy do twórcy/właściciela i moderatorów danego chatroomu.<br />
4.2) Zabronione jest używanie wulgaryzmów (również wykropkowanych, przekręconych itp. oraz będącymi wulgaryzmami w językach obcych). Wyjątkiem jest forum plemienne, gdzie kwestia wulgaryzmów i pozwolenia na ich używanie należy do administracji tego plemienia. Drugim wyjątkiem jest chat w grze, gdzie kwestia wulgaryzmów i pozwolenia na ich używanie należy do twórcy/właściciela i moderatorów danego chatroomu.<br />
4.3) Zabronione jest publikowanie treści uznawanych za kontrowersyjne oraz naruszających zasady współżycia społecznego.<br />
4.4) Zabronione jest używanie oraz propagowanie treści pornograficznych w każdej postaci oraz linków prowadzących do takich treści.<br />
4.5) Groźby i szantaże są dozwolone tylko w grze i mogą dotyczyć tylko gry.<br />
4.6) Groźby i szantaże dotyczące życia realnego oraz podszywanie się pod obsługę gry prowadzą do wykluczenia z gry. Skrajnie polityczne, pornograficzne lub w inny sposób niezgodne z prawem wypowiedzi w grze są surowo zabronione.<br />
4.7) Zakazane jest przesyłanie listów-łańcuszków, linków do gier konkurencyjnych lub systemów premiowych.<br />
4.8) Językiem obowiązującym w grze Plemiona jest język polski. Używanie innego języka w grze jest zabronione i może prowadzić do blokady lub wykluczenia konta z gry. Dozwolone jest także użycie języka angielskiego oraz innych języków obcych (w zakresie ograniczonym do nazw własnych lub powszechnie znanych sentencji) w takich obszarach gry jak nazwy wiosek/plemion, profile graczy/plemion, tytuły członków plemienia/wypowiadanych wojen, pod warunkiem, że stosowane nazewnictwo nie narusza innych zasad Regulaminu gry.<br />
4.9) Zabronione jest zaśmiecanie supportu oraz systemu affrontów, poprzez zgłaszanie spraw dla których dane narzędzie nie jest przewidziane, używania wulgaryzmów, notorycznego poruszania spraw, które obsługa gry uznała za załatwione.<br />

<div id="more_4" style="display: none">	<ul>
<li>Dozwolony jest szantaż o surowce lub wojsko.</li>
<li>Surowo zabroniony jest szantaż o Punkty Premium. Namawianie do łamania regulaminu w jakikolwiek sposób (w tym także przez linki, boty itp.) prowadzi do wykluczenia z gry.</li>
<li>Nicki, nazwy wiosek lub plemion, a także inne treści ukazujące hasła, symbole lub ludzi związanych z ustrojami opartymi na dyktaturze, terrorze lub nienawiści (np. faszyzm, nazizm) lub wzywające do nienawiści rasowej, wyznaniowej, etnicznej itp. prowadzą do wykluczenia z gry.</li>
<li>Zabronione jest podawanie linków/zdjęć/"ascii-artów" pornograficznych w profilu, wiadomościach prywatnych oraz na forum plemiennym.</li>
</ul>
</div>

<span id="link_">
	<a id="link_4" href="?rule=4" onclick="return toggleRule(4);" style="font-size: x-small">&raquo; więcej</a>
</span>


</p>
<h4>§5) Komercyjne użycie gry</h4>
<p>5.1) Zabronione jest używanie konta w celach komercyjnych lub reklamowych.<br />
5.2) Zabronione jest sprzedawanie i kupno kont, wiosek, surowców, wojsk, Punktów Premium, kodów umożliwiających otrzymanie Punktów Premium itp. Wyjątkiem jest sytuacja opisana w przykładach do §5. <br />
5.3) Bez pisemnej zgody InnoGames zabronione jest porozumiewanie się z osobami trzecimi w zakresie przekazywania lub wykorzystywania, czy ujawniania zabezpieczeń kont i danych dostępu. Zakaz tyczy się w szczególności sprzedaży kont, surowców, Punktów Premium czy uzyskiwania jakichkolwiek innych profitów przy przekazywaniu kont, surowców lub Punktów Premium innej osobie. To samo dotyczy sprzedaży danych dostępu do kont, praw do wykorzystywania kont, oraz innych prób złamania tych przepisów. <br />
5.4) Naruszenie tych lub innych praw, w szczególności praw autorskich, będzie wiązało się ze zgłoszeniem takiego faktu odpowiednim organom i złożeniem oskarżenia w stosownym urzędzie, oraz do wykluczenia z gry.<br /><br />

<div id="more_5" style="display: none">	<ul>
<li>Zabronione jest sprzedawanie/kupowanie kont, surowców, wojsk, wiosek, czasu poświęconego na rozbudowę konta itd. (np. w aukcjach internetowych) a także składanie propozycji kupna/sprzedaży wymienionych artykułów (także poprzez wiadomości w grze, ogłoszenie na forum czy informację w profilu gracza).</li>
<li>Zabronione jest też sprzedawanie praw gracza lub licencji konta.</li>
<li>Zabronione jest wykorzystanie konta do przesyłania wiadomości reklamowych, przynoszących korzyści w jakiejkolwiek postaci osobie wysyłającej (np. linki referencyjne do różnych gier czy programów lojalnościowych) lub osobom trzecim.</li>
<li>Zabronione jest oferowanie pomocy w atakach lub osobistego paktu o nieagresji w zamian za pieniądze/punkty premium/doładowania itp.</li>
<li>Zabronione jest oferowanie kupna/sprzedaży Punktów Premium (lub kodów umożliwiających otrzymanie Punktów Premium itp.) w jakimkolwiek miejscu gry a także na stronach zewnętrznych (np. portalach aukcyjnych).</li>
<li>Zabronione jest kupowanie Punktów Premium w sposób inny niż za pomocą przeznaczonego do tego modułu w grze Premium -> Zakup.</li>
<li>Dozwolony jest tzw. wspólny zakup Punktów Premium przez wielu graczy na zasadzie "składki" na ten cel. Zakupione w ten sposób Punkty należą do właściciela konta dokonującego transakcji. Podział Punktów Premium między graczy jest sprawą wewnętrznych umów między nimi. InnoGames nie odpowiada za ewentualne nadużycia w tej kwestii.</li>
</ul>
</div>

<span id="link_">
	<a id="link_5" href="?rule=5" onclick="return toggleRule(5);" style="font-size: x-small">&raquo; więcej</a>
</span>


</p>
<h4>§6) Awarie i błędy w programie</h4>
<p>6.1) InnoGames dokłada wszelkich starań aby zapewnić ciągłą dostępność wszystkich usług. Jednak w przypadkach niezależnych od InnoGames, niektóre usługi mogą być nie zawsze dostępne. W związku z tym żaden użytkownik nie może żądać dostępności usług.<br />
6.2) Dostawca usługi nie jest w żadnym stopniu odpowiedzialny za awarie serwera, wady oprogramowania, oraz włamania wynikające ze strony użytkownika.<br />
6.3) Występowanie wszelkich niedogodności dla użytkownika wynikających z awarii serwera, wad oprogramowania, włamania nie upoważnia użytkownika do żądania przywrócenia jego/jej stanu konta przed zaistnieniem tej sytuacji.<br />
6.4) Każdy gracz jest zobowiązany do niezwłocznego zgłaszania błędów do Supportu. Wykorzystywanie błędów jest zabronione.<br />

<div id="more_6" style="display: none">	<ul>
<li>Jeśli zauważysz, że poprzez przerywanie szkolenia jednostek dostajesz więcej surowców niż wydałeś, musisz to zgłosić w Supporcie.</li>
<li>Jeśli zauważysz, że w zagrodzie na stopniu 30 masz więcej jednostek, niż zagroda może wyżywić, musisz to zgłosić w Supporcie.</li>
<li>Za problemy techniczne odpowiada bezpośrednio firma InnoGames GmbH, obsługa gry jedynie przekazuje informacje na temat awarii właścicielowi gry.</li>
</ul>
</div>

<span id="link_">
	<a id="link_6" href="?rule=6" onclick="return toggleRule(6);" style="font-size: x-small">&raquo; więcej</a>
</span>


</p>
<h4>§7) Boty/Skrypty</h4>
<p>7.1) Grać można tylko używając znanych i popularnie używanych przeglądarek. Boty, rozszerzenia przeglądarek, inne programy automatyzujące przebieg gry, blokujące reklamy lub modyfikujące w jakikolwiek sposób system operacyjny lub przeglądarkę w celu automatyzacji wysyłania komend są niedozwolone.<br />
7.2) W pasku skrótów można umieścić zaakceptowane polecenia JavaScript. Polecenia te mogą obsługiwać formularze - np. wypełniać ilość wojsk do wysłania w ekranie komend albo liczbę wojsk do rekrutacji - i mogą wykonywać maksymalnie jedną akcję w grze na jedno kliknięcie.<br />
7.3) Dodatkowe skrypty rozszerzające funkcjonalność przeglądarki (np. skrypty do rozszerzenia Greasemonkey) należy zawsze zgłaszać celem uzyskania decyzji o zgodzie na ich użycie (obowiązek zgłaszania nie dotyczy skryptów, które są już zatwierdzone przez obsługę gry w pytaniu do supportu, w odpowiednim dziale na forum lub w innym specjalnie do tego celu wyznaczonym miejscu).<br />
7.4) Zabronione są skrypty, które dają zalety płatnych rozszerzeń gry.<br />
7.5) Dział Skrypty na forum jest poświęcony prezentacji własnych skryptów oraz poszukiwaniu skryptów, jednak obsługa gry nie ma obowiązku sprawdzania każdego skryptu. Przed rozpoczęciem jego użytkowania należy zgłosić dany skrypt do weryfikacji przez support, chyba że skrypt jest zaakceptowany przez członka obsługi gry na forum lub w innym specjalnie do tego celu wyznaczonym miejscu.<br />
7.6) Support zajmuje się tylko integralnymi częściami skryptu gry. Nie świadczy zatem pomocy do skryptów tworzonych przez społeczność graczy. Dopuszczonych przez obsługę gry skryptów można używać na własną odpowiedzialność.<br />

<div id="more_7" style="display: none">	<ul>
<li>Można używać pomocy z TWplus i TWstats.</li>
<li>Zabronione jest używanie programów umożliwiających wysyłanie jednostek automatycznie lub przy pomocy mniejszej liczby kliknięć.</li>
<li>Dozwolone jest wysyłanie automatycznych wiadomości zbiorczych z aktualnymi informacjami plemienia.</li>
<li>Zabronione jest używanie skryptów, które umożliwiają posiadanie paska skrótów bez wykupienia Konta Premium.
<li>Zabronione jest używanie skryptów powiadamiających o atakach.</li>
<li>Zabronione jest używanie skryptów takich jak TribalWars Enhancer lub podobnych.</li>
<li>Zabronione jest używanie skryptów posiadających opcje: bicia kilku monet naraz, większej mapy, dodatkowych skrótów pobierających dane bez publikacji raportów itp.</li>
<li>Zabronione jest stosowanie wszelkich programów i skryptów, które klikają przyciski napadu, wsparcia lub 'OK' na stronach komend lub używają focus'a.</li>
</ul>
</div>

<span id="link_">
	<a id="link_7" href="?rule=7" onclick="return toggleRule(7);" style="font-size: x-small">&raquo; więcej</a>
</span>


</p>
<h4>§8) Usunięcie konta oraz kary</h4>
<p>8.1) Konto może zostać zablokowane lub usunięte bez podania przyczyny. Nie dotyczy to przewinień zawartych w regulaminie gry.<br />
8.2) Usunięcie może nastąpić automatycznie, jeżeli nie logowało się dłużej niż czternaście dni, wyjątkiem jest posiadanie aktywnego Konta Premium na danym świecie.<br />
8.3) Konto może zostać zablokowane w przypadku stwierdzenia nieprzestrzegania niniejszego regulaminu. Kara nakładana jest zgodnie z <a href="http://forum.plemiona.pl/showpost.php?p=918791&postcount=1" target="_blank">Tabelą kar</a>. Po przekazaniu informacji do obsługi gry o możliwym naruszeniu regulaminu, przeprowadza się czynności mające na celu pociągnięcie sprawcy do odpowiedzialności regulaminowej. W celu otrzymania obrazu stanu faktycznego, obsługa gry zapoznaje się z całym materiałem informacyjnym, który jest zapisany przez system gry, a także z danymi dostarczonymi przez gracza dokonującego zawiadomienia po ich weryfikacji.<br />
8.4) Tabela kar jest integralną częścią Regulaminu gry i określa zasady i kary stosowane wobec graczy łamiących Regulamin.<br />
8.5) Gracz ma prawo do sprzeciwu. Sprzeciw należy nadesłać do 5 dni od dnia nałożenia blokady na konto. Obsługa gry zastrzega sobie prawo do nie wzięcia pod uwagę sprzeciwu nadesłanego po tym terminie. W razie braku sprzeciwu, konto może zostać skasowane.<br />
8.6) Jeśli blokada jest karą za posiadanie więcej niż jednego konta na danym świecie, należy przesłać sprzeciw tylko z jednego konta.<br />
8.7) Jeśli konto zostanie zablokowane za złamanie regulaminu, płatne rozszerzenia gry nie są zwracane ani przedłużane. Również ich koszty nie są zwracane.<br />
8.8) W uzasadnionych przypadkach (na przykład działania na szkodę gry) obsługa gry ma prawo zablokować lub wykluczyć z gry konto gracza z powodów innych niż podane w niniejszym regulaminie.<br />

<div id="more_8" style="display: none">	
</div>



</p>
<h4>§9) Pozostałe zasady</h4>
<p>9.1) Obsługa gry zastrzega sobie prawo do zmian Regulaminu oraz Tabeli Kar w dowolnym czasie, po wcześniejszym poinformowaniu graczy o treści planowanych zmian.<br />
9.2) Regulamin wchodzi w życie z dniem 2 maja 2010 roku i obowiązuje wraz z późniejszymi zmianami.<br />

<div id="more_9" style="display: none">	
</div>



</p>
				</div>
			</div>
		  			<div class="container-bottom-full"></div>
		  		 </div>
<?php
require_once PE . "/index_footer.php";
?>