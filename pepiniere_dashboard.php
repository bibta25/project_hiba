<?php
session_start();
require('admin/includs/db.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: loginM.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Fonction utilitaire pour générer un nom de fichier unique
function uniqueFileName($filename) {
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    return uniqid('img_', true) . '.' . $ext;
}

// --- AJOUTER UNE PLANTE ---
if (isset($_POST['ajouter_plante'])) {
    $nom_plante = trim($_POST['nom_plante']);
    $prix = floatval($_POST['prix']);
    $description = $_POST['description_plante'] ?? '';

    if ($prix <= 0) {
        echo "<script>alert('Le prix doit être un nombre positif.');</script>";
    } else {
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $image_tmp = $_FILES['image']['tmp_name'];
            $image_original = basename($_FILES['image']['name']);
            $image = uniqueFileName($image_original);
            $image_path = "img/" . $image;

            // Récupérer pepiniere
            $stmt = $conn->prepare("SELECT id FROM pepiniere WHERE user_id = ? LIMIT 1");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $pepiniere = $result->fetch_assoc();
                $pepiniere_id = $pepiniere['id'];

                if (move_uploaded_file($image_tmp, $image_path)) {
                    $stmt = $conn->prepare("INSERT INTO plants (name, price, description, image, pepiniere_id) VALUES (?, ?, ?, ?, ?)");
                    $stmt->bind_param("sdssi", $nom_plante, $prix, $description, $image, $pepiniere_id);
                    if ($stmt->execute()) {
                        echo "<script>alert('Plante ajoutée avec succès'); window.location.href='" . $_SERVER['PHP_SELF'] . "';</script>";
                        exit;
                    } else {
                        echo "<script>alert('Erreur lors de l\\'insertion en base.');</script>";
                    }
                } else {
                    echo "<script>alert('Erreur lors de l\\'upload de l\\'image');</script>";
                }
            } else {
                echo "<script>alert('Vous devez d\\'abord créer une pépinière.');</script>";
            }
        } else {
            echo "<script>alert('Veuillez sélectionner une image valide.');</script>";
        }
    }
}

// --- MODIFIER PEPINIERE ---
if (isset($_POST['modifier_pepiniere'])) {
    $name = trim($_POST['name']);
    $address = trim($_POST['address']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $description = $_POST['description'];
    $image_name = null;

    // Gérer image si uploadé
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $image_original = basename($_FILES['image']['name']);
        $image_name = uniqueFileName($image_original);
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_path = "img/" . $image_name;
        if (!move_uploaded_file($image_tmp, $image_path)) {
            echo "<script>alert('Erreur lors de l\\'upload de l\\'image de la pépinière');</script>";
            $image_name = null; // annuler pour ne pas écraser l’image existante
        }
    }

    // Mettre à jour la pepiniere
    if ($image_name) {
        $stmt = $conn->prepare("UPDATE pepiniere SET name=?, address=?, email=?, phone=?, description=?, image=? WHERE user_id=?");
        $stmt->bind_param("ssssssi", $name, $address, $email, $phone, $description, $image_name, $user_id);
    } else {
        $stmt = $conn->prepare("UPDATE pepiniere SET name=?, address=?, email=?, phone=?, description=? WHERE user_id=?");
        $stmt->bind_param("sssssi", $name, $address, $email, $phone, $description, $user_id);
    }
    if ($stmt->execute()) {
        echo "<script>alert('Pépinière modifiée avec succès'); window.location.href='" . $_SERVER['PHP_SELF'] . "';</script>";
        exit;
    } else {
        echo "<script>alert('Erreur lors de la modification de la pépinière');</script>";
    }
}

// --- SUPPRIMER UNE PLANTE ---
if (isset($_GET['delete_plant'])) {
    $plant_id = intval($_GET['delete_plant']);
    // Vérifier que cette plante appartient bien à la pépinière de l'utilisateur
    $stmt = $conn->prepare("SELECT p.id FROM plants p JOIN pepiniere pe ON p.pepiniere_id = pe.id WHERE p.id = ? AND pe.user_id = ?");
    $stmt->bind_param("ii", $plant_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        // Supprimer la plante
        $stmt_del = $conn->prepare("DELETE FROM plants WHERE id = ?");
        $stmt_del->bind_param("i", $plant_id);
        if ($stmt_del->execute()) {
            echo "<script>alert('Plante supprimée'); window.location.href='" . $_SERVER['PHP_SELF'] . "';</script>";
            exit;
        } else {
            echo "<script>alert('Erreur lors de la suppression de la plante');</script>";
        }
    } else {
        echo "<script>alert('Plante non trouvée ou accès refusé'); window.location.href='" . $_SERVER['PHP_SELF'] . "';</script>";
        exit;
    }
}

