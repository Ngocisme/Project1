<?php

include_once "Database.php";

 $stmt = $conn->query("SELECT * FROM brands");

 $products = $stmt->fetchAll();

