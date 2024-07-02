<?php
include 'includes/header.php';
include 'includes/functions.php';

$id = $_GET['id'];
$sql = "SELECT student.*, classes.name AS class_name FROM student
        LEFT JOIN classes ON student.class_id = classes.class_id WHERE student.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();
$stmt->close();
?>

<div class="container mt-5">
    <h2>View Student</h2>
    <table class="table table-bordered">
        <tr>
            <th>Name</th>
            <td><?= htmlspecialchars($student['name']) ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?= htmlspecialchars($student['email']) ?></td>
        </tr>
        <tr>
            <th>Address</th>
            <td><?= htmlspecialchars($student['address']) ?></td>
        </tr>
        <tr>
            <th>Class</th>
            <td><?= htmlspecialchars($student['class_name']) ?></td>
        </tr>
        <tr>
            <th>Created At</th>
            <td><?= htmlspecialchars($student['created_at']) ?></td>
        </tr>
        <tr>
            <th>Image</th>
            <td>
                <?php if ($student['image']): ?>
                    <img src="<?= htmlspecialchars($student['image']) ?>" alt="Student Image" style="width:150px; height:150px;">
                <?php else: ?>
                    <p>No image uploaded</p>
                <?php endif; ?>
            </td>
        </tr>
    </table>
    <a href="index.php" class="btn btn-primary">Back</a>
</div>

<?php include 'includes/footer.php'; ?>
