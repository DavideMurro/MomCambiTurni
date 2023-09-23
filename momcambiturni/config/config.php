<?php

$server = "localhost";
$username = "momcambiturni";
$password = "momcambiturni";
$db = "momcambiturni";


try {
    $dbh = new PDO("mysql:host=$server;dbname=$db", $username, $password);
    $dbh->exec("set names utf8");
}
catch (PDOException $e) {
    echo "Connessione database fallita: " . $e->getMessage() . "\n";
    exit;
}
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


?>
