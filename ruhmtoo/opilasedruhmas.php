<?php if (isset($_GET['code'])) {die(highlight_file(__FILE__, 1));}?>
<?php
$opilased = simplexml_load_file("xml/opilased.xml");
function opilaneDiv($nimi, $juuksevarv, $sitelink, $gender){ // see funktsioon on vajalik konteineri loomiseks, mis sisaldab teavet inimese kohta
    echo "<div class='opilane-card ".$gender."'>";
    echo "<div class='opilane-card-header'>";
    echo "<h3>Nimi: ".$nimi."</h3>";

    echo "</div>";
    echo "<div class='opilane-card-body'>";
    echo "<p>Juuksuvärv: ".$juuksevarv."</p>";

    echo "</div>";
    echo "<div class='opilane-card-footer'>";
    echo "<button class='leht-button' onclick=\"clickButton(this, '".$nimi."', '".$sitelink."')\">Tema leht</button>";
//    echo "<form method='post'><input type='submit' class='kustuta-button' value='X' /></form>";
    echo "</div>";
    echo "</div>";
}
?>
<?php
if(isset($_POST["submit"])) { // siin töötlame HTTP taotlus õpilase lisamiseks
    $xmlDoc = new DOMDocument();
    $xmlDoc->formatOutput = true;
    $xmlDoc->preserveWhiteSpace = false;
    $xmlDoc->load("xml/opilased.xml");
    $specificNode = $xmlDoc->getElementsByTagName("opilased")[0];
    $xml_root = $xmlDoc->createElement('opilane');
    $specificNode->appendChild($xml_root);
    if(!empty($_POST["name-input"]) && !empty($_POST["juuksuvarv-input"] && !empty($_POST["genders"]))){ // kontrollime kui meil on kõik teave
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

        exit(header('Location: opilasedruhmas.php?m=success')); // lõpetame protsessi, saates kasutaja tagasi lehele
    }
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
<h1 style="text-align: center">Õpilased</h1>
<div class="opilased-container">
    <?php // siin me lisame DOM-sse kõik konteinerid mis siseldab teavet inimesed kohta
    $first = false;
    $max_size_of_row = 4; // kui konteinereid on rohkem kui 4, siis edastame järgmised konteinerid uuele reale
    $row_count = 0;
    $index = 0;
    foreach($opilased as $opilane){
        $row_count++;
        $index++;
        if($first === false){
            echo "<div class='opilane-row'>";
            $first = true;
        }
        opilaneDiv($opilane->nimi, $opilane->juuksevarv, $opilane->sitelink, $opilane->gender); // kutsume funktsiooni konteinerid loomiseks
        if($row_count === $max_size_of_row || $index === count($opilased)){ // kontrollime kui see on lõpp ja siis paname div'i kinni
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
                <select name="juuksuvarv-input" id="juuksuvarv-input">
                    <option value="hele">Hele</option>
                    <option value="must">Must</option>
                    <option value="punapea">Punapea</option>
                </select>
            </div>
            <div class="input-container">
                <p>Sugu:</p>
                <div class="genders-container">
                    <div class="genders-choice-container gender-male">
                        <label for="male">Mees</label>
                        <input type="radio" name="genders" id="male" value="male">
                    </div>
                    <div class="genders-choice-container gender-female">
                        <label for="female">Naine</label>
                        <input type="radio" name="genders" id="female" value="female">
                    </div>
                </div>
            </div>
            <div class="input-container">
                <label for="site-link">Veebileht (Optional): </label>
                <input type="text" name="site-link-input" id="site-link" placeholder="veebileht">
            </div>
            <input type="submit" value="OK" name="submit" id="submit"/>
        </div>

    </form>
</div>
<script>
    function clickButton(element, nimi, sitelink){ // see funktsioon on vajalik kasutaja saatmiseks õigele lehele
        console.log(sitelink)
        if(sitelink === "null" || sitelink === ""){
            const onlyName = nimi.replace(" ", "").replace("sh", "s").replace("õ", "o")
            const link = `https://${onlyName}23.thkit.ee/index.html`;
            console.log(link)
            window.open(link);
        }
        else{
            window.open(sitelink);
        }

    }
</script>
</body>

</html>