<?php
ob_start();
include_once "./includes/header.php";

include_once "../../models/ProductCategoryAll_model.php";

$cateID = $_GET['product_category_id'];
$stmt = $conn->prepare("SELECT * FROM product_categories WHERE id = ?");
$stmt->execute([$cateID]);
$category = $stmt->fetch(PDO::FETCH_ASSOC);

$cateID = $category['id'];
$cateName = $category['name'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_POST['id'];
    $name = $_POST['name'];

    $sql = "UPDATE product_categories SET name = :name WHERE id= :id ";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':id', $id);

    $stmt->execute();


    header("Location: http://localhost:8888/keitaizoneTemplate/views/admin/ProductCategory_Show.php");


    ob_end_flush();
}

?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- DataTales Example -->
    <h2>Edit Product Category</h2>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        <div class="form-group">
            <label for="productPrice">Id product category:</label>
            <input type="number" class="form-control" id="productPrice" placeholder="Enter product category id"
                value="<?= $cateID ?>" name="id">
        </div>
        <div class="form-group">
            <label for="productName">Product category Name:</label>
            <input type="text" class="form-control" id="productName" placeholder="Enter product category name"
                value="<?= $cateName ?>" name="name">
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Update Product Category</button>
    </form>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<?php
include_once "./includes/footer.php";
?>