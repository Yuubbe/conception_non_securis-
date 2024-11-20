<?php
// Proxy pour protéger la clé API

// Remplacez cette URL par celle de l'API réelle que vous souhaitez interroger
$apiUrl = 'https://newsapi.org/v2/top-headlines';
$apiKey = '4fc33b78c89e420da745c3e532aaa356';  // Clé API secrète stockée côté serveur

// Paramètres de la requête : ici, on récupère les actualités des États-Unis, vous pouvez personnaliser la requête
$country = 'fr';  // Pays des actualités (vous pouvez changer 'us' en un autre pays, comme 'fr' pour la France)
$category = 'general'; // Catégorie des actualités, ici "general" mais vous pouvez aussi utiliser "technology", "sports", etc.

// Créer l'URL de l'API avec la clé API et les paramètres
$requestUrl = $apiUrl . '?country=' . $country . '&category=' . $category . '&apiKey=' . $apiKey;

// Appel à l'API
$response = file_get_contents($requestUrl);
if ($response === FALSE) {
    die('Erreur lors de la récupération des données');
}

// Renvoi des données JSON au client
header('Content-Type: application/json');
echo $response;
?>
