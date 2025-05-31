<?php
require('admin/includs/db.php');

$error = '';
$admin_exists = false;

// Vérifie si un admin existe déjà
$checkAdmin = $conn->query("SELECT id FROM users WHERE role = 'admin' LIMIT 1");
if ($checkAdmin && $checkAdmin->num_rows > 0) {
    $admin_exists = true;
}

if (isset($_POST['signup'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $role = $_POST['user_type'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Email invalide.";
    } elseif ($password !== $confirmPassword) {
        $error = "Les mots de passe ne correspondent pas.";
    } elseif (strlen($password) < 6) {
        $error = "Le mot de passe doit contenir au moins 6 caractères.";
    } elseif ($role === 'admin' && $admin_exists) {
        $error = "Un administrateur existe déjà.";
    } else {
        // Vérifier si l'email est déjà utilisé
        $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $error = "Cet email est déjà utilisé.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO users (email, password, role) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $email, $hashedPassword, $role);

            if ($stmt->execute()) {
                $new_user_id = $conn->insert_id;

                if ($role === 'proprietaire') {
                    $stmtProprio = $conn->prepare("INSERT INTO proprietaire (user_id) VALUES (?)");
                    $stmtProprio->bind_param("i", $new_user_id);
                    if (!$stmtProprio->execute()) {
                        $error = "Utilisateur créé, mais erreur lors de l'ajout en tant que propriétaire.";
                    }
                    $stmtProprio->close();
                }

                if (empty($error)) {
                    echo "<script>alert('Compte créé avec succès !'); window.location.href = 'loginM.php';</script>";
                    exit;
                }
            } else {
                $error = "Erreur lors de la création du compte.";
            }
            $stmt->close();
        }
        $check->close();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Cairo', sans-serif;
            margin: 0;
            padding: 0;
        }

        body {
            background: linear-gradient(135deg, #a8e063, #56ab2f);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .signup-container {
            background: #fff;
            display: flex;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
            height: 500px;
        }

        .signup-image {
            flex: 1;
            background-image: url('img/2.png');
            background-size: cover;
            background-position: center;
            height: 100%;
        }

        .signup-form {
            flex: 1;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .signup-form h2 {
            color: #2e7d32;
            margin-bottom: 25px;
            text-align: center;
            font-size: 32px;
            font-weight: bold;
        }

        .signup-form input,
        .signup-form select {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 2px solid #4caf50;
            border-radius: 8px;
            font-size: 16px;
            outline: none;
            transition: all 0.3s ease;
        }

        .signup-form input:focus,
        .signup-form select:focus {
            border-color: #2e7d32;
        }

        .signup-form button {
            background: #4caf50;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }

        .signup-form button:hover {
            background: #2e7d32;
        }

        .signup-form a {
            display: block;
            margin-top: 15px;
            color: #333;
            text-decoration: none;
            text-align: center;
            font-size: 14px;
        }

        .signup-form a:hover {
            color: #4caf50;
        }

        @media (max-width: 768px) {
            .signup-container {
                flex-direction: column;
                height: auto;
            }

            .signup-image {
                height: 200px;
            }

            .signup-form {
                padding: 20px;
            }

            .signup-form h2 {
                font-size: 28px;
            }
        }
    </style>
</head>
<body>

<div class="signup-container">
    <div class="signup-image"></div>
    <div class="signup-form">
        <h2>Inscription</h2>
        <form method="POST">
            <?php if (!empty($error)): ?>
                <div style="color: red; text-align: center; margin-bottom: 10px;"><?php echo $error; ?></div>
            <?php endif; ?>

            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Mot de passe" required minlength="6">
            <input type="password" name="confirm_password" placeholder="Confirmer le mot de passe" required minlength="6">

            <select name="user_type" required>
                <?php if (!$admin_exists): ?>
                    <option value="admin">Admin</option>
                <?php endif; ?>
                <option value="proprietaire">Propriétaire</option>
            </select>

            <button type="submit" name="signup">S'inscrire</button>
            <a href="loginM.php">Vous avez déjà un compte ? Se connecter</a>
        </form>
    </div>
</div>

</body>
</html>