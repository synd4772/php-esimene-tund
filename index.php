<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP tunnitööd</title>
    <link rel="stylesheet" href="style/styles.css">
</head>
<body>
<?php
include("nav.php");
?>
<section>
<?php
    if(isset($_GET["leht"])) {
        echo "<div>";
        include('content/'.$_GET["leht"]);
        echo "</div>";

    } else {
        echo "Tere tulemast!";
    }
?>
</section>
<?php
    echo "<p class='mark'>Aleksander Milishenko &copy;";
    echo date('Y')."</p>";

?>
</body>
</html>

