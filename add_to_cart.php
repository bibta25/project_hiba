<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $quantity = intval($_POST['quantity']);
    if ($quantity < 1) $quantity = 1;

    // إذا الكارت ما كيناش في السيشن، نخلقوها
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // إذا المنتج موجود في الكارت نزود الكمية، إذا لا نضيفه مع الكمية
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] += $quantity;
    } else {
        $_SESSION['cart'][$id] = $quantity;
    }
}

header('Location: products.php'); // أو أي صفحة تريد ترجع لها
exit();
