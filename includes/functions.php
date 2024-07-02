<?php
// includes/functions.php

include __DIR__ . '/db.php';  // Absolute path to db.php file

// Function to retrieve all students with their class names
function getStudents() {
    global $conn;
    $sql = "SELECT student.id, student.name, student.email, student.address, student.created_at, student.image, classes.name AS class_name 
            FROM student
            LEFT JOIN classes ON student.class_id = classes.class_id";
    $result = $conn->query($sql);
    
    if (!$result) {
        die("Query failed: " . $conn->error);
    }
    
    $students = [];
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
    
    return $students;
}


// Function to retrieve all classes
function getClasses() {
    global $conn;
    $sql = "SELECT * FROM classes";
    $result = $conn->query($sql);
    
    if ($result === false) {
        die("Query failed: " . $conn->error);
    }
    
    return $result;
}

// Function to generate HTML options for class selection
function getClassOptions() {
    $classes = getClasses();
    $options = "";
    while ($row = $classes->fetch_assoc()) {
        $options .= "<option value='{$row['class_id']}'>{$row['name']}</option>";
    }
    return $options;
}

// Function to validate uploaded image type
function validateImage($image) {
    $allowed_types = ['image/jpeg', 'image/png'];
    return in_array($image['type'], $allowed_types);
}

// Function to upload image file
function uploadImage($image) {
    $target_dir = "uploads/";
    $unique_name = uniqid() . "-" . basename($image["name"]);
    $target_file = $target_dir . $unique_name;

    if (move_uploaded_file($image["tmp_name"], $target_file)) {
        return $target_file;
    } else {
        return false;
    }
}

// Function to add a new class
function addClass($class_name) {
    global $conn;
    $sql = "INSERT INTO classes (name, created_at) VALUES (?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $class_name);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}

// Function to edit an existing class
function editClass($class_id, $class_name) {
    global $conn;
    $sql = "UPDATE classes SET name = ? WHERE class_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $class_name, $class_id);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}

// Function to delete a class
function deleteClass($class_id) {
    global $conn;
    $sql = "DELETE FROM classes WHERE class_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $class_id);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}

// Function to retrieve a student by ID
function getStudentById($student_id) {
    global $conn;
    $sql = "SELECT * FROM student WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();
    $stmt->close();
    return $student;
}

// Function to retrieve a class by ID


// Function to update student information
function updateStudent($student_id, $name, $email, $address, $class_id, $image_path) {
    global $conn;

    $sql = "UPDATE student SET name = ?, email = ?, address = ?, class_id = ?, image = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $name, $email, $address, $class_id, $image_path, $student_id);

    if ($stmt->execute()) {
        $stmt->close();
        return true;
    } else {
        return false;
    }
   
    function updateClass($class_id, $class_name) {
        global $conn;
        $sql = "UPDATE classes SET name = ? WHERE class_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $class_name, $class_id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
    // In includes/functions.php or appropriate file
    function getClassById($class_id) {
        global $conn;
        $sql = "SELECT * FROM classes WHERE class_id = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("i", $class_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if (!$result) {
            die("Execute failed: " . $stmt->error);
        }
        $class = $result->fetch_assoc();
        $stmt->close();
        return $class;
    }
    

}
?>
