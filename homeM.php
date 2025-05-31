<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>MACHTALATY</title>
  <meta name="description" content="مشتلتي - اكتشف أجمل النباتات لمنزلك ومكان عملك.">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="icon" href="../project_hiba/img/3.png">

  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; scroll-behavior: smooth; }
    body { background-color: #f7fdf9; color: #094b22; position: relative; }

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

    .main {
      min-height: 90vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      background: linear-gradient(rgba(9,75,34,0.7), rgba(76,175,80,0.7)), url('../project_hiba/img/10.jpg') no-repeat center/cover;
      color: #fff;
      padding: 0 20px;
      animation: fadeIn 1s ease;
    }

    .main h1 {
      font-size: 50px;
      margin-bottom: 20px;
      animation: bounceIn 1.2s;
    }

    @keyframes bounceIn {
      0% { transform: scale(0.8); opacity: 0; }
      50% { transform: scale(1.05); opacity: 1; }
      100% { transform: scale(1); }
    }

    .main p {
      font-size: 18px;
      margin-bottom: 30px;
      animation: fadeIn 2s;
    }

    .main a {
      padding: 12px 25px;
      background: #4caf50;
      color: #fff;
      border-radius: 30px;
      text-decoration: none;
      font-weight: 600;
      transition: background 0.3s, transform 0.3s;
    }

    .main a:hover {
      background: #2e7d32;
      transform: scale(1.05);
    }

    footer {
      background: #ffffff;
      text-align: center;
      padding: 30px 10px;
      font-size: 16px;
      color: #094b22;
      border-top: 1px solid #ccc;
    }

    footer .contact-info {
      margin-bottom: 10px;
    }

    footer .contact-info a {
      color: #094b22;
      text-decoration: none;
      font-weight: 600;
    }

    footer .contact-info a:hover {
      color: #4caf50;
    }

    #scrollToTopBtn {
      position: fixed;
      bottom: 20px;
      right: 20px;
      background-color: #4caf50;
      color: white;
      border: none;
      padding: 12px 16px;
      border-radius: 50%;
      font-size: 18px;
      cursor: pointer;
      display: none;
      box-shadow: 0 2px 8px rgba(0,0,0,0.2);
      transition: background 0.3s, transform 0.3s;
    }

    #scrollToTopBtn:hover {
      background: #2e7d32;
      transform: scale(1.1);
    }
  </style>
</head>

<body>

<!-- Navigation -->
<nav>
  <div class="navbar">
    <div class="logo">
      <img src="../project_hiba/img/3.png" alt="شعار مشتلتي">
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

<!-- Main Section -->
<section class="main">
  <h1 id="welcome-text">Welcome to <span>MACHTALATY</span></h1>
  <p id="desc-text">Discover a beautiful collection of plants that bring life to your home and workspace.</p>
  <a href="plantesM.php" class="main_btn" id="discover-btn">Discover Now</a>
</section>

<!-- Footer -->
<footer>
  <div class="contact-info">
    📞 Phone: <a href="tel:+213123456789">+213 123 456 789</a><br>
    📧 Email: <a href="mailto:contact@machtalaty.dz">contact@machtalaty.dz</a>
  </div>
  <p>&copy; 2025 MACHTALATY. All rights reserved.</p>
</footer>

<!-- Scroll Button -->
<button onclick="topFunction()" id="scrollToTopBtn" title="Go to top">
  <i class="fas fa-arrow-up"></i>
</button>

<!-- Scripts -->
<script>
const translations = {
  "en": {
    "welcome": "Welcome to <span>MACHTALATY</span>",
    "description": "Discover a beautiful collection of plants that bring life to your home and workspace.",
    "button": "Discover Now"
  },
  "ar": {
    "welcome": "مرحبًا بك في <span>مشتلتي</span>",
    "description": "اكتشف مجموعة رائعة من النباتات التي تضفي الحياة على منزلك ومكان عملك.",
    "button": "اكتشف الآن"
  },
  "fr": {
    "welcome": "Bienvenue chez <span>MACHTALATY</span>",
    "description": "Découvrez une belle collection de plantes qui apportent de la vie à votre maison et votre espace de travail.",
    "button": "Découvrir maintenant"
  }
};

function changeLanguage(lang) {
  localStorage.setItem("lang", lang);
  updateText(lang);
}

function updateText(lang) {
  document.getElementById('welcome-text').innerHTML = translations[lang].welcome;
  document.getElementById('desc-text').innerText = translations[lang].description;
  document.getElementById('discover-btn').innerText = translations[lang].button;
}

window.onload = () => {
  const savedLang = localStorage.getItem("lang") || "en";
  updateText(savedLang);
};

let mybutton = document.getElementById("scrollToTopBtn");
window.onscroll = function () {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
};

function topFunction() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}
</script>

</body>
</html>
