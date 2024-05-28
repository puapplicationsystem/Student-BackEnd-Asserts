<?php
session_start();
include 'connection.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["mobile"]) && isset($_POST["location"]) && isset($_POST["pin"])) {
        $email = $_SESSION['email'];
        $mobile = $_POST["mobile"];
        $location = $_POST["location"];
        $pin = $_POST["pin"];

        // Update user data
        $stmt = $conn->prepare("UPDATE student SET mobile = ?, location = ?, pincode = ? WHERE email = ?");
        $stmt->bind_param("ssss", $mobile, $location, $pin, $email);
        $stmt->execute();

        echo json_encode(['success' => true, 'message' => 'Profile updated successfully']);

        $stmt->close();
        $conn->close();

        // Clear session data
        session_unset();
        session_destroy();
    } else {
        echo json_encode(['success' => false, 'message' => 'All fields are required']);
    }
}
?>
