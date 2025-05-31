<?php
require('admin/includs/db.php');
session_start();

if (isset($_POST['login'])) {
    $email    = $_POST['email'];
    $password = $_POST['password'];

    try {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_role'] = $user['role'];

            if ($user['role'] === 'admin') {
                header('Location: admin/adminM_plantes.php');
                exit;
            } elseif ($user['role'] === 'proprietaire') {
                $checkPepiniere = $conn->prepare("SELECT * FROM pepiniere WHERE user_id = ?");
                $checkPepiniere->bind_param("i", $user['id']);
                $checkPepiniere->execute();
                $pepiniere_result = $checkPepiniere->get_result();

                if ($pepiniere_result->num_rows > 0) {
                    header('Location: mes_pepinieres.php');
                    exit;
                } else {
                    echo "<script>
                        alert('No nursery found. You can create one now.');
                        window.location.href = 'ajouter_pepiniere.php';
                    </script>";
                    exit;
                }
            } else {
                echo "<script>alert('Unknown user role.');</script>";
            }
        } else {
            echo "<script>alert('Incorrect email or password.');</script>";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
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

        .login-container {
            background: #fff;
            display: flex;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
        }

        .login-image {
            flex: 1;
            background-image: url('img/2.png'); /* Change to your actual image path */
            background-size: cover;
            background-position: center;
        }

        .login-form {
            flex: 1;
            padding: 50px;
        }

        .login-form h2 {
            color: #2e7d32;
            margin-bottom: 25px;
            text-align: center;
        }

        .login-form input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 2px solid #4caf50;
            border-radius: 8px;
            font-size: 16px;
        }

        .login-form button {
            background: #4caf50;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 10px;
        }

        .login-form button:hover {
            background: #2e7d32;
        }

        .login-form a {
            display: block;
            margin-top: 15px;
            color: #333;
            text-decoration: none;
            text-align: center;
        }

        .login-form a:hover {
            color: #4caf50;
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="login-image"></div>
    <div class="login-form">
        <h2>Login</h2>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Login</button>
            <a href="signupM.php">Don't have an account? Sign up here</a>
        </form>
    </div>
</div>

</body>
</html>
