<?php
echo "<h2>Ajafunktsioonid</h2>";
echo "<div id='kuupaev'>";
echo "Täna on ".date("d.m.Y")."<br>";
date_default_timezone_set("Europe/Tallinn");
echo "<strong>Tänane Tallinna kuupäev in kelleaeg on ".date("d.m.Y G:i")."</strong><br>";
echo "date('d.m.Y G:i', time())";
echo "<br>";
echo "d - kuupäev - 1-31";
echo "<br>";
echo "m - kuu numbrina 1-12";
echo "<br>";
echo "y - aasta neljakohane";
echo "<br>";
echo "i - minutid 0-59";
echo "</div>";?>
<div id="hooaeg">
    <h2>Väljasta vastavalt hoojale pilt(kevad/sivo/sügis/talv)</h2>

    <?php
    $today = new DateTime();
    echo "Täna on ".$today->format('d-m-Y');
    // hoaeg punktid - сезон
    $spring = new DateTime("March 20");
    $summer = new DateTime("June 21");
    $fall = new DateTime("September 22");
    $winter = new DateTime("December 22");

    switch(true) {
        //kevad
        case($today >= $spring && $today < $summer):
            echo "Kevad";
            $pildi_aadress = "../img/vesna.jpg";
            break;
        case($summer <= $today && $today < $fall):
            echo "Suvi";
            $pildi_aadress = "../img/summer.jpg";
            break;
        case $fall <= $today && $today < $winter:
            echo "Sügis";
            $pildi_aadress = "../img/osen.jpg";
            break;
        default:
            echo "Talv";
            $pildi_aadress = "../img/winter.jpg";
    }
    ?>
    <img src="<?=$pildi_aadress?>" id="pilt" alt="hooja pilt">
    <div id="koolivaheaeg">
        <h2>Mitu päeva on koolivaheajani 23.12.2024</h2>
        <?php
        $kdata=date_create_from_format("d.m.Y", "23.12.2024");
        $date = date_create();
        $diff = date_diff($kdata, $date);
        echo "jaab ".$diff->format("%a")." päeva";
        echo "<br>";
        echo "jääb ".$diff->days." päeva";
        ?>
        <h2>Mitu päeva on minu sünnipäevani 13.11.2024</h2>
        <?php
        $kdata=date_create_from_format("d.m.Y", "13.11.2024");
        $date = date_create();
        $diff = date_diff($kdata, $date);
        echo "jääb ".$diff->days." päeva";
        ?>

    </div>
    <div id="vanus">
        <form method="post">
            Sisesta oma sünnikupäev
            <input type="date" name="synd" placeholder="dd.mm.yyyy">
            <input type="submit" value="OK">
        </form>
        <?php
        if(isset($_POST["synd"])){
            if(empty($_POST["synd"])){
                echo "Sisesta oma Sünipäeva - kuupäev";
            }
            else {
                $kdata=date_create($_POST["synd"]);
                $date = date_create();
                $diff = date_diff($kdata, $date);
                echo "Sinu vanus ".$diff->format("%y")." aastat vama";
            }
        }
        ?>
    </div>
    <div>
        Massivi abil näidata kuu nimega tänases kuupäevas
        <?php
        $months = array(
            "jaanuar","veebruar","märts","aprill","mai","juune","juuli","avgust","september","oktoober","november","detsember"
        );
        $kuu = date_create()->format("m");
        echo $kuu.". ".$months[$kuu];

        ?>
    </div>
</div>