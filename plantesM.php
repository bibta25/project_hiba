<?php
session_start();
include 'config.php';

// Gestion du filtre via GET
$type_filter = isset($_GET['type']) ? $_GET['type'] : '';

// Requête pour obtenir tous les types distincts
$query_types = "SELECT DISTINCT type FROM plantes";
$result_types = mysqli_query($conn, $query_types);

// Requête pour obtenir les plantes selon filtre
if ($type_filter && $type_filter != '') {
    $type_filter_safe = mysqli_real_escape_string($conn, $type_filter);
    $query_plantes = "SELECT * FROM plantes WHERE type = '$type_filter_safe'";
} else {
    $query_plantes = "SELECT * FROM plantes";
}
$result_plantes = mysqli_query($conn, $query_plantes);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Nos Plantes</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <link rel="icon" href="img/3.png" />
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: rgb(244, 247, 244);
      margin: 0;
      padding: 0;
      color: #333;
    }
    nav {
      background: #fff;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      position: sticky;
      top: 0;
      width: 100%;
      z-index: 1000;
    }
    .navbar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 10px 30px;
      flex-wrap: wrap;
    }
    .logo img {
      width: 80px;
    }
    .nav-links {
      display: flex;
      align-items: center;
      gap: 25px;
    }
    .nav-links ul {
      list-style: none;
      display: flex;
      gap: 20px;
    }
    .nav-links ul li a {
      text-decoration: none;
      color: #094b22;
      font-weight: 600;
      font-size: 18px;
      transition: color 0.3s;
    }
    .nav-links ul li a:hover {
      color: #4caf50;
    }
    .search-bar {
      padding: 8px 15px;
      border: 2px solid #4caf50;
      border-radius: 20px;
      outline: none;
      margin-left: 20px;
    }
    .icons {
      display: flex;
      align-items: center;
      gap: 15px;
    }
    .icons a {
      color: #4caf50;
      font-size: 22px;
      transition: color 0.3s;
    }
    .icons a:hover {
      color: #2e7d32;
    }
    .login-icon,
    .lang-switcher {
      position: relative;
    }
    .login-dropdown,
    .lang-dropdown {
      position: absolute;
      top: 35px;
      right: 0;
      background: #fff;
      border: 1px solid #4caf50;
      border-radius: 10px;
      overflow: hidden;
      display: none;
      flex-direction: column;
      min-width: 130px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      z-index: 500;
    }
    .login-dropdown a,
    .lang-dropdown a {
      padding: 10px;
      text-align: center;
      color: #094b22;
      text-decoration: none;
      font-weight: 600;
      transition: background-color 0.3s;
    }
    .login-dropdown a:hover,
    .lang-dropdown a:hover {
      background-color: #4caf50;
      color: #fff;
    }
    .login-icon:hover .login-dropdown,
    .lang-switcher:hover .lang-dropdown {
      display: flex;
    }
    .container {
      max-width: 1200px;
      margin: 50px auto;
      padding: 20px;
      background-color: #fff;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
      border-radius: 10px;
    }

    /* Boutons filtre */
    .filter-buttons {
      text-align: center;
      margin-bottom: 20px;
    }
    .filter-buttons a {
      text-decoration: none;
      margin: 0 5px;
    }
    .filter-buttons button {
      padding: 6px 12px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-weight: 600;
      transition: background-color 0.3s;
    }
    .filter-buttons button.active {
      background-color: #4caf50;
      color: white;
    }
    .filter-buttons button:not(.active) {
      background-color: #ccc;
      color: black;
    }

    .plant-container {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 30px;
      padding: 20px;
    }

    .plant-card {
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(35, 192, 30, 0.9);
      overflow: hidden;
      transition: 0.3s;
      cursor: pointer;
    }

    .plant-card img {
      width: 100%;
      height: 250px;
      object-fit: cover;
      transition: transform 0.3s ease;
    }

    .plant-card img:hover {
      transform: scale(1.05);
    }

    .plant-card .info {
      padding: 20px;
      text-align: center;
    }

    .plant-card h3 {
      font-size: 22px;
      color: #2e7d32;
      margin-bottom: 10px;
      font-weight: 600;
    }

    @media (max-width: 768px) {
      .plant-card h3 {
        font-size: 18px;
      }

      .plant-card img {
        height: 200px;
      }
    }
  </style>
</head>
<body>
  <!-- Navigation -->
  <nav>
    <div class="navbar">
      <div class="logo">
        <img src="../project_hiba/img/3.png" alt="شعار مشتلتي" />
      </div>

      <div class="nav-links">
        <ul>
          <li><a href="homeM.php">Home</a></li>
          <li><a href="aboutM.php">About</a></li>
          <li><a href="plantesM.php">Plants</a></li>
          <li><a href="pepiniere.php">Nurseries</a></li>
          <li><a href="blogM.php">Blog</a></li>
          <li><a href="contactM.php">Contact</a></li>
        </ul>

        <form action="recherche.php" method="GET" style="display: flex; align-items: center;">
  <input type="text" name="search" class="search-bar" placeholder="Search..." />
</form>

        <div class="icons">
          <a href="cart.php"><i class="fas fa-shopping-cart"></i></a>

          <div class="login-icon">
            <a href="#"><i class="fas fa-seedling"></i></a>
            <div class="login-dropdown">
              <a href="loginM.php">Login</a>
              <a href="signupM.php">Sign Up</a>
            </div>
          </div>

          <div class="lang-switcher">
            <a href="#"><i class="fas fa-globe"></i></a>
            <div class="lang-dropdown">
              <a href="#" onclick="changeLanguage('ar')">العربية</a>
              <a href="#" onclick="changeLanguage('en')">English</a>
              <a href="#" onclick="changeLanguage('fr')">Français</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <!-- Conteneur principal des plantes -->
  <div class="container">
    <h1 style="text-align: center; color: #2e7d32; margin-bottom: 30px;">Nos Plantes</h1>

    <!-- Boutons de filtre par type -->
    <div class="filter-buttons">
      <a href="plantesM.php">
        <button class="<?php echo ($type_filter == '') ? 'active' : ''; ?>">all</button>
      </a>
      <?php
      // Remise à zéro du pointeur pour réutiliser $result_types
      mysqli_data_seek($result_types, 0);
      while ($type = mysqli_fetch_assoc($result_types)) {
          $activeClass = ($type_filter == $type['type']) ? 'active' : '';
      ?>
        <a href="plantesM.php?type=<?php echo urlencode($type['type']); ?>">
          <button class="<?php echo $activeClass; ?>"><?php echo htmlspecialchars($type['type']); ?></button>
        </a>
      <?php } ?>
    </div>

    <!-- Affichage des plantes -->
    <div class="plant-container">
      <?php
      if (mysqli_num_rows($result_plantes) > 0) {
          while ($row = mysqli_fetch_assoc($result_plantes)) {
      ?>
            <div class="plant-card" onclick="window.location.href='plant_detail.php?id=<?php echo $row['id']; ?>'">
              <img src="admin/uploaded_img/<?php echo htmlspecialchars($row['image']); ?>" alt="Image de la plante" />
              <div class="info">
                <h3><?php echo htmlspecialchars($row['nom']); ?></h3>
              </div>
            </div>
      <?php
          }
      } else {
          echo "<h2 style='text-align:center;'>Aucune plante trouvée!</h2>";
      }
      ?>
    </div>
  </div>
</body>
</html>
