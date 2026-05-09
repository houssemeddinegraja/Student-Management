<?php
try {
    $db_cnx = new PDO("mysql:host=localhost;dbname=test","root","");
}
catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}
?>