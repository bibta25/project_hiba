<?php
require('admin/includs/db.php');

// Fetch all nurseries
$sql = "SELECT * FROM pepiniere";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Nurseries - MACHTALATY</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="icon" href="../project_hiba/img/3.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
      scroll-behavior: smooth;
    }
    body {
      background-color: #f7fdf9;
      color: #094b22;
    }
    nav {
      background: #fff;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      position: sticky;
      top: 0;
      width: 100%;
      z-index: 1000;
      animation: slideDown 1s ease forwards;
    }
    @keyframes slideDown {
      from { top: -80px; opacity: 0; }
      to { top: 0; opacity: 1; }
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
      transition: transform 0.5s ease;
    }
    .logo img:hover {
      transform: rotate(5deg) scale(1.1);
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
      position: relative;
      transition: color 0.3s;
    }
    .nav-links ul li a::after {
      content: "";
      height: 2px;
      background: #4caf50;
      width: 0;
      position: absolute;
      left: 0;
      bottom: -5px;
      transition: 0.3s;
    }
    .nav-links ul li a:hover::after {
      width: 100%;
    }
    .search-bar {
      padding: 8px 15px;
      border: 2px solid #4caf50;
      border-radius: 20px;
      outline: none;
      margin-left: 20px;
      transition: 0.3s;
    }
    .search-bar:focus {
      box-shadow: 0 0 8px #4caf50;
    }
    .icons {
      display: flex;
      align-items: center;
      gap: 15px;
    }
    .icons a {
      color: #4caf50;
      font-size: 22px;
      transition: transform 0.3s ease, color 0.3s;
    }
    .icons a:hover {
      transform: scale(1.2);
      color: #2e7d32;
    }
    .login-icon, .lang-switcher {
      position: relative;
    }
    .login-dropdown, .lang-dropdown {
      position: absolute;
      top: 35px;
      right: 0;
      background: #fff;
      border: 1px solid #4caf50;
      border-radius: 10px;
      display: none;
      flex-direction: column;
      min-width: 130px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      z-index: 500;
      animation: fadeIn 0.3s ease-in-out;
    }
    .login-dropdown a, .lang-dropdown a {
      padding: 10px;
      text-align: center;
      color: #094b22;
      text-decoration: none;
      font-weight: 600;
    }
    .login-dropdown a:hover, .lang-dropdown a:hover {
      background-color: #4caf50;
      color: #fff;
    }
    .login-icon:hover .login-dropdown,
    .lang-switcher:hover .lang-dropdown {
      display: flex;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .container {
      max-width: 1100px;
      margin: 40px auto;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 30px;
      padding: 0 20px;
    }
    .card {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      transition: transform 0.3s ease;
      display: flex;
      flex-direction: column;
    }
    .card:hover {
      transform: translateY(-5px);
    }
    .card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
    }
    .card-content {
      padding: 20px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }
    .card-content h3 {
      margin: 0 0 10px;
      color: #2e7d32;
      font-size: 20px;
      font-weight: bold;
    }
    .card-content p {
      margin: 6px 0;
      color: #555;
      font-size: 14px;
    }
    .card-content i {
      color: #4caf50;
      margin-right: 6px;
    }
    .more-btn {
      margin-top: 12px;
      background-color: #4caf50;
      color: #fff;
      padding: 8px 14px;
      border-radius: 20px;
      text-decoration: none;
      font-size: 14px;
      width: fit-content;
      transition: background-color 0.3s;
    }
    .more-btn:hover {
      background-color: #2e7d32;
    }
    .rating-stars i {
      color: gold;
      margin-right: 3px;
    }
    .rating-form {
      margin-top: 10px;
    }
    .rating-form select, .rating-form button {
      padding: 6px 10px;
      margin-right: 5px;
      border-radius: 6px;
      border: 1px solid #4caf50;
      font-size: 14px;
    }
    .rating-form button {
      background-color: #4caf50;
      color: white;
      cursor: pointer;
    }
    .rating-form button:hover {
      background-color: #2e7d32;
    }
  </style>
</head>
<body>

<nav>
  <div class="navbar">
    <div class="logo">
      <img src="../project_hiba/img/3.png" alt="Logo">
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
      <input type="text" class="search-bar" placeholder="Search...">
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

<div class="container">
  <?php while ($row = $result->fetch_assoc()): ?>
    <div class="card">
      <img src="img/<?php echo $row['image']; ?>" alt="Nursery Image">
      <div class="card-content">
        <h3><?php echo htmlspecialchars($row['name']); ?></h3>
        <p><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($row['address']); ?></p>
        <p><i class="fas fa-phone"></i> <?php echo htmlspecialchars($row['phone']); ?></p>
        <p><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($row['email']); ?></p>
        <p>Rating: <?php echo round($row['rating'], 1); ?> / 5</p>
        <p class="rating-stars">
          <?php
            $avg = $row['rating'];
            $full = floor($avg);
            $half = ($avg - $full) >= 0.5;
            for ($i = 0; $i < $full; $i++) echo '<i class="fas fa-star"></i>';
            if ($half) echo '<i class="fas fa-star-half-alt"></i>';
            for ($i = $full + $half; $i < 5; $i++) echo '<i class="far fa-star"></i>';
          ?>
        </p>
        <form class="rating-form" method="post" action="rate_pepiniere.php">
          <input type="hidden" name="pepiniere_id" value="<?php echo $row['id']; ?>">
          <label>Rate this nursery:</label>
          <select name="rating" required>
            <option value="">Choose</option>
            <option value="1">1 star</option>
            <option value="2">2 stars</option>
            <option value="3">3 stars</option>
            <option value="4">4 stars</option>
            <option value="5">5 stars</option>
          </select>
          <button type="submit">Submit</button>
        </form>
        <a href="details_pepiniere.php?id=<?php echo $row['id']; ?>" class="more-btn">More Info</a>
      </div>
    </div>
  <?php endwhile; ?>
</div>

</body>
</html>