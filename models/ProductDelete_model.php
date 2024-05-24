<?php

include_once "Database.php";

if(isset($_GET['product_id'])) {
    
    // Sanitize the product ID to prevent SQL injection
    $product_id = htmlspecialchars($_GET['product_id']);
    
    // SQL query to delete the product with the given ID
    // $sql = "DELETE FROM products WHERE id = :product_id";
    
    // // Prepare the SQL statement
    // $stmt = $conn->prepare($sql);
    
    // // Bind the product ID parameter
    // $stmt->bindParam(':product_id', $product_id);
    
    // // Execute the statement
    // $stmt->execute();
    
    $stmt = $conn->prepare('SELECT img FROM products WHERE id = :id');
    $stmt->execute(['id' => $product_id]);
    $image = $stmt->fetch();

    if ($image) {
        $filepath = $image['img'];

        // Xóa ảnh khỏi thư mục
        if (file_exists("../../assets/users/img/products/" .$filepath)) {
            if (unlink("../../assets/users/img/products/".$filepath)) {
                // Xóa bản ghi khỏi cơ sở dữ liệu
                $stmt = $conn->prepare('DELETE FROM products WHERE id = :id');
                $stmt->execute(['id' => $product_id]);

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



    echo "Category with ID $product_id has been deleted successfully.";
    echo "</br>";
    echo "<a href='./Product_Show.php'>Back To Table</a>";

} else {
    echo "Fail to delete";
}

