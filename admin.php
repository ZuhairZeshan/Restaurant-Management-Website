<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Admin Portal</title>
    
</head>
<body>

<!-- Connecting Starts -->
<?php include '_dbconnect.php'; ?>   
<!-- Connecting Ends -->


<!-- Delete Query Starts -->
<?php  
if (isset($_GET['delete_category'])) {
    $cat_id = $_GET['delete_category'];
    $sql = "DELETE FROM `categories` WHERE `Category_id` = $cat_id";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo "<script>alert('Category deleted successfully!'); window.location.href='admin.php';</script>";
    } else {
        echo "<script>alert('Error deleting category.');</script>";
    }
}
elseif (isset($_GET['delete_item'])) {
    $item_id = $_GET['delete_item'];
    $sql = "DELETE FROM `items` WHERE `Item_id` = $item_id";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo "<script>alert('Item deleted successfully!'); window.location.href='admin.php';</script>";
    } else {
        echo "<script>alert('Error deleting item.');</script>";
    }
}
?>
<!-- Delete Query Ends -->


<!-- Add Category Query Starts -->
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_category'])) {
    $category_id = $_POST['category_id'];
    $category_name = $_POST['category_name'];

    $sql_check_id = "SELECT * FROM `categories` WHERE Category_id = '$category_id'";
    $result_id = mysqli_query($conn, $sql_check_id);
    if (mysqli_num_rows($result_id) > 0) {
        $error_message = "Category ID already exists.";
    }

    $sql_check_name = "SELECT * FROM `categories` WHERE Category_name = '$category_name'";
    $result_name = mysqli_query($conn, $sql_check_name);
    if (mysqli_num_rows($result_name) > 0) {
        $error_message = "Category Name already exists.";
    }

    if (!isset($error_message)) {
        $sql_insert = "INSERT INTO `categories` (Category_id, Category_name) 
                       VALUES ('$category_id', '$category_name')";
        if (mysqli_query($conn, $sql_insert)) {
            header("Location: admin.php");  // Redirect after successful insert
        } else {
            $error_message = "Error adding category.";
        }
    }
}
?>
<!-- Add Category Query Ends -->


<!-- Add Item Query Starts -->
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_item'])) {
    $item_id = $_POST['item_id'];
    $item_name = $_POST['item_name'];
    $item_image = $_POST['item_image'];
    $item_description = $_POST['item_description'];
    $price = $_POST['price'];
    $cat_id = $_POST['cat_id'];

    $sql_check_id = "SELECT * FROM `items` WHERE Item_id = '$item_id'";
    $result_id = mysqli_query($conn, $sql_check_id);
    if (mysqli_num_rows($result_id) > 0) {
        $error_message = "Item ID already exists.";
    }

    $sql_check_name = "SELECT * FROM `items` WHERE Item_name = '$item_name'";
    $result_name = mysqli_query($conn, $sql_check_name);
    if (mysqli_num_rows($result_name) > 0) {
        $error_message = "Item Name already exists.";
    }

    if (!isset($error_message)) {
        $sql_insert = "INSERT INTO `items` (Item_id, Item_name, Item_image, Item_description, Price, cat_id) 
                       VALUES ('$item_id', '$item_name', '$item_image', '$item_description', '$price', '$cat_id')";
        if (mysqli_query($conn, $sql_insert)) {
            header("Location: admin.php");  
        } else {
            $error_message = "Error adding item.";
        }
    }
}
// Error Message Category & Items
if (isset($error_message)) {
    echo "<script>alert('$error_message');</script>";
}
?>
<!-- Add Item Query Ends -->


<!-- Admin Portal Starts -->
<section class="bg-color text-center" style="min-height: 700px;">
  <div class="container">
    <div class="row text-light p-3">
      <div class="col"> 
        <?php include 'admin_navbar.php';?>              
      </div>

      <!-- Categories Start -->
      <div class="pt-5">
        <div class="d-flex justify-content-between align-items-center">
          <h4 class="text-start">Categories</h4>
          <button type="button" class="btn btn-success mb-2" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
              Add Category
          </button>
        </div>
        <table class="table table-light table-striped-columns">
            <thead>
                <tr>
                  <th scope="col">Category Id</th>
                  <th scope="col">Category Name</th>
                  <th scope="col">Actions</th>
                </tr>
              </thead>
              <tbody>
                  <?php 
                    $sql = "SELECT * FROM `categories`";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                      echo '
                      <tr>
                      <th scope="row">'.$row['Category_id'].'</th>
                      <td>'.$row['Category_name'].'</td>
                      <td>
                        <a href="edit.php?cat_id='.$row['Category_id'].'"><button type="button" class="btn btn-primary">Edit</button></a>
                        <a href="admin.php?delete_category='.$row['Category_id'].'" onclick="return confirm(\'Are you sure you want to delete this category?\')">
                            <button type="button" class="btn btn-danger">Delete</button>
                        </a>
                      </td>
                      </tr>';
                    }                     
                  ?>
              </tbody>
          </table>
        </div>
        <!-- Categories Ends -->
          
          <!-- Items Starts -->
