<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

    <title>Document</title>

    <style>
    .bg-color {
        background: #0f0c29;
        /* fallback for old browsers */
        background: -webkit-linear-gradient(to right, #24243e, #302b63, #0f0c29);
        /* Chrome 10-25, Safari 5.1-6 */
        background: linear-gradient(to right, #24243e, #302b63, #0f0c29);
        /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

    }
    </style>

</head>

<body>

<!-- Connecting Starts -->
<?php include '_dbconnect.php';?>   
<!-- Connecting Ends -->


<!-- Update Query starts -->
<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_GET['cat_id'])) {
            $id = $_GET['cat_id'];
            $newid = $_POST['category_id'];
            $newname = $_POST['category_name'];

            $sql_check_category = "SELECT * FROM `categories` WHERE `Category_id` = '$newid' OR `Category_name` = '$newname'";
            $result_check_category = mysqli_query($conn, $sql_check_category);
            if (mysqli_num_rows($result_check_category) > 1) {
                echo '<div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
                    <strong>Warning!</strong> Category ID or Name already exist.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
            } else {
                $sql = "UPDATE `categories` SET `Category_id` = '$newid', `Category_name` = '$newname' WHERE `Category_id` = '$id'";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    header('Location: /Restaurant-Management-Website/admin.php');
                } else {
                    echo '<div class="alert alert-danger">Error updating category.</div>';
                }
            }
        } elseif (isset($_GET['item_id'])) {
            $id = $_GET['item_id'];
            $newid = $_POST['it_id'];
            $newimageurl = $_POST['item_image'];
            $newname = $_POST['item_name'];
            $newdesc = $_POST['item_description'];
            $newprice = $_POST['price'];
            $newcatid = $_POST['cat_id'];

            $sql_check_item = "SELECT * FROM `items` WHERE `Item_id` = '$newid' OR `Item_name` = '$newname'";
            $result_check_item = mysqli_query($conn, $sql_check_item);
            if (mysqli_num_rows($result_check_item) > 1) {
                echo '<div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
                    <strong>Warning!</strong> Item ID or Name already exist.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
            } else {
                $sql2 = "UPDATE `items` SET `Item_id` = '$newid', `Item_image` = '$newimageurl', `Item_name` = '$newname', `Item_description` = '$newdesc', `Price` = '$newprice', `cat_id` = '$newcatid' WHERE `Item_id` = '$id'";
                $result = mysqli_query($conn, $sql2);
                if ($result) {
                    header('Location: /Restaurant-Management-Website/admin.php');
                } else {
                    echo '<div class="alert alert-danger">Error updating item.</div>';
                }
            }
        }
    }
?>
<!-- Update Query ends-->



<!-- Edit portal Starts -->
    <section class="bg-color text-light text-center" style="height: 695px;">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h1 class="pt-4"> Edit Portal</h1>
                    <!-- Category edit starts -->
                    <?php if (isset($_GET['cat_id'])): ?>
                        <form action="edit.php?cat_id=<?php echo $_GET['cat_id']; ?>" method="post">
                            <?php if (isset($error)): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo $error; ?>
                                </div>
                            <?php endif; ?>
                            <table class="table table-light table-striped-columns">
                                <tbody>
                                    <?php 
                                        $id = $_GET['cat_id'];
                                        $sql = "SELECT * FROM `categories` where Category_id = $id";
                                        $result = mysqli_query($conn, $sql);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo '
                                            <tr>
                                                <th>Category ID</th>
                                                <td><textarea class="form-control" name="category_id" style="height: 60px">' . $row['Category_id'] . '</textarea></td>
                                            </tr>
                                            <tr>
                                                <th>Category Name</th>
                                                <td><textarea class="form-control" name="category_name" style="height: 60px">' . $row['Category_name'] . '</textarea></td>
                                            </tr>
                                            ';
                                        }
                                    ?>
                                </tbody>
                            </table>
                            <button type="submit" class="btn btn-secondary text-light btn-outline-success px-4">Save Changes</button>
                            <a href="admin.php"><button type="button" class="btn btn-secondary text-light btn-outline-success px-5">Cancel</button></a>
                        </form>
                        <?php endif; ?>  
                    <!-- Category edit ends -->                        
                    
                    
                    <!-- Item edit starts -->
                    <?php if (isset($_GET['item_id'])): ?>
                        <form action="edit.php?item_id=<?php echo $_GET['item_id']; ?>" method="post">
                            <?php if (isset($error_message)): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo $error_message; ?>
                                </div>
                            <?php endif; ?>
                            <table class="table table-light table-striped-columns">
                                <tbody>
                                    <?php
                                        $id = $_GET['item_id'];
                                        $sql = "SELECT * FROM `items` WHERE Item_id = $id";
                                        $result = mysqli_query($conn, $sql);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo '
                                            <tr>
                                                <th>Item ID</th>
                                                <td><textarea class="form-control" name="it_id" style="height: 60px">' . $row['Item_id'] . '</textarea></td>
                                            </tr>
                                            <tr>
                                                <th>Item Image URL</th>
                                                <td><textarea class="form-control" name="item_image" style="height: 60px">' . $row['Item_image'] . '</textarea></td>
                                            </tr>
                                            <tr>
                                                <th>Item Name</th>
                                                <td><textarea class="form-control" name="item_name" style="height: 60px">' . $row['Item_name'] . '</textarea></td>
                                            </tr>
                                            <tr>
                                                <th>Item Description</th>
                                                <td><textarea class="form-control" name="item_description" style="height: 60px">' . $row['Item_description'] . '</textarea></td>
                                            </tr>
                                            <tr>
                                                <th>Price</th>
                                                <td><textarea class="form-control" name="price" style="height: 60px">' . $row['Price'] . '</textarea></td>
                                            </tr>
                                            <tr>
                                                <th>Category</th>
                                                <td>
                                                    <select class="form-control" name="cat_id" required>';

                                                    $sql_categories = "SELECT * FROM `categories`";
                                                    $result_categories = mysqli_query($conn, $sql_categories);

                                                    while ($category = mysqli_fetch_assoc($result_categories)) {
                                                        $selected = ($category['Category_id'] == $row['cat_id']) ? 'selected' : '';
                                                        echo '<option value="' . $category['Category_id'] . '" ' . $selected . '>' . $category['Category_name'] . '</option>';
                                                    }
                                                    echo '</select>';
                                                echo '</td>
                                            </tr>
                                            ';
                                        }
                                    ?>
                                </tbody>
                            </table>
                            <button type="submit" class="btn btn-secondary text-light btn-outline-success px-4">Save Changes</button>
                            <a href="admin.php"><button type="button" class="btn btn-secondary text-light btn-outline-success px-5">Cancel</button></a>
                        </form>
                        <?php endif; ?>
                    <!-- Item edit ends -->
                </div>
            </div>
        </div>
    </section>
    <!-- Edit portal Ends -->

</body>

</html>