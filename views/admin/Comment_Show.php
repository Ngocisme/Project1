<?php
include_once "./includes/header.php";

include_once '../../models/Database.php';


$stmt = $conn->query("SELECT * FROM product_comments ORDER BY created_at DESC");
$commentsShow = $stmt->fetchAll();

?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Users</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">List of comments</h6>
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
                            <th>Product</th>
                            <th>Email</th>
                            <th>Name</th>
                            <th>Messages</th>
                            <th>Status</th>
                            <th>Created Time</th>
                            <th>Method</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Product</th>
                            <th>Email</th>
                            <th>Name</th>
                            <th>Messages</th>
                            <th>Status</th>
                            <th>Created Time</th>
                            <th>Method</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        foreach ($commentsShow as $comment) {
                            ?>
                            <tr>
                                <td><?= $comment['id'] ?></td>
                                <td><?= $comment['id_product'] ?></td>
                                <td><?= $comment['email'] ?></td>
                                <td><?= $comment['name'] ?></td>
                                <td><?= $comment['messages'] ?></td>
                                <td><?= $comment['status'] ?></td>
                                <td><?= $comment['created_at'] ?></td>
                                <td>
                                    <a href="../../models/CommentApprove.php?id=<?= $comment['id'] ?>&action=approve" class="btn btn-primary">Approve</a>
                                    
                                    <a href="../../models/CommentApprove.php?id=<?= $comment['id'] ?>&action=reject" class="btn btn-danger">Reject</a>
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