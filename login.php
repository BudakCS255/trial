<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5; /* Light gray */
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
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.2); /* Increased shadow */
            border: 2px solid #003366; /* Dark blue border */
            max-width: 400px; /* Restrict width for better readability */
        }

        h1 {
            text-align: center;
            color: #003366; /* Dark blue */
            font-size: 24px; /* Larger font size */
            margin-bottom: 20px; /* Increased margin */
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="text"],
        input[type="password"] {
            width: calc(100% - 32px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            display: inline-block;
        }

        .password-toggle {
            display: inline-block;
            width: 32px;
            height: 32px;
            border: none;
            background: none;
            cursor: pointer;
            vertical-align: middle;
            margin-left: -36px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #003366; /* Dark blue */
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #001f4d; /* Darker blue on hover */
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Digital Evidence System</h1> <!-- Changed heading -->
        <form action="login_script.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            <button type="button" class="password-toggle" onclick="togglePassword()">👁️</button>
            <input type="submit" value="Login">
        </form>
    </div>

    <script>
        function togglePassword() {
            var passwordField = document.getElementById("password");
            if (passwordField.type === "password") {
                passwordField.type = "text";
            } else {
                passwordField.type = "password";
            }
        }
    </script>
</body>
</html>
