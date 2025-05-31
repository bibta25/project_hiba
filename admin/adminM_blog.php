<?php
include('../admin/includs/header.php');

$conn = new mysqli('localhost', 'root', '', 'machtala');
if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}

if (isset($_POST['add_product'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $text = $conn->real_escape_string($_POST['text']);
    $image = $_FILES['image']['name'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_size = $_FILES['image']['size'];
    $image_folder = 'uploaded_img/' . $image;

    $stmt = $conn->prepare("SELECT name FROM blog WHERE name = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<script>alert('Product name already exists.');</script>";
    } else {
        if ($image_size > 2000000) {
            echo "<script>alert('Image size is too large.');</script>";
        } else {
            move_uploaded_file($image_tmp_name, $image_folder);
            $stmt = $conn->prepare("INSERT INTO blog (image, name, text) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $image, $name, $text);
            $stmt->execute();
            echo "<script>alert('Blog added successfully.');</script>";
        }
    }
    $stmt->close();
}

if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    $stmt = $conn->prepare("SELECT image FROM blog WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->bind_result($image);
    $stmt->fetch();
    $stmt->close();

    if ($image) {
        unlink('uploaded_img/' . $image);
    }

    $stmt = $conn->prepare("DELETE FROM blog WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    echo "<script>alert('Blog deleted successfully.'); window.location.href='';</script>";
}

if (isset($_POST['update_product'])) {
    $update_id = intval($_POST['update_p_id']);
    $update_name = $conn->real_escape_string($_POST['update_name']);
    $update_text = $conn->real_escape_string($_POST['update_text']);
    $update_image = $_FILES['update_image']['name'];
    $update_tmp_name = $_FILES['update_image']['tmp_name'];
    $update_size = $_FILES['update_image']['size'];
    $old_image = $_POST['update_old_image'];

    $stmt = $conn->prepare("UPDATE blog SET name = ?, text = ? WHERE id = ?");
    $stmt->bind_param("ssi", $update_name, $update_text, $update_id);
    $stmt->execute();
    $stmt->close();

    if (!empty($update_image)) {
        if ($update_size > 2000000) {
            echo "<script>alert('Updated image size too large.');</script>";
        } else {
            move_uploaded_file($update_tmp_name, 'uploaded_img/' . $update_image);
            unlink('uploaded_img/' . $old_image);
            $stmt = $conn->prepare("UPDATE blog SET image = ? WHERE id = ?");
            $stmt->bind_param("si", $update_image, $update_id);
            $stmt->execute();
            $stmt->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Blog</title>
    <link rel="stylesheet" href="../admin/css/adminM_blog.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<h1 class="title">Blog Management</h1>
<section>
    <form class="form" method="post" enctype="multipart/form-data">
        <h3 class="add_product">Add Blog</h3>
        <input type="text" name="name" class="form--input" placeholder="Enter blog title" required>
        <input type="text" name="text" class="form--input" placeholder="Enter blog content" required>
        <input type="file" name="image" accept="image/*" class="form--input" required>
        <input type="submit" value="Add Blog" name="add_product" class="form--submit">
    </form>
</section>

<section class="show-products">
    <div class="box-container">
        <?php
        $result = $conn->query("SELECT * FROM blog");
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="box">';
                echo '<img src="uploaded_img/' . htmlspecialchars($row['image']) . '" alt="">';
                echo '<div class="name">' . htmlspecialchars($row['name']) . '</div>';
                echo '<div class="text">' . htmlspecialchars($row['text']) . '</div>';
                echo '<div class="btn">';
                echo '<a href="../admin/update_blog.php?name=' . urlencode($row['name']) . '" class="update-btn">Update</a>';
                echo '<a href="?delete=' . $row['id'] . '" class="delete-btn" onclick="return confirm(\'Are you sure you want to delete this blog?\');">Delete</a>';
                echo '</div></div>';
            }
        } else {
            echo '<p class="empty">No blog posts added yet.</p>';
        }
        ?>
    </div>
</section>

<?php
include('../admin/includs/footer.php');
include('../admin/includs/scripts.php');
?>
</body>
</html>
