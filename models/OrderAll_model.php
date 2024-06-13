<?php

include_once 'Database.php';

$stmt = $conn->query("SELECT * FROM orders ORDER BY created_at DESC");

$orders = $stmt->fetchAll();

