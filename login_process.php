<?php
session_start();
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
    $password = $_POST["password"];
    
    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['username'] = $username;
            $_SESSION['user_type'] = $row['user_type'];
            
            switch ($row["user_type"]) {
                case "event_organiser":
                    header("Location: organizer.php");
                    break;
                case "attendee":
                    header("Location: attendee_events.php");
                    break;
                case "admin":
                    header("Location: admin_dashboard.php");
                    break;
                default:
                    echo "Invalid user type";
                    break;
            }
            exit();
        } else {
            echo "Incorrect password";
        }
    } else {
        echo "User not found";
    }
    
    $stmt->close();
}

$conn->close();
?>