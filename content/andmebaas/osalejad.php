<?php if (isset($_GET['code'])) {die(highlight_file(__FILE__, 1));}?>
<?php
ob_start();
require ('conf.php');
global $connection;
function vottaVanus($synniaeg){
    $result = $synniaeg;
    $date = date_create($result);
    $currentDate = date_create(date("Y-m-d H:i:s"));
    return round($date->diff($currentDate)->days/365);
}

$paring = $connection -> prepare("SELECT id, nimi, telefon, pilt, synniaeg FROM osalejad");
$paring -> bind_result($id, $nimi, $telefon, $pilt, $synniaeg);
$paring ->execute();

?>

    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="styles.css">
        <title>Osalejad</title>
    </head>
    <body>
    <h1>Osalejad tabel</h1>
    <div class="table-container">
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Nimi</th>
                <th>Telefon</th>
                <th>Pilt</th>
                <th>Sünniaeg</th>
                <th>Vanus</th>
            </tr>
            </thead>
            <tbody>
            <?php
            while($paring -> fetch()){
                echo "<tr onclick='select(".$id.")'>";
                echo "<td >" . htmlspecialchars($id) . "</td><td>" . htmlspecialchars($nimi) . "</td><td>" . htmlspecialchars($telefon) . "</td><td>" . "<img src='".$pilt."' width='100px' height='100px' alt='undefined'>" . "</td>" ."<td>" .date_create($synniaeg)->format("Y-m-d"). "</td>" . "<td>".vottaVanus($synniaeg)."</td>";
                echo "</tr>";
            }
            ?>
            </tbody>
        </table>
    </div>

    <h2 class="special-space">Andmete tabelist kustutamine</h2>
    <div class="form-container">
        <form method="POST">
            <label for="select-records">Kustuta id abil</label>
            <select id="select-records" name="record-ids"></select>
            <input type="submit" name="kustuta-button" id="kustuta-button">
        </form>
    </div>
    <h2 class="special-space">Amdmete tabelisse "osaleja" nimega lisamine</h2>
    <div class="form-container">
        <form method="POST">
            <label for="nimi-input">Sisesta nimi</label>
            <input type="text" placeholder="Nimi" name="nimi-input" id="nimi-input">
            <label for="telefon-input">Sisesta telefon</label>
            <input type="text" placeholder="Telefon" name="telefon-input" id="telefon-input">
            <label for="pildi-input">Sisesta pildi URL</label>
            <input type="text" placeholder="URL" name="pildi-input" id="pildi-input">
            <label for="synniaeg">Vali aeg</label>
            <input type="date" name="synniaeg" id="synniaeg">
            <input type="submit" name="osalejad-submit-form" id="osalejad-submit-form">
        </form>
    </div>
    <script>
        const recordsSelectElement = document.getElementById("select-records");;
        const recordIds = [<?php
            $paring = $connection -> prepare("SELECT id, nimi, telefon, pilt, synniaeg FROM osalejad");
            $paring -> bind_result($id, $nimi, $telefon, $pilt, $synniaeg);
            $paring ->execute();
            $result = $paring -> get_result() -> fetch_all(MYSQLI_ASSOC);
            for($i = 0; $i < count($result); $i++){
                echo($result[$i]["id"]);
                echo $i === count($result) - 1 ? "" : ", ";
            }
            ?>]
        recordIds.forEach((element)=> {
            const elementID = element;
            const DOMelement = document.createElement("option");
            DOMelement.value = elementID;
            DOMelement.innerHTML = elementID;
            recordsSelectElement.appendChild(DOMelement);
        })
        function select(id){
            recordsSelectElement.value = id;
        }
    </script>
    </body>
    </html>

<?php

if(isset($_POST["osalejad-submit-form"])){
    if(!empty($_POST["nimi-input"]) && !empty($_POST["telefon-input"]) && !empty($_POST["pildi-input"]) && !empty($_POST["synniaeg"])){
        $connection -> execute_query("INSERT INTO osalejad(nimi, telefon, pilt, synniaeg) VALUES('".$_POST["nimi-input"]."','".$_POST["telefon-input"]."','".$_POST["pildi-input"]."', '".$_POST["synniaeg"]."')");
        exit(header("Location: https://aleksandermilisenko23.thkit.ee/php-tund/php-esimene-tund/content/andmebaas/osalejad.php"));
    }
}
if(isset($_POST["kustuta-button"])){
    if(!empty($_POST["record-ids"])){
        $connection->query("DELETE FROM osalejad WHERE id = ".$_POST["record-ids"]);
        exit(header("Location: https://aleksandermilisenko23.thkit.ee/php-tund/php-esimene-tund/content/andmebaas/osalejad.php"));
    }
}
$connection -> close();
?>