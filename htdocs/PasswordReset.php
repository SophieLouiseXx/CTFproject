<!DOCTYPE HTML>
<html>
    <head>

    </head>
        <body>
            <form method = "POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"  > <!-- [PHP_SELF is to prevent the page from redirecting to another page and just passes information onto itself] -->
            <input type="email" name="Email" placeholder="Email..." pattern="^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]+$" title = "Enter a valid email"><!-- The 'name=' is used for the PHP section for assigning it to a variable that can be used by PHP--></span>
            <input type="submit" name="submit">  
            </form>
            </div>
        </body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

$person = $_POST["Email"];
$to = 'raykha201@student.loreto.ac.uk';
$subject = 'Tester';
$message = 'Hi, does this work'; 
 
// Sending email
if(mail($person, $subject, $message)){
     echo'<script>alert("Your mail has been sent successfully. Please check your email and follow the instructions in it.") </script>';
    } else{
    echo 'Unable to send email. Please try again.';
}
}
?>
