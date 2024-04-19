<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test</title>
</head>
<body>
    <?php
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

        // Run query
        $sql = "INSERT INTO `users`(`ID`, `Name`, `Username`, `Password`, `Image URL`) VALUES ('','Sam Smith','ssmith07','password7', 'sam.jpeg')";
        $result = $conn->query($sql);
    ?>
</body>
</html>