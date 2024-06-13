<?php
session_start();
include_once "../../models/ProductAll_model.php";

if (!isset($_SESSION['cart']))
    $_SESSION['cart'] = [];

if (isset($_GET['delete_cart']) && ($_GET['delete_cart'] == 1)) {
    unset($_SESSION['cart']);
    header('Location: http://localhost:8888/keitaizoneTemplate/views/users/index.php');
}

if (isset($_POST['addToCart']) && ($_POST['addToCart'])) {
    $nameCart = $_POST['name'];
    $priceCart = $_POST['price'];
    $imgCart = $_POST['img'];
    $qtyCart = $_POST['qty'];

    $check = 0;

    for ($i = 0; $i < sizeof($_SESSION['cart']); $i++) {
        if ($_SESSION['cart'][$i][0] === $nameCart) {
            $check == 1;
            $count = $qty + $_SESSION['cart'][$i][3];
            $_SESSION['cart'][$i][3] = $count;
            break;
        }
    }

    if ($check === 0) {
        $cartArray = [
            $nameCart,
            $priceCart,
            $imgCart,
            $qtyCart
        ];

        $_SESSION['cart'][] = $cartArray;
    }

    $temp = 0;

    for ($i = 0; $i < sizeof($_SESSION['cart']); $i++) {
        $temp += $_SESSION['cart'][$i][3];
    }


    // Hàm để show các sản phẩm thêm vào giỏ hàng
    function showCartItem()
    {
        if (isset($_SESSION['cart']) && (is_array($_SESSION['cart']))) {
            $totalBill = 0;
            for ($i = 0; $i < sizeof($_SESSION['cart']); $i++) {
                $total = $_SESSION['cart'][$i][1] * $_SESSION['cart'][$i][3];
                $totalBill += $total;
                echo '
        <tr>
            <td class="align-middle">' . ($i + 1) . '</td>
            <td class="align-middle">' . $_SESSION['cart'][$i][0] . '</td>
            <td class="align-middle">' . formatCurrencyVND($_SESSION['cart'][$i][1]) . '</td>
            <td class="align-middle">
                <img src="../../assets/users/img/products/' . $_SESSION['cart'][$i][2] . '" alt="" style="width: 50px; height: 50px">
            </td>
            <td class="align-middle">' . $_SESSION['cart'][$i][3] . '</td>
            <td class="align-middle">' . formatCurrencyVND($total) . '</td>
                <td class="align-middle">
                    <input type="number" name="qty" value="1" min="1" max="99">
                </td>
            <td class="align-middle"><button class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button></td>
        </tr>
            ';
            }
            echo '
            <tr>
                <th colspan="5">Tổng đơn hàng: </th>
                <th>
                    <div>' . formatCurrencyVND($totalBill) . '</div>
                </th>
            </tr>
        ';

        }
    }
}

// Hàm để lấy tổng giá trị đơn hàng để thanh toán

