<?php
// Start the session and database configuration
session_start();
$dbHost = 'localhost';
$dbUsername = 'afnan';
$dbPassword = 'john_wick_77';
$dbName = 'mywebsite_images';

// Attempt to create a database connection
try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database $dbName :" . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $verificationCode = $_POST['verification_code'];

    // Debug: Output the submitted information
    echo "Submitted Email: " . htmlspecialchars($email) . "<br>";
    echo "Submitted Verification Code: " . htmlspecialchars($verificationCode) . "<br>";

    $query = "SELECT * FROM usersWithEmail WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Debug: Output the stored token for comparison
    if ($user) {
        echo "Stored Verification Code in Database: " . $user['token'] . "<br>";
    } else {
        echo "No user found with that email.<br>";
    }

    // Comparing the submitted verification code with the stored token
    if ($user && $verificationCode == $user['token']) {
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
        <input type="hidden" name="email" value="<?php echo isset($_GET['email']) ? htmlspecialchars($_GET['email']) : ''; ?>">
        <input type="submit" value="Submit">
    </form>
</body>
</html>
