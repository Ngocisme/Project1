<?php
ob_start();
include_once "../users/includes/header.php";
include_once "../../models/Database.php";
include_once "../../models/MailerSuccess_model.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $checkout_fullname = $_POST['fullname'];
    $checkout_email = $_POST['email'];
    $checkout_phone = $_POST['phone'];
    $checkout_address = $_POST['address'];
    $checkout_city = $_POST['city'];
    $checkout_district = $_POST['district'];
    $checkout_ward = $_POST['ward'];
    $totalCheckoutBill = totalCheckout();

    // Check data from form
    // $array_checkout = [
    //     $checkout_fullname,
    //     $checkout_email,
    //     $checkout_phone,
    //     $checkout_address,
    //     $checkout_city,
    //     $checkout_district,
    //     $checkout_ward,
    //     $totalCheckoutBill
    // ];

    // check($array_checkout);

    $sql = "
    INSERT INTO orders (full_name, email, phone, address, city, district, ward, totalBill) 
    VALUES (:fullname, :email, :phone, :address, :city, :district, :ward, :totalBill)
    ";
    $stmt = $conn->prepare($sql);
    $stmt->execute(
        [
            'fullname' => $checkout_fullname,
            'email' => $checkout_email,
            'phone' => $checkout_phone,
            'address' => $checkout_address,
            'city' => $checkout_city,
            'district' => $checkout_district,
            'ward' => $checkout_ward,
            'totalBill' => $totalCheckoutBill
        ]
    );
    $orderId = $conn->lastInsertId();
    
    for ($i=0; $i < sizeof($_SESSION['cart']); $i++) { 
        $nameDetailCart = $_SESSION['cart'][$i][0];
        $priceDetailCart = $_SESSION['cart'][$i][1];
        $qtyDetailCart = $_SESSION['cart'][$i][3];
        $totalDetailCart = $_SESSION['cart'][$i][1] * $_SESSION['cart'][$i][3];
        $sql = "
        INSERT INTO order_details (order_id, product_name, qty, price, total) 
        VALUES (:order_id, :product_name, :qty, :price, :total)
        ";
        $stmt = $conn->prepare($sql);
        $stmt->execute(
            [
                'order_id'=> $orderId,
                'product_name'=> $nameDetailCart,
                'qty'=> $qtyDetailCart,
                'price'=> $priceDetailCart,
                'total'=> $totalDetailCart,
            ]
        );
    }

    sendMailSuccess($checkout_email, $checkout_fullname, $orderId, $totalCheckoutBill);
    unset($_SESSION['cart']);
    header("Location: http://localhost:8888/keitaizoneTemplate/views/users/checkout.php?success=successfully");

}
ob_end_flush();
?>

<!-- Checkout Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-lg-8">
            <h5 class="section-title position-relative text-uppercase mb-3">
                <span class="bg-secondary pr-3">
                    Thông tin giao hàng
                </span>
            </h5>
            <div class="bg-light p-30 mb-5">
                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label>Họ và Tên</label>
                            <input class="form-control" type="text" placeholder="Nguyễn Văn A" name="fullname" required>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>E-mail</label>
                            <input class="form-control" type="email" placeholder="example@email.com" name="email" required>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Số Điện Thoại</label>
                            <input class="form-control" type="text" placeholder="090 865 1234" name="phone" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Địa Chỉ</label>
                            <input class="form-control" type="text" placeholder="123 Street" name="address" required>
                        </div>

                        <div class="col-md-12 form-group">
                            <label>Thành Phố</label>
                            <input class="form-control" type="text" placeholder="Hà Nội...." name="city" required>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Quận</label>
                            <input class="form-control" type="text" placeholder="Gò Vấp....." name="district" required>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Phường</label>
                            <input class="form-control" type="text" placeholder="Phường 7....." name="ward" required>
                        </div>
                        <button class="btn btn-block btn-primary font-weight-bold py-3" type="submit">
                            Đặt hàng
                        </button>

                    </div>
                </form>

            </div>

        </div>
        <div class="col-lg-4">
            <h5 class="section-title position-relative text-uppercase mb-3">
                <span class="bg-secondary pr-3">
                    Tổng giá tiền sản phẩm
                </span>
            </h5>
            <div class="bg-light p-30 mb-5">
                <h6 class="mb-3">Sản Phẩm</h6>
                <div class="border-bottom">
                    <?php
                    for ($i = 0; $i < sizeof($_SESSION['cart']); $i++) {
                        echo '
                            <div class="d-flex justify-content-between">
                            <p>' . $_SESSION['cart'][$i][0] . '</p>
                            <p>' . formatCurrencyVND($_SESSION['cart'][$i][1]) . '</p>
                            <p> SL: ' . $_SESSION['cart'][$i][3] . '</p>
                            </div>
                            ';
                    }
                    ?>

                </div>

                <div class="pt-2">
                    <div class="d-flex justify-content-between mt-2">
                        <?php
                        $totalBill = 0;
                        for ($i = 0; $i < sizeof($_SESSION['cart']); $i++) {
                            $total = $_SESSION['cart'][$i][1] * $_SESSION['cart'][$i][3];
                            $totalBill += $total;
                        }
                        echo
                            '
                            <h5>Tổng đơn hàng hoá</h5>
                            <h5>' . formatCurrencyVND($totalBill) . '</h5>
                            ';
                        ?>
                    </div>
                </div>
            </div>
            <p class='text-success'>
            <?php
            if (isset($_GET['success'])) {
                echo $_GET['success'];
            } ?>

        </p>
        </div>
    </div>
</div>
<!-- Checkout End -->


<?php

include_once "../users/includes/footer.php";

?>