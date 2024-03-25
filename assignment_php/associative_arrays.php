<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP: Associative Arrays</title>
    <style>
        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .line {
            display: flex;
            flex-direction: row;
            gap: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
            echo "<h1>Molly's Dry Cleaning</h1>";
            echo "<h2>Hours of Operation</h2>";
            $hours = array("Monday"=>"9am to 4pm", "Tuesday"=>"9am to 4pm", "Wednesday"=>"9am to 4pm", "Thursday"=>"9am to 4pm", "Friday"=>"9am to 3pm", "Saturday"=>"11am to 3pm", "Sunday"=>"Closed");
            foreach ($hours as $day=>$hour) 
                echo "<div class='line'><p class='day'>$day</p><p class='hour'>$hour</p></div>";
        ?>
    </div>
</body>
</html>