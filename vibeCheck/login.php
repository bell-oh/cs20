<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>vibeCheck | Login</title>
    <!-- Google Fonts: Lexend and Inter -->
	<link rel="icon" type="image/x-icon" href="./images/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Lexend:wght@100..900&display=swap" rel="stylesheet">
    <!-- -->
    <style>
        * {
            color: #092119;
        }
        #loginContainer {
            background-image: url(images/concert.jpeg);
            background-size: cover;
            background-repeat: none;
            height: 100%;
            display: flex;
            justify-content: center;
            padding: 5rem;
            padding-bottom: 8rem;
        }
        h1 {
            font-family: 'Lexend', Verdana, Geneva, Tahoma, sans-serif;
        }
        #loginBlurb {
            /* position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            margin-top: 30px; */
            font-family: 'Inter', Verdana, Geneva, Tahoma, sans-serif;
        }
        #loginForm {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 2rem;
            background-color: #F2C1D9;
            width: max-content;
            border-radius: 20px;
            padding: 4rem;
            filter: drop-shadow(1px 2px 4px #0921196f);
        }
        #loginForm input {
            border-radius: 10px;
            padding: 10px;
            border: 1px solid #092119;
            color: #092119;
            font-size: 24px;
        }
        #loginForm input:focus {
            border: 2px solid #F54375;
            outline: none;
        }
        #submit {
            border-radius: 30px; 
            padding: 15px; 
            font-family: 'Lexend', Verdana, Geneva, Tahoma, sans-serif;
            font-size: 20px;
            text-align: center;
            background-color: #F54375;
            color: #c9e5dd;
            border-width: 5px;
            transition-duration: 300ms;
        }
        #submit:hover {
            background-color: #F2C1D9; 
            color: #092119;  
        }

    </style>
</head>
<body>
    <script>
        window.onload = function() {
            document.getElementById("concerts").style.display="none";
            document.getElementById("profile").style.display="none";
            populateErrorMessage();
        };
        
        function handleSubmit() {
            // Validation of username and password
            username = document.forms["loginForm"]["username"].value;
            password = document.forms["loginForm"]["password"].value;
            if (username == "") {
                alert("Username must be filled out.")
                return false;
            }
            if (password == "") {
                alert("Password must be filled out.")
                return false;
            }

            sessionStorage.setItem('username', username);
            sessionStorage.setItem('password', password);

            // window.location.href = "results.php";

        }

    
        // Function to get URL parameters
        function getUrlParameter(name) {
            name = name.replace(/[[]/, '\\[').replace(/[]]/, '\\]');
            var regex = new RegExp('[?&]' + name + '=([^&#]*)');
            var results = regex.exec(location.search);
            // console.log("results", results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' ')));
            return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
            
        };

        // Function to populate error message if present in URL parameter
        function populateErrorMessage() {
            var errorMessage = getUrlParameter('error');
            console.log(errorMessage);
            if (errorMessage === 'password') {
                console.log("password should be outputed");
                document.getElementById('errorMessage').innerText = 'Wrong password entered.';
            }
        }


        
    </script>
    <?php include "header.php" ?>
    <div id="page-container">
        <div id="loginContainer">
        <div id="loginBlurb">
            <form method="GET" action="process-login.php" name="loginForm" onSubmit='return handleSubmit()'>
                <div id="loginForm">
                    <h1>Sign In</h1>
                    <input type='text' placeholder='Username' name='username'>
                    <input type='password' placeholder='Password' name='password'>
                    <div id="errorMessage" style="color: red;"></div> <!-- Placeholder for error message -->
                    <input type='submit' value='Submit' id='submit'>
                </div>
            </form>
        </div>
        </div>
    </div>

</body>
</html>