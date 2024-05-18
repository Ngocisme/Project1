<?php

include_once "Database.php";

 $stmt = $conn->query("SELECT * FROM product_categories");

 $productCategories = $stmt->fetchAll();

