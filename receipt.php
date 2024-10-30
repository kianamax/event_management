<?php
session_start();

if (!isset($_SESSION['order'])) {
    header("Location: index.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "event_management";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Fetch event details
    $stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
    $stmt->execute([$_SESSION['order']['event_id']]);
    $event = $stmt->fetch(PDO::FETCH_ASSOC);
    
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Receipt</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #0a0a0a;
            color: white;
        }
        .gradient-text {
            background: linear-gradient(to right, #8B5CF6, #C084FC);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .receipt-card {
            background-color: #111111;
            border: 1px solid #2d2d2d;
        }
    </style>
</head>
<body class="min-h-screen p-8">
    <div class="container mx-auto max-w-2xl">
        <div class="receipt-card rounded-xl p-8 space-y-6">
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold gradient-text mb-2">Thank You!</h1>
                <p class="text-gray-400">Your ticket has been booked successfully</p>
            </div>
            
            <div class="border-t border-b border-gray-800 py-6 space-y-4">
                <h2 class="text-2xl font-bold">Order Details</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-400">Order ID</p>
                        <p class="font-bold"><?= htmlspecialchars($_SESSION['order']['order_id']) ?></p>
                    </div>
                    <div>
                        <p class="text-gray-400">Event</p>
                        <p class="font-bold"><?= htmlspecialchars($event['event_name']) ?></p>
                    </div>
                    <div>
                        <p class="text-gray-400">Date</p>
                        <p class="font-bold"><?= date('F j, Y', strtotime($event['event_date'])) ?></p>
                    </div>
                    <div>
                        <p class="text-gray-400">Venue</p>
                        <p class="font-bold"><?= htmlspecialchars($event['venue']) ?></p>
                    </div>
                </div>
            </div>
            
            <div class="space-y-4">
                <h2 class="text-2xl font-bold">Payment Information</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-400">Amount Paid</p>
                        <p class="font-bold text-purple-400">KES <?= number_format($_SESSION['order']['amount'], 2) ?></p>
                    </div>
                    <div>
                        <p class="text-gray-400">Payment Method</p>
                        <p class="font-bold"><?= strtoupper(htmlspecialchars($_SESSION['order']['payment_method'])) ?></p>
                    </div>
                </div>
            </div>
            
            <div class