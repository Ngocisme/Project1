<?php

include_once "./Database.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = $_POST["name"];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repassword = $_POST['repassword'];
    $level = 1;
    $avatar = $_FILES['fileUpload']['name'];

    try {
        // Prepare SQL statement to prevent SQL injection
        $sql = "INSERT INTO users (name, email, password, avatar, level) VALUES (:name, :password, :email, :avatar, :level)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':avatar', $avatar);
        $stmt->bindParam(':level', $level);
        $stmt->execute();

        $infor = $stmt->fetch(PDO::FETCH_ASSOC);

        if (isset($name) && isset($email) && isset($password) && isset($repassword) && isset($level) && isset($avatar)) {
            header('Location: http://localhost:8888/keitaizoneTemplate/views/admin/login.php?success=successfully');

            exit();
        } else {
            header('Location: http://localhost:8888/keitaizoneTemplate/views/admin/register.php?err=Password does not match');
        }

    } catch (PDOException $e) {
        // Handle database errors
        echo "Error: " . $e->getMessage();
    }
}

