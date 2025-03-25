<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_id'], $_POST['title'], $_POST['post'])) {
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "post";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $postId = $conn->real_escape_string($_POST['post_id']);
    $title = $conn->real_escape_string($_POST['title']);
    $postContent = $conn->real_escape_string($_POST['post']);
    $userEmail = $conn->real_escape_string($_COOKIE['email']);

    $updateSql = "UPDATE posts SET title='$title', post='$postContent' WHERE id='$postId' AND email='$userEmail'";

    if ($conn->query($updateSql) === TRUE) {
        echo "Post updated successfully!";
        echo "<a href='index.php'>Return to Dashboard</a>";
    } else {
        echo "Error updating post: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Invalid request.";
}
?>