<div class="pt-5">
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="text-start">Items</h4>
        <button type="button" class="btn btn-success mb-2" data-bs-toggle="modal" data-bs-target="#addItemModal">
            Add Item
        </button>
    </div>
    <table class="table table-light table-striped-columns">
        <thead>
            <tr>
                <th scope="col">Item Id</th>
                <th scope="col">Image URL</th>
                <th scope="col">Name</th>
                <th scope="col">Description</th>
                <th scope="col">Price</th>
                <th scope="col">Category</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $sql = $sql = "SELECT items.*, categories.Category_name FROM items JOIN categories ON items.cat_id = categories.Category_id";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '
                    <tr>
                        <th scope="row">' . $row['Item_id'] . '</th>
                        <td>
                            <a href="' . $row['Item_image'] . '" target="_blank">
                                <img src="' . $row['Item_image'] . '" alt="Item Image" class="img-thumbnail" style="max-width: 60px; max-height: 60px;">
                            </a>
                        </td>
                        <td>' . $row['Item_name'] . '</td>
                        <td>' . substr($row['Item_description'],0,35) . '...</td>
                        <td>' . $row['Price'] . '</td>
                        <td>' . $row['Category_name'] . '</td>
                        <td>
                            <a href="edit.php?item_id=' . $row['Item_id'] . '">
                                <button type="button" class="btn btn-primary">Edit</button>
                            </a>
                            <a href="admin.php?delete_item=' . $row['Item_id'] . '" 
                               onclick="return confirm(\'Are you sure you want to delete this item?\')">
                                <button type="button" class="btn btn-danger">Delete</button>
                            </a>
                        </td>
                    </tr>';
                }
            ?>
        </tbody>
    </table>
</div>
<!-- Items Ends -->

      </div>
    </div>
</section>
<!-- Admin portal ends -->


<!-- Add Category Modal Starts -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">Add New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category ID</label>
                        <input type="number" class="form-control" id="category_id" name="category_id" required>
                    </div>
                    <div class="mb-3">
                        <label for="category_name" class="form-label">Category Name</label>
                        <input type="text" class="form-control" id="category_name" name="category_name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="add_category" class="btn btn-success">Add Category</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Add Category Modal Ends -->



<!-- Add Item Modal Starts -->
<div class="modal fade" id="addItemModal" tabindex="-1" aria-labelledby="addItemModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addItemModalLabel">Add New Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="item_id" class="form-label">Item ID</label>
                        <input type="number" class="form-control" id="item_id" name="item_id" required>
                    </div>
                    <div class="mb-3">
                        <label for="item_image" class="form-label">Image URL</label>
                        <input type="text" class="form-control" id="item_image" name="item_image" required>
                    </div>
                    <div class="mb-3">
                        <label for="item_name" class="form-label">Item Name</label>
                        <input type="text" class="form-control" id="item_name" name="item_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="item_description" class="form-label">Description</label>
                        <input type="text" class="form-control" id="item_description" name="item_description" required>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" class="form-control" id="price" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label for="cat_id" class="form-label">Category</label>
                        <select class="form-control" id="cat_id" name="cat_id" required>
                            <option value="">Select Category</option>
                            <?php
                            $sql_categories = "SELECT * FROM `categories`";
                            $result_categories = mysqli_query($conn, $sql_categories);

                            while ($row = mysqli_fetch_assoc($result_categories)) {
                                echo "<option value='" . $row['Category_id'] . "'>" . $row['Category_name'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="add_item" class="btn btn-success">Add Item</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Add Item Modal Ends -->




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-qw8p2+TCHJkh3mvV8TFUZd07YaxEpJ7AoZjK4fG8hw/QoFsmPePsRUMl9cUGx6Dz" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>