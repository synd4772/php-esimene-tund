<h2>PHP – Töö pildifailidega</h2>
<a href="https://www.metshein.com/unit/php-pildifailidega-ulesanne-14/">Töö pildifailidega</a>
<form method="post" action="">
    <select name="pildid"> <!-- ripp loend -->
        <option value="">Vali pilt</option>
        <?php
        $kataloog = 'img/';
        $asukoht=opendir($kataloog); // võtab kaustast pildi failid
        while($rida = readdir($asukoht)){
            if($rida!='.' && $rida!='..'){
                echo "<option value='$rida'>$rida</option>\n";
            }
        }

        ?>
    </select>
    <input type="submit" value="Vaata">
    <input name="random" type="submit" value="random picture">
</form>
<?php
    $pildidmassiv = array(); // massiv kus pildid asuvad
    $asukoht = opendir('img/');
    while($rida = readdir($asukoht)){
        if($rida!='.' && $rida!='..') {
            array_push($pildidmassiv, $rida);
        }
    }
    $randinteger = rand(0, 3); // juhuslikult number
    $randpilt = $pildidmassiv[$randinteger]; // juhuslikult pilt

    if(!empty($_POST['pildid'])){
        drawPildInfo($_POST['pildid']); // kui kasutaja vajutab "Vaata" nupp, siis näitame ripp loendist pilti
    }
    else if(!empty($_POST['random'])){
        drawPildInfo($randpilt); // siin lihtsalt näitame juhuslikult pilt
    }
    else {
        drawPildInfo($randpilt); // siin ka
    }

    function drawPildInfo($pilt_nimi) // funkstioon, mis näitab pilti info
    {
        $pilt = $pilt_nimi;
        $pildi_aadress = 'img/'.$pilt;
        $pildi_andmed = getimagesize($pildi_aadress);

        $laius = $pildi_andmed[0];
        $korgus = $pildi_andmed[1];
        $formaat = $pildi_andmed[2];
        $max_laius = 120;
        $max_korgus = 90;

        //suhtearvu leidmine
        if($laius <= $max_korgus && $korgus<=$max_korgus){
            $ratio = 1;
        } elseif($laius>$korgus){
            $ratio = $max_laius/$laius;
        } else {
            $ratio = $max_korgus/$korgus;
        }

        //uute mõõtmete leidmine
        $pisi_laius = round($laius*$ratio);
        $pisi_korgus = round($korgus*$ratio);

        echo '<h3>Originaal pildi andmed</h3>';
        echo "Laius: $laius<br>";
        echo "Kõrgus: $korgus<br>";
        echo "Formaat: $formaat<br>";

        echo '<h3>Uue pildi andmed</h3>';
        echo "Arvutamse suhe: $ratio <br>";
        echo "Laius: $pisi_laius<br>";
        echo "Kõrgus: $pisi_korgus<br>";
        echo "<img width='$pisi_laius' src='$pildi_aadress'><br>";
    }
?>