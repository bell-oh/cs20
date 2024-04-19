<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Process Event</title>
</head>
<body>
    <?php
        // Get data from hidden form fields
        $eventName = $_GET["eventName"];
        $artistName = $_GET["artistName"];
        $venue = $_GET["venue"];
        $date = $_GET["date"];
        $localTime = $_GET["localTime"];
        $city = $_GET["city"];
        $state = $_GET["state"];
        $country = $_GET["country"];
        $url = $_GET["url"];

        // echo $eventName;
        // echo $artistName;
        // echo $venue;
        // echo $date;
        // echo $localTime;
        // echo $city;
        // echo $state;
        // echo $country;
        // echo $url;

        // Variables to set up connection
        $server = "localhost";
        $userid = "ugf8r1wb53c4a";
        $pw = "pdk3ekowisn1";
        $db = "db07ibmkhthwwd";

        // Create connection
        $conn = new mysqli($server, $userid, $pw);
        
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Select database
        $conn->select_db($db);

        // https://phpdelusions.net/mysqli_examples/insert
        // Create and prepare query
        $sql = "INSERT INTO `my_list`(`Name`, `Artist`, `Venue`, `Date`, `Time`, `City`, `State`, `Country`, `URL`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $statement = $conn->prepare($sql);
        // Bind parameters and execute query
        $statement->bind_param("sssssssss", $eventName, $artistName, $venue, $date, $localTime, $city, $state, $country, $url);
        $statement->execute();
    ?>
</body>
</html>