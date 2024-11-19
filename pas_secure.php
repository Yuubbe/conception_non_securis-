<?php

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $stmt = $pdo->query($sql);
    $user = $stmt->fetch();

    if ($user) {
        echo "Connexion réussie : Bienvenue, " . htmlspecialchars($user['username']) . "!<br>";

        // Vérifie si l'utilisateur est "admin"
        if ($user['username'] === 'admin') {
            echo "<h2>Liste des utilisateurs :</h2>";
            $allUsersQuery = "SELECT username, password FROM users";
            $allUsersStmt = $pdo->query($allUsersQuery);
            
            while ($row = $allUsersStmt->fetch(PDO::FETCH_ASSOC)) {
                echo "Nom d'utilisateur : " . htmlspecialchars($row['username']) . " | Mot de passe : " . htmlspecialchars($row['password']) . "<br>";
            }
        }
    } else {
        echo "Identifiants incorrects.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
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
