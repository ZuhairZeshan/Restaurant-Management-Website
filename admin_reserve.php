<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal - Reservations</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> <!-- Removed extra space -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    
<!-- Connecting Starts -->
<?php include '_dbconnect.php'; ?>   
<!-- Connecting Ends -->

<?php
// Handle Add Table
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add') {
    $table_id = $_POST['table_id'];
    $table_no = $_POST['table_no'];
    $capacity = $_POST['capacity'];

    $stmt = $conn->prepare("INSERT INTO tables (Id, Table_no, seats) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $table_id, $table_no, $capacity);
    $stmt->execute();
    $stmt->close();
    header("Location: admin_reserve.php");
    exit();
}

// Handle Edit Table
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'edit') {
    $table_id = $_POST['table_id'];
    $table_no = $_POST['table_no'];
    $seats = $_POST['seats'];

    // Fetch current values from the database
    $current_stmt = $conn->prepare("SELECT Table_no, seats FROM tables WHERE Id = ?");
    $current_stmt->bind_param("i", $table_id);
    $current_stmt->execute();
    $current_stmt->bind_result($current_table_no, $current_seats);
    $current_stmt->fetch();
    $current_stmt->close();

    // Prepare the update query
    $update_fields = [];
    $params = [];
    $param_types = '';

    // Check for changes and prepare the update statement
    if ($current_table_no !== $table_no) {
        $update_fields[] = "Table_no = ?";
        $params[] = $table_no;
        $param_types .= 'i'; // string type for Table_no
    }
    if ($current_seats !== $seats) {
        $update_fields[] = "seats = ?";
        $params[] = $seats;
        $param_types .= 'i'; // integer type for seats
    }

    if (!empty($update_fields)) {
        // Join the fields to update
        $update_query = "UPDATE tables SET " . implode(", ", $update_fields) . " WHERE Id = ?";
        $stmt = $conn->prepare($update_query);
        
        if ($stmt) {
            // Add the ID to the parameters
            $params[] = $table_id;
            $param_types .= 'i'; // string type for ID

            // Bind parameters dynamically
            $stmt->bind_param($param_types, ...$params);

            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    // Successful update
                    $stmt->close();
                    header("Location: admin_reserve.php");
                    exit();
                } else {
                    echo "No rows updated. Check if the ID exists or if the values are the same.";
                }
            } else {
                echo "Error executing statement: " . $stmt->error;
            }
        } else {
            echo "Error preparing statement: " . $conn->error;
        }
    } else {
        echo "No changes detected.";
    }
}

// Handle Delete Table
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $table_id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM tables WHERE Id = ?");
    $stmt->bind_param("s", $table_id);
    $stmt->execute();
    $stmt->close();
    header("Location: admin_reserve.php");
    exit();
}
?>

