<?php
// Include database connection
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "post";

// Decode the JSON input
$data = json_decode(file_get_contents('php://input'), true);

// Check for update privacy action
if ($data['action'] === 'update_privacy') {
    $post_id = intval($data['post_id']);
    $privacy_status = $data['prvt'] === 'no' ? 'no' : 'yes'; // 'no' for private, 'yes' for public

    // Update query to change the privacy of the post
    $update_sql = "UPDATE posts SET prvt = '$privacy_status' WHERE id = $post_id";
    
    if ($conn->query($update_sql) === TRUE) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => $conn->error]);
    }
}
?>
