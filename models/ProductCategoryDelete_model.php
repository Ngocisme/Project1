<?php

include_once "Database.php";

if(isset($_GET['product_category_id'])) {
    // Sanitize the product ID to prevent SQL injection
    $product_category_id = htmlspecialchars($_GET['product_category_id']);
    
    // SQL query to delete the product with the given ID
    $sql = "DELETE FROM product_categories WHERE id = :product_category_id";
    
    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);
    
    // Bind the product ID parameter
    $stmt->bindParam(':product_category_id', $product_category_id);
    
    // Execute the statement
    $stmt->execute();
    
    echo "Category with ID $product_category_id has been deleted successfully.";
    echo "</br>";
    echo "<a href='./ProductCategory_Show.php'>Back To Table</a>";

} else {
    echo "Fail to delete";
}