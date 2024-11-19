<?php
// Proxy pour protéger la clé API

// Remplacez cette URL par celle de l'API réelle que vous souhaitez interroger
$apiUrl = 'https://newsapi.org/v2/top-headlines';
$apiKey = '4fc33b78c89e420da745c3e532aaa356';  // Clé API secrète stockée côté serveur

// Effectuer l'appel API avec la clé secrète
$response = file_get_contents($apiUrl . '?key=' . $apiKey);

// Retourner la réponse de l'API au front-end
header('Content-Type: application/json');
echo $response;
?>
