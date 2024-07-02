<?php
include 'includes/functions.php';

$id = $_GET['id'];

// Fetch current image path
$sql = "SELECT image FROM student WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();
$stmt->close();

// Delete student record
$sql = "DELETE FROM student WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

// Delete image file
if (file_exists($student['image'])) {
    unlink($student['image']);
}

header("Location: index.php");
exit();
?>
