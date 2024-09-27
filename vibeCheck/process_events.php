<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>vibeCheck | Processing Events</title>
    <!-- Google Fonts: Lexend and Inter -->
	<link rel="icon" type="image/x-icon" href="./images/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Lexend:wght@100..900&display=swap" rel="stylesheet">
    <!-- -->
</head>
<body>
    <?php include "header.php"; ?>
    <?php
        if(!empty($_POST['addToList'])) {
            // Counting number of checked checkboxes.
            $checked_count = count($_POST['addToList']);
            if ($checked_count > 1) {
                // echo "<p>You have added ".$checked_count." shows to your list.</p><br/>";
            } else {
                // echo "<p>You have added ".$checked_count." show to your list.</p><br/>";
            }
            // Loop to put identifier for each checked event into an array
            foreach($_POST['addToList'] as $selected) {
                $events[] = $selected;
            }
        } else {
            // echo "<b>Please Select Atleast One Show.</b>";
        }

        $user_id = $_POST['username'];
        // echo $user_id;
        
        // echo "<script>";
        // echo "console.log('this is the USER ID " . $user_id. "' );";
        // echo "</script>";

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
        // $sqlDelete = "DELETE FROM `my_list`";
        // $conn->query($sqlDelete);

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



            $sqlSearch = "SELECT * FROM `my_list` WHERE `Name` = ? AND `Artist` = ? AND `Venue` = ? AND `Date` = ? AND `Time` = ? AND `City` = ? AND `Country` = ? AND `URL` = ? AND `Image URL` = ? AND `User ID` = ?";
            $statement = $conn->prepare($sqlSearch);
            $statement->bind_param("ssssssssss", $eventName, $artistName, $venue, $date, $localTime, $city, $country, $url, $imageURL, $user_id);
            $statement->execute();
            $result = $statement->get_result();

            // if event doesn't exist already
            if ($result->num_rows == 0) {

                echo "<script>";
                echo "console.log('this event DOEST NOT ALREADY exist: " . $eventName . "' );";
                echo "</script>";


                // https://phpdelusions.net/mysqli_examples/insert
                // Create and prepare query
                $sql = "INSERT INTO `my_list`(`Name`, `Artist`, `Venue`, `Date`, `Time`, `City`, `Country`, `URL`, `Image URL`, `User ID`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $statement = $conn->prepare($sql);
                // Bind parameters and execute query
                $statement->bind_param("ssssssssss", $eventName, $artistName, $venue, $date, $localTime, $city, $country, $url, $imageURL, $user_id);
                $statement->execute();
            }
            else {
                
                echo "<script>";
                echo "console.log('this event EXISTS ALREADY: " . $eventName . "' );";
                echo "</script>";

            }
        }  
    ?>

    <script>
        window.onload = function() {
            async function wait() {
                // Delay 
                await new Promise(resolve => setTimeout(resolve, 1000));
            }
            wait();
            window.location.href = 'pre-profile.php';
        };

    </script>
</body>
</html>