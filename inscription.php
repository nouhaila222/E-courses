<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Récupérer les données du formulaire
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $ville = htmlspecialchars($_POST['ville']);
    $email = htmlspecialchars($_POST['email']);
    $pwd = htmlspecialchars($_POST['pwd']);

    // Hacher le mot de passe
    $hashed_pwd = password_hash($pwd, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO insc (nom, prenom, ville, email, password) VALUES (:nom, :prenom, :ville, :email, :password)");
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(':ville', $ville);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashed_pwd);

    if ($stmt->execute()) {
        echo "Inscription réussie!";
        // Rediriger vers une page de succès ou de connexion
        // header("Location: success.html");
        // exit;
    } else {
        echo "Erreur: " . $stmt->errorInfo()[2];
    }

    // Fermer la connexion
    $conn = null;
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
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

        input[type="text"],
        input[type="email"],
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
        <form action="inscription.php" method="post">
            <fieldset>
                <h2>Inscription</h2>
                <label for="nom">Nom</label>
                <input type="text" name="nom" id="nom" required>
                <label for="prenom">Prenom</label>
                <input type="text" name="prenom" id="prenom" required>
                <label for="ville">La ville</label>
                <input type="text" name="ville" id="ville" required>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>
                <label for="cour">Coure</label>
                <input type="text" name="cour" id="cour" required>
                <label for="pwd">Mot de passe</label>
                <input type="password" name="pwd" id="pwd" required>
                <a href="#"><button type="submit">S'inscrire</button></a>
            </fieldset>
        </form>
    </div>

    <script>
        document.querySelector('form').addEventListener('submit', function(event) {
            const password = document.getElementById('pwd').value;
            const confirmPassword = document.getElementById('confirm_pwd').value;

            if (password !== confirmPassword) {
                event.preventDefault(); // Empêche la soumission du formulaire
                document.getElementById('error-message').textContent = "Les mots de passe ne correspondent pas.";
                document.getElementById('error-message').style.display = 'block';
            }
        });
    </script>
</body>
</html>
