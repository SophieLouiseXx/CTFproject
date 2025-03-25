<?php
session_start();

// Assuming you have already established a database connection
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "user";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in using cookies
if (!isset($_COOKIE['email'])) {
    echo "No user logged in.";
    exit();
}

$email = $_COOKIE['email'];  // Get the user's email from the cookie

// Handle password change request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPassword = $_POST['current-password'];
    $newPassword = $_POST['new-password'];
    $confirmPassword = $_POST['confirm-password'];

    // Fetch current password from the database for the user
    $sql = "SELECT pWord FROM users WHERE Email = '$email'";
    
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
         
        // Verify if the current password matches the stored password
        
            // Check if the new password matches the confirmation password
            if ($newPassword === $confirmPassword) {
                // Hash the new password
                

                // Update the password in the database
                $updateSql = "UPDATE users SET pWord = '$newPassword' WHERE Email = '$email'";

                if ($conn->query($updateSql) === TRUE) {
                    echo "Password updated successfully!";
                } else {
                    echo "Error updating password: " . $conn->error;
                }
            } else {
                echo "New password and confirmation do not match.";
            }
        
    } else {
        echo "User not found.";
    }
}

$conn->close();
?>
