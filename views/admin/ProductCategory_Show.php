<?php
include_once "./includes/header.php";
include_once "../../models/ProductCategoryAll_model.php";
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Categories Products</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">List of Categorie Products</h6>
            <a class="btn btn-primary" href="./ProductCategory_Add.php" role="button">Create Category Product</a>
            <?php 
              if(isset($_GET['success'])) {
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
                            <th>Name</th>
                            <th>Method</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Method</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        foreach ( $productCategories as $item) {
                            ?>
                            <tr>
                                <td><?=$item['id'] ?></td>
                                <td><?=$item['name'] ?></td>
                                <td>
                                    <a href="./ProductCategory_Edit.php?product_category_id=<?=$item['id']?>" class="btn btn-primary">Edit</a>
                                    
                                    <a href="./ProductCategory_Delete.php?product_category_id=<?=$item['id']?>" class="btn btn-danger">Delete</a>
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