<?php
ob_start();
include_once "./includes/header.php";
include_once '../../models/Database.php';

function is_valid_image($file_tmp_path)
{
    $allowed_types = array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG);
    $detected_type = exif_imagetype($file_tmp_path);
    return in_array($detected_type, $allowed_types);
}

$user_id = $_GET['user_id'];

$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $userid = $_POST['id'];
    $username = $_POST['name'];
    $useremail = $_POST['email'];
    $userpassword = $_POST['password'];
    $userrepassword = $_POST['repassword'];
    $imgName = $_FILES['img']['name'];
    $imgTMP = $_FILES['img']['tmp_name'];

    if (isset($_FILES['img']) && $_FILES['img']['error'] === 0) {

        // Kiểm tra xem tệp có phải là ảnh hợp lệ không
        if (is_valid_image($imgTMP)) {
            // Thay đổi đường dẫn ảnh (nếu cần)
            $new_image_path = '../../assets/admin/img/users/' . $imgName; // Đường dẫn mới
            move_uploaded_file($imgTMP, $new_image_path); // Di chuyển file đến đường dẫn mới


            echo "Tệp là ảnh hợp lệ và đã được lưu vào cơ sở dữ liệu.";
        } else {
            echo "Tệp không phải là ảnh hợp lệ.";
        }
    } else {
        echo "Đã xảy ra lỗi trong quá trình upload file.";
    }



    $sql = "UPDATE users SET id = ?, name = ?, email = ?, password = ?, avatar = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(
        [
            $userid,
            $username,
            $useremail,
            $userpassword,
            $imgName,
            $userid
        ]
    );
    if (isset($userid) && isset($username) && isset($useremail) && isset($userpassword) && isset($userrepassword) && isset($imgName)) {
        header("Location:  http://localhost:8888/keitaizoneTemplate/views/admin/User_Show.php?success=successfully");
        exit();
    }
        else
        {
            if ($userpassword !== $userrepassword) {
                header("Location:  http://localhost:8888/keitaizoneTemplate/views/admin/User_Edit.php?err=password does not match");
                exit();
            }
        }
}

ob_end_flush();
?>

<div class="container-fluid">

    <!-- DataTales Example -->
    <h2>Edit User</h2>
    <form action="../../views/admin/User_Edit.php?user_id=<?$user['id']?>" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="productPrice">Id user</label>
            <input type="number" class="form-control" placeholder="Enter user id" value="<?= $user['id'] ?>" name="id">
        </div>

        <div class="form-group">
            <label for="productName">Username:</label>
            <input type="text" class="form-control" placeholder="Enter user name" value="<?= $user['name'] ?>"
                name="name">
        </div>

        <div class="form-group">
            <label for="productName">Email:</label>
            <input type="email" class="form-control" placeholder="Enter user email" value="<?= $user['email'] ?>"
                name="email">
        </div>

        <div class="form-group">
            <label for="productName">Password:</label>
            <input type="text" class="form-control" placeholder="Enter user password" value="<?= $user['password'] ?>"
                name="password">
        </div>

        <div class="form-group">
            <label for="productName">Re-Password:</label>
            <input type="text" class="form-control" placeholder="Enter user re password" value=""
                name="repassword">
        </div>

        <div class="form-group">
            <input type="file" class="form-control form-control-user" placeholder="Put your avatar here" name="img"
                accept="image/*" required>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Update User</button>

        <?php
            if (isset($_GET['err'])) {
                ?>
                <div class="alert alert-danger">
                    <?php
                    echo $_GET['err'];
                    ?>
                </div>
                <?php
            }
            ?>
    </form>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<?php
include_once "./includes/footer.php";
?>