<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP: Times Table</title>
</head>
<body>
    <h1>Times Table</h1>
    <?php
        $n = $_GET["n"];
        for ($x = 1; $x <= 15; $x++) {
            $product = $n * $x;
            echo "<p>$n x $x = $product</p>";
        }   
    ?>
</body>
</html>