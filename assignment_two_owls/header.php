<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Vollkorn:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #FFFCF7;
            font-family: 'Inter', sans-serif;
        }
        .header {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            padding: 0px 40px;
            flex-wrap: wrap;
        }
        h1 {
            color: #564138;
            font-family: 'Vollkorn', serif;
        }
        #title-logo {
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 20px;
            padding: 20px;
            flex-wrap: wrap;
        }
        #hours {
            font-style: italic;
        }
        img {
            width: 80px;
            height: 100%;
        }
    </style>
</head>
<body>
    <div class="header">
        <div id="title-logo">
            <img alt="owl logo" src="owl_logo.png">
            <h1>Two Owls Café</h1>
        </div>
        <p id="hours">Open 11am - 10pm</p>
    </div>
</body>
</html>