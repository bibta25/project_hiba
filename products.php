<?php
session_start();
require('admin/includs/db.php');

// جلب كل النباتات من قاعدة البيانات
$stmt = $conn->prepare("SELECT * FROM plants");
$stmt->execute();
$result_plants = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Produits</title>
</head>
<body>

<h1>Liste des plantes</h1>

<?php while ($plant = $result_plants->fetch_assoc()): ?>
  <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
    <img src="img/<?php echo htmlspecialchars($plant['image']); ?>" alt="Image" width="100" height="100">
    <h3><?php echo htmlspecialchars($plant['name']); ?></h3>
    <p><?php echo nl2br(htmlspecialchars($plant['description'])); ?></p>
    <p>Prix: €<?php echo number_format($plant['price'], 2, ',', ' '); ?></p>
    
    <!-- Formulaire ajout au panier -->
    <form method="post" action="add_to_cart.php">
      <input type="hidden" name="id" value="<?php echo $plant['id']; ?>">
      <label>
        Quantité:
        <input type="number" name="quantity" value="1" min="1" style="width:50px;">
      </label>
      <button type="submit">Ajouter au panier</button>
    </form>
  </div>
<?php endwhile; ?>

</body>
</html>
