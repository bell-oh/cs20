<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile | vibeCheck</title>
</head>
<body>
    <form method="POST" action="process_events.php" name="userID">
        <input type="hidden" id="user_id" name="user_id" value="">
        <!-- <input type="submit" value="Submit"> -->
    </form>



    <script>
        // Assuming you have a JavaScript variable named userId
        var userId = sessionStorage.getItem('username');

        // Set the user ID value in the hidden input element
        document.getElementById("user_id").value = userId;

        console.log("USER ID: ", userId);
        document.forms['userID'].submit();
    </script>

<?php
    if(!empty($_POST['addToList'])) {
            // Counting number of checked checkboxes.
            $checked_count = count($_POST['addToList']);
            if ($checked_count > 1) {
                echo "<p>You have added ".$checked_count." shows to your list.</p><br/>";
            } else {
                echo "<p>You have added ".$checked_count." show to your list.</p><br/>";
            }
            // Loop to put identifier for each checked event into an array
            foreach($_POST['addToList'] as $selected) {
                $events[] = $selected;
            }
        } else {
            echo "<b>Please Select Atleast One Option.</b>";
        }

        // $user_id = $_POST['username'];

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

        // Clear table
        $sqlDelete = "DELETE FROM `my_list`";
        $conn->query($sqlDelete);

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
            $country = $event_data[6];
            $url = $event_data[7];
            $imageURL = $event_data[8];

            // https://phpdelusions.net/mysqli_examples/insert
            // Create and prepare query
            $sql = "INSERT INTO `my_list`(`Name`, `Artist`, `Venue`, `Date`, `Time`, `City`, `Country`, `URL`, `Image URL`, `User ID`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $statement = $conn->prepare($sql);
            // Bind parameters and execute query
            $statement->bind_param("ssssssssss", $eventName, $artistName, $venue, $date, $localTime, $city, $country, $url, $imageURL, $user_id);
            $statement->execute();
        }  
    ?>

    
</body>
</html>