<?php

include "Database.php";

if(isset($_GET['user_id'])) {
    // Sanitize the product ID to prevent SQL injection
    $userid = htmlspecialchars($_GET['user_id']);
    
    // SQL query to delete the product with the given ID
    // $sql = "DELETE FROM users WHERE id = :userid";
    
    // // Prepare the SQL statement
    // $stmt = $conn->prepare($sql);
    
    // // Bind the product ID parameter
    // $stmt->bindParam(':userid', $userid);
    
    // // Execute the statement
    // $stmt->execute();

    $stmt = $conn->prepare('SELECT avatar FROM users WHERE id = :id');
    $stmt->execute(['id' => $userid]);
    $image = $stmt->fetch();

    if ($image) {
        $filepath = $image['avatar'];

        // Xóa ảnh khỏi thư mục
        if (file_exists("../../assets/admin/img/users/" .$filepath)) {
            if (unlink("../../assets/admin/img/users/".$filepath)) {
                // Xóa bản ghi khỏi cơ sở dữ liệu
                $stmt = $conn->prepare('DELETE FROM users WHERE id = :id');
                $stmt->execute(['id' => $userid]);

                echo "Ảnh và bản ghi đã được xóa thành công.";
            } else {
                echo "Không thể xóa ảnh từ thư mục.";
            }
        } else {
            echo "Tệp ảnh không tồn tại.";
        }
    } else {
        echo "Bản ghi không tồn tại.";
    }

    
    echo "User with ID $userid has been deleted successfully.";
    echo "</br>";
    echo "<a href='./User_Show.php'>Back To Table</a>";

} else {
    echo "Fail to delete";
}