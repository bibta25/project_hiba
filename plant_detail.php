<?php
session_start();
include 'config.php';

// Récupération de l'ID de la plante à partir de l'URL
$plant_id = isset($_GET['id']) ? $_GET['id'] : 0;

// Requête pour obtenir les détails de la plante
$query_plant_details = "SELECT * FROM plantes WHERE id = $plant_id";
$result_plant_details = mysqli_query($conn, $query_plant_details);

// Vérifier si la plante existe
if (mysqli_num_rows($result_plant_details) == 0) {
    echo "<h2>Plante non trouvée!</h2>";
    exit;
}

$plant = mysqli_fetch_assoc($result_plant_details);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Détails de la Plante</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="icon" href="img/3.png">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f9fafb;
      color: #333;
      transition: all 0.3s ease;
    }

    /* Container principal */
    .container {
      width: 80%;
      margin: 40px auto;
      padding: 30px;
      background-color: #fff;
      border-radius: 12px;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
    }

    .container:hover {
      box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
    }

    /* Détails de la plante */
    .plant-detail {
      text-align: center;
      animation: fadeIn 1.5s ease-in-out;
    }

    /* Image de la plante */
    .plant-detail img {
      width: 350px;
      height: 350px;
      object-fit: cover;
      border-radius: 10px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
      margin-bottom: 20px;
      transition: transform 0.3s ease;
    }

    .plant-detail img:hover {
      transform: scale(1.1);
    }

    /* Titres et textes */
    .plant-detail h2 {
      font-size: 36px;
      color: #2c6f2c;
      margin-bottom: 15px;
      font-weight: 600;
      opacity: 0;
      animation: fadeInUp 1s forwards 0.5s;
    }

    .plant-detail p {
      font-size: 18px;
      color: #555;
      line-height: 1.6;
      margin-top: 20px;
      opacity: 0;
      animation: fadeInUp 1s forwards 1s;
    }

    /* Grid pour les informations */
    .plant-detail .info {
      display: flex;
      justify-content: space-around;
      flex-wrap: wrap;
      margin-top: 30px;
      animation: fadeInUp 1s forwards 1.5s;
    }

    /* Infos avec effet de survol */
    .plant-detail .info div {
      background-color: #f4f7f6;
      padding: 20px;
      width: 45%;
      border-radius: 10px;
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.05);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      margin-bottom: 15px;
      text-align: left;
      display: flex;
      align-items: center;
      opacity: 0;
      animation: fadeInUp 1s forwards 1.5s;
    }

    .plant-detail .info div:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .plant-detail .info i {
      color: #4caf50;
      font-size: 30px;
      margin-right: 10px;
      transition: color 0.3s ease;
    }

    .plant-detail .info div:hover i {
      color: #ff9800;
    }

    .plant-detail .info div strong {
      color: #4caf50;
      font-size: 18px;
    }

    /* Section Description dynamique et professionnelle */
    .plant-description {
      background: linear-gradient(135deg, #a8e6cf, #d0f4de);
      padding: 40px;
      margin-top: 40px;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
      max-width: 90%;
      margin-left: auto;
      margin-right: auto;
      font-size: 18px;
      line-height: 1.8;
      opacity: 0;
      animation: fadeInUp 1.5s forwards 2s;
      transition: all 0.3s ease;
    }

    .plant-description h3 {
      font-size: 28px;
      color: #3e8e41;
      margin-bottom: 20px;
      font-weight: 700;
      letter-spacing: 1px;
    }

    .plant-description p {
      font-size: 18px;
      color: #333;
    }

    .plant-description .highlight {
      color: #ff9800;
      font-weight: bold;
      font-style: italic;
    }

    .plant-description:hover {
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    /* Animation fadeIn */
    @keyframes fadeIn {
      from {
        opacity: 0;
      }
      to {
        opacity: 1;
      }
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
</head>
<body>

<div class="container">
  <div class="plant-detail">
    <img src="admin/uploaded_img/<?php echo htmlspecialchars($plant['image']); ?>" alt="Image de la plante">
    <h2><?php echo htmlspecialchars($plant['nom']); ?></h2>

    <div class="info">
      <div><i class="fas fa-sun"></i><strong>Sun exposure:</strong> <?php echo htmlspecialchars($plant['exposition_soleil']); ?></div>
      <div><i class="fas fa-thermometer-half"></i><strong>Temperature:</strong> <?php echo htmlspecialchars($plant['temperature']); ?></div>
      <div><i class="fas fa-leaf"></i><strong>Soil type:</strong> <?php echo htmlspecialchars($plant['type_sol']); ?></div>
      <div><i class="fas fa-tint"></i><strong>Watering:</strong> <?php echo htmlspecialchars($plant['arrosage']); ?></div>
    </div>

    <!-- Description -->
    <div class="plant-description">
      <h3>Plant description :</h3>
      <p><?php echo nl2br(htmlspecialchars($plant['description'])); ?></p>
      <p><span class="highlight">Astuce :</span> Cette plante préfère un endroit bien éclairé et nécessite un arrosage modéré pour une croissance optimale. Assurez-vous de lui fournir un sol bien drainé.</p>
    </div>
  </div>
</div>

<!-- Footer -->
<footer>
  <p>&copy; 2025 MACHTALATY. All Rights Reserved.</p>
</footer>

</body>
</html>
