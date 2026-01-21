<?php
include "db.php";

$message = ""; // Message to display
$message_class = ""; // CSS class for styling

if(!isset($_GET['email'])){
    echo "Invalid request.";
    exit();
}

$email = $_GET['email'];

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $new_password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if($new_password !== $confirm_password){
        $message = "Passwords do not match!";
        $message_class = "warning";
    } else {
        $hashed = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET password=? WHERE email=?");
        $stmt->bind_param("ss", $hashed, $email);

        if($stmt->execute()){
            $message = "Password successfully reset! You can now Sign In.";
            $message_class = "success";
        } else {
            $message = "Failed to reset password. Try again.";
            $message_class = "warning";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,800" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        /* Inline styles for warning/success messages */
        .message {
            font-size: 14px;
            margin-top: 10px;
            margin-bottom: 10px;
            text-align: center;
        }
        .warning { color: #FF4B2B; }
        .success { color: #28a745; }
    </style>
</head>
<body>
    <div class="container" style="width: 400px; min-height: auto; padding: 50px;">
        <form action="" method="POST">
            <h1>Reset Password</h1>

            <input type="password" placeholder="New Password" name="password" required
            pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,20}$"
            title="8-20 characters, include uppercase, lowercase, number, special character"/>
            <input type="password" placeholder="Confirm Password" name="confirm_password" required/>

            <!-- Message placeholder -->
            <?php if($message != ""): ?>
                <div class="message <?php echo $message_class; ?>"><?php echo $message; ?></div>
            <?php endif; ?>

            <button type="submit">Reset</button>
            <p><a href="index.html">Back to Sign In</a></p>
        </form>
    </div>
</body>
</html>
