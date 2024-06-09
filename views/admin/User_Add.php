<?php
ob_start();
include_once "./includes/header.php";
include_once "../../models/CategoryAll_model.php";

function is_valid_image($file_tmp_path)
{
    $allowed_types = array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG);
    $detected_type = exif_imagetype($file_tmp_path);
    return in_array($detected_type, $allowed_types);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_name = $_POST['username'];
    $user_password = $_POST['password'];
    $user_email = $_POST['email'];
    $user_level = $_POST['level'];
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


    // $checkarray = [
    //     $user_name,
    //     $user_password,
    //     $user_email,
    //     $user_level
    // ];

    // check($checkarray);

    $sql = "INSERT INTO users (name, email, password, level, avatar) VALUES (:name, :email, :password, :level, :avatar)";
    $stmt = $conn->prepare($sql);
    $stmt->execute(
        [
            'name' => $user_name,
            'email' => $user_email,
            'password' => $user_password,
            'level' => $user_level,
            'avatar' => $imgName
        ]
    );

    header("Location:  http://localhost:8888/keitaizoneTemplate/views/admin/User_Show.php");
}
ob_end_flush();
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- DataTales Example -->
    <h2>Add User</h2>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">

        <div class="form-group">
            <label for="productName">UserName:</label>
            <input type="text" class="form-control" id="productName" placeholder="Enter category name" name="username">
        </div>

        <div class="form-group">
            <label for="productName">Password:</label>
            <input type="text" class="form-control" id="productName" placeholder="Enter category name" name="password">
        </div>

        <div class="form-group">
            <label for="productName">Email</label>
            <input type="email" class="form-control" id="productName" placeholder="Enter category name" name="email">
        </div>


        <div class="form-floating">
            <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="level"
                required>
                <option selected>Select</option>
                <option>0</option>
                <option>1</option>
            </select>
            <label for="floatingSelect">Role</label>
        </div>

        <div class="form-group">
            <input type="file" class="form-control form-control-user" placeholder="Put your avatar here" name="img"
                accept="image/*" required>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Add User</button>
    </form>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<?php
include_once "./includes/footer.php";
?>