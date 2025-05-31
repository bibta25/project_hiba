<?php
session_start();

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $plant_id = intval($_GET['id']);
    if (isset($_SESSION['cart'][$plant_id])) {
        unset($_SESSION['cart'][$plant_id]);
    }
}

header("Location: cart.php");
exit();
