<?php
session_start();
require('admin/includs/db.php');

// Vérifier que l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: loginM.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Vérifier si le propriétaire a une pépinière
$stmt = $conn->prepare("SELECT id FROM pepiniere WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$pepiniere = $result->fetch_assoc();

if (!$pepiniere) {
    echo "Vous devez avoir une pépinière avant d'ajouter des plantes.";
    exit();
}

// Ajouter la plante si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    // Vérifier si une image a été téléchargée
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // Définir l'emplacement du fichier uploadé
        $image_name = uniqid() . "-" . basename($_FILES['image']['name']);
        $target = "img/" . $image_name;

        // Créer le dossier img s'il n'existe pas
        if (!is_dir("img")) {
            mkdir("img", 0755, true);
        }

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            // Ajouter la plante à la base de données
            $query = "INSERT INTO plants (pepiniere_id, name, price, description, image) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("isdss", $pepiniere['id'], $name, $price, $description, $target);

            if ($stmt->execute()) {
                echo "Plante ajoutée avec succès!";
            } else {
                echo "Erreur lors de l'ajout : " . $stmt->error;
            }
        } else {
            echo "Erreur lors du téléchargement de l'image.";
        }
    } else {
        echo "Veuillez télécharger une image.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une Plante</title>
    <style>
        /* Styles CSS pour la page */
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f9f9f9;
        }
        .form-container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-container h2 {
            margin-bottom: 20px;
            color: #4CAF50;
        }
        input, textarea, button {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        input[type="file"] {
            padding: 10px;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Ajouter une Plante à Votre Pépinière</h2>

    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Nom de la Plante" required>
        <input type="text" name="price" placeholder="Prix" required>
        <textarea name="description" placeholder="Description de la Plante" rows="4" required></textarea>
        <input type="file" name="image" required>
        <button type="submit">Ajouter la Plante</button>
    </form>
</div>

</body>
</html>
