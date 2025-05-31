<?php
include('../admin/includs/header.php');

$conn = mysqli_connect('localhost', 'root', '', 'machtala') or die('Connection failed: ' . mysqli_connect_error());

$id = $_GET['id'] ?? null;
$errors = [];
$success_msg = "";

if (!$id) {
    echo "ID manquant !";
    exit;
}

$query = "SELECT * FROM plantes WHERE id = '$id'";
$result = mysqli_query($conn, $query);
$plante = mysqli_fetch_assoc($result);

if (!$plante) {
    echo "Plante non trouvée !";
    exit;
}

if (isset($_POST['update_plante'])) {
    $nom = mysqli_real_escape_string($conn, $_POST['nom']);
    $type_sol = mysqli_real_escape_string($conn, $_POST['type_sol']);
    $arrosage = mysqli_real_escape_string($conn, $_POST['arrosage']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $target_dir = "uploaded_img/";
        move_uploaded_file($_FILES['image']['tmp_name'], $target_dir . $image);
    } else {
        $image = $plante['image'];
    }

    $update_query = "UPDATE plantes 
                     SET nom='$nom', type_sol='$type_sol', arrosage='$arrosage', description='$description', image='$image' 
                     WHERE id='$id'";

    if (mysqli_query($conn, $update_query)) {
        $success_msg = "Plante mise à jour avec succès !";
        $plante = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM plantes WHERE id = '$id'"));
    } else {
        $errors[] = "Erreur de mise à jour : " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Plante</title>
    <style>
        body {
            background-color: #f5f5f5;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 60px auto;
            background: #fff;
            padding: 30px 40px;
            box-shadow: 0 4px 10px rgba(52, 110, 12, 0.57);
            border-radius: 12px;
        }

        h2 {
            text-align: center;
            color: #2e7d32;
        }

        label {
            font-weight: bold;
            color: #094b22;
        }

        input[type="text"],
        textarea,
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        button {
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            display: block;
            margin: 20px auto 0;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #388e3c;
        }

        .success, .error {
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
        }

        .preview {
            display: block;
            margin: 10px auto;
            border-radius: 8px;
            max-width: 100%;
            height: auto;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

    </style>
</head>
<body>

<div class="container">
    <h2>Modifier une Plante</h2>

    <?php if (!empty($errors)): ?>
        <div class="error">
            <?php foreach ($errors as $error): ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($success_msg)): ?>
        <div class="success"><?= $success_msg ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <label for="nom">Nom:</label>
        <input type="text" name="nom" value="<?= htmlspecialchars($plante['nom']) ?>" required>

        <label for="type_sol">Type de sol:</label>
        <input type="text" name="type_sol" value="<?= htmlspecialchars($plante['type_sol']) ?>" required>

        <label for="arrosage">Arrosage:</label>
        <input type="text" name="arrosage" value="<?= htmlspecialchars($plante['arrosage']) ?>" required>

        <label for="description">Description:</label>
        <textarea name="description" rows="4" required><?= htmlspecialchars($plante['description']) ?></textarea>

        <label for="image">Image (laisser vide pour ne pas changer):</label>
        <input type="file" name="image">

        <img src="uploaded_img/<?= $plante['image'] ?>" alt="Aperçu" class="preview">

        <button type="submit" name="update_plante">Mettre à jour</button>
    </form>
</div>

</body>
</html>

<?php include('../admin/includs/footer.php'); ?>
