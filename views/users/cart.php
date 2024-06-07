<?php
ob_start();
session_start();
include_once "../users/includes/header.php";
include_once "../../models/Database.php";

$id = isset($_GET['id']) ? $_GET['id'] : null;

if($id !== null) {
    $sql = "SELECT * FROM products WHERE id = $id";
    $stmt = $conn->query($sql);
    if($stmt) {
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        if($product) {
            $item = [ 
                'id'=> $product['id'],
                'name'=> $product['name'],
                'price'=> $product['price'],
                'qty'=> 1,
                'total' => $product['price'] // Khởi tạo total bằng giá sản phẩm ban đầu
            ];
            if(isset($_SESSION['cart'][$id])){
                     $_SESSION['cart'][$id]['qty'] += 1;
                 }else{
                    $_SESSION['cart'][$id]=$item;
                 }
        }
    }

    unset($_GET['id']);
}

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
//update so lượng
//if(isset($_POST['update_item'])) {
    //$id = $_POST['update_item'];
    //$quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
    
    // Kiểm tra số lượng sản phẩm để đảm bảo rằng nó là số nguyên và không âm
   // $quantity = max(1, $quantity);
    
    // Cập nhật số lượng sản phẩm
    //$_SESSION['cart'][$id]['qty'] = $quantity;
    
    // Tính toán lại tổng giá trị của sản phẩm
    //$_SESSION['cart'][$id]['total'] = $_SESSION['cart'][$id]['price'] * $quantity;
//}
if (isset($_POST['update_item'])) {
    $id = $_POST['update_item'];
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

    // Kiểm tra số lượng sản phẩm để đảm bảo rằng nó là số nguyên và không âm
    $quantity = max(1, $quantity);
    

    // Kiểm tra xem giỏ hàng đã được khởi tạo hay chưa
    if (!isset($_SESSION['cart'])) { 
        $_SESSION['cart'] = array();
    }

    // Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng chưa
    if (array_key_exists($id, $_SESSION['cart'])) {
        // Cập nhật số lượng sản phẩm
        $_SESSION['cart'][$id]['qty'] = $quantity;

        // Tính toán lại tổng giá trị của sản phẩm
        $_SESSION['cart'][$id]['total'] = $_SESSION['cart'][$id]['price'] * $quantity;
    }
}
//xoa item 
if(isset($_POST['remove_item'])) {
    $remove_id = $_POST['remove_item'];
    unset($cart[$remove_id]);
    $_SESSION['cart'] = $cart;
    header("Location: cart.php");
    exit;
}
// Tính Subtotal
$subTotal = 0;
foreach($cart as $id => $item) {
    $subTotal += $item['total'];
}

// Phí shipping cố định
$shippingFee = 10; // Giả sử phí shipping là $10

// Tính Total
$total = $subTotal + $shippingFee;
ob_end_flush();
?>
<!-- Cart Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-lg-8 table-responsive mb-5">
            <table class="table table-light table-borderless table-hover text-center mb-0">
                <thead class="thead-dark">
                    <tr>
                        <th>Products</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody class="align-middle">
                    <?php foreach($cart as $id => $item ):?>
                    <tr>
                        <td class="align-middle"><img src="img/product-1.jpg" alt="" style="width: 50px;"><?php echo $item['name']?>
                        </td>
                        <td class="align-middle"><?php echo $item['price']?></td>
                        <td class="align-middle">
                            <form method="post">
                                <input type="hidden" name="update_item" value="<?php echo $id ?>">
                                <div class="input-group quantity mx-auto" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-primary btn-minus" type="submit" name="decrease_quantity">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                    <input type="text" class="form-control form-control-sm bg-secondary border-0 text-center" name="quantity" value="<?php echo $item['qty'] ?>">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-primary btn-plus" type="submit" name="increase_quantity">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </td>
                        <td class="align-middle"><?php echo $item['total']?></td>
                        <td class="align-middle">
                            <form method="post">
                                <input type="hidden" name="remove_item" value="<?php echo $id ?>">
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to remove this item?')">
                                    <i class="fa fa-times"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach?>
                    
                </tbody>
            </table>
        </div>
        <div class="col-lg-4">
            <form class="mb-30" action="">
                <div class="input-group">
                    <input type="text" class="form-control border-0 p-4" placeholder="Coupon Code">
                    <div class="input-group-append">
                        <button class="btn btn-primary">Apply Coupon</button>
                    </div>
                </div>
            </form>
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Cart
                    Summary</span></h5>
            <div class="bg-light p-30 mb-5">
            <div class="border-bottom pb-2">
                <div class="d-flex justify-content-between mb-3">
                    <h6>Subtotal</h6>
                    <h5><?php echo formatCurrencyVND($total); ?></h5>
                </div>
                <div class="d-flex justify-content-between">
                    <h6 class="font-weight-medium">Shipping</h6>
                    <h6 class="font-weight-medium"><?php echo $shippingFee; ?>VND</h6>
                </div>
            </div>
                <div class="pt-2">
                <div class="d-flex justify-content-between mt-2">
                    <h5>Total</h5>
                    <h5><?php echo formatCurrencyVND($total); ?></h5>
                </div>
                <a href="checkout.php" class="btn btn-block btn-primary font-weight-bold my-3 py-3 ">Proceed To Checkout</a>
             </div>
            </div>
        </div>
    </div>
</div>
<!-- Cart End -->

<?php
include_once "../users/includes/footer.php";
?>
