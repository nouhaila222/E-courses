<?php

$servername = "localhost";
$username = "root"; // Nom d'utilisateur par défaut de MySQL pour XAMPP
$password = ""; // Mot de passe par défaut de MySQL pour XAMPP
$dbname = "inscription"; // Nom de votre base de données

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>

