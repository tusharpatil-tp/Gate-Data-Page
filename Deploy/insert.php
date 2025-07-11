<?php
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database credentials
    $host = "localhost";
    $dbname = "your_database_name";
    $user = "your_username";
    $pass = "your_password";

    // Create DB connection
    $conn = new mysqli($host, $user, $pass, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get and sanitize input
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);

    // Prepare and execute insert
    $stmt = $conn->prepare("INSERT INTO users (username, email) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $email);

    if ($stmt->execute()) {
        $message = "Data inserted successfully!";
    } else {
        $message = "Error: " . $stmt->error;
    }

    // Close connections
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        form {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .message {
            margin-top: 15px;
            font-weight: bold;
            color: green;
        }
    </style>
</head>
<body>

<form method="POST" action="">
    <h2>User Info</h2>
    <label for="username">Username:</label><br>
    <input type="text" name="username" required><br>

    <label for="email">Email:</label><br>
    <input type="email" name="email" required><br>

    <input type="submit" value="Submit">
    
    <?php if (!empty($message)): ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>
</form>

</body>
</html>
