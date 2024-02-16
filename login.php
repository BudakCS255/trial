<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            position: relative; /* Added */
        }

        h1 {
            text-align: center;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="text"],
        input[type="password"] {
            width: calc(100% - 40px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .password-toggle {
            position: absolute; /* Changed */
            top: 50%; /* Changed */
            right: 5px; /* Changed */
            transform: translateY(-50%); /* Changed */
            width: 40px;
            height: 40px;
            background-color: #ccc;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .password-toggle::before {
            content: "\f06e";
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            color: #333;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .password-toggle.active::before {
            content: "\f070";
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Login</h1>
        <form action="login_script.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            <button type="button" class="password-toggle" onclick="togglePassword()"></button>
            <input type="submit" value="Login">
        </form>
    </div>

    <script>
        function togglePassword() {
            var passwordField = document.getElementById("password");
            var toggleButton = document.querySelector(".password-toggle");
            if (passwordField.type === "password") {
                passwordField.type = "text";
                toggleButton.classList.add("active");
            } else {
                passwordField.type = "password";
                toggleButton.classList.remove("active");
            }
        }
    </script>
</body>
</html>
