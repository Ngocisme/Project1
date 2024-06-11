<?php
include_once "../users/includes/header.php";
include_once "../../models/Database.php";

if (!isset($_SESSION['cart']))
    $_SESSION['cart'] = [];

if (isset($_GET['delete_cart']) && ($_GET['delete_cart'] == 1))
    unset($_SESSION['cart']);

if (isset($_POST['addToCart']) && ($_POST['addToCart'])) {
    $nameCart = $_POST['name'];
    $priceCart = $_POST['price'];
    $imgCart = $_POST['img'];
    $qtyCart = $_POST['qty'];

    $check = 0;

    for ($i=0; $i < sizeof($_SESSION['cart']) ; $i++) { 
        if($_SESSION['cart'][$i][0] === $nameCart)
        {
            $check == 1;
            $count = $qty + $_SESSION['cart'][$i][3];
            $_SESSION['cart'][$i][3] = $count;
            break;
        }
    }

    if($check === 0)
    {
        $cartArray = [
            $nameCart,
            $priceCart,
            $imgCart,
            $qtyCart
        ];
    
        $_SESSION['cart'][] = $cartArray;
    }

    check($_SESSION['cart']);
    function showCartItem()
    {
        if (isset($_SESSION['cart']) && (is_array($_SESSION['cart']))) {
            $totalBill = 0;
            for ($i = 0; $i < sizeof($_SESSION['cart']); $i++) {
                $total = $_SESSION['cart'][$i][1] * $_SESSION['cart'][$i][3];
                $totalBill+=$total;
                echo '
            <tr>
                <td class="align-middle">'.($i+1).'</td>
                <td class="align-middle">'.$_SESSION['cart'][$i][0].'</td>
                <td class="align-middle">'.formatCurrencyVND($_SESSION['cart'][$i][1]).'</td>
                <td class="align-middle">
                    <img src="../../assets/users/img/products/'.$_SESSION['cart'][$i][2].'" alt="" style="width: 50px; height: 50px">
                </td>
                <td class="align-middle">'.$_SESSION['cart'][$i][3].'</td>
                <td class="align-middle">'.formatCurrencyVND($total).'</td>
                <td class="align-middle"><button class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button></td>
            </tr>
                ';
            }
            echo '
                <tr>
                    <th colspan="5">Tổng đơn hàng: </th>
                    <th>
                        <div>'.formatCurrencyVND($totalBill).'</div>
                    </th>
                </tr>
            ';
        }
    }
}

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
                        <th>Xoá Sản Phẩm</th>
                    </tr>
                </thead>
                <tbody class="align-middle">
                    <?php
                        showCartItem();
                    ?>
                </tbody>
            </table>
            <a href="../users/index.php" class="btn btn-block btn-primary font-weight-bold my-3 py-3">Thanh Toán</a>
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