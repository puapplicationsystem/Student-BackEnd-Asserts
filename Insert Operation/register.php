<?php
session_start();
include 'connection.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $aadhar = $_POST['aadhar'];
    $dof = $_POST['dof'];

    // Check if email already exists
    $check_stmt = $conn->prepare("SELECT * FROM student WHERE email = ?");
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Email already exists']);
    } else {
        // Insert into student table
        $stmt = $conn->prepare("INSERT INTO student (email, password, name, aadhar, dof) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $email, $password, $name, $aadhar, $dof);
        $stmt->execute();

        echo json_encode(['success' => true, 'message' => 'Registration successful. Please log in to complete your profile.']);

        $stmt->close();
    }

    $check_stmt->close();
    $conn->close();
}
?>
