<?php
include('../admin/includs/header.php');
$conn = mysqli_connect('localhost', 'root', '', 'machtala') or die('connection failed');

if (isset($_GET['name'])) {
    $name = mysqli_real_escape_string($conn, $_GET['name']);
    $select = mysqli_query($conn, "SELECT * FROM blog WHERE name = '$name'") or die('query failed');

    if (mysqli_num_rows($select) > 0) {
        $blog = mysqli_fetch_assoc($select);
    } else {
        echo "<p>Blog introuvable.</p>";
        exit;
    }
}

if (isset($_POST['update_blog'])) {
    $id = $_POST['id'];
    $new_name = mysqli_real_escape_string($conn, $_POST['name']);
    $new_text = mysqli_real_escape_string($conn, $_POST['text']);
    
    $new_image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $image_folder = '../admin/uploaded_img/' . $new_image;

    if (!empty($new_image)) {
        move_uploaded_file($image_tmp, $image_folder);
        mysqli_query($conn, "UPDATE blog SET name='$new_name', text='$new_text', image='$new_image' WHERE id='$id'") or die('query failed');
    } else {
        mysqli_query($conn, "UPDATE blog SET name='$new_name', text='$new_text' WHERE id='$id'") or die('query failed');
    }

    echo "<script>alert('Blog mis à jour avec succès.'); window.location.href='admin_blogs.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier le Blog</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f4f4f4;
            padding: 40px 20px;
        }
        .container {
            max-width: 700px;
            margin: auto;
            background-color: #fff;
            padding: 35px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #2e7d32;
            margin-bottom: 25px;
        }
        form input[type="text"],
        form input[type="file"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        img {
            max-width: 200px;
            border-radius: 10px;
            margin-bottom: 15px;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }
        input[type="submit"] {
            background-color: #4caf50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #388e3c;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>📝 Modifier l'article du blog</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $blog['id']; ?>">

        <label for="name">Titre de l'article</label>
        <input type="text" name="name" value="<?= htmlspecialchars($blog['name']); ?>" required>

        <label for="text">Contenu</label>
        <input type="text" name="text" value="<?= htmlspecialchars($blog['text']); ?>" required>

        <label>Image actuelle :</label>
        <img src="../admin/uploaded_img/<?= htmlspecialchars($blog['image']); ?>" alt="Image actuelle">

        <label for="image">Changer l’image :</label>
        <input type="file" name="image" accept="image/*">

        <input type="submit" name="update_blog" value="💾 Mettre à jour">
    </form>
</div>

</body>
</html>
