<?php
global $connection;
require ('conf.php');

if(isset($_POST["submit-adding-form"])){
    if(!empty($_POST["loomanimi"])){
        $pildiURL = empty($_POST["pildi-URL"]) ? 'null' : $_POST["pildi-URL"];
        $connection -> execute_query("INSERT INTO loomad(loomanimi, omnik, varv, img) VALUES('".$_POST["loomanimi"]."','".$_POST["omnik"]."','".$_POST["varv"]."','".$pildiURL."')");
    }

    if(!headers_sent()){
        exit(header("Location: loomad1kaupa.php"));
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
    $paring = $connection -> prepare("SELECT id, loomanimi, omnik, varv, img FROM loomad");
    $paring -> bind_result($id, $loomanimi, $omnik, $varv, $img);
    $paring ->execute();
    while($paring -> fetch()){
        echo "<li class='on-li'><a href='?looma_id=$id'>".$loomanimi."</a></li>";
    }
    ?>
</ul>
    <?php
    echo "<a href='?lisamine=jah' style=''>LISA loom...</a>";
    ?>

</div>
<div id="sisu">
    <?php
    // kui klik looma nimele, siis näitame looma info
    if(isset($_REQUEST["looma_id"])){
        $paring = $connection -> prepare("SELECT id, loomanimi, omnik, varv, img FROM loomad WHERE id = ?");
        $paring -> bind_result($id, $loomanimi, $omnik, $varv, $img);
        $paring -> bind_param("i", $_REQUEST["looma_id"]);
        $paring -> execute();
        // näitame ühe kaupa
        while($paring->fetch()){

            echo "<div>Loomanimi: ".$loomanimi."<br>Omanik: ".$omnik."<br>Tõug: ".$varv."<br><img src='$img' width='100px' alt='pilt'></div>";
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
                    <label for="loomanimi">Looma nimi</label>
                    <input type="text" value="bobik" name="loomanimi" id="loomanimi" placeholder="loomanimi">
                    <br>
                    <label for="omnik">Omniku nimi</label>
                    <input type="text" value="John Doe" name="omnik" id="omnik" placeholder="omnik">
                    <br>
                    <label for="varv">Värv</label>
                    <select name="varv" id="varv">
                        <option value="red">Red</option>
                        <option value="black">Black</option>
                        <option value="green">Green</option>
                        <option value="yellow">Yellow</option>
                        <option value="purple">Purple</option>
                        <option value="blue">Blue</option>
                        <option value="pink">Pink</option>
                        <option value="aqua">Aqua</option>
                    </select>
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
