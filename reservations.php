<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "restaurant";

// Enable error reporting (optional, for debugging)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Establishing connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handling form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collecting form data
    $email = $_POST['email'];
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $noOfGuests = $_POST['noOfGuests'];
    $reservedTime = $_POST['reservedTime']; // Input format is 'HH:MM'
    $reservedDate = $_POST['reservedDate']; // Input format is 'YYYY-MM-DD'

    // Debug: Check the raw reservedTime input
    echo "Raw Reserved Time: " . htmlspecialchars($reservedTime) . "<br>";

    // Process reservedTime to ensure it includes seconds
    $reservedTimeWithSeconds = date('H:i:s', strtotime($reservedTime));
    
    // Debug: Check the processed reservedTime
    echo "Processed Reserved Time: " . htmlspecialchars($reservedTimeWithSeconds) . "<br>";

    // Prepare SQL statement to insert data into reservations table
    $sql = "INSERT INTO reservations (email, name, contact, noOfGuests, reservedTime, reservedDate) 
            VALUES (?, ?, ?, ?, ?, ?)";

    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("sssiis", $email, $name, $contact, $noOfGuests, $reservedTimeWithSeconds, $reservedDate);

    // Execute the statement
    if ($stmt->execute()) {
        echo '<script>alert("Reservation successful!"); window.location.href="index.php";</script>';
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>
