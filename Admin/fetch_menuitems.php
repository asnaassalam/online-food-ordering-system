

<?php
// Establish a connection to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "restaurant";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Query to fetch menu item count
$sql = "SELECT COUNT(*) AS totalItems FROM menuitem";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $totalItems = $row["totalItems"];
} else {
  $totalItems = 0;
}

$conn->close();

// Return JSON response
header('Content-Type: application/json');
echo json_encode(['totalItems' => $totalItems]);
?>
