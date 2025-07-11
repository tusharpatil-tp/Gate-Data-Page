<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// MySQL connection (remote DB on 10.1.0.4)
$servername = "10.1.0.4";
$username = "webuser";             // your MySQL username
$password = "StrongPassword123";   // your MySQL password
$database = "userdb";              // your database name

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get data from form
    $user = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';

    // Check for empty fields
    if (empty($user) || empty($email)) {
        die("Both username and email are required.");
    }

    // Connect to remote MySQL server
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert user data using prepared statements
    $stmt = $conn->prepare("INSERT INTO users (username, email) VALUES (?, ?)");
    $stmt->bind_param("ss", $user, $email);

    if ($stmt->execute()) {
        echo "✅ User inserted successfully!";
    } else {
        echo "❌ Error: " . $stmt->error;
    }

    // Cleanup
    $stmt->close();
    $conn->close();
} else {
    echo "Please submit the form.";
}
?>
