<?php
global $connection;
require ('conf.php');

if(isset($_POST["submit-adding-form"])){
    if(!empty($_POST["nimi"])){
        $pildiURL = empty($_POST["pildi-URL"]) ? 'null' : $_POST["pildi-URL"];
        $connection -> execute_query("INSERT INTO osalejad(nimi, telefon, pilt, synniaeg) VALUES('".$_POST["nimi"]."','".$_POST["telefon"]."','".$_POST["pilt"]."','".$pildiURL."')");
    }

    if(!headers_sent()){
        exit(header("Location: matkajad.php"));
    }
}
?>
<!doctype html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="styles.css">
    <title>Loomad 1 kaupa</title>
</head>
<body>
<h1 style="text-align: center">Loomad 1 kaupa</h1>
<div style="width: 100%; align-items: center; justify-content: center; display: flex; flex-direction: column; row-gap: 50px">
    <div class="container" style="display:flex; column-gap: 100px;">
        <div id="meny" style="display:flex; flex-direction: column; justify-content: center;align-items: center">
            <ul>
                <?php
                // loomade nimed andmebaasist
                $paring = $connection -> prepare("SELECT id, nimi, telefon, pilt, synniaeg FROM osalejad");
                $paring -> bind_result($id, $nimi, $telefon, $pilt, $synniaeg);
                $paring ->execute();
                while($paring -> fetch()){
                    echo "<li class='on-li'><a href='?osaleja_id=$id'>".$nimi."</a></li>";
                }
                ?>
            </ul>
            <?php
            echo "<a href='?lisamine=jah' style=''>LISA osaleja...</a>";
            ?>

        </div>
        <div id="sisu">
            <?php
            // kui klik looma nimele, siis näitame looma info
            if(isset($_REQUEST["osaleja_id"])){
                $paring = $connection -> prepare("SELECT id, nimi, telefon, pilt, synniaeg FROM osalejad WHERE id = ?");
                $paring -> bind_result($id, $nimi, $telefom, $pilt, $synniaeg);
                $paring -> bind_param("i", $_REQUEST["osaleja_id"]);
                $paring -> execute();
                // näitame ühe kaupa
                while($paring->fetch()){
                    echo "<div>Nimi: ".$nimi."<br>Telefon: ".$telefon."<br>Sünniaeg: ".$synniaeg."<br><img src='$pilt' width='100px' alt='pilt'></div>";
                }
            }
            ?>
        </div>
    </div>
    <?php
    // lisamisvorm, mis avatakse kui
    if(isset($_REQUEST["lisamine"])){
        ?>
        <div class="form-container">
            <form method="POST">
                <label for="nimi">Osaleja nimi</label>
                <input type="text" value="bobik" name="nimi" id="nimi" placeholder="nimi">
                <br>
                <label for="telefon">Telefon</label>
                <input type="text" value="John Doe" name="telefon" id="telefon" placeholder="telefon">
                <br>
                <label for="synniaeg">Sünniaeg</label>
                <input type="date" name="synniaeg" id="synniaeg">
                <br>
                <label for="pildi-URL">pildi URL</label>
                <input type="text" placeholder="URL" name="pildi-URL" id="pildi-URL">
                <br>
                <input type="submit" name="submit-adding-form" id="submit-adding-form">

            </form>
        </div>
        <?php
    }
    ?>
</div>
</body>
</html>
