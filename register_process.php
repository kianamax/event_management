<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "event_management";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $email = $_POST["email"];  // Added email field
    $usertype = $_POST["usertype"];
    $town = $_POST["town"];
    
    // Check if username or email already exists
    $checkQuery = "SELECT * FROM users WHERE username = ? OR email = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("ss", $username, $email);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();
    
    if ($checkResult->num_rows > 0) {
        echo "Username or email already exists. Please choose a different username or email.";
    } else {
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO users (username, password, email, user_type, town) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $username, $password, $email, $usertype, $town);
        
        // Execute the statement
        if ($stmt->execute()) {
            echo "Registration successful!";
            
            // Redirect to login page
            header("Location: login.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        
        $stmt->close();
    }
    
    $checkStmt->close();
}

$conn->close();
?>