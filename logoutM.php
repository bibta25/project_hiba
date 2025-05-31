<?php
session_start();
session_destroy();
header("Location: loginM.php");
exit;
?>
