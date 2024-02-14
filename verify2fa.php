<?php
// Database configuration
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = 'john_wick_77';
$dbName = '2fa_demo';

// Create a database connection
$pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the user's email and verification code from the form
    $email = $_POST['email'];
    $verificationCode = $_POST['verification_code'];

    // Check if the verification code matches with the stored code for the user
    $query = "SELECT * FROM users WHERE email = :email AND verification_code = :code";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':code', $verificationCode);
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
        <input type="hidden" name="email" value="<?php echo isset($_GET['email']) ? htmlspecialchars($_GET['email']) : ''; ?>">
        <input type="submit" value="Submit">
    </form>
</body>
</html>
