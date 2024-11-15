<?php
$autod = simplexml_load_file("content/xml/autod.xml");

// otsing funktsioon

function OtsingAutoNumbriJyargi($paring){
    $autod_array = array(
    );
    $breakLoop = false;
    global $autod;

    for($i = strlen($paring); $i >= 0; $i--) {
        if($breakLoop) {
            break;
        }
        $paringStr = strtoupper(substr($paring, 0, $i));
        foreach($autod as $auto){
            if(substr($auto->autonumber, 0, $i) === $paringStr){
                array_push($autod_array, $auto);
                $breakLoop = true;
            }
        }
    }
    return $autod_array;
}
?>
<!doctype html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Document</title>

</head>
<body>
    <h2>Autode andmed xml failist</h2>
    <div>
        Esimene auto andmed:
        <?php
        echo "<br>";
        $auto_count = 0;
        foreach ($autod as $auto) {
            $auto_count++;
            $index = 0;
            echo $auto_count.". ";
            foreach ($auto as $auto_propery){
                $index++;
                echo $auto_propery;
                echo (count($auto) != $index) ? ", " : ";";
            }
            echo "<br>";
        }
        ?>
    </div>
    <br>
    <br>
    <!-- otsing -->
    <form method="get" action="?" id="main-form">
        <label for="otsing">Otsing:</label>
        <input type="text" id="otsing" name="otsing" placeholder="autonumber" >
        <!-- oninput="document.getElementById('main-form').submit()" -->
        <input type="submit" value="OK" id="submit-button">
    </form>
    <br>
    <br>
    <table>
        <thead>
            <th>Mark</th>
            <th>Autonumber</th>
            <th>Omanik</th>
            <th>Väljastamise aasta</th>
        </thead>
        <tbody>
        <?php
        if(!empty($_GET["otsing"])){
            $paringVastus = OtsingAutoNumbriJyargi($_GET["otsing"]);
            foreach($paringVastus as $paringVastu){
                echo "<tr>";
                foreach ($paringVastu as $auto_propery){
                    echo "<td>".$auto_propery."</td>";
                }
                echo "</tr>";
            }
        }
        else {
            foreach ($autod as $auto) {
                echo "<tr>";
                foreach ($auto as $auto_propery){
                    echo "<td>".$auto_propery."</td>";
                }
                echo "</tr>";
            }
        }
        echo "</tbody></table>";
        ?>
</body>

</html>


