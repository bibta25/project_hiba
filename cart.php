<?php
session_start();
require('admin/includs/db.php');

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<p>Votre panier est vide.</p>";
    exit();
}

$plant_ids = array_keys($_SESSION['cart']);
$placeholders = implode(',', array_fill(0, count($plant_ids), '?'));

$stmt = $conn->prepare("SELECT * FROM plants WHERE id IN ($placeholders)");
$stmt->bind_param(str_repeat('i', count($plant_ids)), ...$plant_ids);
$stmt->execute();
$result_plants = $stmt->get_result();

$cart_total = 0;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Mon Panier</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f4f7f6;
      margin: 0;
      padding: 30px;
    }

    .cart-container {
      max-width: 900px;
      margin: 0 auto;
      background: #fff;
      padding: 30px;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
      border-radius: 10px;
    }

    .cart-item {
      display: flex;
      justify-content: space-between;
      margin-bottom: 20px;
      border-bottom: 1px solid #ddd;
      padding-bottom: 10px;
    }

    .cart-item img {
      width: 100px;
      height: 100px;
      object-fit: cover;
      border-radius: 8px;
    }

    .cart-item .details {
      flex: 1;
      padding-left: 20px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .cart-item .details p {
      margin: 0;
    }

    .remove-btn {
      color: red;
      cursor: pointer;
      text-decoration: underline;
    }

    .total {
      font-size: 18px;
      font-weight: bold;
      margin-top: 30px;
    }

    .checkout-btn {
      background-color: #4caf50;
      color: white;
      padding: 10px 20px;
      border-radius: 10px;
      text-decoration: none;
      transition: background-color 0.3s ease;
    }

    .checkout-btn:hover {
      background-color: #388e3c;
    }

    .quantity-form {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-top: 10px;
    }

    .quantity-form button {
      padding: 5px 10px;
      font-size: 16px;
      background-color: #4caf50;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .quantity-form button:hover {
      background-color: #388e3c;
    }

    .quantity-form span {
      font-size: 16px;
      font-weight: bold;
    }
  </style>
</head>
<body>

<div class="cart-container">
  <h2>Mon Panier</h2>

  <?php
  while ($plant = $result_plants->fetch_assoc()) {
      $id = $plant['id'];
      $quantity = $_SESSION['cart'][$id];
      $subtotal = $plant['price'] * $quantity;

      echo '<div class="cart-item">';
      echo '<img src="img/' . htmlspecialchars($plant['image']) . '" alt="Image de la plante">';
      echo '<div class="details">';
      echo '<p><strong>' . htmlspecialchars($plant['name']) . '</strong></p>';
      echo '<p>' . nl2br(htmlspecialchars($plant['description'])) . '</p>';
      echo '<p>Prix unitaire: DA' . number_format($plant['price'], 2, ',', ' ') . '</p>';
      echo '<form method="post" action="update_cart.php" class="quantity-form">';
      echo '<input type="hidden" name="plant_id" value="' . $id . '">';
      echo '<button type="submit" name="action" value="decrease">-</button>';
      echo '<span>' . $quantity . '</span>';
      echo '<button type="submit" name="action" value="increase">+</button>';
      echo '</form>';
      echo '<p>Sous-total: DA' . number_format($subtotal, 2, ',', ' ') . '</p>';
      echo '</div>';
      echo '<a href="remove_from_cart.php?id=' . $id . '" class="remove-btn">Supprimer</a>';
      echo '</div>';

      $cart_total += $subtotal;
  }
  ?>

  <p class="total">Total: €<?php echo number_format($cart_total, 2, ',', ' '); ?></p>
  <a href="checkout.php" class="checkout-btn">Procéder à la commande</a>
</div>

</body>
</html>
