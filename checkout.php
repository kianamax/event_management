<?php
session_start();
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "event_management";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Fetch event details
    if(isset($_GET['event_id'])) {
        $stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
        $stmt->execute([$_GET['event_id']]);
        $event = $stmt->fetch(PDO::FETCH_ASSOC);
    }
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - <?= htmlspecialchars($event['event_name']) ?></title>
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
        .checkout-card {
            background-color: #111111;
            border: 1px solid #2d2d2d;
        }
        .input-field {
            background-color: #1a1a1a;
            border: 1px solid #3d3d3d;
            color: white;
        }
        .input-field:focus {
            border-color: #8B5CF6;
            outline: none;
        }
        .payment-option {
            border: 2px solid #3d3d3d;
            transition: all 0.3s;
        }
        .payment-option:hover {
            border-color: #8B5CF6;
        }
        .payment-option.selected {
            border-color: #8B5CF6;
            background-color: rgba(139, 92, 246, 0.1);
        }
    </style>
</head>
<body class="min-h-screen p-8">
    <div class="container mx-auto max-w-4xl">
        <h1 class="text-4xl font-bold mb-8 text-center gradient-text">Checkout</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Event Summary -->
            <div class="checkout-card rounded-xl p-6 space-y-4">
                <h2 class="text-2xl font-bold mb-4">Event Details</h2>
                <?php if (isset($event['poster_filename'])): ?>
                    <img src="uploads/<?= htmlspecialchars($event['poster_filename']) ?>" 
                         alt="<?= htmlspecialchars($event['event_name']) ?>" 
                         class="w-full h-48 object-cover rounded-lg mb-4">
                <?php endif; ?>
                <div class="space-y-2">
                    <p class="text-xl font-bold"><?= htmlspecialchars($event['event_name']) ?></p>
                    <p class="text-gray-400"><?= date('F j, Y', strtotime($event['event_date'])) ?></p>
                    <p class="text-gray-300"><?= htmlspecialchars($event['venue']) ?></p>
                    <p class="text-2xl font-bold text-purple-400">KES <?= number_format($event['ticket_price'], 2) ?></p>
                </div>
            </div>

            <!-- Checkout Form -->
            <form action="process_order.php" method="POST" class="checkout-card rounded-xl p-6 space-y-6">
                <h2 class="text-2xl font-bold mb-4">Your Information</h2>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-gray-300 mb-2">Full Name</label>
                        <input type="text" name="full_name" required
                               class="input-field w-full px-4 py-2 rounded-lg">
                    </div>
                    
                    <div>
                        <label class="block text-gray-300 mb-2">Email</label>
                        <input type="email" name="email" required
                               class="input-field w-full px-4 py-2 rounded-lg">
                    </div>
                    
                    <div>
                        <label class="block text-gray-300 mb-2">Phone Number</label>
                        <input type="tel" name="phone" required
                               class="input-field w-full px-4 py-2 rounded-lg">
                    </div>

                    <div>
                        <label class="block text-gray-300 mb-2">Select Payment Method</label>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="payment-option rounded-lg p-4 cursor-pointer" onclick="selectPayment('mpesa')">
                                <input type="radio" name="payment_method" value="mpesa" required class="hidden" id="mpesa">
                                <label for="mpesa" class="cursor-pointer">
                                    <div class="text-center">
                                        <div class="text-lg font-bold mb-2">M-PESA</div>
                                        <div class="text-sm text-gray-400">Pay via M-PESA</div>
                                    </div>
                                </label>
                            </div>
                            
                            <div class="payment-option rounded-lg p-4 cursor-pointer" onclick="selectPayment('airtel')">
                                <input type="radio" name="payment_method" value="airtel" required class="hidden" id="airtel">
                                <label for="airtel" class="cursor-pointer">
                                    <div class="text-center">
                                        <div class="text-lg font-bold mb-2">Airtel Money</div>
                                        <div class="text-sm text-gray-400">Pay via Airtel Money</div>
                                    </div>
                                </label>
                            </div>
                            
                            <div class="payment-option rounded-lg p-4 cursor-pointer" onclick="selectPayment('card')">
                                <input type="radio" name="payment_method" value="card" required class="hidden" id="card">
                                <label for="card" class="cursor-pointer">
                                    <div class="text-center">
                                        <div class="text-lg font-bold mb-2">Card</div>
                                        <div class="text-sm text-gray-400">Credit/Debit Card</div>
                                    </div>
                                </label>
                            </div>
                            
                            <div class="payment-option rounded-lg p-4 cursor-pointer" onclick="selectPayment('paypal')">
                                <input type="radio" name="payment_method" value="paypal" required class="hidden" id="paypal">
                                <label for="paypal" class="cursor-pointer">
                                    <div class="text-center">
                                        <div class="text-lg font-bold mb-2">PayPal</div>
                                        <div class="text-sm text-gray-400">Pay via PayPal</div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="event_id" value="<?= $event['id'] ?>">
                <input type="hidden" name="amount" value="<?= $event['ticket_price'] ?>">
                
                <button type="submit" 
                        class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-4 rounded-lg transition-all duration-300 transform hover:scale-105">
                    Pay KES <?= number_format($event['ticket_price'], 2) ?>
                </button>
            </form>
        </div>
    </div>

    <script>
        function selectPayment(method) {
            // Remove selected class from all options
            document.querySelectorAll('.payment-option').forEach(option => {
                option.classList.remove('selected');
            });
            
            // Add selected class to chosen option
            document.querySelector(`#${method}`).closest('.payment-option').classList.add('selected');
            document.querySelector(`#${method}`).checked = true;
        }
    </script>
</body>
</html>