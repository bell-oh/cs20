<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connecting to a SQL Database</title>
</head>
<body>
    <?php
        $server = "localhost";
        $userid = "ugf8r1wb53c4a";
        $pw = "pdk3ekowisn1";
        $db = "dbnbgwzjhpcskn";

        // Create connection
        $conn = new mysqli($server, $userid, $pw);
        
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        echo "Connected successfully";

        // Select database
        $conn->select_db($db);

        // Run a query
        $sql = "SELECT * FROM event_schedule_example";
        $result = $conn->query($sql);

        // Get results
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo $row->title;
            }
        } else {
            echo "no results";
        }



    ?>
</body>
</html>