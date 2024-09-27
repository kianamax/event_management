<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brightlane - Admin Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            background: linear-gradient(135deg, #1a0033 0%, #000000 100%);
            color: #fff;
            min-height: 100vh;
            display: flex;
        }
        .sidebar {
            width: 250px;
            background: rgba(17, 17, 17, 0.8);
            padding: 20px;
            height: 100vh;
            overflow-y: auto;
        }
        .main-content {
            flex-grow: 1;
            padding: 20px;
            overflow-y: auto;
        }
        h1, h2 {
            color: #8a2be2;
            margin-bottom: 20px;
        }
        .sidebar ul {
            list-style-type: none;
        }
        .sidebar ul li {
            margin-bottom: 10px;
        }
        .sidebar ul li a {
            color: #fff;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 10px;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .sidebar ul li a:hover {
            background: rgba(138, 43, 226, 0.2);
        }
        .sidebar ul li a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        .card {
            background: rgba(17, 17, 17, 0.8);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        .btn {
            background: #8a2be2;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .btn:hover {
            background: #9d4edd;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #444;
        }
        th {
            background-color: rgba(138, 43, 226, 0.2);
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <ul>
            <li><a href="#dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="#users"><i class="fas fa-users"></i> Manage Users</a></li>
            <li><a href="#events"><i class="fas fa-calendar-alt"></i> Manage Events</a></li>
            <li><a href="#performance"><i class="fas fa-chart-line"></i> System Performance</a></li>
            <li><a href="#disputes"><i class="fas fa-gavel"></i> Handle Disputes</a></li>
            <li><a href="#moderation"><i class="fas fa-shield-alt"></i> Content Moderation</a></li>
            <li><a href="#reports"><i class="fas fa-file-alt"></i> Reports & Analytics</a></li>
            <li><a href="#maintenance"><i class="fas fa-tools"></i> System Maintenance</a></li>
            <li><a href="index.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>
    <div class="main-content">
        <div id="dashboard">
            <h1>Welcome to Brightlane Admin Dashboard</h1>
            <div class="grid">
                <div class="card">
                    <h3>Total Users</h3>
                    <p class="big-number">10,567</p>
                </div>
                <div class="card">
                    <h3>Active Events</h3>
                    <p class="big-number">283</p>
                </div>
                <div class="card">
                    <h3>Revenue This Month</h3>
                    <p class="big-number">$45,892</p>
                </div>
                <div class="card">
                    <h3>New Sign-ups Today</h3>
                    <p class="big-number">124</p>
                </div>
            </div>
        </div>
        <div id="users" style="display: none;">
            <h2>Manage User Accounts</h2>
            <button class="btn">Add New User</button>
            <table>
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>User Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>john_doe</td>
                        <td>john@example.com</td>
                        <td>Event Organiser</td>
                        <td>
                            <button class="btn">Edit</button>
                            <button class="btn">Delete</button>
                        </td>
                    </tr>
                    <!-- More user rows here -->
                </tbody>
            </table>
        </div>
        <!-- Other sections (events, performance, disputes, etc.) go here -->
    </div>
    <script>
        document.querySelectorAll('.sidebar a').forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const sectionId = e.target.getAttribute('href').substr(1);
                loadSection(sectionId);
            });
        });

        function loadSection(sectionId) {
            // Hide all sections
            document.querySelectorAll('.main-content > div').forEach(div => {
                div.style.display = 'none';
            });

            // Show the selected section
            const selectedSection = document.getElementById(sectionId);
            if (selectedSection) {
                selectedSection.style.display = 'block';
            } else {
                // If section doesn't exist in HTML, load it via AJAX
                fetch(`admin_sections.php?section=${sectionId}`)
                    .then(response => response.text())
                    .then(html => {
                        const newSection = document.createElement('div');
                        newSection.id = sectionId;
                        newSection.innerHTML = html;
                        document.querySelector('.main-content').appendChild(newSection);
                    });
            }
        }
    </script>
</body>
</html>