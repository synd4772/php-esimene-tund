<?php

require ('conf.php');

// tabeli sisu kuvamine
global $connection;
$paring = $connection -> prepare("SELECT id, loomanimi, omnik, varv, img FROM loomad");
$paring -> bind_result($id, $loomanimi, $omnik, $varv, $pilt);
$paring ->execute();
?>

<!doctype html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="styles.css">
    <title>Tabeli sisu mida võtakse admebaasist</title>
</head>
<body>
    <h1>Loomad andmebaasist</h1>
    <div class="table-container">
    <table>
        <thead>
        <tr>
            <th>
                id
            </th>
            <th>
                loomanimi
            </th>
            <th>
                omnik
            </th>
            <th>
                varv
            </th>
            <th>
                pilt
            </th>
        </tr>
        </thead>
        <tbody>
        <?php
        while($paring -> fetch()){
            echo "<tr>";
            echo "<td>" . htmlspecialchars($id) . "</td><td>" . htmlspecialchars($loomanimi) . "</td><td>" . htmlspecialchars($omnik) . "</td><td style='color:" . $varv . "'>" . htmlspecialchars($varv) . "</td>" . "<td><img src='" . $pilt . "' width='100px' height='100px' alt='zxc'></td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
    </div>
    <br>
    <br>
    <h2>FAST SQL QUERY EXECUTE</h2>
    <div class="form-container">
        <form method="POST">
            <label for="query">Sisesta oma päring</label>
            <input type="text" placeholder="Query" name="query" id="query">
            <input type="submit" id="submit-button" name="submit-button">

        </form>
    </div>
<br>
<br>
    <h2>Andmete tabelisse lisamine</h2>
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
    <h2>Andmete tabelist kustutamine</h2>
    <div class="form-container">
        <form method="POST">
            <label for="select-records">Kustuta id abil</label>
            <select id="select-records" name="record-id"></select>
            <input type="submit" name="kustuta-button" id="kustuta-button">
        </form>
    </div>
    <script>
        const recordsSelectElement = document.getElementById("select-records");
        const records = [<?php
            $paring = $connection -> prepare("SELECT id, loomanimi, omnik, varv, img FROM loomad");
            $paring -> bind_result($id, $loomanimi, $omnik, $varv, $pilt);
            $paring ->execute();
            $result = $paring -> get_result() -> fetch_all(MYSQLI_ASSOC);
            for($i = 0; $i < count($result); $i++){
                echo($result[$i]["id"]);
                echo $i === count($result) - 1 ? "" : ", ";
            }
            ?>]
        records.forEach((element)=> {
            const elementID = element;
            const DOMelement = document.createElement("option");
            DOMelement.value = elementID;
            DOMelement.innerHTML = elementID;
            recordsSelectElement.appendChild(DOMelement);


        })
    </script>
</body>
</html>
<?php
if(isset($_POST["submit-button"])){
    $connection -> execute_query($_POST["query"]);
    if(!headers_sent()){
        exit(header("Location: admetabelisisu.php"));
    }
}
?>
<?php
if(isset($_POST["submit-adding-form"])){
    if(!empty($_POST["loomanimi"])){
        $pildiURL = empty($_POST["pildi-URL"]) ? 'null' : $_POST["pildi-URL"];
        $connection -> execute_query("INSERT INTO loomad(loomanimi, omnik, varv, img) VALUES('".$_POST["loomanimi"]."','".$_POST["omnik"]."','".$_POST["varv"]."','".$pildiURL."')");
    }

    if(!headers_sent()){
        exit(header("Location: admetabelisisu.php"));
    }
}
?>
<?php
if(isset($_POST["kustuta-button"])){
    $connection -> execute_query("DELETE FROM loomad WHERE id = ".$_POST["record-id"]);
    if(!headers_sent()){
        exit(header("Location: admetabelisisu.php"));
    }
}
?>
<?php

$connection->close();


?>