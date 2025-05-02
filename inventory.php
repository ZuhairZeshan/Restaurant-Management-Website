
<?php include '_dbconnect.php'; ?> 

<?php
// Add Inventory
if (isset($_POST['add_product'])) {
    $product_name = $_POST['product_name'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    $sql = "INSERT INTO inventory (product_name, quantity, price, description) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sids", $product_name, $quantity, $price, $description);

    if ($stmt->execute()) {
        echo "<script>alert('Product added successfully!');</script>";
    } else {
        echo "<script>alert('Error adding product: " . $stmt->error . "');</script>";
    }
}

// Update Inventory
if (isset($_POST['update_product'])) {
    $id = $_POST['id'];
    $product_name = $_POST['product_name'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    $sql = "UPDATE inventory SET product_name=?, quantity=?, price=?, description=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siisi", $product_name, $quantity, $price, $description, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Product updated successfully!');</script>";
    } else {
        echo "<script>alert('Error updating product: " . $stmt->error . "');</script>";
    }
}

// Delete Inventory
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $sql = "DELETE FROM inventory WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Product deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error deleting product: " . $stmt->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</head>
<body>
    <section class="bg-color" style="min-height: 693px;">
  <div class="container-fluid">
    <div class="row text-light p-3 ">
      <div class="col text-center"> 
        <?php include 'admin_navbar.php';?>              
      </div>

    <div class="container my-3 px-5">
        
        <h1 class="text-center">Inventory Management</h1>

        <div class="col align-content-end" >
        <button type="button" class="btn btn-primary my-3 float-end" data-bs-toggle="modal" data-bs-target="#addProductModal">
            Add Product
        </button>
        </div>
        <div class="modal fade " id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content text-dark">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addProductModalLabel">Add Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body ">
                        <form method="POST">
                            <div class="mb-3 ">
                                <label for="product_name" class="form-label">Product Name:</label>
                                <input type="text" class="form-control" id="product_name" name="product_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantity:</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" required>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Price:</label>
                                <input type="number" class="form-control" id="price" name="price" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description:</label>
                                <textarea class="form-control" id="description" name="description"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" name="add_product" class="btn btn-primary">Add Product</ button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive text-center">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM inventory";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td>" . $row['product_name'] . "</td>";
                            echo "<td>" . $row['quantity'] . "</td>";
                            echo "<td>$" . $row['price'] . "</td>";
                            echo "<td>" . $row['description'] . "</td>";
                            echo "<td>
                                    <a href='?delete_id=" . $row['id'] . "' class='btn btn-danger mx-2'>Delete</a>
                                    <button type='button' class='btn btn-primary px-4' data-bs-toggle='modal' data-bs-target='#editProductModal" . $row['id'] . "'>Edit</button>
                                </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No products found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <?php
        // Reset the result pointer to fetch rows again for edit modals
        $result->data_seek(0);
        while ($row = $result->fetch_assoc()) {
            echo '<div class="modal fade" id="editProductModal' . $row['id'] . '" tabindex="-1" aria-labelledby="editProductModalLabel' . $row['id'] . '" aria-hidden="true">';
            echo '<div class="modal-dialog">';
            echo '<div class="modal-content text-dark">';
            echo '<div class="modal-header">';
            echo '<h5 class="modal-title" id="editProductModalLabel' . $row['id'] . '">Edit Product</h5>';
            echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
            echo '</div>';
            echo '<div class="modal-body">';
            echo '<form method="POST">';
            echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
            echo '<div class="mb-3">';
            echo '<label for="product_name" class="form-label">Product Name:</label>';
            echo '<input type="text" class="form-control" id="product_name" name="product_name" value="' . $row['product_name'] . '" required>';
            echo '</div>';
            echo '<div class="mb-3">';
            echo '<label for="quantity" class="form-label">Quantity:</label>';
            echo '<input type="number" class="form-control" id="quantity" name="quantity" value="' . $row['quantity'] . '" required>';
            echo '</div>';
            echo '<div class="mb-3">';
            echo '<label for="price" class="form-label">Price:</label>';
            echo '<input type="number" class="form-control" id="price" name="price" value="' . $row['price'] . '" required>';
            echo '</div>';
            echo '<div class="mb-3">';
            echo '<label for="description" class="form-label">Description:</label>';
            echo '<textarea class="form-control" id="description" name="description">' . $row['description'] . '</textarea>';
            echo '</div>';
            echo '</div>';
            echo '<div class="modal-footer">';
            echo '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>';
            echo '<button type="submit" name="update_product" class="btn btn-primary">Update Product</button>';
            echo '</div>';
            echo '</form>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        ?>
    </div>

    </div>
    </div>
</section>

</body>
</html>