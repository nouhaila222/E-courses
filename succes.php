<?php
session_start();
if (!isset($_SESSION['success'])) {
    // Redirect to the form page if accessed directly
    header("Location: inscription.html");
    exit;
}

// Unset the success session variable
unset($_SESSION['success']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Réussie</title>
    <script>
        window.onload = function() {
            alert("Votre compte a été créé avec succès !");
            // Redirect to another page if needed, for example, the login page
            window.location.href = "protected.php";
        }
    </script>
</head>
<body>
</body>
</html>
