<?php
$servername = "localhost";
$username = "lopezser_root"; // Tu usuario de MySQL
$password = "Root2025-*+"; // Tu contraseña de MySQL
$dbname = "lopezser_rano";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica si la conexión fue exitosa
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>