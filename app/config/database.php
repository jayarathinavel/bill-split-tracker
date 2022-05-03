<?php
    $dbservername = getenv('DB_HOST');
    $dbusername = getenv('DB_USERNAME');
    $dbpassword = getenv('DB_PASSWORD');
    $dbname = getenv('DB_NAME');
    $conn = mysqli_connect($dbservername, $dbusername, $dbpassword, $dbname);
    if ($conn->connect_error) {
        die("Connection failed : " . $conn->connect_error);
    }
?>