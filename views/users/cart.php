<?php
include_once "../users/includes/header.php";
include_once "../../models/Database.php";


?>
<!-- Cart Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-lg-12 table-responsive mb-5">
            <table class="table table-light table-borderless table-hover text-center mb-0">
                <thead class="thead-dark">
                    <tr>
                        <th>STT</th>
                        <th>Tên Sản Phẩm</th>
                        <th>Giá</th>
                        <th>Ảnh sản phẩm</th>
                        <th>Số Lượng</th>
                        <th>Tổng Giá Thành</th>
                        <th>Tăng/Giảm SL</th>
                        <th>Xoá Sản Phẩm</th>
                    </tr>
                </thead>
                <tbody class="align-middle">
                    <?php
                        showCartItem();
                    ?>
                </tbody>
            </table>
            <a href="../users/checkout.php" class="btn btn-block btn-primary font-weight-bold my-3 py-3">Thanh Toán</a>
            <div class="d-flex justify-content-center">
            <a href="../users/index.php" class="btn btn-block btn-warning font-weight-bold my-3 py-3">Mua hàng tiếp</a>
            <a href="../users/cart.php?delete_cart=1" class="btn btn-block btn-info font-weight-bold my-3 py-3">Làm mới giỏ hàng</a>
            </div>
        </div>

    </div>
</div>
<!-- Cart End -->

<?php
include_once "../users/includes/footer.php";
?>