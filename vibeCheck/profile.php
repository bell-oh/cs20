<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="./images/favicon.ico">
    <title>vibeCheck | Profile</title>
    <style>
        h2 {
            font-family: 'Lexend', Verdana, Geneva, Tahoma, sans-serif;
        }
        #container {
            display: flex;
            flex-direction: column;
            padding: 2rem;
            gap: 2rem;
            color: #092119;
        }
        #profile-artists {
            display: flex;
            flex-direction: row;
            width: 100%;
            gap: 2rem;
        }
        #profile-div {
            height: 600px;
            width: 50%;
            background-color: #D2F2E8;
            border-radius: 20px;
            padding: 2rem;
            filter: drop-shadow(1px 2px 4px #0921196f);
        }
        #profile-div img {
            height: 300px;
            width: 300px;
            border-radius: 100%;
            object-fit: cover;
            border: 5px solid #F54375;

        }
        #profile-contents {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        #artists-div {
            background-color: #D2F2E8;
            border-radius: 20px;
            text-align: left;
            padding: 2rem;
            height: 600px;
            width: 50%;
            filter: drop-shadow(1px 2px 4px #0921196f);
        }
        #artists-div h2 {
            position: sticky;
        }
        #artists-div p {
            text-align: left;
            text-overflow: ellipsis;
        }
        #artist-ps {
            overflow: scroll;
            height: 85%;
        }
        .artist-and-image {
            display: flex;
            flex-direction: row;
            gap: 1rem;
            align-items: center;
        }
        .artist-and-image img {
            height: 50px;
            width: 50px;
            object-fit: cover;
            border-radius: 100%;
            border: 2px solid #F54375;
        }
        #shows {
            width: 100%;
            filter: drop-shadow(1px 2px 4px #0921196f);
            background-color: #D2F2E8;
            border-radius: 20px;
            padding: 2rem;
        }
        #event-container {
            display: flex;
            flex-direction: row;
            justify-content: center;
            /* flex-wrap: wrap; */
            gap: 30px;
        }
        #events-form-div {
            display: flex;
            flex-direction: row;
            justify-content: center;
            flex-wrap: wrap;
            gap: 30px;
        }
        .event {
            /* min-width: 300px;
            max-width: 400px; */
            width: 400px;
            height: 450px;
            overflow: hidden;
            background-color: #D2F2E8;
            border-radius: 20px;
            border: 2px solid #092119;
            filter: drop-shadow(1px 2px 4px #0921196f);
        }
        .event-image {
            height: 250px;
            width: 100%;
            background-repeat: no-repeat;
            background-size: cover;
        }
        .event-content {
            padding: 1rem;
            display: flex;
            flex-direction: column;
            gap: .5rem;
        }
        .date-time-checkbox {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }
        .date-time, .location-venue {
            display: flex;
            flex-direction: row;
            gap: .5rem;
            align-items: center;
        }
        .city-state {
            max-width: max-content;
            min-width: min-content;
            flex: none;
        }
        .event-name a {
            font-size: 24px;
            text-decoration: none;
            font-weight: bold;
            color: #092119;
            transition-duration: 300ms;
        }
        .event-name a:hover {
            color: #F54375;
        }
        input[type="checkbox"] {
            accent-color: #F54375;
        }
        @media (max-width: 750px) {
            #profile-artists {
                flex-wrap: wrap;
            }
            #artists-div {
                width: 100%;
            }      
            #profile-div {
                width: 100%;
            }
        }
        
    </style>
</head>
<body>
 

    <?php include "header.php"; ?>
    <?php
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

        // Get the user ID from the hidden input element
        // $user_id = $_POST['user_id']; 


        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get the value of the hidden input element
            $user_id = $_POST['user_id'];
            // echo "User ID: " . $user_id;

            // echo "<script>";
            // echo "console.log('this is the FIRST Variable: " . $user_id. "' );";
            // echo "</script>";
        }

        // echo "<script>";
        // echo "console.log('this is a Variable: " . $user_id. "' );";
        // echo "</script>";

        // Run query for artists
        // Run query for artists with user ID filter
        $artistsQuery = "SELECT * FROM `artists` WHERE `User ID` = '" . $user_id . "'";
        // $artistsQuery = "SELECT * FROM `artists`";
        $artistsResult = $conn->query($artistsQuery);

        echo "<div id='container'>";
        echo "<div id='profile-artists'>";
        echo "<div id='profile-div'>";
        echo "<h2>Profile</h2>";
        echo "<div id='profile-contents'>";
        echo "<p>" . $user_id . "</p>";
        echo"<div id='profilePicture'></div>";
        echo "</div>";
        echo "</div>";
        echo "<div id='artists-div'>";
        echo "<h2>Top Artists</h2>";
        echo "<div id='artist-ps'>";
        $i = 0;
        while ($row = $artistsResult->fetch_assoc()) {
            $name = $row["Name"];
            $spotifyID = $row["Spotify ID"];
            $term = $row["term"];
            $pic = $row["pic"];

            echo "<div class='artist-and-image'>";
            echo "<img src='" . $pic . "'>";
            echo "<p>" . $name . "</p>";
            echo "</div>";
            $i++;
        }
        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "<div id='shows'>";
        echo "<h2>Shows</h2>";
        echo "<form method='POST' action='remove_events.php' id='events-form'><div id='events-form-div'>";
        
        // Run query for shows
        $showsQuery = "SELECT * FROM `my_list` WHERE `User ID` = '" . $user_id . "'";
        $showsResult = $conn->query($showsQuery);
        $i = 0;
        while ($row = $showsResult->fetch_assoc()) {
            $inputName = "event" . $i;

            $name = $row["Name"];
            $artist = $row["Artist"];
            $venue = $row["Venue"];
            $date = $row["Date"];
            $time = $row["Time"];
            $city = $row["City"];
            $country = $row["Country"];
            $url = $row["URL"];
            $imageURL = $row["Image URL"];

            echo "<div class='event'><div class='event-image' style='background-image: url(" . $imageURL . ")';></div><div class='event-content'><div class='date-time-checkbox'><div class='date-time'><span>" . $date . "</span><span>•</span><span>" . $time . "</span></div></div><span class='event-name'><a target='_blank' href='" . $url . "'>" . $name . "</a></span><span>" . $artistName . "</span><div class='location-venue'><span>" . $city . ", " . $country . "</span><span>•</span><span>" . $venue . "</span></div></div></div>";
            $csvString = $name . "," . $artist . "," . $venue . "," . $date . "," . $time . "," . $city . "," . $country . "," . $url . "," . $imageURL;
            echo "<input type='hidden' name='" . $inputName . "' value='" . $csvString . "'>";
            $i++;
        }
        echo "</form>";
        echo "</div>";
        echo "</div>";



    ?>
  <script>
    profilePic=sessionStorage.getItem('userPic');
    //not likely but good just in case of an error
    if(profilePic==null){
      profilePic='images/blankArtists.png';
    }
    codeStr="<img src='"+profilePic+"'>";
    document.getElementById("profilePicture").innerHTML=codeStr;
  </script> 
</body>
</html>