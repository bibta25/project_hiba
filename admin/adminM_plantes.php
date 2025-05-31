<?php
include('../admin/includs/header.php');

$conn = mysqli_connect('localhost', 'root', '', 'machtala') or die('Connection failed: ' . mysqli_connect_error());

$errors = [];
$success_msg = "";

// Supprimer plante
if (isset($_POST['delete'])) {
    $plantes_id = $_POST['plantes_id'];
    $delete_query = "DELETE FROM plantes WHERE id = '$plantes_id'";
    if (mysqli_query($conn, $delete_query)) {
        $success_msg = "Plante supprimée avec succès !";
    } else {
        $errors[] = "Erreur lors de la suppression : " . mysqli_error($conn);
    }
}

// Ajouter plante
if (isset($_POST['add_plante'])) {
    $nom = mysqli_real_escape_string($conn, $_POST['nom']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);
    $exposition_soleil = mysqli_real_escape_string($conn, $_POST['exposition_soleil']);
    $temperature = mysqli_real_escape_string($conn, $_POST['temperature']);
    $type_sol = mysqli_real_escape_string($conn, $_POST['type_sol']);
    $arrosage = mysqli_real_escape_string($conn, $_POST['arrosage']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $image = $_FILES['image']['name'];

    $target_dir = "uploaded_img/";
    move_uploaded_file($_FILES['image']['tmp_name'], $target_dir . $image);

    $insert_query = "INSERT INTO plantes (nom, type, exposition_soleil, temperature, type_sol, arrosage, description, image) 
                     VALUES ('$nom', '$type', '$exposition_soleil', '$temperature', '$type_sol', '$arrosage', '$description', '$image')";

    if (mysqli_query($conn, $insert_query)) {
        $success_msg = "Plante ajoutée avec succès !";
    } else {
        $errors[] = "Erreur d'ajout : " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Plantes</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f9f4;
            margin: 0;
            padding: 20px;
            color: #2e4d3f;
        }

        h2 {
            color: #2e7d32;
            border-bottom: 2px solid #2e7d32;
            padding-bottom: 5px;
        }

        form.add_plants {
            max-width: 600px;
            margin: 60px auto;
            background: #fff;
            padding: 30px 40px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            border-radius: 12px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="file"],
        select,
        textarea {
            width: 100%;
            padding: 8px 10px;
            margin: 6px 0 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button[type="submit"],
        input[type="submit"],
        .btn_b a {
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            margin-right: 10px;
            display: inline-block;
        }

        button[type="submit"]:hover,
        input[type="submit"]:hover,
        .btn_b a:hover {
            background-color: #388e3c;
        }

        #show-product {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }

        .show_plants {
            background-color: #fff;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .show_plants img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .btn_b {
            margin-top: 10px;
        }

        .btn_b input[type="submit"] {
            background-color: #e53935;
        }

        .btn_b input[type="submit"]:hover {
            background-color: #b71c1c;
        }

        .message {
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .message.success {
            background-color: #d0f0d3;
            color: #256029;
        }

        .message.error {
            background-color: #fddede;
            color: #b71c1c;
        }
    </style>
</head>
<body>
    <h2>Ajouter une Plante</h2>

    <?php if (!empty($errors)): ?>
        <div class="message error">
            <?php foreach ($errors as $error): ?>
                <p><?php echo $error; ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($success_msg)): ?>
        <div class="message success">
            <p><?php echo $success_msg; ?></p>
        </div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data" class="add_plants">
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" required>

        <label for="type">Type:</label>
        <input type="text" id="type" name="type" required>

        <label for="exposition_soleil">Exposition au soleil:</label>
        <input type="text" id="exposition_soleil" name="exposition_soleil" required>

        <label for="temperature">Température:</label>
        <input type="text" id="temperature" name="temperature" required>

        <label for="type_sol">Type de sol:</label>
        <select id="type_sol" name="type_sol" required>
            <option value="">-- Sélectionnez --</option>
            <option value="Sol sablonneux">Sol sablonneux</option>
            <option value="Sol argileux">Sol argileux</option>
            <option value="Sol limoneux">Sol limoneux</option>
            <option value="Sol calcaire">Sol calcaire</option>
            <option value="Sol humifère">Sol humifère</option>
            <option value="Sol bien drainé">Sol bien drainé</option>
        </select>

        <label for="arrosage">Arrosage:</label>
        <input type="text" id="arrosage" name="arrosage" required>

        <label for="description">Description:</label>
        <textarea name="description" id="description" cols="40" rows="5" required></textarea>

        <label for="image">Image:</label>
        <input type="file" id="image" name="image" required>

        <button type="submit" name="add_plante">Ajouter Plante</button>
    </form>

    <h2>Liste des Plantes</h2>
    <section id="show-product">
        <?php
        $result = mysqli_query($conn, "SELECT * FROM plantes");
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='show_plants'>";
                echo "<img src='uploaded_img/" . htmlspecialchars($row['image']) . "' alt='Image Plante'>";
                echo "<strong>Nom:</strong> " . htmlspecialchars($row['nom']) . "<br>";
                echo "<strong>Type:</strong> " . htmlspecialchars($row['type']) . "<br>";
                echo "<strong>Exposition:</strong> " . htmlspecialchars($row['exposition_soleil']) . "<br>";
                echo "<strong>Température:</strong> " . htmlspecialchars($row['temperature']) . "<br>";
                echo "<strong>Sol:</strong> " . htmlspecialchars($row['type_sol']) . "<br>";
                echo "<strong>Arrosage:</strong> " . htmlspecialchars($row['arrosage']) . "<br>";
                echo "<strong>Description:</strong> " . htmlspecialchars(substr($row['description'], 0, 80)) . "...<br>";
                echo "<form method='post'>";
                echo "<input type='hidden' name='plantes_id' value='" . $row['id'] . "'>";
                echo "<div class='btn_b'>";
                echo "<input type='submit' value='Supprimer' name='delete'>";
                echo "<a href='../admin/update_plante.php?id=" . $row['id'] . "'>Modifier</a>";
                echo "</div>";
                echo "</form>";
                echo "</div>";
            }
        } else {
            echo "<p>Aucune plante trouvée !</p>";
        }
        ?>
    </section>
</body>
</html>


<?php
include('../admin/includs/footer.php');
include('../admin/includs/scripts.php');
?>
