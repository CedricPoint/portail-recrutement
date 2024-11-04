<?php
// Connexion à la base de données
$servername = "localhost";
$username = "DBUSERNAME";
$password = "DBPASSWORD";
$dbname = "DBNAME";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}
?>