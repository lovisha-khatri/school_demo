<?php
include 'includes/header.php';
include 'includes/functions.php';

// Manually define class options (for form display)
$class_options = [
    ['class_id' => 1, 'name' => 'Class 1'],
    ['class_id' => 2, 'name' => 'Class 2'],
    ['class_id' => 3, 'name' => 'Class 3'],
    ['class_id' => 4, 'name' => 'Class 4'],
    ['class_id' => 5, 'name' => 'Class 5'],
    ['class_id' => 6, 'name' => 'Class 6'],
    ['class_id' => 7, 'name' => 'Class 8'],
    ['class_id' => 8, 'name' => 'Class 8'],
    ['class_id' => 9, 'name' => 'Class 9'],
    ['class_id' => 10, 'name' => 'Class 10'],
    ['class_id' => 11, 'name' => 'Class 11'],
    ['class_id' => 12, 'name' => 'Class 12']
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $class_id = $_POST['class_id'];
    $image = $_FILES['image'];

    if (empty($name)) {
        echo "<div class='alert alert-danger'>Name is required</div>";
    } elseif (!validateImage($image)) {
        echo "<div class='alert alert-danger'>Invalid image format</div>";
    } else {
        $image_path = uploadImage($image);
        if (!$image_path) {
            echo "<div class='alert alert-danger'>Failed to upload image</div>";
        } else {
            // Check if class_id exists in classes table before insertion
            if (isValidClassId($class_id)) {
                $stmt = $conn->prepare("INSERT INTO student (name, email, address, class_id, image, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
                $stmt->bind_param("sssis", $name, $email, $address, $class_id, $image_path);
                if ($stmt->execute()) {
                    $stmt->close();
                    header("Location: index.php");
                    exit();
                } else {
                    echo "<div class='alert alert-danger'>Failed to insert student: " . $conn->error . "</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>Invalid Class ID</div>";
            }
        }
    }
}

// Function to check if class_id exists in classes table
function isValidClassId($class_id) {
    global $conn;
    $sql = "SELECT class_id FROM classes WHERE class_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $class_id);
    $stmt->execute();
    $stmt->store_result();
    $num_rows = $stmt->num_rows;
    $stmt->close();
    return $num_rows > 0;
}
?>

<div class="container">
    <h2>Create Student</h2>
    <form action="create.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <textarea class="form-control" id="address" name="address" required></textarea>
        </div>
        <div class="form-group">
            <label for="class_id">Class</label>
            <select class="form-control" id="class_id" name="class_id">
                <?php foreach ($class_options as $option): ?>
                    <option value="<?= $option['class_id'] ?>"><?= $option['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" class="form-control-file" id="image" name="image" required>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
