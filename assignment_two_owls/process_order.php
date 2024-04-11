<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <style>
        body {
            color: #564138;
        }
        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 0px 20px;
        }
        h2 {
            text-align: center;
            font-family: 'Vollkorn', serif;
        }
        .item {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            min-width: 300px;
            max-width: 600px;
            width: auto;
        }
        .quantity-name {
            display: flex;
            flex-direction: row;
            gap: 10px;
        }
        .quantity, #total {
            font-weight: bold;
        }
        .totals {
            width: 300px;
            display: flex;
            flex-direction: column;
            align-items: end;
            margin-bottom: 100px;
        }
        .totals-line {
            display: flex;
            flex-direction: row;
            gap: 5px;
        }
    </style>
</head>
<body>
    <?php include 'header.php';?>

    <?php
        $server = "localhost";
        $userid = "ugf8r1wb53c4a";
        $pw = "pdk3ekowisn1";
        $db = "db669i14itoqkb";

        // Create connection
        $conn = new mysqli($server, $userid, $pw);
        
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Select database
        $conn->select_db($db);

        // Run query
        $sql = "SELECT * FROM menu";
        $result = $conn->query($sql);

        echo "<div class='container'>";
        // Display orderer name, instructions, pickup time
        $first_name = $_GET["first_name"];
        $last_name = $_GET["last_name"];
        $instructions = $_GET["instructions"];
        $pickup_time = $_GET["pickup_time"];
        echo "<h2>Order for " . $first_name .  " " . $last_name . "</h2>";
        echo "<p>Special instructions: " . $instructions . "</p>";
        echo "<p>Pickup at " . $pickup_time . "</p>";
        
        // Get results
        $i = 0;
        $subtotal = 0;
        while ($row = $result->fetch_assoc()) {
            // Get Name and Price only
            $name = $row["Name"];
            $price = $row["Price"];
            // Get quantity
            $quantity_string = "quantity" . $i;
            $quantity = $_GET[$quantity_string];
            // Calculate total and subtotal
            $item_total = round($price * $quantity, 2);
            // Display items
            if ($quantity != "0") {
                echo "<div class='item'><div class='quantity-name'><p class='quantity'>" . $quantity . "</p><p>" . $name . "</p></div><p>x $" . number_format($price, 2, '.', '') . " = $" . number_format($item_total, 2, '.', '') . "</p></div>";
                $subtotal += $item_total;
            }
            $i++;
        }
        $tax = $subtotal * 0.625;
        $total = $subtotal + $tax;
        echo "<div class='totals'><div class='totals-line'><p>Subtotal: </p><p>$" . number_format($subtotal, 2, '.', '') . "</p></div><div class='totals-line'><p>Tax: </p><p>+$" . number_format($tax, 2, '.', '') . "</p></div><div class='totals-line'><p>Total: </p><p id='total'>$" . number_format($total, 2, '.', '') . "</p></div></div>";
        echo "</div>";
    ?>

    <script>
    </script>
</body>
</html>