<?php
$conn = new mysqli("localhost", "root", "", "machtala");
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

$sql = "SELECT * FROM blog ORDER BY created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title data-lang="blogTitle">Blog - Machtalaty</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        /* ----- NAVBAR STYLE ----- */
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

        /* ----- BLOG PAGE ----- */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        .blog-container {
            max-width: 1200px;
            margin: 50px auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 30px;
            padding: 0 20px;
        }

        .blog-card {
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }

        .blog-card:hover {
            transform: translateY(-5px);
        }

        .blog-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .blog-content {
            padding: 20px;
        }

        .blog-content h3 {
            color: #2e7d32;
            font-size: 22px;
            margin-bottom: 10px;
        }

        .blog-content p {
            color: #333;
            font-size: 16px;
        }

        .blog-content .date {
            font-size: 14px;
            color: #777;
            margin-top: 10px;
        }

        .blog-content a {
            display: inline-block;
            margin-top: 15px;
            color: #4caf50;
            text-decoration: none;
            font-weight: bold;
        }

        .blog-content a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<!-- NAVIGATION -->
<nav>
    <div class="navbar">
        <div class="logo">
            <img src="../project_hiba/img/3.png" alt="Logo" title="Machtalaty Logo">
        </div>
        <div class="nav-links">
            <ul>
                <li><a href="homeM.php" data-lang="home">Home</a></li>
                <li><a href="aboutM.php" data-lang="about">About</a></li>
                <li><a href="plantesM.php" data-lang="plants">Plants</a></li>
                <li><a href="pepiniere.php" data-lang="nurseries">Nurseries</a></li>
                <li><a href="blogM.php" data-lang="blog">Blog</a></li>
                <li><a href="contactM.php" data-lang="contact">Contact</a></li>
            </ul>
            <form action="recherche.php" method="GET">
                <input type="text" name="search" class="search-bar" placeholder="Search...">
            </form>
            <div class="icons">
                <a href="cart.php" title="Cart"><i class="fas fa-shopping-cart"></i></a>
                <div class="login-icon">
                    <a href="#"><i class="fas fa-seedling"></i></a>
                    <div class="login-dropdown">
                        <a href="loginM.php" data-lang="login">Login</a>
                        <a href="signupM.php" data-lang="signup">Sign Up</a>
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

<!-- BLOG CONTENT -->
<main class="blog-container">
    <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
            <article class="blog-card">
                <img src="img/<?php echo htmlspecialchars($row['image']); ?>" alt="Blog Image">
                <div class="blog-content">
                    <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                    <p><?php echo mb_strimwidth(htmlspecialchars($row['text']), 0, 100, "..."); ?></p>
                    <div class="date"><?php echo date("d/m/Y", strtotime($row['created_at'])); ?></div>
                    <a href="details_blog.php?id=<?php echo $row['id']; ?>" data-lang="readMore">Read more</a>
                </div>
            </article>
        <?php endwhile; ?>
    <?php else: ?>
        <p style="text-align:center; font-size:18px;" data-lang="noPosts">No blog posts available.</p>
    <?php endif; ?>
</main>

<!-- JAVASCRIPT FOR MULTILINGUAL -->
<script>
const translations = {
    en: {
        home: "Home",
        about: "About",
        plants: "Plants",
        nurseries: "Nurseries",
        blog: "Blog",
        contact: "Contact",
        login: "Login",
        signup: "Sign Up",
        readMore: "Read more",
        noPosts: "No blog posts available.",
        blogTitle: "Blog - Machtalaty"
    },
    fr: {
        home: "Accueil",
        about: "À propos",
        plants: "Plantes",
        nurseries: "Pépinières",
        blog: "Blog",
        contact: "Contact",
        login: "Connexion",
        signup: "Créer un compte",
        readMore: "Lire la suite",
        noPosts: "Aucun article de blog disponible.",
        blogTitle: "Blog - Machtalaty"
    },
    ar: {
        home: "الرئيسية",
        about: "من نحن",
        plants: "النباتات",
        nurseries: "المشاتل",
        blog: "المدونة",
        contact: "اتصل بنا",
        login: "تسجيل الدخول",
        signup: "إنشاء حساب",
        readMore: "اقرأ المزيد",
        noPosts: "لا توجد مقالات متاحة.",
        blogTitle: "المدونة - ماشتلتي"
    }
};

function changeLanguage(lang) {
    localStorage.setItem("lang", lang);
    applyTranslations(lang);
}

function applyTranslations(lang) {
    const elements = document.querySelectorAll("[data-lang]");
    elements.forEach(el => {
        const key = el.getAttribute("data-lang");
        if (translations[lang] && translations[lang][key]) {
            el.innerText = translations[lang][key];
        }
    });

    const titleEl = document.querySelector("title[data-lang]");
    if (titleEl) {
        titleEl.textContent = translations[lang]['blogTitle'];
    }
}

document.addEventListener("DOMContentLoaded", () => {
    const savedLang = localStorage.getItem("lang") || "en";
    applyTranslations(savedLang);
});
</script>

</body>
</html>