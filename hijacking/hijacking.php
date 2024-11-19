<?php
session_start();
include 'db2.php'; // Connexion à la base de données

// Si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Requête non sécurisée
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $pdo->query($sql);
    $user = $result->fetch();

    if ($user) {
        // Initialisation de la session (vulnérable)
        $_SESSION['username'] = $user['username'];
        // Ajouter le mot de passe en session (attention, ce n'est pas sécurisé)
        $_SESSION['password'] = $user['password'];
        
        // Afficher un message de bienvenue
        echo "Connexion réussie : Bonjour, " . htmlspecialchars($user['username']) . "!";
    } else {
        echo "Identifiants incorrects.";
    }
}

// Si la session existe déjà
elseif (isset($_SESSION['username'])) {
    echo "Session active pour : " . htmlspecialchars($_SESSION['username']);
    echo "<br>Mot de passe en session : " . htmlspecialchars($_SESSION['password']);
} else {
    echo "Veuillez vous connecter.";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion vulnérable</title>
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
