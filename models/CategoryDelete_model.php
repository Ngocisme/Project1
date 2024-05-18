<?php

include_once "Database.php";

if(isset($_GET['category_id'])) {
    // Sanitize the product ID to prevent SQL injection
    $category_id = htmlspecialchars($_GET['category_id']);
    
    // SQL query to delete the product with the given ID
    $sql = "DELETE FROM brands WHERE id = :category_id";
    
    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);
    
    // Bind the product ID parameter
    $stmt->bindParam(':category_id', $category_id);
    
    // Execute the statement
    $stmt->execute();
    
    echo "Category with ID $category_id has been deleted successfully.";
    echo "</br>";
    echo "<a href='./Category_Show.php'>Back To Table</a>";

} else {
    echo "Fail to delete";
}