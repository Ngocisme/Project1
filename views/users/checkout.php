<?php

include_once "../users/includes/header.php";
include_once "../../models/Database.php";

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $checkout_fullname = $_POST['fullname'];
//     $checkout_email = $_POST['email'];
//     $checkout_phone = $_POST['phone'];
//     $checkout_address = $_POST['address'];
//     $checkout_city = $_POST['city'];
//     $checkout_district = $_POST['district'];
//     $checkout_ward = $_POST['ward'];

//     // $array_checkout = [
//     //     $checkout_fullname,
//     //     $checkout_email,
//     //     $checkout_phone,
//     //     $checkout_address,
//     //     $checkout_city,
//     //     $checkout_district,
//     //     $checkout_ward
//     // ];

//     // check($array_checkout);
// }
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
                            <input class="form-control" type="text" placeholder="Nguyễn Văn A" name="fullname">

                        </div>

                        <div class="col-md-6 form-group">
                            <label>E-mail</label>
                            <input class="form-control" type="email" placeholder="example@email.com" name="email">
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Số Điện Thoại</label>
                            <input class="form-control" type="text" placeholder="090 865 1234" name="phone">
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Địa Chỉ</label>
                            <input class="form-control" type="text" placeholder="123 Street" name="address">
                        </div>

                        <div class="col-md-12 form-group">
                            <label>Thành Phố</label>
                            <input class="form-control" type="text" placeholder="Hà Nội...." name="city">
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Quận</label>
                            <input class="form-control" type="text" placeholder="Gò Vấp....." name="district">
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Phường</label>
                            <input class="form-control" type="text" placeholder="Phường 7....." name="ward">
                        </div>
                        <button class="btn btn-block btn-primary font-weight-bold py-3" type="submit">Place
                            Order</button>

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
                        <div class="d-flex justify-content-between">
                            <p>sản phẩm a</p>
                            <p>29000vnd</p>
                        </div>
                    </div>

                <div class="pt-2">
                    <div class="d-flex justify-content-between mt-2">
                        <h5>Tổng đơn hàng hoá</h5>
                        <h5>350000vnd</h5>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Checkout End -->


<?php

include_once "../users/includes/footer.php";

?>