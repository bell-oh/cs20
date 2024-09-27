<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile | vibeCheck</title>
</head>
<body>
    <form method="POST" action="profile.php" name="userID">
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
    
</body>
</html>