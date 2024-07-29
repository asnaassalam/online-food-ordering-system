<?php
// Establish a connection to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "restaurant";

// Enable error reporting (for debugging)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
    throw new Exception("Connection failed: " . $conn->connect_error);
  }

  // Query to fetch user count
  $sql = "SELECT COUNT(*) AS totalUsers FROM users";
  $result = $conn->query($sql);

  if ($result === false) {
    throw new Exception("Query failed: " . $conn->error);
  }

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalUsers = $row["totalUsers"];
  } else {
    $totalUsers = 0;
  }

  // Close connection
  $conn->close();

  // Return JSON response
  header('Content-Type: application/json');
  echo json_encode(['totalUsers' => $totalUsers]);
} catch (Exception $e) {
  http_response_code(500); // Internal Server Error
  echo json_encode(['error' => $e->getMessage()]);
}
?>
