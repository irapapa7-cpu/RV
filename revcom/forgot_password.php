<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Check if email exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if($stmt->num_rows == 0){
        echo "Email not found. <a href='forgot_password.html'>Try again</a>";
        exit();
    }

    // Safe: send email as GET parameter (or ideally generate a token)
    $stmt->bind_result($user_id);
    $stmt->fetch();

    // Redirect to reset password with email
    header("Location: reset_password.php?email=".urlencode($email));
    exit();
}
?>
