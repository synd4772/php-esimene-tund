<?php
$opilased = simplexml_load_file("xml/opilased.xml");
function opilaneDiv($nimi, $juuksevarv, $sitelink, $gender){
    echo "<div class='opilane-card ".$gender."'>";
    echo "<div class='opilane-card-header'>";
    echo "<h3>Nimi: ".$nimi."</h3>";

    echo "</div>";
    echo "<div class='opilane-card-body'>";
    echo "<p>Juuksevärv: ".$juuksevarv."</p>";

    echo "</div>";
    echo "<div class='opilane-card-footer'>";
    echo "<button class='leht-button' onclick=\"clickButton(this, '".$nimi."', '".$sitelink."')\">Tema leht</button>";
    echo "</div>";
    echo "</div>";
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Opilased Ruhmas</title>
</head>
<body>
    <div class="opilased-container">
        <?php
            $first = false;
            $max_size_of_row = 4;
            $row_count = 0;
            $index = 0;
            foreach($opilased as $opilane){
                $row_count++;
                $index++;
                if($first === false){
                    echo "<div class='opilane-row'>";
                    $first = true;
                }
                opilaneDiv($opilane->nimi, $opilane->juuksevarv, $opilane->sitelink, $opilane->gender);
                if($row_count === $max_size_of_row || $index === count($opilased)){
                    echo "</div>";
                    $first = false;
                    $row_count = 0;
                }
            }
        ?>
    </div>
    <div class="form-container">
        <h1>Lisa õpilane</h1>
        <form method="post" id="main-form">
            <div class="inputs-container">
                <div class="input-container">
                    <label for="name-input">Nimi:</label>
                    <input type="text" name="name-input" id="name-input" placeholder="Nimi"/>
                </div>
                <div class="input-container">
                    <label for="juuksuvarv-input">Juuksuvärv:</label>
                    <input type="text" name="juuksuvarv-input" id="juuksuvarv-input" placeholder="Juuksuvärv"/>
                </div>
                <div class="input-container">
                <label for="genders">Genders:</label>
                <select name="genders" id="genders">
                    <option>male</option>
                    <option>female</option>
                </select>
                </div>
                <div class="input-container">
                    <label for="site-link">Veebileht (Optional): </label>
                    <input type="text" name="site-link-input" id="site-link" placeholder="veebileht">
                </div>
                <input type="submit" value="OK" name="submit" id="submit"/>
            </div>
            <?php
            if(isset($_POST["submit"])) {
                $xmlDoc = new DOMDocument();
                $xmlDoc->formatOutput = true;
                $xmlDoc->preserveWhiteSpace = false;
                $xmlDoc->load("xml/opilased.xml");
                $specificNode = $xmlDoc->getElementsByTagName("opilased")[0];
                $xml_root = $xmlDoc->createElement('opilane');
                $specificNode->appendChild($xml_root);
                if(!empty($_POST["name-input"]) && !empty($_POST["juuksuvarv-input"] && !empty($_POST["genders"]))){
                    $xml_root->appendChild($xmlDoc->createElement("nimi", $_POST["name-input"]));
                    $xml_root->appendChild($xmlDoc->createElement("juuksevarv", $_POST["juuksuvarv-input"]));
                    if(!empty($_POST["site-link-input"])){
                        $xml_root->appendChild($xmlDoc->createElement("link", $_POST["site-link-input"]));
                    }
                    else{
                        $xml_root->appendChild($xmlDoc->createElement("link", "null"));
                    }
                    $xml_root->appendChild($xmlDoc->createElement("gender", $_POST["genders"]));
                    $xmlDoc->save('xml/opilased.xml');

                    header('Location: opilasedruhmas.php?m=success');
                    exit;
                }

            }
            ?>
        </form>
    </div>
    <script>
        function clickButton(element, nimi, sitelink){
            console.log(sitelink)
            if(sitelink === "null" || sitelink === ""){
                const onlyName = nimi.replace(" ", "")

                const link = `https://${onlyName}23.thkit.ee/`;

                window.open(link);
            }
            else{
                window.open(sitelink);
            }

        }
    </script>
</body>

</html>