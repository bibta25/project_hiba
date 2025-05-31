<?php
session_start();
require('admin/includs/db.php');

// Vérification de la session utilisateur (connexion requise)
if (!isset($_SESSION['user_id'])) {
    header('Location: loginM.php');
    exit;
}

// Ajouter un nouveau pépinière
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $nom = $_POST['nom'];
    $adresse = $_POST['adresse'];
    $telephone = $_POST['telephone'];
    $email = $_POST['email'];
    $description = $_POST['description'];
    $user_id = $_SESSION['user_id'];

    // Gestion de l'image
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $image_path = "img/" . basename($image);

    // Déplacer l'image vers le répertoire d'upload
    if (move_uploaded_file($image_tmp, $image_path)) {
        // Préparer l'insertion dans la base de données
        $stmt = $conn->prepare("INSERT INTO pepiniere (name, address, phone, email, description, image, user_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssi", $nom, $adresse, $telephone, $email, $description, $image, $user_id);
        $stmt->execute();

        echo "<script>alert('Pépinière ajoutée avec succès !'); window.location.href = 'mes_pepinieres.php';</script>";
    } else {
        echo "<script>alert('Erreur lors de l\'upload de l\'image');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Add a Nursery</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f1f8f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 700px;
            margin: 50px auto;
            padding: 30px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2 {
            color: #2e7d32;
            text-align: center;
            margin-bottom: 25px;
        }

        form input, form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        form input[type="file"] {
            padding: 8px;
        }

        form button {
            width: 100%;
            padding: 12px;
            background-color: #4caf50;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        form button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Add a New Nursery</h2>

    <!-- Formulaire d'ajout -->
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="nom" placeholder="Nursery name" required>
        <input type="text" name="adresse" placeholder="Address" required>
        <input type="text" name="telephone" placeholder="Phone" required>
        <input type="email" name="email" placeholder="Email" required>
        <textarea name="description" placeholder="Description" rows="5" required></textarea>
        <input type="file" name="image" accept="image/*" required>
        <button type="submit" name="submit">Add</button>
    </form>
</div>

</body>
</html>
