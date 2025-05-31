<?php
session_start();
require('admin/includs/db.php');

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "Votre panier est vide.";
    exit();
}

// Récupération des données du formulaire
$fullname = $_POST['fullname'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$city = $_POST['city'];
$zipcode = $_POST['zipcode'];
$payment_method = $_POST['payment_method'];
$notes = $_POST['notes'] ?? '';

// Insertion de la commande
$stmt = $conn->prepare("INSERT INTO orders (fullname, email, phone, address, city, zipcode, payment_method, notes, created_at) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
$stmt->bind_param("ssssssss", $fullname, $email, $phone, $address, $city, $zipcode, $payment_method, $notes);
$stmt->execute();
$order_id = $stmt->insert_id;

// Enregistrement des plantes commandées
foreach ($_SESSION['cart'] as $plant_id) {
    $stmt = $conn->prepare("INSERT INTO order_items (order_id, plant_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $order_id, $plant_id);
    $stmt->execute();
}

unset($_SESSION['cart']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Commande réussie</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }

    .confirmation-box {
      background: #fff;
      padding: 40px;
      max-width: 600px;
      width: 90%;
      border-radius: 20px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.1);
      text-align: center;
      animation: fadeIn 0.6s ease-in-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .confirmation-box h2 {
      color: #2e7d32;
      margin-bottom: 10px;
      font-size: 28px;
    }

    .confirmation-box p {
      color: #555;
      margin-bottom: 10px;
      font-size: 16px;
    }

    .icon-check {
      font-size: 60px;
      color: #4caf50;
      margin-bottom: 20px;
    }

    .btn {
      margin-top: 25px;
      display: inline-block;
      background-color: #4caf50;
      color: white;
      padding: 14px 28px;
      border-radius: 8px;
      font-size: 16px;
      text-decoration: none;
      transition: background-color 0.3s ease;
    }

    .btn:hover {
      background-color: #388e3c;
    }

    @media (max-width: 600px) {
      .confirmation-box {
        padding: 25px;
      }

      .confirmation-box h2 {
        font-size: 22px;
      }

      .btn {
        padding: 12px 24px;
        font-size: 15px;
      }
    }
  </style>
</head>
<body>

<div class="confirmation-box">
  <div class="icon-check">✅</div>
  <h2>Commande confirmée !</h2>
  <p><strong><?php echo htmlspecialchars($fullname); ?></strong>, merci pour votre commande.</p>
  <p>Un email de confirmation a été envoyé à <strong><?php echo htmlspecialchars($email); ?></strong>.</p>
  <p>Mode de paiement : <strong><?php echo htmlspecialchars(ucfirst($payment_method)); ?></strong></p>
  <a href="index.php" class="btn">Retour à l'accueil</a>
</div>

</body>
</html>
