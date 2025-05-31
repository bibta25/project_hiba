<?php
// recherche.php
include 'config.php'; // ta connexion $conn

// Récupérer le terme de recherche depuis GET, si défini
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';

$results_plants = [];
$results_plantes = [];

if ($searchTerm !== '') {
    $safeTerm = mysqli_real_escape_string($conn, $searchTerm);

    // Requête sur table plants avec jointure pepiniere
    $query_plants = "
        SELECT 
            pl.name AS plante_name, pl.image, pl.price, pl.description, 
            pep.name AS pepiniere_name, pep.address, pep.phone 
        FROM plants pl 
        LEFT JOIN pepiniere pep ON pl.pepiniere_id = pep.id 
        WHERE pl.name LIKE '%$safeTerm%'
    ";
    $res1 = mysqli_query($conn, $query_plants);
    if ($res1 && mysqli_num_rows($res1) > 0) {
        $results_plants = mysqli_fetch_all($res1, MYSQLI_ASSOC);
    }

    // Requête sur table plantes (sans jointure)
    $query_plantes = "
        SELECT 
            nom, type, exposition_soleil, temperature, type_sol, arrosage, description, image 
        FROM plantes 
        WHERE nom LIKE '%$safeTerm%'
    ";
    $res2 = mysqli_query($conn, $query_plantes);
    if ($res2 && mysqli_num_rows($res2) > 0) {
        $results_plantes = mysqli_fetch_all($res2, MYSQLI_ASSOC);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8" />
<title>Recherche de plantes</title>
<style>
    /* Reset basique */
    * {
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        max-width: 900px;
        margin: 40px auto;
        padding: 20px 30px;
        background: #f9f9f9;
        color: #333;
    }

    h1 {
        text-align: center;
        color: #2c3e50;
        font-weight: 700;
        margin-bottom: 40px;
    }

    form {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-bottom: 40px;
    }

    input[type="text"] {
        flex: 1;
        max-width: 400px;
        padding: 12px 15px;
        border: 2px solid #2ecc71;
        border-radius: 6px;
        font-size: 16px;
        transition: border-color 0.3s ease;
    }
    input[type="text"]:focus {
        border-color: #27ae60;
        outline: none;
    }

    input[type="submit"] {
        background-color: #2ecc71;
        color: white;
        border: none;
        padding: 12px 25px;
        font-weight: 600;
        font-size: 16px;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    input[type="submit"]:hover {
        background-color: #27ae60;
    }

    h3 {
        color: #27ae60;
        font-weight: 700;
        border-bottom: 2px solid #2ecc71;
        padding-bottom: 8px;
        margin-bottom: 25px;
    }

    .plant, .plante {
        background: white;
        border-radius: 10px;
        box-shadow: 0 3px 8px rgba(0,0,0,0.1);
        padding: 15px;
        margin-bottom: 25px;
        display: flex;
        gap: 20px;
        align-items: flex-start;
        transition: box-shadow 0.3s ease;
    }
    .plant:hover, .plante:hover {
        box-shadow: 0 6px 18px rgba(0,0,0,0.15);
    }

    .plant img, .plante img {
        width: 140px;
        height: 110px;
        object-fit: cover;
        border-radius: 10px;
        flex-shrink: 0;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    .details {
        flex-grow: 1;
    }

    .details h4 {
        margin: 0 0 12px 0;
        color: #16a085;
        font-weight: 700;
        font-size: 1.25rem;
    }

    .details p {
        margin: 6px 0;
        line-height: 1.45;
        color: #555;
        font-size: 0.95rem;
    }

    .details p strong {
        color: #2c3e50;
    }

    p {
        font-size: 1rem;
        text-align: center;
        color: #777;
        margin-top: 50px;
    }
</style>

</head>
<body>

<h1>Recherche de plantes</h1>

<form method="GET" action="recherche.php">
    <input type="text" name="search" placeholder="Entrez le nom de la plante..." value="<?php echo htmlspecialchars($searchTerm); ?>" />
    <input type="submit" value="Rechercher" />
</form>

<?php if ($searchTerm === ''): ?>
    <p>Veuillez entrer un terme de recherche.</p>
<?php else: ?>

    <?php if (!empty($results_plants)): ?>
        <h3>Plantes avec pépinière</h3>
        <?php foreach ($results_plants as $plant): ?>
            <div class="plant">
                <img src="img/<?php echo htmlspecialchars($plant['image']); ?>" alt="<?php echo htmlspecialchars($plant['plante_name']); ?>" />
                <div class="details">
                    <h4><?php echo htmlspecialchars($plant['plante_name']); ?> — <?php echo number_format($plant['price'], 2); ?> €</h4>
                    <p><?php echo nl2br(htmlspecialchars($plant['description'])); ?></p>
                    <p><strong>Pépinière :</strong> <?php echo htmlspecialchars($plant['pepiniere_name'] ?? 'Non renseigné'); ?></p>
                    <p><strong>Adresse :</strong> <?php echo htmlspecialchars($plant['address'] ?? 'Non renseignée'); ?></p>
                    <p><strong>Téléphone :</strong> <?php echo htmlspecialchars($plant['phone'] ?? 'Non renseigné'); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if (!empty($results_plantes)): ?>
        <h3>Plantes du site</h3>
        <?php foreach ($results_plantes as $plante): ?>
            <div class="plante">
                <img src="admin/uploaded_img/<?php echo htmlspecialchars($plante['image']); ?>" alt="<?php echo htmlspecialchars($plante['nom']); ?>" />
                <div class="details">
                    <h4><?php echo htmlspecialchars($plante['nom']); ?></h4>
                    <p><strong>Type :</strong> <?php echo htmlspecialchars($plante['type']); ?></p>
                    <p><strong>Exposition au soleil :</strong> <?php echo htmlspecialchars($plante['exposition_soleil']); ?></p>
                    <p><strong>Température :</strong> <?php echo htmlspecialchars($plante['temperature']); ?></p>
                    <p><strong>Type de sol :</strong> <?php echo htmlspecialchars($plante['type_sol']); ?></p>
                    <p><strong>Arrosage :</strong> <?php echo htmlspecialchars($plante['arrosage']); ?></p>
                    <p><?php echo nl2br(htmlspecialchars($plante['description'])); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if (empty($results_plants) && empty($results_plantes)): ?>
        <p>Aucun résultat trouvé pour "<?php echo htmlspecialchars($searchTerm); ?>"</p>
    <?php endif; ?>

<?php endif; ?>

</body>
</html>
