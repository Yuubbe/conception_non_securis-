<?php
// Simuler un appel API externe pour récupérer des données météo
// Exemple d'API publique, changez l'URL pour simuler un appel réel

// Exemple de réponse de l'API
$response = [
    'weather' => 'Ensoleillé',
    'temperature' => '22°C',
];

// Retourner la réponse sous forme de JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
