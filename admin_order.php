<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Portal - Orders</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <style>
    .status-pending {
      color: orange;
    }
    .status-approved {
      color: green;
    }
    .status-completed {
      color: blue;
    }
    .status-rejected {
      color: red;
    }
  </style>
</head>
<body>

<?php
// Connect to the database
include '_dbconnect.php';

// Handle order status update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $order_id = $_POST['order_id'];
  $new_status = $_POST['new_status'];

  if (!empty($order_id) && !empty($new_status)) {
    // Update the order status in the database
    $sql = "UPDATE orders SET Order_status = ? WHERE Order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $new_status, $order_id);

    if ($stmt->execute()) {
      // Redirect back to the same page after updating
      header("Location: admin_order.php?status=success");
      exit();
    } else {
      // Handle error
      echo "<div class='alert alert-danger'>Error updating order: " . $conn->error . "</div>";
    }
  }
}
?>

<section class="bg-color text-center" style="min-height: 600px;">
  <div class="container">
    <div class="row text-light p-3">
      <div class="col"> 
        <?php include 'admin_navbar.php';?> 
      </div>
    </div>

    <div class="row">
      <div class="col">
        <h2 class="text-light my-3">Manage Orders</h2>
        <table class="table table-bordered text-light">
          <thead>
            <tr>
              <th>Order ID</th>
              <th>User ID</th>
              <th>Date</th>
              <th>Type</th>
              <th>Total Amount</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
              // Fetch orders from the database
              $sql = "SELECT * FROM orders o";
              $result = mysqli_query($conn, $sql);

              if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                  echo "<tr>";
                  echo "<td>" . $row['Order_id'] . "</td>";
                  echo "<td>" . $row['User_id'] . "</td>";
                  echo "<td>" . $row['Order_date'] . "</td>";
                  echo "<td>" . $row['Order_type'] . "</td>";
                  echo "<td>" . number_format($row['Total_amount'], 2) . " PKR</td>"; // Format amount

                  // Determine the status class and text
                  $statusClass = '';
                  switch ($row['Order_status']) {
                    case 'pending':
                      $statusClass = 'status-pending';
                      break;
                    case 'approved':
                      $statusClass = 'status-approved';
                      break;
                    case 'completed':
                      $statusClass = 'status-completed';
                      break;
                    case 'rejected':
                      $statusClass = 'status-rejected';
                      break;
                  }
                  echo "<td class='$statusClass'>" . htmlspecialchars($row['Order_status']) . "</td>";

                  // Show update form only if status is not completed or rejected
                  echo "<td>";
                  if ($row['Order_status'] !== 'completed' && $row['Order_status'] !== 'rejected') {
                    echo "<form method='POST' action='' class='d-inline'>
                            <input type='hidden' name='order_id' value='" . $row['Order_id'] . "'>
                            <select name='new_status' required>
                              <option value=''>Select Status</option>
                              <option value='pending'" . ($row['Order_status'] == 'pending' ? ' selected' : '') . ">Pending</option>
                              <option value='approved'" . ($row['Order_status'] == 'approved' ? ' selected' : '') . ">Approved</option>
                              <option value='completed'" . ($row['Order_status'] == 'completed' ? ' selected' : '') . ">Completed</option>
                              <option value='rejected'" . ($row['Order_status'] == 'rejected' ? ' selected' : '') . ">Rejected</option>
                            </select>
                            <button type='submit' class='btn btn-primary btn-sm'>Update</button>
                          </form>";
                  } else {
                    echo "N/A"; // No action available
                  }
                  echo "</td>";
                  echo "</tr>";
                }
              } else {
                echo "<tr><td colspan='7'>No orders found.</td></tr>";
              }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>

</body>
</html>