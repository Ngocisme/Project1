<?php

include_once "../users/includes/header.php";

include_once "../../models/ProductAll_model.php";

$comment_product_id = $_GET['product_id'];
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$comment_product_id]);
$prod = $stmt->fetch(PDO::FETCH_ASSOC);

// Xử lí comment
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $comment = $_POST['comment'];
    $name = $_POST['name'];
    $email = $_POST['email'];

    $stmt = $conn->prepare('INSERT INTO product_comments (id_product ,email, name, messages) VALUES (?,?, ?, ?)');
    $stmt->execute(
        [
            $comment_product_id,
            $email,
            $name,
            $comment
        ]
    );
}

// dùng where ngay chỗ product id để lấy bình luận đúng với id của sản phẩm đó tránh bị lặp bình luận qua các sản phẩm khác
$stmt = $conn->prepare('SELECT * FROM product_comments WHERE id_product = ? AND status = 1 ORDER BY created_at DESC');
$stmt->execute([
    $comment_product_id
]);
$comments = $stmt->fetchAll();

$stmt = $conn->prepare('SELECT COUNT(id) as comment_count FROM product_comments WHERE id_product = ?');
$stmt->execute(
    [
        $comment_product_id
    ]
);
$commentsCount = $stmt->fetch(PDO::FETCH_ASSOC)['comment_count'];

?>


<!-- Breadcrumb Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-12">
            <nav class="breadcrumb bg-light mb-30">
                <a class="breadcrumb-item text-dark" href="#">Home</a>
                <a class="breadcrumb-item text-dark" href="#">Shop</a>
                <span class="breadcrumb-item active">Shop Detail</span>
            </nav>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->


<!-- Shop Detail Start -->
<div class="container-fluid pb-5">
    <div class="row px-xl-5">
        <div class="col-lg-5 mb-30">
            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img class="d-block w-100" src="../../assets/users/img/products/<?= $prod['img'] ?>"
                            alt="First slide">
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>

        <div class="col-lg-7 h-auto mb-30">
            <div class="h-100 bg-light p-30">
                <h3><?= $prod['name'] ?></h3>
                <h3 class="font-weight-semi-bold mb-4"><?= formatCurrencyVND($prod['price']); ?></h3>
                <p class="mb-4">
                    <?= $prod['description'] ?>
                </p>


                <div class="d-flex align-items-center mb-4 pt-2">

                    <a href="./../users/cart.php "><button class="btn btn-primary px-3"><i
                                class="fa fa-shopping-cart mr-1"></i>
                            Add To Cart</button>
                    </a>
                </div>
                <div class="d-flex pt-2">
                    <strong class="text-dark mr-2">Share on:</strong>
                    <div class="d-inline-flex">
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-pinterest"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row px-xl-5">
        <div class="col">
            <div class="bg-light p-30">
                <div class="nav nav-tabs mb-4">
                    <a class="nav-item nav-link text-dark active" data-toggle="tab" href="#tab-pane-1">Description</a>
                    <a class="nav-item nav-link text-dark" data-toggle="tab" href="#tab-pane-2">Information</a>
                    <a class="nav-item nav-link text-dark" data-toggle="tab" href="#tab-pane-3">Reviews
                        (<?= $commentsCount ?>)</a>
                </div>
                <div class="tab-content">

                    <div class="tab-pane fade" id="tab-pane-3">
                        <div class="row">
                            <div class="col-md-6">
                                <?php
                                if ($comments) {
                                    ?>
                                    <?php
                                    foreach ($comments as $comment):
                                        ?>
                                        <div class="media mb-4">
                                            <!-- <img src="../../assets/users/img/<?= $comment[''] ?>" alt="Image" class="img-fluid mr-3 mt-1"
                                        style="width: 45px;"> -->
                                            <div class="media-body">
                                                <h6><?= $comment['name'] ?><small> - <i><?= $comment['created_at'] ?></i></small>
                                                </h6>
                                                <!-- <div class="text-primary mb-2">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star-half-alt"></i>
                                                <i class="far fa-star"></i>
                                            </div> -->
                                                <p>
                                                    <?= $comment['messages'] ?>
                                                </p>
                                            </div>
                                        </div>
                                    <?php
                                    endforeach;
                                    ?>
                                    <?php
                                } else {
                                    ?>
                                    <p>Không có bình luận</p>
                                        <?php
                                }
                                ?>
                            </div>


                            <?php
                            if (isset($_SESSION['user'])) {
                                ?>

                                <div class="col-md-6">
                                    <h4 class="mb-4">Để lại bình luận</h4>

                                    <!-- <div class="d-flex my-3">
                                        <p class="mb-0 mr-2">Your Rating * :</p>
                                        <div class="text-primary">
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                        </div>
                                    </div> -->

                                    <form action="../../views/users/detail.php?product_id=<?= $comment_product_id ?>"
                                        method="post">
                                        <div class="form-group">
                                            <label for="message">Bình luận của bạn *</label>
                                            <textarea id="message" cols="30" rows="5" class="form-control" name="comment"
                                                required></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Tên người dùng *</label>
                                            <input type="text" class="form-control" id="name" name="name" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email *</label>
                                            <input type="email" class="form-control" id="email" name="email" required>
                                        </div>
                                        <div class="form-group mb-0">
                                            <input type="submit" value="Để lại bình luận" class="btn btn-primary px-3">
                                        </div>
                                    </form>
                                </div>

                                <?php
                            }
                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Shop Detail End -->



<!-- Footer Start -->
<?php

include_once "../users/includes/footer.php";

?>