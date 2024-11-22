<?php
$kasutaja = "aleksander_milishenko";
$salasona = "123456";
$andmebaas = $kasutaja;
$serveri_nimi = "localhost";
$PORT = 3306;

$connection = new mysqli($serveri_nimi, $kasutaja, $salasona, $andmebaas, $PORT);
$connection->set_charset("utf8");
