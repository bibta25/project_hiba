<?php
session_start();
require('admin/includs/db.php'); // database connection

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: loginM.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch nurseries for this user
$sql = "SELECT * FROM pepiniere WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>My Nurseries</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f8ff;
            margin: 0;
            padding: 0 20px;
            color: #333;
        }
        header {
            background-color: #2e7d32;
            color: white;
            padding: 20px 0;
            text-align: center;
            font-size: 1.8rem;
            font-weight: bold;
        }
        main {
            max-width: 800px;
            margin: 30px auto;
            background: white;
            padding: 25px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(46,125,50,0.3);
        }
        h1 {
            margin-bottom: 20px;
            color: #2e7d32;
        }
        a.button {
            display: inline-block;
            background-color: #4caf50;
            color: white;
            padding: 12px 22px;
            text-decoration: none;
            font-weight: 600;
            border-radius: 6px;
            margin-bottom: 25px;
            transition: background-color 0.3s ease;
        }
        a.button:hover {
            background-color: #388e3c;
        }
        ul {
            list-style: none;
            padding-left: 0;
        }
        ul li {
            background: #e8f5e9;
            border: 1px solid #c8e6c9;
            margin-bottom: 12px;
            border-radius: 6px;
            padding: 14px 20px;
            font-size: 1.1rem;
            transition: background-color 0.3s ease;
        }
        ul li a {
            color: #2e7d32;
            text-decoration: none;
            display: block;
        }
        ul li:hover {
            background: #c8e6c9;
        }
        /* Responsive */
        @media (max-width: 500px) {
            body {
                padding: 10px;
            }
            main {
                padding: 20px 15px;
            }
            a.button {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <header>
        My Nurseries
    </header>
    <main>
        <h1>Your Nurseries</h1>

        <a href="ajouter_pepiniere.php" class="button">Add New Nursery</a>

        <?php if ($result->num_rows > 0): ?>
            <ul>
                <?php while($row = $result->fetch_assoc()) : ?>
                    <li>
                        <a href="pepiniere_dashboard.php?id=<?= $row['id'] ?>">
                            <?= htmlspecialchars($row['name']) ?>
                        </a>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>You have not added any nurseries yet.</p>
        <?php endif; ?>
    </main>
</body>
</html>
