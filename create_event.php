<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

// Database connection
$servername = "localhost";  // Changed from $host
$username = "root";
$password = "";
$dbname = "event_management";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die(json_encode(['error' => 'Connection failed: ' . $e->getMessage()]));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_name = $_POST['eventName'];
    $event_date = $_POST['eventDate'];
    $venue = $_POST['eventVenue'];
    $ticket_price = $_POST['ticketPrice'];
    
    // Handle file upload
    $poster_filename = null;
    if(isset($_FILES['eventPoster']) && $_FILES['eventPoster']['error'] == 0) {
        $target_dir = "uploads/";
        $poster_filename = uniqid() . '_' . basename($_FILES["eventPoster"]["name"]);
        $target_file = $target_dir . $poster_filename;
        
        // You might want to add more checks here (file type, size, etc.)
        if (!move_uploaded_file($_FILES["eventPoster"]["tmp_name"], $target_file)) {
            die(json_encode(['error' => 'Failed to upload file.']));
        }
    }

    // Insert data into database
    $sql = "INSERT INTO events (event_name, event_date, venue, ticket_price, poster_filename) 
            VALUES (:event_name, :event_date, :venue, :ticket_price, :poster_filename)";
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':event_name' => $event_name,
            ':event_date' => $event_date,
            ':venue' => $venue,
            ':ticket_price' => $ticket_price,
            ':poster_filename' => $poster_filename
        ]);
        echo json_encode(['success' => 'Event created successfully!']);
    } catch(PDOException $e) {
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Invalid request method.']);
}
?>