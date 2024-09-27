<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>vibeCheck | Processing Login</title>
    <!-- Google Fonts: Lexend and Inter -->
	<link rel="icon" type="image/x-icon" href="./images/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Lexend:wght@100..900&display=swap" rel="stylesheet">
    <!-- -->

</head>
<body>
    <?php 
        $username = $_GET['username'];
        $password = $_GET['password'];

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

        // Check if user is already in database
        $sqlSearch = "SELECT * FROM `users` WHERE `Username` = ?";
        $statement = $conn->prepare($sqlSearch);
        $statement->bind_param("s", $username);
        $statement->execute();
        $result = $statement->get_result();

        // user doesn't exist already
        if ($result->num_rows == 0) {
            // Create and prepare query
            $sqlInsert = "INSERT INTO `users`(`Username`, `Password`) VALUES (?,?)";
            $statement = $conn->prepare($sqlInsert);
            // Bind parameters and execute query
            $statement->bind_param("ss", $username, $password);
            $statement->execute();
        }
        // user exists already
        elseif ($result->num_rows > 0) {
            // check password
            $user = $result->fetch_assoc();
            // if password doesn't match,
            // redirect user back to login page with error message
            if ($password != $user['Password']) {
                echo "<script>window.location.href = 'login.php?error=password';</script>";
                exit();
            }
        }
    ?>

    <script>
        
        window.location.href = `main.php`;
    </script>
    
</body>
</html>