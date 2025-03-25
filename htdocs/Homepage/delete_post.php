<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "post";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'error' => $conn->connect_error]));
}

$data = json_decode(file_get_contents('php://input'), true);
$postId = isset($data['post_id']) ? intval($data['post_id']) : 0;

if ($postId > 0) {
    $sql = "DELETE FROM posts WHERE id = $postId";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $postId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid post ID']);
}

$conn->close();
?>

