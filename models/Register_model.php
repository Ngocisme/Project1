<?php

include_once "./Database.php";
function is_valid_image($file_tmp_path)
{
    $allowed_types = array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG);
    $detected_type = exif_imagetype($file_tmp_path);
    return in_array($detected_type, $allowed_types);
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = $_POST["name"];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repassword = $_POST['repassword'];
    $level = 1;
    $avatarname = $_FILES['avatar']['name'];
    $avatarTMP = $_FILES['avatar']['tmp_name'];

    try {
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {

        // Kiểm tra xem tệp có phải là ảnh hợp lệ không
        if (is_valid_image($avatarTMP)) {
            // Thay đổi đường dẫn ảnh (nếu cần)
            $new_image_path = '../assets/admin/img/users/' . $avatarname; // Đường dẫn mới
            move_uploaded_file($avatarTMP, $new_image_path); // Di chuyển file đến đường dẫn mới


            echo "Tệp là ảnh hợp lệ và đã được lưu vào cơ sở dữ liệu.";
        } else {
            echo "Tệp không phải là ảnh hợp lệ.";
        }
    } else {
        echo "Đã xảy ra lỗi trong quá trình upload file.";
    }

        // // Prepare SQL statement to prevent SQL injection
        $sql = "INSERT INTO users (name, email, password, avatar, level) VALUES (:name, :email, :password, :avatarname, :level)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':avatarname', $avatarname);
        $stmt->bindParam(':level', $level);
        $stmt->execute();

        $infor = $stmt->fetch(PDO::FETCH_ASSOC);

        if (isset($name) && isset($email) && isset($password) && isset($repassword) && isset($level) && isset($avatarname)) {
            header('Location: http://localhost:8888/keitaizoneTemplate/views/admin/login.php?success=successfully');
            exit();
        } else {
            if ($password !== $repassword) {
                header('Location: http://localhost:8888/keitaizoneTemplate/views/admin/register.php?err=Password does not match');
                exit();
            } elseif (empty($name)) {
                header('Location: http://localhost:8888/keitaizoneTemplate/views/admin/register.php?err=Please enter your name');
                exit();
            } elseif (empty($password)) {
                header('Location: http://localhost:8888/keitaizoneTemplate/views/admin/register.php?err=Please enter your password');
                exit();
            } elseif (empty($repassword)) {
                header('Location: http://localhost:8888/keitaizoneTemplate/views/admin/register.php?err=Please enter your repassword');
                exit();
            }
        }


    } catch (PDOException $e) {
        // Handle database errors
        echo "Error: " . $e->getMessage();
    }
}