// --- MODIFIER UNE PLANTE ---
// Affichage formulaire modification plante
if (isset($_GET['edit_plant'])) {
    $edit_plant_id = intval($_GET['edit_plant']);
    $stmt = $conn->prepare("SELECT p.* FROM plants p JOIN pepiniere pe ON p.pepiniere_id = pe.id WHERE p.id = ? AND pe.user_id = ?");
    $stmt->bind_param("ii", $edit_plant_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $plant_to_edit = $result->fetch_assoc();
}

// Traitement formulaire modification plante
if (isset($_POST['modifier_plante'])) {
    $plant_id = intval($_POST['plant_id']);
    $nom_plante = trim($_POST['nom_plante']);
    $prix = floatval($_POST['prix']);
    $description = $_POST['description_plante'] ?? '';
    $image_name = null;

    if ($prix <= 0) {
        echo "<script>alert('Le prix doit être un nombre positif.');</script>";
    } else {
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $image_original = basename($_FILES['image']['name']);
            $image_name = uniqueFileName($image_original);
            $image_tmp = $_FILES['image']['tmp_name'];
            $image_path = "img/" . $image_name;
            if (!move_uploaded_file($image_tmp, $image_path)) {
                echo "<script>alert('Erreur lors de l\\'upload de l\\'image');</script>";
                $image_name = null;
            }
        }

        if ($image_name) {
            $stmt = $conn->prepare("UPDATE plants SET name=?, price=?, description=?, image=? WHERE id=?");
            $stmt->bind_param("sdssi", $nom_plante, $prix, $description, $image_name, $plant_id);
        } else {
            $stmt = $conn->prepare("UPDATE plants SET name=?, price=?, description=? WHERE id=?");
            $stmt->bind_param("sdsi", $nom_plante, $prix, $description, $plant_id);
        }
        if ($stmt->execute()) {
            echo "<script>alert('Plante modifiée avec succès'); window.location.href='" . $_SERVER['PHP_SELF'] . "';</script>";
            exit;
        } else {
            echo "<script>alert('Erreur lors de la modification de la plante');</script>";
        }
    }
}

