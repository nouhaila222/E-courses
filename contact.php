<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "inscription";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        exit;
    }

    $name = htmlspecialchars($_POST['nom']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    $stmt = $conn->prepare("INSERT INTO contact (nom, email, message) VALUES (:nom, :email, :message)");
    $stmt->bindParam(':nom', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':message', $message);

    if ($stmt->execute()) {
        $to_email = "elmaksoubn@example.com"; // Replace with your email address
        $subject = "New Contact Message";
        $body = "Name: $name\nEmail: $email\nMessage: $message";
        $headers = "From: elmaksoubn@example.com"; // Replace with your email address

        ini_set('SMTP', 'smtp.gmail.com');
        ini_set('smtp_port', '587');
        ini_set('sendmail_from', 'elmaksoubn@example.com'); // Replace with your email address

        if (mail($to_email, $subject, $body, $headers)) {
            echo "<script>alert('Message envoyé avec succès.'); window.location.href='success.html';</script>";
        } else {
            echo "<script>alert('L'envoi du message a échoué.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Erreur lors de l\'envoi du message.'); window.history.back();</script>";
    }

    $conn = null;
}
?>
