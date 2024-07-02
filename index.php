<?php
include 'includes/header.php';
include 'includes/functions.php';

// Fetch students
$students = getStudents();

?>

<div class="container mt-4">
    <h2>Students List</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Student ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Address</th>
                <th>Class</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $student): ?>
            <tr>
                <td><?= $student['id'] ?></td>
                <td><?= $student['name'] ?></td>
                <td><?= $student['email'] ?></td>
                <td><?= $student['address'] ?></td>
                <td><?= $student['class_name'] ?></td>
                <td>
                    <?php if (!empty($student['image'])): ?>
                        <img src="<?= $student['image'] ?>" alt="Student Image" style="width: 50px; height: auto;">
                    <?php else: ?>
                        No Image Available
                    <?php endif; ?>
                </td>
                <td>
                    <a href="view.php?id=<?= $student['id'] ?>" class="btn btn-info btn-sm">View</a>
                    <a href="edit.php?id=<?= $student['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                    <a href="delete.php?id=<?= $student['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Add Student and Add Class buttons -->
    <div class="row">
        <div class="col-md-6">
            <a href="create.php" class="btn btn-success">Add Student</a>
        </div>
        <div class="col-md-6">
            <a href="classes.php" class="btn btn-success">Add Class</a>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
