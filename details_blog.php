<?php
$conn = new mysqli('localhost', 'root', '', 'machtala');
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID d'article invalide.");
}

$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM blog WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$blog = $result->fetch_assoc();

if (!$blog) {
    die("Article non trouvé.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($blog['name']); ?></title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f4f4f4;
            padding: 40px 20px;
            color: #333;
        }
        .container {
            max-width: 900px;
            margin: auto;
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 6px 16px rgba(0,0,0,0.1);
        }
        .container img {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 25px;
        }
        h1 {
            margin-bottom: 15px;
            color: #2e7d32;
        }
        p {
            font-size: 1.1rem;
            line-height: 1.7;
            color: #555;
        }
        .back-btn {
            display: inline-block;
            margin-top: 30px;
            text-decoration: none;
            color: white;
            background-color: #4caf50;
            padding: 10px 20px;
            border-radius: 8px;
            transition: background 0.3s;
        }
        .back-btn:hover {
            background-color: #388e3c;
        }
    </style>
</head>
<body>

<div class="container">
    <h1><?php echo htmlspecialchars($blog['name']); ?></h1>
    <img src="img/<?php echo htmlspecialchars($blog['image']); ?>" alt="Blog Image">
    <p><?php echo nl2br(htmlspecialchars($blog['text'])); ?></p>
    <a class="back-btn" href="blogM.php">← Retour au blog</a>
</div>

</body>
</html>
