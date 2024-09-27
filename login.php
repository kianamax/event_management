<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brightlane Login</title>
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
        }
        .hero {
            height: 100vh;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .form-box {
            width: 380px;
            background: rgba(17, 17, 17, 0.8);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(138, 43, 226, 0.2);
        }
        .button-box {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .toggle-btn {
            padding: 10px 30px;
            cursor: pointer;
            background: transparent;
            border: 1px solid #8a2be2;
            color: #fff;
            outline: none;
            border-radius: 30px;
            transition: 0.3s;
        }
        .toggle-btn.active {
            background: #8a2be2;
        }
        .input-group {
            transition: 0.5s;
        }
        .input-field {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #444;
            background: rgba(34, 34, 34, 0.8);
            color: #fff;
            outline: none;
            border-radius: 5px;
        }
        .submit-btn {
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            cursor: pointer;
            background: #8a2be2;
            border: 0;
            outline: none;
            color: #fff;
            border-radius: 30px;
            font-size: 16px;
            transition: 0.3s;
        }
        .submit-btn:hover {
            background: #9d4edd;
        }
        .input-group select {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #444;
            background: rgba(34, 34, 34, 0.8);
            color: #fff;
            outline: none;
            border-radius: 5px;
        }
        #login, #register {
            display: none;
        }
        #login.active, #register.active {
            display: block;
        }
    </style>
</head>
<body>
    <div class="hero">
        <div class="form-box">
            <div class="button-box">
                <button type="button" class="toggle-btn active" onclick="toggleForm('login')">Log in</button>
                <button type="button" class="toggle-btn" onclick="toggleForm('register')">Register</button>
            </div>
            <form id="login" action="login_process.php" method="post" class="input-group active">
                <input type="text" id="login_username" name="username" placeholder="Username" class="input-field" required>
                <input type="password" id="password" name="password" placeholder="Password" class="input-field" required>
                <button type="submit" class="submit-btn">Log in</button>
            </form>
            <form id="register" action="register_process.php" method="post" class="input-group">
                <input type="text" id="register_username" name="username" placeholder="Username" class="input-field" required>
                <input type="password" id="password" name="password" placeholder="Password" class="input-field" required>
                <input type="email" id="email" name="email" placeholder="Email" class="input-field" required>
                <select id="usertype" name="usertype" class="input-field" required>
                    <option value="event_organiser">Event Organiser</option>
                    <option value="Attendee">Attendee</option>
                    <option value="admin">Admin</option>
                </select>
                <input type="text" id="town" name="town" placeholder="Town" class="input-field" required>
                <button type="submit" class="submit-btn">Register</button>
            </form>
        </div>
    </div>
    <script>
        function toggleForm(formId) {
            const loginForm = document.getElementById('login');
            const registerForm = document.getElementById('register');
            const loginBtn = document.querySelector('.toggle-btn:nth-child(1)');
            const registerBtn = document.querySelector('.toggle-btn:nth-child(2)');

            if (formId === 'login') {
                loginForm.classList.add('active');
                registerForm.classList.remove('active');
                loginBtn.classList.add('active');
                registerBtn.classList.remove('active');
            } else {
                loginForm.classList.remove('active');
                registerForm.classList.add('active');
                loginBtn.classList.remove('active');
                registerBtn.classList.add('active');
            }
        }
    </script>
</body>
</html>