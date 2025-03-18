<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "post";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle new post submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'], $_POST['post'], $_POST['email'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $post = $conn->real_escape_string($_POST['post']);
    $email = $conn->real_escape_string($_POST['email']);
    
    $sql = "INSERT INTO posts (title, post, email) VALUES ('$title', '$post', '$email')";
    
    if ($conn->query($sql) === TRUE) {
        echo "New post added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch posts from the database
$sql = "SELECT title, post, email FROM posts";
$result = $conn->query($sql);

$posts = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $posts[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .header {
            background-color: #333;
            color: white;
            padding: 10px;
            text-align: center;
        }
        .tabs {
            display: flex;
            background-color: #444;
            color: white;
            justify-content: center;
        }
        .tabs button {
            background-color: #444;
            border: none;
            padding: 14px 20px;
            cursor: pointer;
            flex-grow: 1;
            text-align: center;
        }
        .tabs button:hover {
            background-color: #666;
        }
        .tabs button.active {
            background-color: #4CAF50;
        }
        .tab-content {
            display: none;
            padding: 20px;
            background-color: white;
            margin-top: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .active-content {
            display: block;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
        }
        button:hover {
            background-color: #45a049;
        }
        .post-box {
            background-color: white;
            padding: 20px;
            margin: 10px 0;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

<div class="header">
    <h1>Blog Dashboard</h1>
</div>

<div class="tabs">
    <button class="tab-link active" onclick="openTab(event, 'account-details')">Account Details</button>
    <button class="tab-link" onclick="openTab(event, 'add-post')">Add a Post</button>
    <button class="tab-link" onclick="openTab(event, 'view-posts')">View All Posts</button>
    <button class="tab-link" onclick="openTab(event, 'change-password')">Change Password</button>
</div>

<!-- Account Details Tab -->
<div id="account-details" class="tab-content active-content">
    <h2>Account Details</h2>
    <p>Here, you can view your account information.</p>
    <!-- Display user account info here -->
</div>

<!-- Add Post Tab -->
<div id="add-post" class="tab-content">
    <h2>Add a New Post</h2>
    <form id="new-post-form">
        <label for="title">Post Title:</label>
        <input type="text" id="title" name="title" required>
        
        <label for="post">Post Content:</label>
        <textarea id="post" name="post" rows="5" required></textarea>
        
        <label for="email">Your Email:</label>
        <input type="email" id="email" name="email" required>
        
        <button type="submit">Submit Post</button>
    </form>
</div>

<!-- View Posts Tab -->
<div id="view-posts" class="tab-content">
    <h2>All Blog Posts</h2>
    <div id="posts-container">
        <?php foreach ($posts as $post): ?>
            <div class="post-box">
                <h2><?php echo htmlspecialchars($post['title']); ?></h2>
                <p><?php echo nl2br(htmlspecialchars($post['post'])); ?></p>
                <p class="email">Posted by: <?php echo htmlspecialchars($post['email']); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Change Password Tab -->
<div id="change-password" class="tab-content">
    <h2>Change Password</h2>
    <p>Here, you can change your password.</p>
    <!-- Add change password form here -->
</div>

<script>
    // Function to handle tab switching
    function openTab(evt, tabName) {
        var i, tabContent, tabLinks;
        
        // Hide all tab content
        tabContent = document.getElementsByClassName("tab-content");
        for (i = 0; i < tabContent.length; i++) {
            tabContent[i].classList.remove("active-content");
        }
        
        // Remove "active" class from all tabs
        tabLinks = document.getElementsByClassName("tab-link");
        for (i = 0; i < tabLinks.length; i++) {
            tabLinks[i].classList.remove("active");
        }
        
        // Show the clicked tab's content and add the active class to the clicked tab
        document.getElementById(tabName).classList.add("active-content");
        evt.currentTarget.classList.add("active");
    }

    // Handle form submission via AJAX
    document.getElementById("new-post-form").addEventListener("submit", function(event) {
        event.preventDefault();  // Prevent the form from submitting normally

        const formData = new FormData(this);

        // Make an AJAX request to the PHP server to add the new post
        fetch("index.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            // If data is an error, log it
            if (data.error) {
                console.error(data.error);
                alert("Error adding post.");
            } else {
                // Clear the form
                document.getElementById("new-post-form").reset();

                // Update the posts dynamically
                updatePosts(data);
            }
        })
        .catch(error => {
            console.error("Error:", error);
        });
    });

    // Function to update the posts on the page
    function updatePosts(posts) {
        const postsContainer = document.getElementById("posts-container");
        postsContainer.innerHTML = "";  // Clear existing posts

        // Add all posts to the container
        posts.forEach(post => {
            const postBox = document.createElement("div");
            postBox.classList.add("post-box");

            const title = document.createElement("h2");
            title.innerText = post.title;

            const content = document.createElement("p");
            content.innerText = post.post;

            const email = document.createElement("p");
            email.classList.add("email");
            email.innerText = "Posted by: " + post.email;

            postBox.appendChild(title);
            postBox.appendChild(content);
            postBox.appendChild(email);

            postsContainer.appendChild(postBox);
        });
    }
</script>

</body>
</html>
