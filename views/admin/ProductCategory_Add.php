<?php
ob_start();
include_once "./includes/header.php";
include_once "../../models/ProductCategoryAll_model.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_category_id = $_POST['id'];
    $product_category_name = $_POST['name'];

     $sql = "INSERT INTO product_categories (id, name) VALUES (:id, :name)";
     $stmt = $conn->prepare($sql);
     $stmt->execute(['id' => $product_category_id, 'name' => $product_category_name]);
 
    header("Location: http://localhost:8888/keitaizoneTemplate/views/admin/ProductCategory_Show.php");
}
ob_end_flush();
?>


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- DataTales Example -->
    <h2>Add Product Category</h2>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
    <div class="form-group">
        <label for="productPrice">Id product category:</label>
        <input type="number" class="form-control" id="productPrice" placeholder="Enter product category ID" name = "id">
      </div>
      <div class="form-group">
        <label for="productName">Product category Name:</label>
        <input type="text" class="form-control" id="productName" placeholder="Enter product category name"  name = "name">
      </div>
     
      <button type="submit" name="submit" class="btn btn-primary">Add product category</button>
    </form>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<?php
include_once "./includes/footer.php";
?>

