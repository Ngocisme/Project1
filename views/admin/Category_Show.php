<?php
include_once "./includes/header.php";
include_once "../../models/CategoryAll_model.php";
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Brands</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">List of Brands</h6>
            <a class="btn btn-primary" href="./Category_Add.php" role="button">Create Brand</a>
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
                        foreach ($products as $product) {
                            ?>
                            <tr>
                                <td><?=$product['id'] ?></td>
                                <td><?=$product['name'] ?></td>
                                <td>
                                    <a href="./Category_Edit.php?category_id=<?=$product['id']?>">Edit</a>
                                    ||
                                    <a href="./Category_Delete.php?category_id=<?=$product['id']?>">Delete</a>
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