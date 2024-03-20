<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP</title>
</head>
<body>
    <?php
        class Event {
            public function __construct($title) {
                $this->title = $title;
            }
            public function display() {
                echo "<h3>" . $this->title . "</h3>";
            }
        }

        $ev = new Event("How to knit");
        $ev->display()
    ?>
</body>
</html>