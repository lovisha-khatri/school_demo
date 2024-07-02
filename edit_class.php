<?php
include 'includes/header.php';
include 'includes/functions.php';

// Check if ID parameter exists in URL
if (!isset($_GET['id'])) {
    echo "Class ID not provided.";
    exit;
}

// Get class ID from URL parameter
$id = $_GET['id'];

// Fetch class details from database using getClassById()
$class = getClassById($id);

// Debugging output
var_dump($class); // Check what getClassById() returns

// Check if class with given ID exists
if (!$class) {
    echo "Class not found.";
    exit;
}

// Handle form submission for updating class details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $class_name = $_POST['class_name'];

    // Update class details in database (you need to define this function)
    $updated = updateClass($id, $class_name); // Make sure updateClass() is defined

    if ($updated) {
        // Redirect to classes.php after successful update
        header("Location: classes.php");
        exit;
    } else {
        echo "Failed to update class.";
    }
}
?>

<div class="container mt-4">
    <h2>Edit Class</h2>
    <form action="edit_class.php?id=<?= $class['class_id'] ?>" method="POST">
        <div class="form-group">
            <label for="class_name">Class Name</label>
            <input type="text" class="form-control" id="class_name" name="class_name" value="<?= $class['name'] ?>">
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="classes.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
