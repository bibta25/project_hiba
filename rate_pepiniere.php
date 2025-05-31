<?php
require('admin/includs/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id = intval($_POST['pepiniere_id']);
  $newRating = floatval($_POST['rating']);

  // Get current rating and count
  $sql = "SELECT rating, rating_count FROM pepiniere WHERE id = $id";
  $result = $conn->query($sql);
  if ($result && $row = $result->fetch_assoc()) {
    $currentRating = $row['rating'];
    $count = $row['rating_count'];

    $updatedCount = $count + 1;
    $updatedRating = (($currentRating * $count) + $newRating) / $updatedCount;

    // Update DB
    $updateSql = "UPDATE pepiniere SET rating = $updatedRating, rating_count = $updatedCount WHERE id = $id";
    $conn->query($updateSql);
  }

  header("Location: pepiniere.php");
  exit();
}
?>
