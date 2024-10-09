<?php
$serverName = '127.0.0.1';
$databaseName = 'test_db';
$username = 'root_user'; // Mettez votre propre nom d'utilisateur ici
$password = 'secure_pass'; // Mettez votre mot de passe ici

try {
    // Connexion à la base de données en utilisant PDO
    $dbConnection = new PDO("mysql:host=$serverName;dbname=$databaseName;charset=utf8", $username, $password);
    
    // Configuration du mode de gestion des erreurs
    $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connection established successfully!";
} catch (PDOException $error) {
    // Message d'erreur si la connexion échoue
    exit("Failed to connect to the database: " . $error->getMessage());
}
?>
