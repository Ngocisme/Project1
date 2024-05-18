<?php
ob_start();
include_once "./includes/header.php";
include_once "../../models/CategoryAll_model.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_id = $_POST['id'];
    $category_name = $_POST['name'];

     $sql = "INSERT INTO brands (id, name) VALUES (:id, :name)";
     $stmt = $conn->prepare($sql);
     $stmt->execute(['id' => $category_id, 'name' => $category_name]);
 
    header("Location:  http://localhost:8888/keitaizoneTemplate/views/admin/Category_Show.php");
}
ob_end_flush();
?>


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- DataTales Example -->
    <h2>Edit Category</h2>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
    <div class="form-group">
        <label for="productPrice">Id Category:</label>
        <input type="number" class="form-control" id="productPrice" placeholder="Enter category ID" name = "id">
      </div>
      <div class="form-group">
        <label for="productName">Category Name:</label>
        <input type="text" class="form-control" id="productName" placeholder="Enter category name"  name = "name">
      </div>
     
      <button type="submit" name="submit" class="btn btn-primary">Add Category</button>
    </form>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<?php
include_once "./includes/footer.php";
?>

