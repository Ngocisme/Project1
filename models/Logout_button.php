<?php
session_start();

// Hủy bỏ tất cả các biến session
session_unset();

// Kết thúc session
session_destroy();

// Chuyển hướng về trang đăng nhập
header("Location: http://localhost:8888/keitaizoneTemplate/views/admin/login.php");
exit();