function totalCheckout()
{
    $totalBill = 0;
    if (isset($_SESSION['cart']) && (is_array($_SESSION['cart']))) {
        for ($i = 0; $i < sizeof($_SESSION['cart']); $i++) {
            $total = $_SESSION['cart'][$i][1] * $_SESSION['cart'][$i][3];
            $totalBill += $total;
        }
    }
    return $totalBill;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>KEITAIZone || Home</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="../../assets/users/lib/animate/animate.min.css" rel="stylesheet">
    <link href="../../assets/users/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../../assets/users/css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Topbar Start -->
    <div class="container-fluid">
        <div class="row bg-secondary py-1 px-xl-5">
            <div class="col-lg-6 d-none d-lg-block">
                <div class="d-inline-flex align-items-center h-100">
                    <a class="text-body mr-3" href="">About</a>
                    <a class="text-body mr-3" href="">Contact</a>
                    <a class="text-body mr-3" href="">Help</a>
                    <a class="text-body mr-3" href="">FAQs</a>
                </div>
            </div>
            <div class="col-lg-6 text-center text-lg-right">
                <div class="d-inline-flex align-items-center">
                    <div class="btn-group">

                        <?php
                        if (isset($_SESSION['user'])) {
                            ?>
                            <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">
                                <?= $_SESSION['user']['name'] ?>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="./../../models/Logout_button.php" class="dropdown-item">Logout</a>
                            </div>
                            <?php
                        } else {
                            ?>
                            <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">
                                My Account
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="./../admin/login.php" class="dropdown-item">Login</a>
                                <a href="./../admin/register.php" class="dropdown-item">Register</a>
                            </div>
                            <?php
                        }
                        ?>

                    </div>
                    <div class="btn-group mx-2">
                        <button type="button" class="btn btn-sm btn-light dropdown-toggle"
                            data-toggle="dropdown">USD</button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <button class="dropdown-item" type="button">EUR</button>
                            <button class="dropdown-item" type="button">GBP</button>
                            <button class="dropdown-item" type="button">CAD</button>
                        </div>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-light dropdown-toggle"
                            data-toggle="dropdown">EN</button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <button class="dropdown-item" type="button">FR</button>
                            <button class="dropdown-item" type="button">AR</button>
                            <button class="dropdown-item" type="button">RU</button>
                        </div>
                    </div>
                </div>
                <div class="d-inline-flex align-items-center d-block d-lg-none">
                    <a href="" class="btn px-0 ml-2">
                        <i class="fas fa-heart text-dark"></i>
                        <span class="badge text-dark border border-dark rounded-circle"
                            style="padding-bottom: 2px;">0</span>
                    </a>
                    <a href="" class="btn px-0 ml-2">
                        <i class="fas fa-shopping-cart text-dark"></i>
                        <span class="badge text-dark border border-dark rounded-circle"
                            style="padding-bottom: 2px;">0</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="row align-items-center bg-light py-3 px-xl-5 d-none d-lg-flex">
            <div class="col-lg-4">
                <a href="" class="text-decoration-none">
                    <span class="h1 text-uppercase text-primary bg-dark px-2">KEITAI</span>
                    <span class="h1 text-uppercase text-dark bg-primary px-2 ml-n1">Zone</span>
                </a>
            </div>
            <div class="col-lg-4 col-6 text-left">
                <form action="">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for products">
                        <div class="input-group-append">
                            <span class="input-group-text bg-transparent text-primary">
                                <i class="fa fa-search"></i>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-4 col-6 text-right">
                <p class="m-0">Customer Service</p>
                <h5 class="m-0">+012 345 6789</h5>
            </div>
        </div>
    </div>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <div class="container-fluid bg-dark mb-30">
        <div class="row px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a class="btn d-flex align-items-center justify-content-between bg-primary w-100" data-toggle="collapse"
                    href="#navbar-vertical" style="height: 65px; padding: 0 30px;">

                    <i class="fa fa-angle-down text-dark"></i>
                </a>
                <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 bg-light"
                    id="navbar-vertical" style="width: calc(100% - 30px); z-index: 999;">
                    <div class="navbar-nav w-100">
                        <div class="nav-item dropdown dropright">



                </nav>
            </div>
            <div class="col-lg-9">
                <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3 py-lg-0 px-0">
                    <a href="" class="text-decoration-none d-block d-lg-none">
                        <span class="h1 text-uppercase text-dark bg-light px-2">Multi</span>
                        <span class="h1 text-uppercase text-light bg-primary px-2 ml-n1">Shop</span>
                    </a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="index.php" class="nav-item nav-link">Trang chủ</a>
                            <a href="shop.php" class="nav-item nav-link">Sản Phẩm</a>
                            <a href="contact.php" class="nav-item nav-link">Liên Hệ</a>
                        </div>
                        <div class="navbar-nav ml-auto py-0 d-none d-lg-block">
                            <a href="cart.php" class="btn px-0 ml-3">
                                <i class="fas fa-shopping-cart text-primary"></i>

                                <?php
                                if (isset($temp)) {
                                    echo '
                                        <span class="badge text-secondary border border-secondary rounded-circle"
                                        style="padding-bottom: 2px;">
                                        ' . $temp . '
                                        </span>
                                        ';
                                }
                                ?>


                            </a>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
    <!-- Navbar End -->