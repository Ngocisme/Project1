<?php
include_once "./includes/header.php";
include_once "../../models/ProductAll_model.php";
include_once "../../models/CategoryAll_model.php";
include_once "../../models/ProductCategoryAll_model.php";

$productID = $_GET['product_id'];
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$productID]);
$productsReal = $stmt->fetch(PDO::FETCH_ASSOC);

$prodId = $productsReal['id'];
$proName = $productsReal['name'];
$branddId = $productsReal['brand_id'];
$proCateId = $productsReal['product_category_id'];
$proDes = $productsReal['description'];
$proPrice = $productsReal['price'];
$proDiscount = $productsReal['discount'];
$proQty = $productsReal['qty'];
$proFeatured = $productsReal['featured'];
$proImg = $productsReal['img'];

function is_valid_image($file_tmp_path)
{
    $allowed_types = array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG);
    $detected_type = exif_imagetype($file_tmp_path);
    return in_array($detected_type, $allowed_types);
}

// if ($_SERVER["REQUEST_METHOD"] == "POST") {

//     $id = $_POST['id'];
//     $name = $_POST['name'];

//     $sql = "UPDATE brands SET name = :name WHERE id= :id ";
//     $stmt = $conn->prepare($sql);

//     $stmt->bindParam(':name', $name);
//     $stmt->bindParam(':id', $id);

//     $stmt->execute();


//     header("Location: http://localhost:8888/keitaizoneTemplate/views/admin/Category_Show.php");


//     ob_end_flush();
// }
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- DataTales Example -->
    <h2>Edit Product</h2>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">

        <div class="form-floating">
            <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="brand"
                required>
                <option selected>
                    <?=$branddId?>
                </option>
                <?php foreach ($products as $product): ?>
                    <option value="<?= $product['id'] ?>"><?= $product['id'] ?>-<?= $product['name'] ?></option>
                <?php endforeach ?>
            </select>
            <label for="floatingSelect">Brand</label>
        </div>

        <div class="form-floating">
            <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="category"
                required>
                <option selected> <?=$proCateId?></option>
                <?php foreach ($productCategories as $item): ?>
                    <option value="<?= $item['id'] ?>"><?= $item['id'] ?>-<?= $item['name'] ?></option>
                <?php endforeach ?>
            </select>
            <label for="floatingSelect">Category</label>
        </div>

        <div class="form-group">
            <label for="productName">Name:</label>
            <input type="text" class="form-control" id="productName" placeholder="Please enter name" name="name" value="<?=$proName?>">
        </div>

        <div class="form-group">
            <label for="productName">Price:</label>
            <input type="number" class="form-control" id="productName" placeholder="Please enter price" name="price" value="<?=$proPrice?>">
        </div>

        <div class="form-group">
            <label for="productName">Qty:</label>
            <input type="number" class="form-control" id="productName" placeholder="Please enter qty" name="qty" value="<?=$proQty?>">
        </div>

        <div class="form-group">
            <label for="productName">Discount:</label>
            <input type="number" class="form-control" id="productName" placeholder="Please enter discount"
                name="discount" value="<?=$proDiscount?>"> 
        </div>

        <div class="form-floating">
            <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="featured">
                <option selected><?=$proFeatured?></option>
                <option value="0">0</option>
                <option value="1">1</option>
            </select>
            <label for="floatingSelect">Select Featured</label>
        </div>

        <div class="form-group">
            <input type="file" class="form-control form-control-user" placeholder="Put your img product here" name="img"
                accept="image/*" required value="<?=$proImg?>">
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Edit product</button>
    </form>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<?php
include_once "./includes/footer.php";
?>