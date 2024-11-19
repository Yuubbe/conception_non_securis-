<?php
// Vérification si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Vérification de la présence du fichier
    if (isset($_FILES['userfile'])) {
        $file = $_FILES['userfile'];

        // Vérification du répertoire 'uploads/'
        if (!is_dir('uploads')) {
            mkdir('uploads', 0777, true); // Créer le dossier s'il n'existe pas
        }

        // Vérification de l'extension du fichier
        $allowed_extensions = ['sql'];
        $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);

        // Si l'extension est .sql
        if (in_array(strtolower($file_extension), $allowed_extensions)) {
            // Déplacement du fichier téléchargé dans le répertoire cible
            $target_file = 'uploads/' . basename($file['name']);
            if (move_uploaded_file($file['tmp_name'], $target_file)) {
                echo "Fichier téléchargé avec succès !<br>";

                // Connexion à la base de données
                include 'db2.php';  // Connexion à la base de données

                // Charger le fichier SQL
                $sql = file_get_contents($target_file);

                // Exécution de la requête SQL téléchargée
                try {
                    // Exécuter la requête SQL (Attention : c'est une vulnérabilité si le fichier SQL est malveillant)
                    $pdo->exec($sql);
                    echo "Fichier SQL exécuté avec succès !<br>";

                    // Vérifier si la requête SQL est de type SELECT
                    if (preg_match('/^\s*SELECT/i', $sql)) {
                        $stmt = $pdo->query($sql); // Exécuter la requête et obtenir le résultat
                        if ($stmt) {
                            // Affichage des résultats sous forme de tableau HTML
                            echo "<table border='1'><tr>";
                            // Récupérer les noms des colonnes
                            $columns = array_keys($stmt->fetch(PDO::FETCH_ASSOC)); // Récupérer les noms des colonnes
                            foreach ($columns as $column) {
                                echo "<th>" . htmlspecialchars($column) . "</th>";
                            }
                            echo "</tr>";

                            // Récupérer toutes les lignes et les afficher
                            $stmt->execute();
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>";
                                foreach ($row as $value) {
                                    echo "<td>" . htmlspecialchars($value) . "</td>";
                                }
                                echo "</tr>";
                            }
                            echo "</table>";
                        } else {
                            echo "Aucun résultat trouvé.";
                        }
                    }
                } catch (PDOException $e) {
                    echo "Erreur lors de l'exécution du fichier SQL : " . $e->getMessage();
                }
            } else {
                echo "Erreur lors du téléchargement du fichier.";
            }
        } else {
            echo "Seuls les fichiers .sql sont autorisés.";
        }
    } else {
        echo "Aucun fichier téléchargé.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Téléversement de fichier </title>
</head>
<body>
    <h1>Formulaire de téléversement de fichier </h1>
    <form method="POST" enctype="multipart/form-data">
        <label for="userfile">Sélectionner un fichier à télécharger :</label>
        <input type="file" name="userfile" id="userfile" required>
        <br><br>
        <button type="submit">Téléverser le fichier</button>
    </form>
</body>
</html>
