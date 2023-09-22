<?php
use PSpell\Config;
require '../vendor/autoload.php';

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__); // Specify the directory where your .env file is located
$dotenv->load();
$DBEMAIL = $_ENV['DB_USER'];
$DBPASS = $_ENV['DB_PASS'];

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['klacht'];

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    // SMTP configuration
    $mail->isSMTP();
    $mail->Host = 'smtp.office365.com'; // Your SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = $DBEMAIL;
    $mail->Password = $DBPASS;
    $mail->SMTPSecure = 'tls'; // Change to 'ssl' if needed
    $mail->Port = 587; // Your SMTP port

    // Additional SMTP settings
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );

    try {
        // Sender and recipient
        $mail->setFrom('jensbul@outlook.com', $name);
        $mail->addAddress($email); // Recipient's email

        // Email content
        $mail->Subject = 'Contact Form Submission';
        $mail->Body = $message;

        // Send the email
        $mail->send();
        echo 'Message has been sent successfully!';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form method="POST" action="index.php">
  <label for="name">name:</label><br>
  <input type="text" id="name" name="name"><br>

  <label for="email">email:</label><br>
  <input type="email" id="email" name="email"><br>

  <label for="klacht">klacht:</label><br>
  <input type="text" id="klacht" name="klacht"><br>
 <input type="submit">
</form>
</body>
</html>
