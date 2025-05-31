<?php
include('../admin/includs/header.php'); // adapte ce chemin selon ton projet

$conn = mysqli_connect('localhost', 'root', '', 'machtala') or die('Connection failed');

$success_msg = '';
$errors = [];

// Suppression du message si demandé
if (isset($_POST['delete'])) {
    $id = intval($_POST['message_id']);
    $delete_query = "DELETE FROM message WHERE id = $id";
    if (mysqli_query($conn, $delete_query)) {
        $success_msg = "Message supprimé avec succès !";
    } else {
        $errors[] = "Erreur lors de la suppression : " . mysqli_error($conn);
    }
}

// Récupération des messages
$result = mysqli_query($conn, "SELECT * FROM message ORDER BY created_at DESC");
$messages = mysqli_fetch_all($result, MYSQLI_ASSOC);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Admin - Messages Contact</title>
    <link rel="stylesheet" href="../admin/css/admin_contact.css" />
</head>
<body>
    <h1>Messages Contact</h1>

    <?php if ($success_msg): ?>
        <p style="color:green;"><?php echo $success_msg; ?></p>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <?php foreach ($errors as $error): ?>
            <p style="color:red;"><?php echo $error; ?></p>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if (empty($messages)): ?>
        <p>Aucun message reçu pour l'instant.</p>
    <?php else: ?>
        <?php foreach ($messages as $message): ?>
            <div class="message-container" style="border:1px solid #ccc; padding:15px; margin-bottom:15px;">
                <p><strong>Nom :</strong> <?php echo htmlspecialchars($message['name']); ?></p>
                <p><strong>Email :</strong> <?php echo htmlspecialchars($message['email']); ?></p>
                <p><strong>Message :</strong> <?php echo nl2br(htmlspecialchars($message['message'])); ?></p>
                <form method="post" onsubmit="return confirm('Supprimer ce message ?');">
                    <input type="hidden" name="message_id" value="<?php echo $message['id']; ?>" />
                    <input type="submit" name="delete" value="Supprimer" />
                </form>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

</body>
</html>

<?php include('../admin/includs/footer.php'); ?>
<?php include('../admin/includs/scripts.php'); ?>
