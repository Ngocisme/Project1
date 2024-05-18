<?php
ob_start();
include_once "./includes/header.php";

include_once "../../models/CategoryAll_model.php";

$cateID = $_GET['category_id'];
$stmt = $conn->prepare("SELECT * FROM brands WHERE id = ?");
$stmt->execute([$cateID]);
$category = $stmt->fetch(PDO::FETCH_ASSOC);

$cateID = $category['id'];
$cateName = $category['name'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_POST['id'];
    $name = $_POST['name'];

    $sql = "UPDATE brands SET name = :name WHERE id= :id ";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':id', $id);

    $stmt->execute();


    header("Location: http://localhost:8888/keitaizoneTemplate/views/admin/Category_Show.php");


    ob_end_flush();
}

?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- DataTales Example -->
    <h2>Edit Product</h2>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        <div class="form-group">
            <label for="productPrice">Id Category:</label>
            <input type="number" class="form-control" id="productPrice" placeholder="Enter category id"
                value="<?= $cateID ?>" name="id">
        </div>
        <div class="form-group">
            <label for="productName">Category Name:</label>
            <input type="text" class="form-control" id="productName" placeholder="Enter category name"
                value="<?= $cateName ?>" name="name">
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Update Product</button>
    </form>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<?php
include_once "./includes/footer.php";
?>