<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Test de vulnérabilité - Clé API exposée</title>
    <script>
        // Requête vers une API externe avec clé API exposée
        function fetchWeather() {
            const apiKey = '4fc33b78c89e420da745c3e532aaa356'; // La clé API exposée
            const url = `https://newsapi.org/v2/top-headlines?key=${apiKey}`;
            
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    console.log('Données de l\'API:', data);
                    document.getElementById('weather').innerText = `Météo: ${data.weather}`;
                })
                .catch(error => console.log('Erreur:', error));
        }

        // Appel de la fonction pour récupérer la météo
        window.onload = function() {
            fetchWeather();
        }
    </script>
</head>
<body>
    <h1>Test de vulnérabilité - Clé API exposée</h1>
    <div id="weather">Chargement de la météo...</div>
</body>
</html>
