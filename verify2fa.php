<?php
session_start(); // Start the session to access session variables.

// Database configuration
$dbHost = 'localhost';
$dbUsername = 'afnan';
$dbPassword = 'john_wick_77';
$dbName = 'mywebsite_images';

// Create a database connection
try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database $dbName :" . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['email'])) {
        die("Session expired or invalid. Please login again.");
    }
    $email = $_SESSION['email'];
    $verificationCode = $_POST['verification_code'];

    // Prepare and execute the query to check the verification code
    $query = "SELECT * FROM usersWithEmail WHERE email = :email AND token = :verificationCode";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':verificationCode', $verificationCode);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Verification successful
        $_SESSION['loggedin'] = true;
        $_SESSION['role'] = $user['role']; // Set logged in status and role
        
        // Redirect to index.php
        header("Location: index.php");
        exit();
    } else {
        // Verification failed, show an error message
        $verificationError = "Invalid verification code.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Two-Factor Authentication Verification</title>
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

        h2 {
            text-align: center;
            color: #003366; /* Dark blue */
            margin-bottom: 20px; /* Increased margin */
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
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

        p.error {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h2>Court Evidence System - Two-Factor Authentication Verification</h2>
    <?php if (isset($verificationError)) { ?>
        <p class="error"><?php echo $verificationError; ?></p>
    <?php } ?>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="verification_code">Enter Verification Code:</label><br>
        <input type="text" id="verification_code" name="verification_code" required><br><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
