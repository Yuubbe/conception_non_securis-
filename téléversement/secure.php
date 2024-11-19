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

        // Liste des extensions autorisées
        $allowed_extensions = ['doc', 'docx', 'pdf', 'txt'];
        $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);

        // Si l'extension est dans les extensions autorisées
        if (in_array(strtolower($file_extension), $allowed_extensions)) {
            // Déplacement du fichier téléchargé dans le répertoire cible
            $target_file = 'uploads/' . basename($file['name']);
            if (move_uploaded_file($file['tmp_name'], $target_file)) {
                echo "Fichier téléchargé avec succès !<br>";
            } else {
                echo "Erreur lors du téléchargement du fichier.";
            }
        } else {
            echo "Seuls les fichiers .doc, .docx, .pdf, .txt sont autorisés.";
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
    <title>Téléversement de fichiers</title>
</head>
<body>
    <h1>Formulaire de téléversement de fichiers</h1>
    <form method="POST" enctype="multipart/form-data">
        <label for="userfile">Sélectionner un fichier à télécharger :</label>
        <input type="file" name="userfile" id="userfile" required>
        <br><br>
        <button type="submit">Téléverser le fichier</button>
    </form>
</body>
</html>
