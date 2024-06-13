<?php

include_once './Database.php';

if (isset($_GET['id']) && isset($_GET['action'])) {
    // dùng intval để biến thành số nguyên
    $commentId = intval($_GET['id']);
    $action = $_GET['action'];

    if ($action == 'approve') {
        $stmt = $conn->prepare('UPDATE product_comments SET status = 1 WHERE id = ?');
        $stmt->execute([$commentId]);
    } elseif ($action == 'reject') {
        $stmt = $conn->prepare('DELETE FROM product_comments WHERE id = ?');
        $stmt->execute([$commentId]);
    }
}

// Chuyển hướng về trang quản lý bình luận sau khi phê duyệt hoặc từ chối
header('Location: http://localhost:8888/keitaizoneTemplate/views/admin/Comment_Show.php');
exit;