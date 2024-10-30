<?php
session_start();
// Check if user is logged in and is admin
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Database connection
$conn = new mysqli("localhost", "root", "", "event_management");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle deletions
if (isset($_POST['delete_user'])) {
    $user_id = $conn->real_escape_string($_POST['user_id']);
    $conn->query("DELETE FROM users WHERE user_id = '$user_id'");
}

if (isset($_POST['delete_event'])) {
    $event_id = $conn->real_escape_string($_POST['event_id']);
    $conn->query("DELETE FROM events WHERE id = '$event_id'");
}

if (isset($_POST['delete_order'])) {
    $order_id = $conn->real_escape_string($_POST['order_id']);
    $conn->query("DELETE FROM orders WHERE id = '$order_id'");
}

// Fetch users, events, and orders with joins for more information
$users = $conn->query("SELECT * FROM users WHERE user_type != 'admin'");
$events = $conn->query("SELECT * FROM events");
$orders = $conn->query("
    SELECT orders.*, events.event_name, events.event_date, events.venue 
    FROM orders 
    JOIN events ON orders.event_id = events.id 
    ORDER BY orders.order_date DESC
");

// Calculate total revenue
$total_revenue = $conn->query("SELECT SUM(amount) as total FROM orders")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #1a1a1a;
            color: #ffffff;
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: #2d1b4e;
            padding: 20px;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }

        .main-content {
            flex: 1;
            padding: 20px;
            margin-left: 250px;
        }

        .logo {
            color: #fff;
            font-size: 24px;
            text-align: center;
            margin-bottom: 30px;
        }

        .nav-link {
            display: block;
            padding: 10px;
            color: #fff;
            text-decoration: none;
            margin-bottom: 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .nav-link:hover {
            background-color: #4a2b7e;
        }

        .card {
            background-color: #2d1b4e;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .card h2 {
            color: #fff;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #4a2b7e;
        }

        th {
            background-color: #4a2b7e;
            color: #fff;
        }

        .btn-delete {
            background-color: #dc3545;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }

        .dashboard-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background-color: #4a2b7e;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }

        .stat-card h3 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .stat-card p {
            font-size: 16px;
            color: #ccc;
        }

        .badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
        }

        .badge-success {
            background-color: #28a745;
            color: white;
        }

        .search-box {
            padding: 10px;
            background: #1a1a1a;
            border: 1px solid #4a2b7e;
            border-radius: 5px;
            color: white;
            width: 100%;
            max-width: 300px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <div class="logo">Admin Dashboard</div>
            <nav>
                <a href="#overview" class="nav-link">Overview</a>
                <a href="#orders" class="nav-link">Orders</a>
                <a href="#users" class="nav-link">Users</a>
                <a href="#events" class="nav-link">Events</a>
                <a href="index.php" class="nav-link">Logout</a>
            </nav>
        </div>

        <div class="main-content">
            <div id="overview" class="dashboard-stats">
                <div class="stat-card">
                    <h3><?php echo $users->num_rows; ?></h3>
                    <p>Total Users</p>
                </div>
                <div class="stat-card">
                    <h3><?php echo $events->num_rows; ?></h3>
                    <p>Total Events</p>
                </div>
                <div class="stat-card">
                    <h3><?php echo $orders->num_rows; ?></h3>
                    <p>Total Orders</p>
                </div>
                <div class="stat-card">
                    <h3>KES <?php echo number_format($total_revenue, 2); ?></h3>
                    <p>Total Revenue</p>
                </div>
            </div>

            <div id="orders" class="card">
                <h2>Manage Orders</h2>
                <input type="text" id="orderSearch" class="search-box" placeholder="Search orders...">
                <table>
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Event</th>
                            <th>Customer</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($order = $orders->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                            <td>
                                <?php echo htmlspecialchars($order['event_name']); ?><br>
                                <small class="text-gray-400">
                                    <?php echo date('M j, Y', strtotime($order['event_date'])); ?>
                                </small>
                            </td>
                            <td><?php echo htmlspecialchars($order['full_name']); ?></td>
                            <td><?php echo htmlspecialchars($order['email']); ?></td>
                            <td><?php echo htmlspecialchars($order['phone']); ?></td>
                            <td>KES <?php echo number_format($order['amount'], 2); ?></td>
                            <td><?php echo date('M j, Y H:i', strtotime($order['order_date'])); ?></td>
                            <td>
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                    <button type="submit" name="delete_order" class="btn-delete" 
                                            onclick="return confirm('Are you sure you want to delete this order?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <div id="users" class="card">
                <h2>Manage Users</h2>
                <input type="text" id="userSearch" class="search-box" placeholder="Search users...">
                <table>
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Email</th>
                            <th>User Type</th>
                            <th>Town</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($user = $users->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['user_type']); ?></td>
                            <td><?php echo htmlspecialchars($user['town']); ?></td>
                            <td>
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                                    <button type="submit" name="delete_user" class="btn-delete" 
                                            onclick="return confirm('Are you sure you want to delete this user?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <div id="events" class="card">
                <h2>Manage Events</h2>
                <input type="text" id="eventSearch" class="search-box" placeholder="Search events...">
                <table>
                    <thead>
                        <tr>
                            <th>Event Name</th>
                            <th>Date</th>
                            <th>Venue</th>
                            <th>Ticket Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($event = $events->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($event['event_name']); ?></td>
                            <td><?php echo htmlspecialchars($event['event_date']); ?></td>
                            <td><?php echo htmlspecialchars($event['venue']); ?></td>
                            <td>KES <?php echo htmlspecialchars($event['ticket_price']); ?></td>
                            <td>
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>">
                                    <button type="submit" name="delete_event" class="btn-delete"
                                            onclick="return confirm('Are you sure you want to delete this event?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
    // Search functionality
    function setupSearch(inputId, tableId) {
        document.getElementById(inputId).addEventListener('keyup', function() {
            const searchText = this.value.toLowerCase();
            const table = this.closest('.card').getElementsByTagName('tbody')[0];
            const rows = table.getElementsByTagName('tr');
            
            for (let row of rows) {
                const cells = row.getElementsByTagName('td');
                let found = false;
                
                for (let cell of cells) {
                    if (cell.textContent.toLowerCase().includes(searchText)) {
                        found = true;
                        break;
                    }
                }
                
                row.style.display = found ? '' : 'none';
            }
        });
    }

    // Setup search for all tables
    setupSearch('orderSearch');
    setupSearch('userSearch');
    setupSearch('eventSearch');
    </script>
</body>
</html>