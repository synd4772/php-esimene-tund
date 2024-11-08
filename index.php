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
        include('content/kodu.php');
    }
    ?>
</section>
<?php
include("footer.php");
?>

</body>
</html>

