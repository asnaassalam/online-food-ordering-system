

<?php
session_start();
$email = $_POST['email'];
$password = $_POST['password'];
//Handling the admin login to access admin dashboard.
if($email == "admin@gmail.com" && $password == "admin2024"){
  $_SESSION['adminloggedin'] = true; 
  header('Location:admin/index.php');
   exit();
}

// Establish a connection to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "restaurant";

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the email and password from the form
$email = $_POST['email'];
$password = $_POST['password'];

// Prepare and execute the SQL query to check the login details
$sql = "SELECT * FROM users WHERE email = ? AND password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $password);
$stmt->execute();
$result = $stmt->get_result();


try {
  // Check if the login details are correct
  if ($result->num_rows > 0) {
       // Store user email in session
       $_SESSION['email'] = $email;
       $_SESSION['userloggedin'] = true;
      
      echo '<script>alert("You are logged in!"); window.location.href="menu.php?userloggedin";</script>';
     
      exit();
  } else {
      // Redirect to the login page with an error message
      header("Location: login.php?error");
      exit();
  }
} catch (Exception $e) {
  // Handle the error (e.g., log the error)
  header("Location: login.php?error");
  exit();
}
// Close the connection
$conn->close();
?>