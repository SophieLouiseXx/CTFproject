<!DOCTYPE HTML>  
<html>
<head>
<style>
body {
    background-image: url('Sign_Up.JPG.jpg');
    background-repeat: no-repeat; /* This is done to ensure the picture isnt repeated in the page.*/
    background-attachment: fixed;
    background-size: cover; /* */
}
div{ /*Background*/
  border-radius:25px; /* Decides how round a corner is. The higher the number, the more rounded it is. */
  display:block;
  margin:auto;
  width: 500px;
  background-color:silver;
}
span{/* The error fields*/
  text-align:left;
    width: 80%;  
    margin: auto;
    display: block;
    box-sizing: border-box;
}
input[type=text]{ /* User input fields*/
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
input[type=submit]{ /* Name and surname input boxes */
  text-align:left;
  margin: auto;
  display: block;
}
h2{ text-align:center;/* Title */
  font-family: "Times New Roman", Times, serif;
  font-size:36px;
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
input[type=password]{
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
</style>
</head>
<body>  

<?php //////////////////////////////////////////////////////////Unused code put in comments/////////////////////////////////////////////////////////////////
//Assign variables which will be used to write to the database.
//$nameError = $surnameError = $emailError = $passwordError = $password_confirmError = "";
//$txtname = $txtsurname = $txtEmail = $txtPassword = $txtPassword_confirm= "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $pass = true; // This variable is used to prevent the code from writing the incorrect information to the database. 
  $txtname = clean_input($_POST["fName"]); //before assigning the users input data from the form into these variables, they will need to be in a format which will prevent a run-time error.
  $txtsurname = clean_input($_POST["sName"]);
  $txtEmail = clean_input($_POST["Email"]);
  $txtPassword  = clean_input($_POST["Pword"]);
  

  if (empty($txtname)){
    $nameError = "Name cannot be empty";
    $pass = false;

  }if (empty($txtsurname)){
    $surnameError = "Surname cannot be empty";
    $pass = false;

  }if (empty($txtEmail)){
    $emailError = "You must enter your email";
    $pass = false;
  
  }if (empty($txtPassword)){
    $passwordError = "Password cannot be empty";
    $pass = false;
  }}
  /*}elseif (!preg_match("/[@]/", $txtEmail) or (!preg_match("/[.]/", $txtEmail))){
    $emailError = "Please enter a valid email";
  $a = false;

  }
  
  

  }elseif (strlen($txtPassword) > 20 or (strlen($txtPassword)< 8)){ s
    $passwordError = "Password too short/long";
    $a = false;

  }elseif (!preg_match("/[a-z]/", $txtPassword)){
  $passwordError = "Password must contain at least 1 lowercase character";
  $a = false;

  }elseif (!preg_match("/[A-Z]/",$txtPassword)){
    $passwordError = "Passord must contail at least 1 uppercase character";
    $a = false;

  }elseif (!preg_match("/[\'^£$%&*()}{@#~?><>,|=_+¬-]/",$txtPassword)){
    $passwordError = "You need at least 1 special character";
  $a = false;

  }*/

//cleans the input by removing possibe mistakes the user may input which may result in a run time error.
function clean_input($data) { //takes in the data where this function is called and stores it temporarily in the $data variable so it can work with it before overwriting the original value.
    $data = trim($data); // removes spaces which may be accidentally put in at the beginning and the end of their input. 
  $data = stripslashes($data); //unquotes a quoted string
  return $data;
}
?>

<div>
<h2>Sign up</h2>
<form method = "POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"  > <!-- [PHP_SELF is to prevent the page from redirecting to another page and just passes information onto itself] -->
  <br> 
  <input type="text" name="fName" placeholder="Name..." pattern="[A-Za-z]{1,15}" title = "No invalid characters in the name">  <!--The placeholder is what the greyed out text is in text boxes when you sign up on a website--> <span style="color:red">* <?php echo $nameError;?></span>
  <br><br>
  <input type="text"  name="sName" placeholder="Surname..." pattern="[A-Za-z]{1,15}" title = "No invalid characters in the surname"><!--The 'type=' tells the text box what information is expected in the boxes by the user--> <span style="color:red">* <?php echo $surnameError;?></span>
  <br><br>
  <input type="email" name="Email" placeholder="Email..." pattern="^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]+$" title = "Enter a valid email"><!-- The 'name=' is used for the PHP section for assigning it to a variable that can be used by PHP--><span style="color:red">* <?php echo $emailError;?></span>
  <br><br>
  <input type="password" name="Pword" placeholder="Password...(Between 8-20 characters)" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,20}" title="Must contain at least one number, one uppercase and lowercase letter and be between 8-20 characters"><span style="color:red">* <?php echo $passwordError;?></span>
  <br><br>
      <input type="submit" name="submit" value="Sign Up">  
</form>
</div>
<?php


//Writes the users information to the database once the 
if ($pass == true){ //$a is a variable 
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "user";
        
// This section is create a  connection connection to the server using the $conn function which calls for a server connection
$conn = new mysqli($servername, $username, $password, $dbname);
// This is a troubleshooting step which i added to help with development by allowing me to see if it has been able to successfully connect to the server.
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} else {
  echo ("hello");
}
$id = uniqid($txtname);
echo $id;


//Specifying what i want the SQL to do with my information on the server and where to save the information.
$sql = $sql = "INSERT INTO users (`fName`, `sName`, `Email`, `pWord`, `uID`) VALUES ('$txtname', '$txtsurname', '$txtEmail','$txtPassword','$id')";
//another validation section where I can get a detailed breakdown of an issue if something is to go wrong.
if ($conn->query($sql) === false) {
  echo "Error: " . $sql . "<br>" . $conn->error;
  exit;
} 
$conn->close();
header('Location: ../index.html'); // This will return to the main HTML page once the users details are stored into the database.
exit;
}
?>

</body>
</html>