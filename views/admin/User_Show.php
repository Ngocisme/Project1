<?php
include_once "./includes/header.php";
include_once "../../models/UserAll_model.php";
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Users</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">List of users</h6>
            <a class="btn btn-primary" href="./User_Add.php" role="button">Create User</a>
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
                            <th>Email</th>
                            <th>Password</th>
                            <th>Avatar</th>
                            <th>Method</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Avatar</th>
                            <th>Method</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        foreach ($users as $user) {
                            ?>
                            <tr>
                                <td><?= $user['id'] ?></td>
                                <td><?= $user['name'] ?></td>
                                <td><?= $user['email'] ?></td>
                                <td><?= $user['password'] ?></td>
                                <td class="image-container">
                                    <img src="../../assets/admin/img/users/<?=$user['avatar']?>" alt="">
                                </td>
                                <td>
                                    <a href="./User_Edit.php?user_id=<?= $user['id'] ?>">Edit</a>
                                    ||
                                    <a href="./User_Delete.php?user_id=<?= $user['id'] ?>">Delete</a>
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