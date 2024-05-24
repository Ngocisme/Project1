<?php
include_once "./includes/header.php";
include_once "../../models/ProductAll_model.php";
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Products</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">List of Products</h6>
            <a class="btn btn-primary" href="./Product_Add.php" role="button">Create Product</a>
            <?php
            if (isset($_GET['success'])) {
                ?>
                <div class="alert alert-success">
                    <?php
                    echo $_GET['success'];
                    ?>
                </div>
                <?php
            }
            ?>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Brand</th>
                            <th>Category</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Discount</th>
                            <th>Featured</th>
                            <th>Views</th>
                            <th>Img</th>
                            <th>Method</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Brand</th>
                            <th>Category</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Discount</th>
                            <th>Featured</th>
                            <th>Views</th>
                            <th>Img</th>
                            <th>Method</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        foreach ($products as $product) {
                            ?>
                            <tr>
                                <td><?= $product['id'] ?></td>
                                <td><?= $product['brand_name'] ?></td>
                                <td><?= $product['product_category'] ?></td>
                                <td><?= $product['name'] ?></td>
                                <td><?= formatCurrencyVND($product['price']) ?></td>
                                <td><?= $product['qty'] ?></td>
                                <td><?= $product['discount'] ?></td>
                                <td><?= $product['featured'] ?></td>
                                <td><?= $product['Views'] ?></td>
                                <td class="image-container">
                                    <img src="../../assets//users/img/products/<?= $product['img'] ?>" alt="" srcset="">
                                </td>
                                <td>
                                    <a href="./Product_Edit.php?product_id=<?= $product['id'] ?>">Edit</a>
                                    ||
                                    <a href="./Product_Delete.php?product_id=<?= $product['id'] ?>">Delete</a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<?php
include_once "./includes/footer.php";
?>