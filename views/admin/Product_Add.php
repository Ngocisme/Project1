<?php
ob_start();
include_once "./includes/header.php";
include_once "../../models/CategoryAll_model.php";
include_once "../../models/ProductCategoryAll_model.php";

function is_valid_image($file_tmp_path)
{
    $allowed_types = array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG);
    $detected_type = exif_imagetype($file_tmp_path);
    return in_array($detected_type, $allowed_types);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_brand = $_POST['brand'];
    $product_category = $_POST['category'];
    $product_name = $_POST['name'];
    $product_price = $_POST['price'];
    $product_qty = $_POST['qty'];
    $product_discount = $_POST['discount'];
    $product_featured = $_POST['featured'];
    $product_view = $_POST['view'];
    $imgName = $_FILES['img']['name'];
    $imgTMP = $_FILES['img']['tmp_name'];

    if (isset($_FILES['img']) && $_FILES['img']['error'] === 0) {

        // Kiểm tra xem tệp có phải là ảnh hợp lệ không
        if (is_valid_image($imgTMP)) {
            // Thay đổi đường dẫn ảnh (nếu cần)
            $new_image_path = '../../assets/users/img/products/' . $imgName; // Đường dẫn mới
            move_uploaded_file($imgTMP, $new_image_path); // Di chuyển file đến đường dẫn mới


            echo "Tệp là ảnh hợp lệ và đã được lưu vào cơ sở dữ liệu.";
        } else {
            echo "Tệp không phải là ảnh hợp lệ.";
        }
    } else {
        echo "Đã xảy ra lỗi trong quá trình upload file.";
    }


    $sql = "INSERT INTO products (brand_id, product_category_id, name, price, qty, discount, featured, Views, img) 
    VALUES (:brand_id, :product_category_id, :name, :price, :qty, :discount, :featured, :Views, :img)";
    $stmt = $conn->prepare($sql);
    $stmt->execute(
        [
            'brand_id' => $product_brand,
            'product_category_id' => $product_category,
            'name' => $product_name,
            'price' => $product_price,
            'qty' => $product_qty,
            'discount' => $product_discount,
            'featured' => $product_featured,
            'Views' => $product_view,
            'img' => $imgName,
        ]
    );

    header("Location: http://localhost:8888/keitaizoneTemplate/views/admin/Product_Show.php");
}
ob_end_flush();

// check($_FILES['img']);
?>


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- DataTales Example -->
    <h2>Add Product</h2>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">

        <div class="form-floating">
            <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="brand"
                required>
                <option selected>Select</option>
                <?php foreach ($products as $product): ?>
                    <option value="<?= $product['id'] ?>"><?= $product['id'] ?>-<?= $product['name'] ?></option>
                <?php endforeach ?>
            </select>
            <label for="floatingSelect">Brand</label>
        </div>

        <div class="form-floating">
            <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="category"
                required>
                <option selected>Select</option>
                <?php foreach ($productCategories as $item): ?>
                    <option value="<?= $item['id'] ?>"><?= $item['id'] ?>-<?= $item['name'] ?></option>
                <?php endforeach ?>
            </select>
            <label for="floatingSelect">Category</label>
        </div>

        <div class="form-group">
            <label for="productName">Name:</label>
            <input type="text" class="form-control" id="productName" placeholder="Please enter name" name="name">
        </div>

        <div class="form-group">
            <label for="productName">Price:</label>
            <input type="number" class="form-control" id="productName" placeholder="Please enter price" name="price">
        </div>

        <div class="form-group">
            <label for="productName">Qty:</label>
            <input type="number" class="form-control" id="productName" placeholder="Please enter qty" name="qty">
        </div>

        <div class="form-group">
            <label for="productName">Discount:</label>
            <input type="number" class="form-control" id="productName" placeholder="Please enter discount"
                name="discount">
        </div>

        <div class="form-floating">
            <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="featured">
                <option selected>Featured</option>
                <option value="0">0</option>
                <option value="1">1</option>
            </select>
            <label for="floatingSelect">Select Featured</label>
        </div>

        <div class="form-floating">
            <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="view">
                <option selected>View</option>
                <option value="0">0</option>
            </select>
            <label for="floatingSelect">View</label>
        </div>

        <div class="form-group">
            <input type="file" class="form-control form-control-user" placeholder="Put your img product here" name="img"
                accept="image/*" required>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Add product</button>
    </form>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<?php
include_once "./includes/footer.php";
?>