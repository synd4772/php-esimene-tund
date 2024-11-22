<?php
// zone kasutaja jaoks conf fail

$kasutaja = "*************";
$salasona = "*************";
$andmebaas = $kasutaja;
$serveri_nimi = "***********";
$connection = new mysqli($serveri_nimi, $kasutaja, $salasona, $andmebaas);
$connection->set_charset("utf8");
