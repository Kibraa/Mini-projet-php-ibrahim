<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $loginUsername = trim($_POST['username']);
    $loginPassword = trim($_POST['password']);
    $loginErrors = [];

    // Validation des champs requis
    if (empty($loginUsername) || empty($loginPassword)) {
        $loginErrors[] = 'Veuillez remplir tous les champs.';
    }

    if (empty($loginErrors)) {
        // Vérification des informations de connexion
        $query = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $query->execute([$loginUsername]);
        $retrievedUser = $query->fetch();

        if ($retrievedUser && password_verify($loginPassword, $retrievedUser['password'])) {
            $_SESSION['username'] = $retrievedUser['username'];
            $_SESSION['user_id'] = $retrievedUser['id']; // Stockage de l'ID utilisateur
            header("Location: dashboard.php");
            exit;
        } else {
            $loginErrors[] = 'Identifiants incorrects. Veuillez réessayer.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Page de Connexion</title>
</head>
<body>
    <h2>Page de Connexion</h2>
    <?php if (!empty($loginErrors)): ?>
        <div><?php echo implode('<br>', $loginErrors); ?></div>
    <?php endif; ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Nom d'utilisateur" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <button type="submit">Connexion</button>
    </form>
</body>
</html>