<section class="bg-color text-center" style="min-height: 600px;">
  <div class="container">
    <div class="row text-light p-3">
    <!-- Admin Navbar Starts--> 
    <div class="col"> 
        <?php include 'admin_navbar.php';?>              
    </div>
    <!-- Admin Navbar Ends-->

    <div class="container mt-5">
        
        <!-- Manage Tables Starts -->
        <h1 class="text-center">Manage Tables</h1>
        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-success" data-toggle="modal" data-target="#addTableModal">Add Table</button>
        </div>
        <table class="table table-bordered mt-4 text-light">
            <thead>
                <tr>
                    <th>Table ID</th>
                    <th>Table No</th>
                    <th>Capacity</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch tables from the database
                $result = $conn->query("SELECT * FROM tables");
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row['Id'] . "</td>
                            <td>" . $row['Table_no'] . "</td>
                            <td>" . $row['seats'] . "</td>
                            <td>
                                <button class='btn btn-warning btn-sm' data-toggle='modal' data-target='#editTableModal' 
                                        data-id='" . $row['Id'] . "' data-table_no='" . $row['Table_no'] . "' 
                                        data-seats='" . $row['seats'] . "'>Edit</button>
                                <a href='admin_reserve.php?action=delete&id=" . $row['Id'] . "' class='btn btn-danger btn-sm' onclick='return confirmDelete();'>Delete</a>
                            </td>
                        </tr>";
                }
                ?>
            </tbody>
        </table>
        <!-- Manage Tables Ends -->

        <!-- Manage Reservations Starts -->
        <h1 class="text-center mt-5">Manage Reservations</h1>
        <table class="table table-bordered mt-4 text-light">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Table ID</th>
                    <th>Reservation Time</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $result = $conn->query("SELECT * FROM reservations");
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row['id'] . "</td>
                            <td>" . $row['customer_name'] . "</td>
                            <td>" . $row['customer_email'] . "</td>
                            <td>" . $row['table_id'] . "</td>
                            <td>" . $row['reservation_time'] . "</td>
                            <td>";

                    // Render the status and form accordingly
                    if ($row['status'] === 'completed') {
                        echo "<span class='badge badge-success'>Completed</span>";
                    } elseif ($row['status'] === 'rejected') {
                        echo "<span class='badge badge-danger'>Rejected</span>";
                    } else {
                        // Render dropdown for pending or approved status
                        echo "<form method='POST' action='update_reserv.php' class='update-form'>
                                <input type='hidden' name='reservation_id' value='" . $row['id'] . "'>
                                <select name='status' class='form-control status-select'>";

                        // Define the statuses
                        $statuses = ['pending', 'approved', 'rejected', 'completed'];
                        foreach ($statuses as $status) {
                            $selected = ($status === $row['status']) ? 'selected' : '';
                            echo "<option value='$status' $selected>" . ucfirst($status) . "</option>";
                        }

                        echo "      </select>
                                    <button type='submit' class='btn btn-primary mt-2 update-button'>Update</button>
                                </form>";
                    }

                    echo "</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <!-- Manage Reservations Ends -->
    </div>
    </div>
  </div>
</section>

<script>
    $(document).ready(function() {
        // When the form is submitted
        $('.update-form').on('submit', function(e) {
            var status = $(this).find('.status-select').val();
            if (status === 'completed' || status === 'rejected') {
                // Hide the dropdown and show badge instead
                $(this).find('.status-select').hide();
                $(this).find('.update-button').hide();
                var badgeClass = status === 'completed' ? 'badge-success' : 'badge-danger';
                $(this).append("<span class='badge " + badgeClass + "'>" + ucfirst(status) + "</span>");
            }
        });

        // Handle edit button click
        $('#editTableModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var id = button.data('id');
            var table_no = button.data('table_no');
            var seats = button.data('seats');

            var modal = $(this);
            modal.find('.modal-body #editId').val(id);
            modal.find('.modal-body #editTableNo').val(table_no);
            modal.find('.modal-body #editSeats').val(seats);
        });
    });

    // Helper function to capitalize the first letter of a string
    function ucfirst(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

    function confirmDelete() {
        return confirm("Are you sure you want to delete this table?");
    }
</script>

<!-- Modal for Adding Table -->
<div class="modal fade" id="addTableModal" tabindex="-1" role="dialog" aria-labelledby="addTableModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addTableModalLabel">Add Table</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="admin_reserve.php">
        <input type="hidden" name="action" value ="add">
        <div class="modal-body">
          <div class="form-group">
            <label for="tableId">Table ID</label>
            <input type="number" class="form-control" id="tableId" name="table_id" required>
          </div>
          <div class="form-group">
            <label for="tableNo">Table No</label>
            <input type="text" class="form-control" id="tableNo" name="table_no" required>
          </div>
          <div class="form-group">
            <label for="capacity">Capacity</label>
            <input type="number" class="form-control" id="capacity" name="capacity" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Add Table</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal for Editing Table -->
<div class="modal fade" id="editTableModal" tabindex="-1" role="dialog" aria-labelledby="editTableModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editTableModalLabel">Edit Table</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="admin_reserve.php">
        <input type="hidden" name="action" value="edit">
        <div class="modal-body">
          <div class="form-group">
            <label for="editId">Table ID</label>
            <input type="text" class="form-control" id="editId" name="table_id" readonly> <!-- Set readonly to prevent editing -->
          </div>
          <div class="form-group">
            <label for="editTableNo">Table No</label>
            <input type="text" class="form-control" id="editTableNo" name="table_no" required>
          </div>
          <div class="form-group">
            <label for="editSeats">Capacity</label>
            <input type="number" class="form-control" id="editSeats" name="seats" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

</body>
</html>