// Récupérer la pepiniere
$stmt = $conn->prepare("SELECT * FROM pepiniere WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$pepiniere_result = $stmt->get_result();
$pepiniere = $pepiniere_result->fetch_assoc();

// Récupérer les plantes de cette pepiniere
$plantes_result = [];
if ($pepiniere) {
    $pepiniere_id = $pepiniere['id'];
    $stmt = $conn->prepare("SELECT * FROM plants WHERE pepiniere_id = ?");
    $stmt->bind_param("i", $pepiniere_id);
    $stmt->execute();
    $plantes_result = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord - Mes Pépinières</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #e8f5e9;
            padding: 30px;
        }
        .container {
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2, h3 {
            color: #2e7d32;
            text-align: center;
        }
        .pepiniere-info, .form-section, .plantes-list {
            margin-top: 30px;
        }
        input, textarea, button {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button {
            background: #4caf50;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }
        .plante-item {
            background: #f1f8e9;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .plante-nom-prix {
            flex-grow: 1;
            display: flex;
            justify-content: space-between;
            margin-right: 10px;
            max-width: 350px;
        }
        .plante-prix {
            min-width: 70px;
            text-align: right;
            font-weight: bold;
        }
        img {
            max-width: 80px;
            border-radius: 5px;
        }
        .actions button {
            width: auto;
            margin-left: 10px;
            background: #388e3c;
        }
        .actions button.delete {
            background: #d32f2f;
        }
        form.inline-form {
            display: inline-block;
            margin: 0;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Ma Pépinière</h2>

    <?php if ($pepiniere): ?>
        <!-- FORM MODIFIER PEPINIERE -->
        <div class="pepiniere-info">
            <form method="POST" enctype="multipart/form-data">
                <h3>Modifier les informations de la pépinière</h3>
                <input type="text" name="name" placeholder="Nom" required value="<?= htmlspecialchars($pepiniere['name']) ?>">
                <textarea name="address" placeholder="Adresse" required><?= htmlspecialchars($pepiniere['address']) ?></textarea>
                <input type="email" name="email" placeholder="Email" required value="<?= htmlspecialchars($pepiniere['email']) ?>">
                <input type="text" name="phone" placeholder="Téléphone" required value="<?= htmlspecialchars($pepiniere['phone']) ?>">
                <textarea name="description" placeholder="Description"><?= htmlspecialchars($pepiniere['description']) ?></textarea>
                <label>Image actuelle :</label><br>
                <?php if (!empty($pepiniere['image'])): ?>
                    <img src="img/<?= htmlspecialchars($pepiniere['image']) ?>" alt="Image pépinière" style="max-width:150px; border-radius:5px;"><br>
                <?php else: ?>
                    <p>Aucune image</p>
                <?php endif; ?>
                <label>Changer l'image :</label>
                <input type="file" name="image" accept="image/*">
                <button type="submit" name="modifier_pepiniere">Modifier Pépinière</button>
            </form>
        </div>

        <!-- LISTE DES PLANTES -->
        <div class="plantes-list">
            <h3>Mes Plantes</h3>

            <?php if ($plantes_result->num_rows > 0): ?>
                <?php while ($plante = $plantes_result->fetch_assoc()): ?>
                    <div class="plante-item">
                        <img src="img/<?= htmlspecialchars($plante['image']) ?>" alt="<?= htmlspecialchars($plante['name']) ?>">
                        <div class="plante-nom-prix">
                            <span><?= htmlspecialchars($plante['name']) ?></span>
                            <span class="plante-prix"><?= number_format($plante['price'], 2, ',', ' ') ?> DZD</span>
                        </div>
                        <div class="actions">
                            <a href="?edit_plant=<?= $plante['id'] ?>"><button>Modifier</button></a>
                            <a href="?delete_plant=<?= $plante['id'] ?>" onclick="return confirm('Voulez-vous vraiment supprimer cette plante ?');"><button class="delete">Supprimer</button></a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Aucune plante disponible pour cette pépinière.</p>
            <?php endif; ?>
        </div>

        <!-- FORM AJOUTER UNE PLANTE -->
        <div class="form-section">
            <h3>Ajouter une nouvelle plante</h3>
            <form method="POST" enctype="multipart/form-data">
                <input type="text" name="nom_plante" placeholder="Nom de la plante" required>
                <input type="number" name="prix" placeholder="Prix en DZD" min="0.01" step="0.01" required>
                <textarea name="description_plante" placeholder="Description"></textarea>
                <input type="file" name="image" accept="image/*" required>
                <button type="submit" name="ajouter_plante">Ajouter Plante</button>
            </form>
        </div>

    <?php else: ?>
        <p>Vous n'avez pas encore créé de pépinière. Veuillez créer une pépinière d'abord.</p>
    <?php endif; ?>


    <!-- FORM MODIFIER PLANTE -->
    <?php if (isset($plant_to_edit)): ?>
        <hr>
        <div class="form-section">
            <h3>Modifier la plante : <?= htmlspecialchars($plant_to_edit['name']) ?></h3>
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="plant_id" value="<?= $plant_to_edit['id'] ?>">
                <input type="text" name="nom_plante" value="<?= htmlspecialchars($plant_to_edit['name']) ?>" required>
                <input type="number" name="prix" value="<?= htmlspecialchars($plant_to_edit['price']) ?>" min="0.01" step="0.01" required>
                <textarea name="description_plante"><?= htmlspecialchars($plant_to_edit['description']) ?></textarea>
                <label>Image actuelle :</label><br>
                <img src="img/<?= htmlspecialchars($plant_to_edit['image']) ?>" alt="Image plante" style="max-width:150px; border-radius:5px;"><br>
                <label>Changer l'image :</label>
                <input type="file" name="image" accept="image/*">
                <button type="submit" name="modifier_plante">Modifier Plante</button>
            </form>
        </div>
    <?php endif; ?>

</div>
</body>
</html>
