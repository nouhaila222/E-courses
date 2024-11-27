<?php
session_start();
require_once 'config.php'; // Inclusion du fichier de configuration

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];

        // Préparation de la requête SQL
        $sql = "SELECT * FROM insc WHERE email = :email";
        
        try {
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            
            if ($stmt->rowCount() == 1) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                if (password_verify($password, $row['password'])) {
                    $_SESSION['loggedin'] = true;
                    $_SESSION['email'] = $email;
                    header("Location: protected.php");
                    exit;
                } else {
                    echo "<script>alert('Mot de passe incorrect');</script>";
                    exit;
                }
            } else {
                echo "<script>alert('Email incorrect');</script>";
                exit;
            }
        } catch (PDOException $e) {
            echo "Erreur: " . $e->getMessage();
        }
        $conn = null;
    } else {
        echo "<script>alert('Veuillez entrer un email et un mot de passe');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Protected Page</title>
    <style>
        footer {
            background-color: #f8f8f8;
            color: #333;
            text-align: center;
            padding: 1rem 0;
            position: relative;
            top: 100px;
        }

        footer p, footer a {
            margin: 0.5rem 0;
            color: #333;
        }

        footer a {
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }

        footer i {
            margin: 0 0.5rem;
            cursor: pointer;
        }

        footer i:hover {
            color: #ddd;
        }

        footer div {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        body {
            font-family: 'Rubik', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: #fff;
        }

        header {
            background-color: #fff;
            padding: 1rem 0;
            text-align: center;
            display: flex;
            flex-wrap: wrap;
            align-content: space-between;
        }

        header .logo {
            font-size: 1.5rem;
            font-weight: bold;
            margin-left: 200px;
            text-align: center;
            text-decoration: none;
            color: rgba(0, 0, 255, 0.884);
        }

        nav {
            margin-left: 500px;
        }

        nav a {
            color: #070bffe5;
            text-decoration: none;
            font-weight: bold;
            display: inline;
            margin-right: 20px;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .content {
            padding: 20px;
            max-width: 700px;
            margin-left: 90px;
            margin-top: -300px;
            line-height: 1.6;
        }

        button {
            background-color: rgb(7, 68, 199);
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
        }

        button:hover {
            background-color: #555;
        }

        dl {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <header>
        <a class="logo" href="#">E-courses</a>
        <nav>
            <a href="#">ACCEUIL </a>
            <a href="#">HTML & CSS </a>
            <a href="#">JAVASCRIPT </a>
            <a href="#">PHP </a>
            <a href="#">CONTACT </a>
        </nav>
    </header>
    <img src="php.png" alt="php" width="350px" height="350px" style="margin-left: 900px;">
    <div class="content">
        <h2>Bienvenue, <?php echo htmlspecialchars($_SESSION['email']); ?>!</h2>
        <p>
        <h2>Introduction du Cours PHP</h2>
        Bienvenue dans ce cours PHP ! PHP (Hypertext Preprocessor) est un langage de script côté serveur largement utilisé pour le développement web. Il est puissant et flexible, permettant de créer des pages web dynamiques et interactives. Dans ce cours, nous allons couvrir les concepts fondamentaux de PHP et vous montrer comment créer des applications web de base.</p>
        <h2>Plan du Cours</h2>
        <dl>
            <dt style="font-weight: 600;">1.Introduction et Installation</dt>
            <dd>. Qu'est-ce que PHP ?</dd>
            <dd>. Installation de PHP et configuration de votre environnement</dd>
        </dl>
        <dl>
            <dt style="font-weight: 600;">2.Syntaxe de Base et Variables</dt>
            <dd>. Structure de base d'un script PHP</dd>
            <dd>. Variables et types de données</dd>
        </dl>
        <dl>
            <dt style="font-weight: 600;">3.Structures de Contrôle</dt>
            <dd>. Conditions (if, else, elseif)</dd>
            <dd>. Boucles (for, while, foreach)</dd>
        </dl>
        <dl>
            <dt style="font-weight: 600;">4.Fonctions et Inclusion de Fichiers</dt>
            <dd>. Définition et utilisation des fonctions</dd>
            <dd>. Inclusion de fichiers avec include et require</dd>
        </dl>
        <dl>
            <dt style="font-weight: 600;">5.Formulaires et Superglobales</dt>
            <dd>. Gestion des formulaires HTML avec PHP</dd>
            <dd>. Utilisation des variables superglobales ($_GET, $_POST, $_SESSION, etc.)</dd>
        </dl>
        <dl>
            <dt style="font-weight: 600;">6.Interaction avec une Base de Données</dt>
            <dd>. Connexion à une base de données MySQL</dd>
            <dd>. Exécution de requêtes SQL et manipulation des données</dd>
        </dl>
        <dl>
            <dt style="font-weight: 600;">7.Bonnes Pratiques et Sécurité</dt>
            <dd>. Validation et assainissement des données</dd>
            <dd>. Bonnes pratiques de sécurité en PHP</dd>
        </dl>

        <button style="font-weight: 600;">commencer le cours</button>
    </div>
    <footer>
        <div>
            <p>ADRESSE : GEULMIM RUE MOHAMED V</p>
            <p>EMAIL : ecourses@gmail.com</p>
            <p>TÉLÉ : 05664332454</p>
        </div>
        <div>
            <i class="fa-brands fa-twitter"></i>
            <i class="fa-brands fa-instagram"></i>
            <i class="fa-brands fa-facebook"></i>
            <i class="fa-brands fa-youtube"></i>
        </div>
        <div>
            <p>
                <a href="#">Mentions légales</a>
                <a href="#">Politique en matière de cookies</a>
                <a href="#">Politique de confidentialité</a>
                <a href="#">Conditions d'utilisation</a>
                <i class="bi bi-c-circle">2024</i>
            </p>
        </div>
    </footer>
</body>
</html>

