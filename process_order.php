<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "event_management";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Generate unique order ID
    $order_id = 'ORD' . date('YmdHis') . rand(100, 999);
    
    // Insert order into database
    $stmt = $pdo->prepare("INSERT INTO orders (order_id, event_id, full_name, email, phone, amount) 
                          VALUES (?, ?, ?, ?, ?, ?)");
    
    $stmt->execute([
        $order_id,
        $_POST['event_id'],
        $_POST['full_name'],
        $_POST['email'],
        $_POST['phone'],
        $_POST['amount']
    ]);
    
    // Store order details in session for receipt page
    $_SESSION['order'] = [
        'order_id' => $order_id,
        'full_name' => $_POST['full_name'],
        'email' => $_POST['email'],
        'phone' => $_POST['phone'],
        'amount' => $_POST['amount'],
        'payment_method' => $_POST['payment_method'],
        'event_id' => $_POST['event_id']
    ];
    
    // Redirect to receipt page
    header("Location: receipt.php");
    exit();
    
} catch(PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>