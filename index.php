<?php
session_start();

// Database configuration
$dbHost = 'localhost';
$dbUsername = 'afnan';
$dbPassword = 'john_wick_77';
$dbName = 'mywebsite_images';

// Create a database connection using PDO
$pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// PHPMailer library
require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password']; // This is the plain text password

    // Retrieve user information from the database
    $stmt = $pdo->prepare("SELECT * FROM usersWithEmail WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verify the password (plain text comparison)
    if ($user && $password === $user['password']) {
        // Generate a random 6-digit verification code
        $verificationCode = rand(100000, 999999);

        // Update the token in the database
        $updateStmt = $pdo->prepare("UPDATE usersWithEmail SET token = :token WHERE username = :username");
        $updateStmt->bindParam(':token', $verificationCode);
        $updateStmt->bindParam(':username', $username);
        $updateStmt->execute();

        // Send the verification code via email
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'hazieq2210@gmail.com'; // Your Gmail email address
        $mail->Password = 'ykng qwly olhd rxls'; // Your Gmail App Password if 2FA is enabled on your Gmail account
        $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('hazieq2210@gmail.com', 'Mohamad Afnan');
        $mail->addAddress($user['email']); // Add the user's email
        $mail->isHTML(true);
        $mail->Subject = 'Login Verification Code';
        $mail->Body = 'Your verification code is: ' . $verificationCode;

        if (!$mail->send()) {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            // Redirect to the main page after sending the email
            header('Location: index.php');
            exit;
        }
    } else {
        echo 'Login failed. Invalid username or password.';
    }
}
?>
