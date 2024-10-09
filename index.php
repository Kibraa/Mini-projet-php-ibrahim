<?php
session_start();
require 'config.php';

// Vérification de la session utilisateur
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userMessage = trim($_POST['message']);
    
    // Validation et insertion du message
    if (!empty($userMessage)) {
        $query = $pdo->prepare("INSERT INTO messages (user_id, message) VALUES (?, ?)");
        $query->execute([$_SESSION['user_id'], $userMessage]);
    }
}

// Récupération et affichage des messages
$allMessages = $pdo->query("SELECT m.id, m.message, m.created_at, u.username FROM messages m JOIN users u ON m.user_id = u.id ORDER BY m.created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Guestbook</title>
</head>
<body>
    <h2>Guestbook</h2>
    <p>Bonjour, <?php echo $_SESSION['username']; ?> <a href="logout.php">Se déconnecter</a></p>
    
    <form method="POST">
        <textarea name="message" placeholder="Tapez votre message" required></textarea>
        <button type="submit">Envoyer</button>
    </form>

    <h3>Messages publiés</h3>
    <?php foreach ($allMessages as $message): ?>
        <div>
            <strong><?php echo htmlspecialchars($message['username']); ?> a écrit:</strong>
            <p><?php echo htmlspecialchars($message['message']); ?></p>
            <small><?php echo $message['created_at']; ?></small>
        </div>
    <?php endforeach; ?>
</body>
</html>
