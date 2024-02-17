<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

// Database configuration
$dbHost = 'localhost';
$dbUser = 'afnan';
$dbPass = 'john_wick_77';
$dbName = 'mywebsite_images';

// Create a database connection
$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT password, role, email FROM usersWithEmail WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Verify the password (consider using password_verify() here)
        if ($password === $row['password']) {
            // Check if user has an associated email
            if (!empty($row['email'])) {
                // Generate a 6-digit verification code
                $verificationCode = mt_rand(100000, 999999);

                // Update the token in the database
                $updateStmt = $conn->prepare("UPDATE usersWithEmail SET token = ? WHERE username = ?");
                $updateStmt->bind_param("is", $verificationCode, $username);
                $updateStmt->execute();
                $updateStmt->close();

                // Include PHPMailer library
                require '/var/www/vendor/autoload.php';

                // Send verification code to the user's email using Google SMTP
                $mail = new PHPMailer\PHPMailer\PHPMailer();
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // Gmail SMTP server
                $mail->Port = 587; // TLS port
                $mail->SMTPSecure = 'tls'; // Enable TLS encryption
                $mail->SMTPAuth = true;
                $mail->Username = 'hazieq2210@gmail.com'; // Your Gmail email address
                $mail->Password = 'ykng qwly olhd rxls'; // Your Gmail App Password
                $mail->setFrom('hazieq2210@gmail.com', 'Mohamad Afnan'); // Replace with your name and Gmail email
                $mail->addAddress($row['email']);
                $mail->Subject = 'Verification Code for Two-Factor Authentication';
                $mail->Body = "Your verification code is: $verificationCode. Please note that this code is for your personal use only. Do not share it with anyone for security reasons.";

                if ($mail->send()) {
                    // Set verification code in session
                    $_SESSION['verification_code'] = $verificationCode;
                    $_SESSION['email'] = $row['email'];
                    header("Location: verify2fa.php");
                    exit();
                } else {
                    echo "Failed to send verification code. Please try again later.";
                }
            } else {
                echo "No email associated with this account. 2FA is not available.";
            }
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "User not found!";
    }
    $stmt->close();
    $conn->close();
}
?>
