<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Status - DelightInn</title>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
          integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
  </script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <style>
    h1 {
      text-align: center;
    }

    table {
      border-collapse: collapse;
      width: 100%;
    }

    th, td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: left;
    }

    th {
      background-color: #f2f2f2;
    }

    .bgcolor {
      background-image: url(https://images.pexels.com/photos/326333/pexels-photo-326333.jpeg);
      background-position: center;
      background-size: cover;
      background-repeat: no-repeat;
    }
  </style>
</head>
<body>
  <?php include '_dbconnect.php';?>

  <div class="container-fluid sec-1">
    <div class='wrapper '>
      <?php include 'navbar.php';?>
    </div>
  </div>
  <div class="container-fluid bgcolor">
    <div class="row text-light" style="min-height: 700px">
      <div class="col-12">

        <h1 class="pt-5">Your Order Status</h1>

        <div class="px-5" id="current-orders">
          <h2 class="pb-3">Current Orders</h2>
          <table class="text-center">
            <thead>
              <tr class="text-dark">
                <th>Order ID</th>
                <th>Date</th>
                <th>Total Amount</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
            <?php
              if (isset($_SESSION['sno'])) {
                // User is logged in
                $userId = $_SESSION['sno'];
                $sqlCurrent = "SELECT * FROM orders WHERE user_id = ? AND (Order_status = 'Approved' OR Order_status = 'Pending')";
                $stmtCurrent = $conn->prepare($sqlCurrent);
                $stmtCurrent->bind_param("i", $userId);
                $stmtCurrent->execute();
                $resultCurrent = $stmtCurrent->get_result();

                if ($resultCurrent->num_rows > 0) {
                  while ($row = $resultCurrent->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['Order_id'] . "</td>";
                    echo "<td>" . $row['Order_date'] . "</td>";
                    echo "<td>$" . $row['Total_amount'] . "</td>";
                    echo "<td>" . $row['Order_status'] . "</td>";
                    echo "</tr>";
                  }
                } else {
                  echo "<tr><td colspan='4'>No current orders found.</td></tr>";
                }
              } else {
                // User is not logged in
                echo "<tr><td colspan='4'>Please Login to See Your Current Orders.</td></tr>";
              }
            ?>

            </tbody>
          </table>
        </div>

        <div class="px-5" id="past-orders">
          <h2 class="pb-3">Past Orders</h2>
          <table class="text-center">
            <thead>
              <tr class="text-dark">
                <th>Order ID</th>
                <th>Date</th>
                <th>Total Amount</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
            <?php
              if (isset($_SESSION['sno'])) {
                // User is logged in
                $userId = $_SESSION['sno'];
                $sqlPast = "SELECT * FROM orders WHERE user_id = ? AND (Order_status != 'Approved' AND Order_status != 'Pending')";
                $stmtPast = $conn->prepare($sqlPast);
                $stmtPast->bind_param("i", $userId);
                $stmtPast->execute();
                $resultPast = $stmtPast->get_result();

                if ($resultPast->num_rows > 0) {
                  while ($row = $resultPast->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['Order_id'] . "</td>";
                    echo "<td>" . $row['Order_date'] . "</td>";
                    echo "<td>$" . $row['Total_amount'] . "</td>";
                    echo "<td>" . $row['Order_status'] . "</td>";
                    echo "</tr>";
                  }
                } else {
                  echo "<tr><td colspan='4'>No past orders found.</td></tr>";
                }

                $conn->close();
              } else {
                // User is not logged in
                echo "<tr><td colspan='4'>Please Login to See Your Past Orders.</td></tr>";
              }
            ?>

            </tbody>
          </table>
        </div>

      </div>
    </div>
  </div>
</body>
</html>