<?php
include_once "./includes/header.php";
include_once '../../models/OrderAll_model.php';
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Orders</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">List of orders</h6>
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
                            <th>Name</th>
                            <th>Dates</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Method</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Dates</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Method</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        foreach ($orders as $order) {
                            ?>
                            <tr>
                                <td><?= $order['id'] ?></td>
                                <td><?= $order['full_name'] ?></td>
                                <td><?= $order['created_at'] ?></td>
                                <td><?= formatCurrencyVND($order['totalBill']) ?></td>
                                <td><?= $order['Status'] ?></td>
                                <td>
                                    <form action="../../models/OrderStatus_model.php?orderid=<?=$order['id']?>" method="POST">
                                        <label for="status">Status:</label>
                                        <select id="status" name="status">
                                            <option value="Pending" <?= $order['Status'] == 'pending' ? 'selected' : '' ?>>
                                                Pending
                                            </option>
                                            <option value="Processed" <?= $order['Status'] == 'processed' ? 'selected' : '' ?>>
                                                Processed</option>
                                            <option value="Shipped" <?= $order['Status'] == 'shipped' ? 'selected' : '' ?>>
                                                Shipped
                                            </option>
                                        </select><br><br>
                                        <input type="submit" value="Update" class="btn btn-primary">
                                    </form>
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