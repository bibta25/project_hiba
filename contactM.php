<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title id="title">Contact - MACHTALATY</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  <link rel="icon" href="../project_hiba/img/3.png">

  <style>
    /* ---- STYLES (نفس لي عندك) ---- */
    * {margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif;}
    body {background: #f0fdf4; color: #094b22;}
    nav {background: #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.1); position: sticky; top: 0; width: 100%; z-index: 1000;}
    .navbar {display: flex; align-items: center; justify-content: space-between; padding: 10px 30px; flex-wrap: wrap;}
    .logo img {width: 80px;}
    .nav-links {display: flex; align-items: center; gap: 25px;}
    .nav-links ul {list-style: none; display: flex; gap: 20px;}
    .nav-links ul li a {text-decoration: none; color: #094b22; font-weight: 600; font-size: 18px; transition: color 0.3s;}
    .nav-links ul li a:hover {color: #4caf50;}
    .search-bar {padding: 8px 15px; border: 2px solid #4caf50; border-radius: 20px; outline: none; margin-left: 20px;}
    .icons {display: flex; align-items: center; gap: 15px;}
    .icons a {color: #4caf50; font-size: 22px; transition: color 0.3s;}
    .icons a:hover {color: #2e7d32;}
    .login-icon, .lang-switcher {position: relative;}
    .login-dropdown, .lang-dropdown {position: absolute; top: 35px; right: 0; background: #fff; border: 1px solid #4caf50; border-radius: 10px; overflow: hidden; display: none; flex-direction: column; min-width: 130px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); z-index: 500;}
    .login-dropdown a, .lang-dropdown a {padding: 10px; text-align: center; color: #094b22; text-decoration: none; font-weight: 600; transition: background-color 0.3s;}
    .login-dropdown a:hover, .lang-dropdown a:hover {background-color: #4caf50; color: #fff;}
    .login-icon:hover .login-dropdown, .lang-switcher:hover .lang-dropdown {display: flex;}

    /* Contact Section */
    .contact-container {display: flex; justify-content: center; align-items: center; padding: 80px 5%; gap: 50px; flex-wrap: wrap;}
    .contact form {flex: 1 1 500px; background: white; padding: 30px; border-radius: 15px; box-shadow: 0px 4px 12px rgba(0,0,0,0.1);}
    .contact form h3 {font-size: 30px; margin-bottom: 20px; text-align: center; color: #094b22;}
    .contact form .box {width: 100%; margin: 10px 0; padding: 12px; border: 2px solid #4caf50; border-radius: 8px; font-size: 16px; outline: none;}
    .contact form textarea {resize: none; height: 140px;}
    .contact form .btn {width: 100%; background: #4caf50; padding: 12px; border: none; border-radius: 8px; color: white; font-weight: bold; font-size: 16px; margin-top: 10px; cursor: pointer; transition: background 0.3s;}
    .contact form .btn:hover {background: #2e7d32;}

    /* Footer */
    footer {background: #d6f5d6; margin-top: 50px; padding: 40px 5%;}
    .footer_main {display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 30px;}
    .footer_main .tag h1 {color: #4caf50; margin-bottom: 10px;}
    .footer_main .tag p, .footer_main .tag a {color: #094b22; text-decoration: none; display: block; margin-bottom: 10px;}
    .footer_main .social_link i {font-size: 20px; margin-right: 10px; cursor: pointer;}
    .footer_main .social_link i:hover {color: #4caf50;}

    /* Scroll To Top */
    #scroll-top {position: fixed; right: 20px; bottom: 20px; background: #4caf50; color: #fff; padding: 12px; border-radius: 50%; cursor: pointer; font-size: 20px; display: none; transition: 0.3s;}
    #scroll-top:hover {background: #2e7d32;}
  </style>
</head>

<body>

<!-- Navbar -->
<nav>
  <div class="navbar">
    <div class="logo">
      <img src="../project_hiba/img/3.png" alt="Logo">
    </div>

    <div class="nav-links">
      <ul id="navList">
        <li><a href="homeM.php">Home</a></li>
        <li><a href="aboutM.php">About</a></li>
        <li><a href="plantesM.php">Plants</a></li>
        <li><a href="pepiniere.php">Nurseries</a></li>
        <li><a href="blogM.php">Blog</a></li>
        <li><a href="contactM.php">Contact</a></li>
      </ul>

      <input type="text" class="search-bar" placeholder="Search..." id="searchPlaceholder">

      <div class="icons">
        <a href="#"><i class="fas fa-shopping-cart"></i></a>

        <div class="login-icon">
          <a href="#"><i class="fas fa-seedling"></i></a>
          <div class="login-dropdown">
            <a href="#">Login</a>
            <a href="#">Sign Up</a>
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

<!-- Contact Section -->
<section class="contact-container">
  <div class="contact">
    <form>
      <h3 id="contactTitle">Say Something!</h3>
      <input type="text" required placeholder="Enter your name" class="box" id="namePlaceholder">
      <input type="email" required placeholder="Enter your email" class="box" id="emailPlaceholder">
      <textarea class="box" placeholder="Enter your message" id="messagePlaceholder"></textarea>
      <input type="submit" value="Send Message" class="btn" id="sendBtn">
    </form>
  </div>
</section>

<!-- Footer -->
<footer>
  <div class="footer_main">
    <div class="tag">
      <h1>MACHTALATY</h1>
      <p id="footerDesc">Your favorite plants delivered to your home.</p>
    </div>

    <div class="tag">
      <h1 id="quickLinks">Quick Links</h1>
      <a href="homeM.php" id="footHome">Home</a>
      <a href="aboutM.php" id="footAbout">About</a>
      <a href="plantesM.php" id="footPlants">Plants</a>
      <a href="blogM.php" id="footBlog">Blog</a>
      <a href="loginM.php" id="footLogin">Login</a>
    </div>

    <div class="tag">
      <h1 id="contactInfo">Contact Info</h1>
      <a href="#"><i class="fas fa-phone"></i> +213 555 555 555</a>
      <a href="#"><i class="fas fa-envelope"></i> machtalaty123@gmail.com</a>
    </div>

    <div class="tag">
      <h1 id="followUs">Follow Us</h1>
      <div class="social_link">
        <i class="fab fa-facebook-f"></i>
        <i class="fab fa-instagram"></i>
        <i class="fab fa-twitter"></i>
        <i class="fab fa-linkedin-in"></i>
      </div>
    </div>
  </div>
</footer>

<!-- Scroll Top -->
<div id="scroll-top" class="fas fa-angle-up"></div>

<!-- SCRIPT -->
<script>
const translations = {
  en: {navList: ["Home", "About", "Plants", "Blog", "Contact"], contactTitle:"Say Something!", namePlaceholder:"Enter your name", emailPlaceholder:"Enter your email", messagePlaceholder:"Enter your message", sendBtn:"Send Message", footerDesc:"Your favorite plants delivered to your home.", quickLinks:"Quick Links", footHome:"Home", footAbout:"About", footPlants:"Plants", footBlog:"Blog", footLogin:"Login", contactInfo:"Contact Info", followUs:"Follow Us", title:"Contact - MACHTALATY"},
  fr: {navList: ["Accueil", "À propos", "Plantes", "Blog", "Contact"], contactTitle:"Dites quelque chose !", namePlaceholder:"Entrez votre nom", emailPlaceholder:"Entrez votre email", messagePlaceholder:"Entrez votre message", sendBtn:"Envoyer le message", footerDesc:"Vos plantes préférées livrées à votre domicile.", quickLinks:"Liens rapides", footHome:"Accueil", footAbout:"À propos", footPlants:"Plantes", footBlog:"Blog", footLogin:"Connexion", contactInfo:"Infos contact", followUs:"Suivez-nous", title:"Contact - MACHTALATY"},
  ar: {navList: ["الرئيسية", "من نحن", "نباتات", "مدونة", "اتصل بنا"], contactTitle:"قل شيئا!", namePlaceholder:"أدخل اسمك", emailPlaceholder:"أدخل بريدك الإلكتروني", messagePlaceholder:"أدخل رسالتك", sendBtn:"إرسال الرسالة", footerDesc:"نقدم لك أفضل النباتات إلى منزلك.", quickLinks:"روابط سريعة", footHome:"الرئيسية", footAbout:"من نحن", footPlants:"نباتات", footBlog:"مدونة", footLogin:"تسجيل الدخول", contactInfo:"معلومات الاتصال", followUs:"تابعنا", title:"اتصل بنا - MACHTALATY"}
};

function changeLanguage(lang) {
  document.documentElement.lang = lang;
  document.documentElement.dir = lang === "ar" ? "rtl" : "ltr";

  const t = translations[lang];
  
  // Translate nav
  const navLinks = document.querySelectorAll("#navList li a");
  navLinks.forEach((link, index) => {
    link.innerText = t.navList[index];
  });

  // Translate other elements
  for (const key in t) {
    if (key !== "navList") {
      const element = document.getElementById(key);
      if (element) {
        if (key.includes("Placeholder")) {
          element.placeholder = t[key];
        } else if (key === "title") {
          document.title = t[key];
        } else {
          element.innerText = t[key];
        }
      }
    }
  }
}

window.onscroll = () => {
  let scrollTopBtn = document.getElementById('scroll-top');
  scrollTopBtn.style.display = window.scrollY > 100 ? 'block' : 'none';
};
document.getElementById('scroll-top').onclick = () => {
  window.scrollTo({ top: 0, behavior: 'smooth' });
};
</script>

</body>
</html>
