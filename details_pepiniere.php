<?php
session_start();
require('admin/includs/db.php');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $conn->prepare("SELECT * FROM pepiniere WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $nursery = $result->fetch_assoc();

        $stmt_plants = $conn->prepare("SELECT * FROM plants WHERE pepiniere_id = ?");
        $stmt_plants->bind_param("i", $id);
        $stmt_plants->execute();
        $result_plants = $stmt_plants->get_result();
    } else {
        header("Location: pepiniere.php");
        exit();
    }
} else {
    header("Location: pepiniere.php");
    exit();
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

if (isset($_GET['add_to_cart']) && is_numeric($_GET['add_to_cart'])) {
    $plant_id = intval($_GET['add_to_cart']);
    if (isset($_SESSION['cart'][$plant_id])) {
        $_SESSION['cart'][$plant_id]++;
    } else {
        $_SESSION['cart'][$plant_id] = 1;
    }
    header("Location: ?id=$id");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Détails de la Pépinière</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f4f7f6;
      margin: 0;
      padding: 30px;
    }

    .detail-container {
      max-width: 900px;
      margin: 0 auto;
      background: #fff;
      padding: 30px;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
      border-radius: 10px;
    }

    .detail-container img {
      width: 100%;
      height: 350px;
      object-fit: cover;
      border-radius: 10px;
    }

    h2 {
      color: #2e7d32;
      margin-top: 20px;
      font-size: 30px;
      text-align: center;
    }

    p {
      font-size: 16px;
      color: #444;
      margin: 10px 0;
    }

    .plants-section {
      margin-top: 40px;
    }

    .plants-list {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 30px;
    }

    .plant-item {
      display: flex;
      flex-direction: column;
      align-items: center;
      background: #ffffff;
      border-radius: 10px;
      padding: 15px;
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.05);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      text-align: center;
      margin-bottom: 20px;
      position: relative;
    }

    .plant-item img {
      width: 100%;
      height: 250px;
      object-fit: cover;
      border-radius: 8px;
      transition: transform 0.3s ease;
    }

    .plant-item:hover {
      transform: translateY(-10px);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .plant-item:hover img {
      transform: scale(1.05);
    }

    .price {
      font-size: 18px;
      font-weight: bold;
      color: #388e3c;
      margin-top: 10px;
    }

    .add-to-cart-btn {
      display: inline-block;
      margin-top: 10px;
      background-color: #4caf50;
      color: #fff;
      padding: 8px 20px;
      border-radius: 20px;
      text-decoration: none;
      transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .add-to-cart-btn:hover {
      background-color: #388e3c;
      transform: scale(1.05);
    }

    .back-btn {
      display: inline-block;
      margin-top: 30px;
      background-color: #4caf50;
      color: #fff;
      padding: 12px 20px;
      border-radius: 20px;
      text-decoration: none;
      font-size: 18px;
      transition: background-color 0.3s ease;
    }

    .back-btn:hover {
      background-color: #388e3c;
    }

    @media (max-width: 1024px) {
      .plants-list {
        grid-template-columns: repeat(3, 1fr);
      }
    }

    @media (max-width: 768px) {
      .plants-list {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    @media (max-width: 480px) {
      .plants-list {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>

<div class="detail-container">
  <img src="img/<?php echo htmlspecialchars($nursery['image']); ?>" alt="Image de la pépinière">
  <h2><?php echo htmlspecialchars($nursery['name']); ?></h2>
  <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($nursery['description'])); ?></p>
  <p><strong>Adresse:</strong> <?php echo htmlspecialchars($nursery['address']); ?></p>
  <p><strong>Téléphone:</strong> <?php echo htmlspecialchars($nursery['phone']); ?></p>
  <p><strong>Email:</strong> <?php echo htmlspecialchars($nursery['email']); ?></p>

  <div class="plants-section">
    <h3>Plantes disponibles dans cette pépinière :</h3>
    <div class="plants-list">
      <?php
      if ($result_plants->num_rows > 0) {
          while ($plant = $result_plants->fetch_assoc()) {
              echo '<div class="plant-item">';
              echo '<img src="img/' . htmlspecialchars($plant['image']) . '" alt="Image de la plante">';
              echo '<p><strong>' . htmlspecialchars($plant['name']) . '</strong></p>';
              echo '<p>' . nl2br(htmlspecialchars($plant['description'])) . '</p>';
              echo '<p class="price">' . number_format(htmlspecialchars($plant['price']), 2, ',', ' ') . ' DA</p>';
              echo '<a href="?id=' . $id . '&add_to_cart=' . $plant['id'] . '" class="add-to-cart-btn">Ajouter au panier</a>';
              echo '</div>';
          }
      } else {
          echo '<p>Aucune plante disponible pour cette pépinière.</p>';
      }
      ?>
    </div>
  </div>

  <a class="back-btn" href="pepiniere.php">← Retour à la liste</a>
</div>

</body>
</html>
