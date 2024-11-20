<?php
// Simulation d'une attaque brute force pour un mot de passe avec un mécanisme de sécurité
session_start();

// Nom d'utilisateur cible et mot de passe hashé
$targetUsername = 'admin'; 
$targetPasswordHash = password_hash('12345', PASSWORD_DEFAULT); // Le mot de passe correct est "12345"

// Dictionnaire de mots de passe courants (exemple)
$passwordList = [
    'password', '123456', '123456789', 'qwerty', 'password1', '12345', 
    '12345678', '111111', '123123', 'admin', 'welcome', 'letmein', 'root', 
    'sunshine', 'monkey', 'dragon', 'trustno1', '1234', 'football', 
    'superman', 'batman', 'test123', 'hello', 'freedom', 'securepass',
    'abc123', 'iloveyou', '123', '654321', '1q2w3e4r', '1qaz2wsx', 
    'loveme', 'starwars', 'bailey', 'shadow', 'maggie', 'buster', 
    'harley', 'princess', 'qwerty123', 'baseball', 'master', 'michael', 
    'football123', 'charlie', 'access', 'passw0rd', 'qwertyuiop', 
    'password123', '123abc', 'summer2024', 'winter2023', 'spring2024', 
    'autumn2023', 'welcome123', 'letmein123', 'pokemon', 'naruto', 
    'dragonball', 'superman2023', 'batman2023', 'avengers', '123qwe', 
    'zxcvbnm', 'asdfghjkl', '0987654321', 'password!', 'admin123', 
    'football2023', 'pass123', 'god123', 'freedom1', 'secured123',
    '1qaz@wsx', 'hello123', 'iloveyou123', 'password2024', '987654321', 
    'hunter2', 'secret123', 'trustme', 'loveyou1', 'qwertz', 'zaq12wsx', 
    'asdf1234', 'mypassword', 'user2024', 'user123', 'mypassword2023',
    'abcd1234', 'freepass', 'strongpass', 'weaktree', 'supersecure'
];

// Limitation des tentatives : Nombre d'essais avant de verrouiller l'accès
$maxAttempts = 5;
$lockoutTime = 60 * 5; // 5 minutes de verrouillage après 5 échecs

// Vérification si l'utilisateur a atteint la limite de tentatives échouées
if (isset($_SESSION['failed_attempts']) && $_SESSION['failed_attempts'] >= $maxAttempts) {
    $timeSinceLastAttempt = time() - $_SESSION['last_attempt_time'];
    if ($timeSinceLastAttempt < $lockoutTime) {
        $remainingTime = $lockoutTime - $timeSinceLastAttempt;
        die("Trop de tentatives échouées. Essayez à nouveau dans $remainingTime secondes.");
    } else {
        // Réinitialiser les tentatives après un délai
        unset($_SESSION['failed_attempts']);
        unset($_SESSION['last_attempt_time']);
    }
}

// Fonction de tentative de connexion
function attemptLogin($username, $password, $hash) {
    if ($username === 'admin' && password_verify($password, $hash)) {
        return true; // Succès
    }
    return false; // Échec
}

// Début de l'attaque brute force sécurisée
echo "Début de l'attaque brute force...\n";
foreach ($passwordList as $password) {
    echo "Essai avec : $password\n";

    // Vérification du mot de passe
    if (attemptLogin($targetUsername, $password, $targetPasswordHash)) {
        echo "Mot de passe trouvé : $password\n";
        break;
    }

    // Incrémentation des tentatives échouées
    if (!isset($_SESSION['failed_attempts'])) {
        $_SESSION['failed_attempts'] = 0;
    }
    $_SESSION['failed_attempts']++;

    // Enregistrer le moment de l'échec
    $_SESSION['last_attempt_time'] = time();

    // Si trop de tentatives échouées, stopper l'attaque
    if ($_SESSION['failed_attempts'] >= $maxAttempts) {
        echo "Trop de tentatives échouées. Vous avez atteint la limite de tentatives.\n";
        break;
    }
}

echo "Fin de l'attaque brute force.\n";
?>
