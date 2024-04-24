<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Process Event</title>
</head>
<body>
    <?php
        $events = array();

        if(!empty($_POST['addToList'])) {
            // Counting number of checked checkboxes.
            $checked_count = count($_POST['addToList']);
            echo "You have selected following ".$checked_count." option(s): <br/>";
            // Loop to put identifier for each checked event into an array
            foreach($_POST['addToList'] as $selected) {
                echo "<p>".$selected ."</p>";
                $events[] = $selected;
            }
            echo print_r($events);
        } else {
            echo "<b>Please Select Atleast One Option.</b>";
        }
        

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

        // For every event in array:
        foreach ($events as $event) {
            // Get csv data from hidden form field
            $eventString = $_POST[$event];
            // Explode csv into array
            $event_data = explode(",", $eventString); 
            
            $eventName = $event_data[0];
            $artistName = $event_data[1];
            $venue = $event_data[2];
            $date = $event_data[3];
            $localTime = $event_data[4];
            $city = $event_data[5];
            $state = $event_data[6];
            $country = $event_data[7];
            $url = $event_data[8];

            // https://phpdelusions.net/mysqli_examples/insert
            // Create and prepare query
            $sql = "INSERT INTO `my_list`(`Name`, `Artist`, `Venue`, `Date`, `Time`, `City`, `State`, `Country`, `URL`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $statement = $conn->prepare($sql);
            // Bind parameters and execute query
            $statement->bind_param("sssssssss", $eventName, $artistName, $venue, $date, $localTime, $city, $state, $country, $url);
            $statement->execute();
        }

        
    ?>
</body>
</html>