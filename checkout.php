<?php
session_start();
require('admin/includs/db.php');

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<p>Votre panier est vide.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Finaliser la commande</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #e9f5ec;
            margin: 0;
            padding: 40px;
        }

        .form-container {
            max-width: 700px;
            margin: auto;
            background-color: #ffffff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-bottom: 30px;
            font-weight: 600;
            color: #2e7d32;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 500;
            color: #333;
        }

        input, textarea, select {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
        }

        textarea {
            resize: vertical;
        }

        button {
            background-color: #4caf50;
            color: white;
            font-size: 16px;
            padding: 14px 24px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #388e3c;
        }

        .note {
            font-size: 14px;
            color: #666;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Formulaire de Commande</h2>
    <form action="process_order.php" method="POST">
        <label for="fullname">Nom complet</label>
        <input type="text" name="fullname" id="fullname" required>

        <label for="email">Adresse email</label>
        <input type="email" name="email" id="email" required>

        <label for="phone">Numéro de téléphone</label>
        <input type="text" name="phone" id="phone" required>

        <label for="address">Adresse complète</label>
        <textarea name="address" id="address" rows="4" required placeholder="Rue, Ville, Code postal..."></textarea>

        <label for="city">Ville</label>
        <input type="text" name="city" id="city" required>

        <label for="zipcode">Code Postal</label>
        <input type="text" name="zipcode" id="zipcode" required>

        <label for="payment_method">Mode de paiement</label>
        <select name="payment_method" id="payment_method" required>
            <option value="">-- Choisissez --</option>
            <option value="cash">Paiement à la livraison</option>
            <option value="card">Carte bancaire</option>
            <option value="paypal">PayPal</option>
        </select>

        <label for="notes">Notes (facultatif)</label>
        <textarea name="notes" id="notes" rows="3" placeholder="Instructions de livraison..."></textarea>

        <button type="submit">Valider la commande</button>
    </form>
</div>

</body>
</html>
