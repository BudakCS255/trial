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
    // Retrieve the user's email from the session
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
        // Verification successful, redirect to index.php
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
    <title>2FA Verification</title>
</head>
<body>
    <h2>Two-Factor Authentication Verification</h2>
    <?php if (isset($verificationError)) { ?>
        <p style="color: red;"><?php echo $verificationError; ?></p>
    <?php } ?>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="verification_code">Enter Verification Code:</label><br>
        <input type="text" id="verification_code" name="verification_code"><br><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
