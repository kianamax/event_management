<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "event_management";

// Initialize events array
$events = [];

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Fetch events from the database
    $stmt = $pdo->prepare("SELECT * FROM events ORDER BY event_date");
    $stmt->execute();
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch(PDOException $e) {
    // Log the error and show a user-friendly message
    error_log("Database Error: " . $e->getMessage());
    $error_message = "Unable to connect to the database. Please try again later.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upcoming Events</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #0a0a0a;
            color: white;
        }
        /* ... rest of your styles ... */
    </style>
</head>
<body class="min-h-screen p-8">
    <div class="container mx-auto">
        <h1 class="text-5xl font-bold mb-12 text-center gradient-text">Upcoming Events</h1>
        
        <?php if (isset($error_message)): ?>
            <div class="text-red-500 text-center mb-8">
                <?= htmlspecialchars($error_message) ?>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php if (!empty($events)): ?>
                <?php foreach ($events as $event): ?>
                    <div class="event-card rounded-xl shadow-2xl overflow-hidden">
                        <?php if (isset($event['poster_filename']) && $event['poster_filename']): ?>
                            <div class="overflow-hidden">
                                <img src="uploads/<?= htmlspecialchars($event['poster_filename']) ?>" 
                                     alt="<?= htmlspecialchars($event['event_name']) ?>" 
                                     class="event-image hover:scale-105 transition-transform duration-500">
                            </div>
                        <?php else: ?>
                            <div class="event-image-placeholder">
                                <span class="text-gray-400">No image available</span>
                            </div>
                        <?php endif; ?>
                        
                        <div class="p-6">
                            <h2 class="text-2xl font-bold mb-2">
                                <?= htmlspecialchars($event['event_name'] ?? '') ?>
                            </h2>
                            <p class="text-gray-400 mb-2">
                                <?= isset($event['event_date']) ? date('F j, Y', strtotime($event['event_date'])) : '' ?>
                            </p>
                            <p class="text-gray-300 mb-4">
                                <?= htmlspecialchars($event['venue'] ?? '') ?>
                            </p>
                            <p class="text-2xl font-bold mb-6 text-purple-400">
                                $<?= number_format($event['ticket_price'] ?? 0, 2) ?>
                            </p>
                            <button onclick="window.location.href='checkout.php?event_id=<?= $event['id'] ?>'" class="btn-primary px-6 py-3 rounded-lg w-full text-white font-semibold transform hover:scale-105 transition-all">
    Book Now
</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-span-3 text-center text-gray-400">
                    <p>No events found.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>