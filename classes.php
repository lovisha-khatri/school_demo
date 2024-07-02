<?php
include 'includes/header.php';
include 'includes/functions.php';

// Handle form submission for adding a new class
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['class_name'])) {
    $class_name = $_POST['class_name'];

    if (!empty($class_name)) {
        $result = addClass($class_name);
        if ($result) {
            // Class added successfully, redirect or show success message
            header("Location: classes.php?success=1");
            exit;
        } else {
            $error_message = "Failed to add class. Please try again.";
        }
    } else {
        $error_message = "Class name cannot be empty.";
    }
}

// Fetch existing classes
$classes = getClasses();
?>

<div class="container mt-4">
    <h2>Classes List</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Class ID</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($class = $classes->fetch_assoc()): ?>
                <tr>
                    <td><?= $class['class_id'] ?></td>
                    <td><?= $class['name'] ?></td>
                    <td>
                        <a href="edit_class.php?id=<?= $class['class_id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                        <a href="delete_class.php?id=<?= $class['class_id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Form to add a new class -->
    <div class="card mt-4">
        <div class="card-header">
            Add New Class
        </div>
        <div class="card-body">
            <?php if (isset($error_message)): ?>
                <div class="alert alert-danger"><?= $error_message ?></div>
            <?php endif; ?>
            <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
                <div class="form-group">
                    <label for="class_name">Class Name</label>
                    <input type="text" class="form-control" id="class_name" name="class_name" required>
                </div>
                <button type="submit" class="btn btn-success">Add Class</button>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
