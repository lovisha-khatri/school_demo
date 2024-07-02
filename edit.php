<?php
include 'includes/header.php';
include 'includes/functions.php';

// Fetch class options
$class_options = getClassOptions();

// Check if ID is provided via GET
if (!isset($_GET['id'])) {
    die("Student ID not provided.");
}

$id = $_GET['id'];

// Fetch student data by ID
$student = getStudentById($id);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $class_id = $_POST['class_id'];

    // Validate and upload image if provided
    $image = $_FILES['image'];
    if ($image['name']) {
        if (validateImage($image)) {
            $image_path = uploadImage($image);
            if ($image_path === false) {
                die("Failed to upload image.");
            }
        } else {
            die("Invalid image type. Allowed types are JPG and PNG.");
        }
    } else {
        // Keep the existing image path
        $image_path = $student['image'];
    }

    // Update student data
    if (updateStudent($id, $name, $email, $address, $class_id, $image_path)) {
        header("Location: index.php");
        exit();
    } else {
        die("Failed to update student.");
    }
}
?>

<div class="container mt-5">
    <h2>Edit Student</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($student['name']) ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($student['email']) ?>">
        </div>
        <div class="form-group">
            <label for="address">Address:</label>
            <textarea class="form-control" id="address" name="address"><?= htmlspecialchars($student['address']) ?></textarea>
        </div>
        <div class="form-group">
            <label for="class_id">Class:</label>
            <select class="form-control" id="class_id" name="class_id">
                <?= $class_options ?>
            </select>
        </div>
        <div class="form-group">
            <label for="image">Profile Image:</label>
            <input type="file" class="form-control-file" id="image" name="image">
            <?php if ($student['image']): ?>
                <img src="<?= htmlspecialchars($student['image']) ?>" alt="Student Image" style="width: 150px; height: auto;">
            <?php else: ?>
                No image uploaded.
            <?php endif; ?>
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="index.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
