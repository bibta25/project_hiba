<?php
session_start();

if (!isset($_POST['plant_id'], $_POST['action'])) {
    header('Location: cart.php');
    exit();
}

$plant_id = (int) $_POST['plant_id'];
$action = $_POST['action'];

if (!isset($_SESSION['cart'][$plant_id])) {
    header('Location: cart.php');
    exit();
}

if ($action === 'increase') {
    $_SESSION['cart'][$plant_id]++;
} elseif ($action === 'decrease') {
    if ($_SESSION['cart'][$plant_id] > 1) {
        $_SESSION['cart'][$plant_id]--;
    } else {
        unset($_SESSION['cart'][$plant_id]); // Supprime si quantité tombe à 0
    }
}

header('Location: cart.php');
exit();
