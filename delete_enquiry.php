<?php
include 'connect.php';
$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM student_enquiries WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
header("Location: view_enquiries.php");
exit;
?>
