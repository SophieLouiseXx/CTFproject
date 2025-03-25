<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "post";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(["success" => false, "error" => "Connection failed: " . $conn->connect_error]);
    exit;
}

// Get JSON data from request
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['postId'], $data['privacyStatus'])) {
    $postId = $conn->real_escape_string($data['postId']);
    $privacyStatus = $conn->real_escape_string($data['privacyStatus']);
    $userEmail = $conn->real_escape_string($_COOKIE['email']);

    // Update privacy status
    $updateSql = "UPDATE posts SET prvt='$privacyStatus' WHERE id='$postId' AND email='$userEmail'";
    if ($conn->query($updateSql) === TRUE) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => $conn->error]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Invalid input"]);
}

$conn->close();
?>