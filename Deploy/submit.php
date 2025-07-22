<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database credentials
$host = "10.0.1.4";    // Changed to your MySQL server IP
$dbname = "user_data";
$dbuser = "newuser";       // Your MySQL username
$dbpass = "newpassword";   // Your MySQL password

// Connect to MySQL server (no DB selected yet)
$conn = new mysqli($host, $dbuser, $dbpass);

// Check connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

// Create database if it doesn't exist
if (!$conn->query("CREATE DATABASE IF NOT EXISTS $dbname")) {
    die("❌ Failed to create database: " . $conn->error);
}

// Select the database
$conn->select_db($dbname);

// Create users table if it doesn't exist
$createTableSQL = "
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL
)";

if (!$conn->query($createTableSQL)) {
    die("❌ Failed to create table: " . $conn->error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if (!empty($username) && !empty($email)) {
        $stmt = $conn->prepare("INSERT INTO users (username, email) VALUES (?, ?)");

        if ($stmt) {
            $stmt->bind_param("ss", $username, $email);
            if ($stmt->execute()) {
                echo "✅ User registered successfully!";
            } else {
                echo "❌ Error while inserting: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "❌ Failed to prepare statement: " . $conn->error;
        }
    } else {
        echo "❗ Both username and email are required.";
    }
} else {
    echo "⛔ Invalid request.";
}

$conn->close();
?>
