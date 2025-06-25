<?php
include 'connect.php';

$id = $_GET['id'];

// Delete payments first (due to FK constraint)
$stmt1 = $conn->prepare("DELETE FROM payments WHERE registration_id=?");
$stmt1->bind_param("i", $id);
$stmt1->execute();

// Then delete registration
$stmt2 = $conn->prepare("DELETE FROM registrations WHERE id=?");
$stmt2->bind_param("i", $id);
$stmt2->execute();

header("Location: view_registrations.php");
exit();
?>
