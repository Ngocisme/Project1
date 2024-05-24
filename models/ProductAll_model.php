<?php

include_once "Database.php";

$sql = "SELECT products.id

,brands.name as brand_name
,product_categories.name as product_category
,products.name
,products.description
,products.price
,products.qty
,products.discount
,products.featured
,products.Views
,products.img
FROM products
INNER JOIN brands ON brands.id = products.brand_id
INNER JOIN product_categories on product_categories.id = products.product_category_id";

$stmt = $conn->query($sql);

$products = $stmt->fetchAll();

