<?php
include "db.php";

$message = "";
$message_class = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if(empty($name) || empty($email) || empty($password)){
        $message = "All fields are required";
        $message_class = "warning";
    } else {
        // Check if email exists
        $check = $conn->prepare("SELECT id FROM users WHERE email=?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if($check->num_rows > 0){
            $message = "Email already exists";
            $message_class = "warning";
        } else {
            // Hash password and insert
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users(name,email,password) VALUES(?,?,?)");
            $stmt->bind_param("sss", $name, $email, $hashed);

            if($stmt->execute()){
                $message = "Sign Up successful! You can now Sign In.";
                $message_class = "success";
            } else {
                $message = "Sign Up failed. Try again.";
                $message_class = "warning";
            }
        }
    }
}
?>
