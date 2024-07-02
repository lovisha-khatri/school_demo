<?php
include 'includes/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $class_id = $_POST['class_id'];

    if (deleteClass($class_id)) {
        echo "Class deleted successfully.";
    } else {
        echo "Error deleting class.";
    }
}

// Redirect to classes.php after deletion
header("Location: classes.php");
exit;
?>
