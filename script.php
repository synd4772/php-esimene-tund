<?php
$text = "Tere hommikust";
$stylesArray = array(
    "background-color" => "blue",
    "color" => "red",
    "font-family" => "Arial"
);
$stylesText = "";
foreach($stylesArray as $style => $color) {
    $stylesText .= "${style}: ${color};";
}
echo "<h1 style='${stylesText}'>${text}</h1>";
echo "<br>";
echo "<strong>${text}</strong>";
echo "<br>";
echo strtoupper($stylesText);
// Teksti pikkus
echo "<br>";
echo "Teksti pikkus: ".strlen($stylesText);
echo "<br>";
// Eraldame esimesed 5 tähte
echo "Esimesed 5 tähte: ".substr($stylesText, 0, 5);
// Leiame on positsiooni
$otsing = "font-family";
echo "<br>";
echo "On asukoht lauses on ".strpos($stylesText, $otsing);
//Eralda esimine sõna kuni $otsing
echo "<br>";
echo substr($stylesText, 0, strpos($stylesText, $otsing));
echo "<br>";
echo "<h2>Kasutame veebis kasutavaid näidised</h2>";
// sõnade arv lauses
echo "Sõnade arv ".str_word_count($stylesText);
// Teksti kärpimine
echo "<br>";
$tekst2 = "Põhitoetus võetakse ära 11:11 kui võlgnevused ei ole para";
echo ltrim($tekst2);
echo "<br>";
echo trim($tekst2, "");
echo "<br>";
$massiivitekst = "Täiendav info õpilase kohta";
echo "1.täht - ".$massiivitekst[0];
$sona = str_word_count($massiivitekst, 1);
print_r($sona);
echo "Kolmas sõna - ".$sona[2];
?>