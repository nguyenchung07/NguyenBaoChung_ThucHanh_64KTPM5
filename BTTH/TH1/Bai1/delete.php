<?php
require 'includes/db.php';

$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM flowers WHERE id = ?");
$stmt->execute([$id]);

header("Location: admin.php");
exit();
?>
