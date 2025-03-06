<!DOCTYPE HTML>  
<html>
<head>
<style>
div{ /*Background*/
  border-radius:25px;
  display:block;
  margin:auto;
  width: 500px;
  background-color:orange;
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
  input[type=submit]{
    text-align:left;
    margin: auto;
    display: block;
  }

  h2{ text-align:center;/*Title*/
    font-family: "Times New Roman", Times, serif;
    font-size:36px;}
  
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

  input[type=password]
{
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

<?php //////////////////////////////////////////////////////////Unused twaddle/////////////////////////////////////////////////////////////////
//Assign variables which will be used to write to the database.
//$nameError = $surnameError = $emailError = $passwordError = $password_confirmError = "";
//$txtname = $txtsurname = $txtEmail = $txtPassword = $txtPassword_confirm= "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $a = true;
  $txtname = clean_input($_POST["fName"]); //before assigning the users input data from the form into these variables, they will need to be in a format which will prevent a run-time error.
  $txtsurname = clean_input($_POST["sName"]);
  $txtEmail = clean_input($_POST["Email"]);
  $txtPassword  = clean_input($_POST["Pword"]);
  $txtPassword_confirm = clean_input($_POST["Pword2"]);

  if (empty($txtname)){
    $nameError = "Name cannot be empty";

  }elseif (!preg_match("/[^A-Za-z]/", $txtname) == 0){
    $nameError = "Invalid characters in the name";
    $a = false;
  }
  
  if (empty($txtsurname)){
    $surnameError = "Surname cannot be empty";
    $a = false;
  }elseif (!preg_match("/[^A-Za-z]/", $txtsurname) == 0){
    $surnameError = "Invalid characters in the surname";
    $a = false;
  }
    
  /*if (empty($txtEmail)){
    $emailError = "You must enter your email";
    $a = false;

  }elseif (!preg_match("/[@]/", $txtEmail) or (!preg_match("/[.]/", $txtEmail))){
    $emailError = "Please enter a valid email";
  $a = false;

  }
  
  if (empty($txtPassword)){
    $passwordError = "Password cannot be empty";
  $a = false;

  }elseif (strlen($txtPassword) > 20 or (strlen($txtPassword)< 8)){
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
  }

//cleans the input by removing possibe mistakes the user may input which may result in a run time error such as entering a space before entering their name. 
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
  <input type="text" name="fName" placeholder="Name..."> <span style="color:red">* <?php echo $nameError;?></span>
  <br><br>
  <input type="text" name="sName" placeholder="Surname..."> <span style="color:red">* <?php echo $surnameError;?></span>
  <br><br>
  <input type="email" name="Email" placeholder="Email...!!!" ><span style="color:red">* <?php echo $emailError;?></span>
  <br><br>
  <input type="password" name="Pword" placeholder="Password...(Between 8-20 characters)" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,20}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 characters and a maximum of 20"><span style="color:red">* <?php echo $passwordError;?></span>
  <br><br>
    <input type="submit" name="submit" value="Sign Up">  
</form>
</div>
<?php


//Database writer.
if ($a == true){
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "user";

        
// This section is create a  connection connection to the server using the $conn function which calls for a server connection
$conn = new mysqli($servername, $username, $password, $dbname);
// This is a troubleshooting step which i added to help with development by allowing me to see if it has been able to successfully connect to the server.
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


//Specifying what i want the SQL to do with my information on the server and where to save the information.
$sql = $sql = "INSERT INTO users (`fName`, `sName`, `Email`, `pWord`) VALUES ('$txtname', '$txtsurname', '$txtEmail','$txtPassword')";
//another validation section where I can get a detailed breakdown of an issue if something is to go wrong.
if ($conn->query($sql) === false) {
  echo "Error: " . $sql . "<br>" . $conn->error;
  exit;
} 

$conn->close();
header("Location: index.html");

exit;
}
?>

</body>
</html>