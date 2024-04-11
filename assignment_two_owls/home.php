<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Vollkorn:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <title>Two Owls Café</title>
    <style>
        body {
            background-color: #FFFCF7;
            color: #564138;
        }
        h2 {
            font-family: 'Vollkorn', serif;
        }
        form {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 30px;
            margin-bottom: 100px;
        }
        .item {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            gap: 40px;
            align-items: center;
            padding: 20px;
            width: 100%;
        }
        .item-right {
            flex: 1 1 300px;
            display: flex;
            flex-direction: column;
        }
        div.item-right > p, h2 {
            margin-bottom: 0px;
        }
        .description {
            text-wrap: wrap;
            font-style: italic;
        }
        .item-image {
            border-radius: 1rem;
            border: 2px solid #564138;
            min-width: 200px;
        }
        .quantity {
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 10px;
        }
        #submit {
            color: #FFFCF7;
            background-color: #DE9151;
            border-radius: 1rem;
            padding: 10px;
            border: none;
            transition-duration: 300ms;
            margin-top: 15px;
        }
        #submit:hover {
            background-color: #564138;
        }
        #form-bottom {
            display: flex;
            flex-direction: column;
            width: 250px;
            justify-content: center;
            padding: 20px;
        }
        div#form-bottom > p {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <?php include 'header.php';?>
    
    <script>
        // JavaScript form validation
        function handleSubmit() {
            // Validation of quantity
            quantities = document.getElementsByClassName("quantity-select");
            quantity_sum = 0;
            for (i = 0; i < quantities.length; i++) {
                if (quantities[i].value != "0") {
                    quantity_sum++;
                }
            }
            if (quantity_sum == 0) {
                alert("You must order at least one item")
                return false;
            }
            // Validation of first name and last name
            firstName = document.forms["order"]["first_name"].value;
            lastName = document.forms["order"]["last_name"].value;
            if (firstName == "") {
                alert("First name must be filled out.")
                return false;
            }
            if (lastName == "") {
                alert("Last name must be filled out.")
                return false;
            }

            // Calculate pickup time
            date = new Date();
            hours = date.getHours();
            mins = date.getMinutes();
            // Add 20 mins
            if (mins + 20 >= 60) {
                hours++;
                mins = mins + 20 - 60;
            } else {
                mins += 20;
            }
            // Set AM or PM
            if (hours >= 12) {
                am_or_pm = "PM";
            } else {
                am_or_pm = "AM";
            }
            // Convert to 12hr format
            if (hours > 12) {
                hours -= 12;
            }
            // Format minutes
            if (mins <= 9) {
                minsString = ":0" + mins;
            } else {
                minsString = ":" + mins;
            }
            // Set pickup time
            pickup_time = hours + minsString + " " + am_or_pm;
            document.forms["order"]["pickup_time"].value = pickup_time;
        }
    </script>

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

        echo "<form name='order' method='get' action='process_order.php' onSubmit='return handleSubmit()'>";
        // Get results
        $i = 0;
        while ($row = $result->fetch_assoc()) {
            $name = $row["Name"];
            $description = $row["Description"];
            $price = $row["Price"];
            $image = $row["Image"];
            // Display each item
            echo "<div class='item'>";
            echo "<div class='item-image' style='width:200px; height:200px; background-image:url(" . $image . "); background-size:cover;'></div>";
            echo "<div class='item-right'>";
            echo "<h2>" . $name . "</h2>"; 
            echo "<p class='description'>" . $description . "</p>";
            echo "<p>$" . $price . ".00</p>";
            echo "<div class='quantity'>
                <p>Quantity</p>
                    <select class='quantity-select' name='quantity" . $i . "'>
                        <option>0</option>
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                        <option>6</option>
                        <option>7</option>
                        <option>8</option>
                        <option>9</option>
                        <option>10</option>
                    </select>
                </div>";
            echo "</div>";
            echo "</div>";

            $i++;
        }
        echo "<div id='form-bottom'>";
        echo "<p>First Name</p><input type='text' name='first_name'>";
        echo "<p>Last Name</p><input type='text' name='last_name'>";
        echo "<p>Special Instructions</p><textarea name='instructions'></textarea>";
        echo "<input type='hidden' name='pickup_time'>";
        echo "<input id='submit' type='submit' value='Submit Order'>";
        echo "</div>";
        echo "</form>";
    ?>
</body>
</html>