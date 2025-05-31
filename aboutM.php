<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>About | MACHTALATY</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
  <link rel="icon" href="../project_hiba/img/3.png" />
  <style>
    /* --- أنماط الناف بار (من الصفحة الأولى) --- */
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; scroll-behavior: smooth; }
    body { background-color: #f7fdf9; color: #094b22; position: relative; min-height: 100vh; display: flex; flex-direction: column; }

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

    .logo img { width: 80px; transition: transform 0.5s ease; }
    .logo img:hover { transform: rotate(5deg) scale(1.1); }

    .nav-links { display: flex; align-items: center; gap: 25px; }

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

    .login-icon:hover .login-dropdown, .lang-switcher:hover .lang-dropdown {
      display: flex;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    /* --- أنماط صفحة About --- */
    main {
      max-width: 900px;
      margin: 3rem auto;
      padding: 0 1rem;
      display: flex;
      gap: 3rem;
      align-items: center;
      flex-wrap: wrap;
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(76,175,80,0.15);
      transition: box-shadow 0.3s ease;
      color: #2f4f2f;
      flex: 1; /* لملء المساحة الرأسية المتبقية */
    }
    main:hover {
      box-shadow: 0 12px 30px rgba(76,175,80,0.3);
    }
    main .text {
      flex: 1 1 400px;
      color: #2f4f2f;
    }
    main .text h2 {
      font-size: 2rem;
      margin-bottom: 1rem;
      font-weight: 700;
      border-left: 6px solid #4caf50;
      padding-left: 12px;
      transition: color 0.3s ease;
    }
    main .text p {
      font-size: 1.1rem;
      line-height: 1.7;
      color: #2f4f2f;
      margin-bottom: 1rem;
    }
    main .image {
      flex: 1 1 350px;
      text-align: center;
      perspective: 1000px;
    }
    main .image img {
      max-width: 100%;
      border-radius: 15px;
      box-shadow: 0 10px 20px rgba(76,175,80,0.15);
      transition: transform 0.4s ease, box-shadow 0.4s ease;
      cursor: pointer;
      transform-style: preserve-3d;
    }
    main .image img:hover {
      transform: rotateY(10deg) scale(1.05);
      box-shadow: 0 15px 30px rgba(76,175,80,0.3);
    }

    footer {
      background: #4caf50;
      color: white;
      text-align: center;
      padding: 1rem;
      font-weight: 500;
      letter-spacing: 1px;
      font-size: 0.9rem;
      margin-top: auto;
    }
    footer a {
      color: #c8e6c9;
      text-decoration: none;
      margin-left: 1rem;
      font-weight: 600;
    }
    footer a:hover {
      text-decoration: underline;
    }

    @media (max-width: 720px) {
      main {
        flex-direction: column;
      }
      main .text, main .image {
        flex: 1 1 100%;
      }
    }
  </style>
</head>

<body>

<!-- Navigation (من الصفحة الأولى) -->
<nav>
  <div class="navbar">
    <div class="logo">
      <img src="../project_hiba/img/3.png" alt="شعار مشتلتي" />
    </div>

    <div class="nav-links">
      <ul>
        <li><a href="homeM.php">Home</a></li>
        <li><a href="aboutM.php" class="active">About</a></li>
        <li><a href="plantesM.php">Plants</a></li>
        <li><a href="pepiniere.php">Nurseries</a></li>
        <li><a href="blogM.php">Blog</a></li>
        <li><a href="contactM.php">Contact</a></li>
      </ul>

      <input type="text" class="search-bar" placeholder="Search..." />

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
            <a href="aboutM.php?lang=ar">العربية</a>
            <a href="aboutM.php?lang=en">English</a>
            <a href="aboutM.php?lang=fr">Français</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</nav>

<!-- Main content About -->
<main>
  <div class="text">
    <h2>About MACHTALATY</h2>
    <p>
      MACHTALATY is your dedicated plant nursery and gardening partner. We provide
      a wide selection of healthy plants, expert gardening tips, and
      eco-friendly solutions to help you create your perfect green space.
    </p>
    <p>
      Our mission is to spread the love for plants and nature, promoting sustainable
      gardening practices across all communities.
    </p>
    <p>
      Whether you are a beginner or an experienced gardener, MACHTALATY is here
      to support your journey with quality plants and reliable advice.
    </p>
  </div>
  <div class="image">
    <img src="../project_hiba/img/10.jpg" alt="Plant Image About" />
  </div>
</main>

<!-- Footer -->
<footer>
  &copy; 2025 MACHTALATY. All rights reserved.
  <a href="privacyM.php">Privacy Policy</a>
  <a href="termsM.php">Terms of Service</a>
</footer>

</body>
</html>
