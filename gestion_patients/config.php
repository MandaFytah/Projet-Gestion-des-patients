<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestion_patients";
$numTel = 0;

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname, $numTel);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion: " . $conn->connect_error);
}
?>
