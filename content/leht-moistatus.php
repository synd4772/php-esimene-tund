<?php
echo "Mõistatus. Euroopa riik";
// 6 подсказок при помощи текстовых функций
// выводить списком <ul> / <ol>
$riik = 'Estonia';

echo "<ol>";
echo "<li>Esimene täht riigis on ${riik[0]}</li>";
echo "<li>Sõnu pikkus on ".strlen($riik)."</li>";
echo "<li>Kui eemalda mitu tähted siis: ".trim($riik, "E, st")."</li>";
echo "<li>Täht 'a' asub: ".strpos($riik, "a")."</li>";
echo "<li>Sõnad riigus sõnas on: ".str_word_count($riik)."</li>";
echo "<li>Vastupidine sõna on: ".strrev($riik)."</li>";
echo "</ol>";
//str_replace()

