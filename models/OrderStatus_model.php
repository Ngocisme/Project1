<?php

include_once "./Database.php";

$order_id = $_GET['orderid'];

$stmt = $conn->prepare('SELECT * FROM orders WHERE id = ?');
$stmt->execute([$order_id]);
$order = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $orderStatus = $_POST['status'];

    // Cập nhật trạng thái đơn hàng
    $stmt = $conn->prepare('UPDATE orders SET Status = ? WHERE id = ?');
    $stmt->execute([$orderStatus, $order_id]);

    header('Location: http://localhost:8888/keitaizoneTemplate/views/admin/Order_Show.php');
    exit;
}