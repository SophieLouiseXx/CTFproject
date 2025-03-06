<!DOCTYPE html>
<html>
    <body>
        <style>
            body{
              background-image: url('Sign_In.JPG.jpg');
              background-repeat: no-repeat; /* This is done to ensure the picture isnt repeated in the page.*/
              background-attachment: fixed;
              background-size: cover;
            }
            input[type=email]{
              text-align:center;
              width: 80%;
              height: 10%;
              padding: 12px 20px;
              margin: auto;
              display: block;
              box-sizing: border-box;
              border:red;
              border-radius:6px;
            }
            input[type=text]{
              text-align:center;
              width: 80%;
              height: 10%;
              padding: 12px 20px;
              margin: auto;
              display: block;
              box-sizing: border-box;
              border:red;
              border-radius:6px;
            }
            div{ /*Background*/
              text-align:center;
              border-radius:25px; /* Decides how round a corner is. The higher the number, the more rounded it is. */
              display:block;
              margin:auto;
              width: 500px;
              length: 500px;
              background-color:silver;
            }
  </style>
          <div>
          <form method = "POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            E-mail: <input type="email" name="email" placeholder="Email..." pattern="^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]+$" title = "Enter a valid email"><br> <!-- The pattern is only used to tell the user whether their entered email is in a valid format or not. This will help users who feel they  -->
            Password: <input type="text" name="Password"> <br> <!-- Password will be in pure text form to prevent potential -->
            <a href="../PasswordReset.php">Forgotten Password?</a>
                    <br>
            <input type = "Submit" value="Sign in" >
          </form>
          </div>
        </body>
    </html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$email = $_POST["email"];
$pWord = $_POST["Password"];
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "user";
$error = "You have entered an incorrect email/password.";      
// This section is create a  connection connection to the server using the $conn function which calls for a server connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT* FROM users WHERE Email='$email' && pWord = '$pWord'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {
  echo "You exist!!", $email; // REDIRECT to BOOKSYS.PHP
  $conn->close();
  header('Location: ../Booking/BOOKSYS.php ');

} else {
  echo "<script type='text/javascript'>alert('$error');</script>";
  exit;
}

mysqli_close($conn);
}
?>  