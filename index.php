<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
    echo "Chris Jones - Quotes Database<br><br>";

    declare(strict_types = 1);

    echo '<pre>';
    print_r(getenv('SITE_URL'));
    echo '<br>';
    print_r($_SERVER);
    echo '</pre>';

    phpinfo();

?>
</body>
</html>