<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newUsername = trim($_POST['username']);
    $newPassword = trim($_POST['password']);
    $signupErrors = [];

    // Vérification des champs obligatoires
    if (empty($newUsername) || empty($newPassword)) {
        $signupErrors[] = 'Veuillez renseigner tous les champs.';
    } elseif (strlen($newPassword) < 6) {
        $signupErrors[] = 'Le mot de passe doit comporter au moins 6 caractères.';
    }

    if (empty($signupErrors)) {
        // Hachage du mot de passe avant insertion
        $encryptedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Insertion des informations dans la base de données
        $query = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        if ($query->execute([$newUsername, $encryptedPassword])) {
            $_SESSION['username'] = $newUsername;
            header("Location: dashboard.php");
            exit;
        } else {
            $signupErrors[] = 'Une erreur s\'est produite lors de l\'inscription.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un compte</title>
</head>
<body>
    <h2>Créer un compte</h2>
    <?php if (!empty($signupErrors)): ?>
        <div><?php echo implode('<br>', $signupErrors); ?></div>
    <?php endif; ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Entrez votre nom d'utilisateur" required>
        <input type="password" name="password" placeholder="Choisissez un mot de passe" required>
        <button type="submit">S'inscrire</button>
    </form>
</body>
</html>
