<?php
// URL de l'API NewsAPI
$apiUrl = 'https://newsapi.org/v2/top-headlines';
$apiKey = '4fc33b78c89e420da745c3e532aaa356'; // Clé API stockée uniquement côté serveur

// Paramètres de la requête
$country = 'us'; // Vous pouvez personnaliser le pays
$category = 'general'; // Catégorie des actualités

// Construire l'URL avec les paramètres
$requestUrl = $apiUrl . '?country=' . $country . '&category=' . $category . '&apiKey=' . $apiKey;

// Initialiser cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $requestUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// Exécuter la requête et récupérer la réponse
$response = curl_exec($ch);

// Vérifier s'il y a des erreurs
if(curl_errno($ch)) {
    // En cas d'erreur, renvoyer le message d'erreur
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode(['error' => 'Erreur lors de la récupération des données', 'curl_error' => curl_error($ch)]);
    exit;
}

// Fermer la session cURL
curl_close($ch);

// Réexpédier les données au frontend
header('Content-Type: application/json');
echo $response;
?>
