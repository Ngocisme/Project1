<?php

session_start();
include_once "./Database.php";

// Login form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $err = $_SESSION['error'];
    try {
        // Prepare SQL statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);

        $user = $stmt->fetch();

        if ($user['email'] === $email && $user['password'] === $password) {
            // Password is correct, start session
            // Check admin
            if ($user['level'] === 0) {
                $_SESSION['user'] = $user;
                header("Location: http://localhost:8888/keitaizoneTemplate/views/admin/index.php"); // Redirect to dashboard or any other page
                exit();
            } elseif ($user['level'] === 1) {
                $_SESSION['user'] = $user;
                header("Location: http://localhost:8888/keitaizoneTemplate/views/users/index.php"); // Redirect to dashboard or any other page
                exit();
            }

        } else {
            // Incorrect email or password
            if(empty($email)  && empty($password)){
                header("Location: http://localhost:8888/keitaizoneTemplate/views/admin/login.php?err=Please enter email and password"); // Redirect to dashboard or any other page
                exit();
            }
            elseif(empty($email)){
                header("Location: http://localhost:8888/keitaizoneTemplate/views/admin/login.php?err=Please enter your email"); // Redirect to dashboard or any other page
                exit();
            }
            elseif(empty($password)){
                header("Location: http://localhost:8888/keitaizoneTemplate/views/admin/login.php?err=Please enter your password"); // Redirect to dashboard or any other page
                exit();
            }
            elseif($email != $user['email'] ||  $password != $user['password']){
                header("Location: http://localhost:8888/keitaizoneTemplate/views/admin/login.php?err=Wrong password or email"); // Redirect to dashboard or any other page
                exit();
            }
           
        }
     
    } catch (PDOException $e) {
        // Handle database errors
        echo "Error: " . $e->getMessage();
    }
}