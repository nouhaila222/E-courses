<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inscription";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = htmlspecialchars($_POST['current_password']);
    $new_password = htmlspecialchars($_POST['new_password']);
    $confirm_password = htmlspecialchars($_POST['confirm_password']);
    $email = $_SESSION['email']; 
    if ($new_password !== $confirm_password) {
        echo "<script>alert('Les nouveaux mots de passe ne correspondent pas.'); window.history.back();</script>";
        exit;
    }

    $stmt = $conn->prepare("SELECT password FROM insc WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$result || !password_verify($current_password, $result['password'])) {
        echo "<script>alert('Le mot de passe actuel est incorrect.'); window.history.back();</script>";
        exit;
    }

    $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("UPDATE insc SET password = :new_password WHERE email = :email");
    $stmt->bindParam(':new_password', $hashed_new_password);
    $stmt->bindParam(':email', $email);

    if ($stmt->execute()) {
        echo "<script>alert('Mot de passe changé avec succès.');</script>";
    } else {
        echo "<script>alert('Erreur lors du changement de mot de passe.'); window.history.back();</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Changer le mot de passe</title>
    <style>
        body {
            font-family: 'Rubik', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: rgb(7, 68, 199);
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #555;
        }

        fieldset {
            border: none;
            padding: 0;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <form action="changepsw.php" method="post">
            <fieldset>
                <h2>Changer le mot de passe</h2>
                <label for="current_password">Mot de passe actuel</label>
                <input type="password" name="current_password" id="current_password" required>
                <label for="new_password">Nouveau mot de passe</label>
                <input type="password" name="new_password" id="new_password" required>
                <label for="confirm_password">Confirmer le nouveau mot de passe</label>
                <input type="password" name="confirm_password" id="confirm_password" required>
                <button type="submit">Changer le mot de passe</button>
            </fieldset>
        </form>
    </div>
</body>
</html>
