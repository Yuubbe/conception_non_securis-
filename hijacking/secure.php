<?php
session_start();
include 'db2.php'; // Connexion à la base de données

// Si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Requête préparée pour récupérer l'utilisateur par son nom d'utilisateur
    $sql = "SELECT * FROM users WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    $user = $stmt->fetch();

    if ($user) {
        // Comparaison des mots de passe (en texte brut)
        if ($password == $user['password']) {
            // Regénérer l'ID de session pour éviter la fixation de session
            session_regenerate_id(true);

            // Initialisation de la session avec un identifiant sécurisé
            $_SESSION['username'] = $user['username'];
            
            // Affichage du message de bienvenue
            echo "Connexion réussie : Bonjour, " . htmlspecialchars($user['username']) . "!";
        } else {
            echo "Mot de passe incorrect.";
        }
    } else {
        echo "Identifiants incorrects.";
    }
}

// Si la session existe déjà
elseif (isset($_SESSION['username'])) {
    echo "Session active pour : " . htmlspecialchars($_SESSION['username']);
} else {
    echo "Veuillez vous connecter.";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion sécurisée</title>
</head>
<body>
    <h1>Connexion</h1>
    <form method="POST" action="">
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" name="username" id="username" required>
        <br><br>
        <label for="password">Mot de passe :</label>
        <input type="password" name="password" id="password" required>
        <br><br>
        <button type="submit">Se connecter</button>
    </form>
</body>
</html>
