<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulation de Brute Force</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
        }
        h1 {
            color: #333;
        }
        #log {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #ccc;
            background: #fff;
            height: 300px;
            overflow-y: auto;
            font-family: monospace;
        }
        .success {
            color: green;
            font-weight: bold;
        }
        .failure {
            color: red;
        }
        .loading {
            font-size: 16px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h1>Simulation d'attaque Brute Force</h1>
    <div id="log">Initialisation...</div>
    <div class="loading">En cours...</div>

    <script>
        // Liste des mots de passe testés (simulée côté client)
        const passwordList = [
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


        // Mot de passe cible (à simuler comme trouvé après un certain nombre d'essais)
        const correctPassword = 'supersecure';

        // Élément pour afficher le log
        const logDiv = document.getElementById('log');
        const loadingDiv = document.querySelector('.loading');

        // Fonction pour simuler une tentative de connexion
        function attemptLogin(username, password, targetPassword) {
            return new Promise((resolve) => {
                setTimeout(() => {
                    const isSuccess = password === targetPassword;
                    resolve({ username, password, isSuccess });
                }, 500); // Délai de 500ms pour chaque tentative
            });
        }

        // Fonction principale pour la simulation
        async function bruteForceAttack() {
            const username = 'admin'; // Utilisateur cible
            logDiv.innerHTML = ''; // Réinitialiser le log

            for (let i = 0; i < passwordList.length; i++) {
                const password = passwordList[i];
                const result = await attemptLogin(username, password, correctPassword);

                // Afficher chaque tentative dans le log
                const attemptLog = document.createElement('div');
                if (result.isSuccess) {
                    attemptLog.className = 'success';
                    attemptLog.textContent = `Succès : "${password}" trouvé pour l'utilisateur "${username}"`;
                    logDiv.appendChild(attemptLog);
                    loadingDiv.textContent = "Mot de passe trouvé.";
                    return;
                } else {
                    attemptLog.className = 'failure';
                    attemptLog.textContent = `Échec : "${password}" incorrect`;
                    logDiv.appendChild(attemptLog);
                }

                // Scroller automatiquement le log vers le bas
                logDiv.scrollTop = logDiv.scrollHeight;
            }

            loadingDiv.textContent = "Brute force terminé. Mot de passe non trouvé.";
        }

        // Lancer la simulation
        bruteForceAttack();
    </script>
</body>
</html>
