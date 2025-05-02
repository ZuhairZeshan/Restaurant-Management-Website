<?php
// Connecting to the database
include '_dbconnect.php'; 
// Handle POST requests for adding or editing employees
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emp_id = $_POST['emp_id'] ?? null;
    $name = $_POST['name'];
    $role = $_POST['role'];
    $salary = $_POST['salary'];
    $shift_time = $_POST['shift_time'];
    $email = $_POST['email'];
    
    if ($emp_id) {
        // Update existing employee
        $sql = "UPDATE employees SET name='$name', role='$role', salary='$salary', shift_time='$shift_time', email='$email' WHERE emp_id='$emp_id'";
    } else {
        // Add new employee
        $sql = "INSERT INTO employees (name, role, salary, shift_time, email) VALUES ('$name', '$role', '$salary', '$shift_time', '$email')";
    }

    if ($conn->query($sql) === TRUE) {
        header("Location: staff.php");
        exit();
    } else {
        echo "<script>alert('Error: " . $conn->error . "')</script>";
    }
}

// Handle DELETE requests for deleting employees
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $_DELETE);
    $id = $_DELETE['id'];
    $sql = "DELETE FROM employees WHERE emp_id = $id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false]);
    }
    exit(); // Make sure to exit after handling the DELETE request
}

// Fetch employee data for editing
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM employees WHERE emp_id = $id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo json_encode($result->fetch_assoc());
    } else {
        echo json_encode(null);
    }
    exit(); // Make sure to exit after handling the GET request
}

// Fetch all employees
$sql = "SELECT * FROM employees";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Management</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0px;
        }
    </style>
</head>
<body>
<section class="bg-color" style="min-height: 600px;">
  <div class="container">
    <div class="row text-light p-3">
    <!-- Admin Navbar Starts--> 
    <div class="col text-center"> 
        <?php include 'admin_navbar.php';?>              
    </div>
    <!-- Admin Navbar Ends-->

    <div class="container mt-5">
        <h1 class="text-center">Staff Management</h1>
        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-success" data-toggle="modal" data-target="#addEmployeeModal">Add Employee</button>
        </div>
        <table class="table table-bordered text-light">
            <thead class="thead-light">
                <tr>
                    <th>Employee ID</th>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Salary</th>
                    <th>Shift Time</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['emp_id']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['role']; ?></td>
                            <td><?php echo $row['salary']; ?></td>
                            <td><?php echo $row['shift_time']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td>
                                <button class="btn btn-warning editBtn" data-id="<?php echo $row['emp_id']; ?>"> Edit</button>
                                <button class="btn btn-danger deleteBtn" data-id="<?php echo $row['emp_id']; ?>">Delete</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">No employees found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Add Employee Modal -->
    <div id="addEmployeeModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content text-dark">
                <div class="modal-header">
                    <h5 class="modal-title">Add Employee</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addEmployeeForm" method="post">
                        <input type="hidden" name="emp_id" id="emp_id">
                        <div class="form-group">
                            <label for="add_name">Name:</label>
                            <input type="text" class="form-control" name="name" id="add_name" required>
                        </div>
                        <div class="form-group">
                            <label for="add_role">Role:</label>
                            <input type="text" class="form-control" name="role" id="add_role" required>
                        </div>
                        <div class="form-group">
                            <label for="add_salary">Salary:</label>
                            <input type="number" class="form-control" name="salary" id="add_salary" required>
                        </div>
                        <div class="form-group">
                            <label for="add_shift_time">Shift Time:</label>
                            <input type="text" class="form-control" name="shift_time" id="add_shift_time" required>
                        </div>
                        <div class="form-group">
                            <label for="add_email">Email:</label>
                            <input type="email" class="form-control" name="email" id="add_email" required>
                        </div>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Employee Modal -->
    <div id="editEmployeeModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content text-dark">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Employee</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id=" editEmployeeForm" method='POST'>
                        <input type="hidden" name="emp_id" id="edit_emp_id">
                        <div class="form-group">
                            <label for="edit_name">Name:</label>
                            <input type="text" class="form-control" name="name" id="edit_name" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_role">Role:</label>
                            <input type="text" class="form-control" name="role" id="edit_role" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_salary">Salary:</label>
                            <input type="number" class="form-control" name="salary" id="edit_salary" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_shift_time">Shift Time:</label>
                            <input type="text" class="form-control" name="shift_time" id="edit_shift_time" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_email">Email:</label>
                            <input type="email" class="form-control" name="email" id="edit_email" required>
                        </div>
                        <button type="submit" class="btn btn-success">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    </div>
  </div>
</section>
   
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <script>
        document.querySelectorAll('.editBtn').forEach(button => {
            button.addEventListener('click', function() {
                const empId = this.getAttribute('data-id');
                fetch(`staff.php?id=${empId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data) {
                            // Populate the edit form with the employee data
                            document.getElementById('edit_emp_id').value = data.emp_id; // Set emp_id for editing
                            document.getElementById('edit_name').value = data.name;
                            document.getElementById('edit_role').value = data.role;
                            document.getElementById('edit_salary').value = data.salary;
                            document.getElementById('edit_shift_time').value = data.shift_time;
                            document.getElementById('edit_email').value = data.email;

                            // Show the modal
                            $('#editEmployeeModal').modal('show');
                        } else {
                            alert('Employee not found');
                        }
                    });
            });
        });

        document.querySelectorAll('.deleteBtn').forEach(button => {
            button.addEventListener('click', function() {
                const empId = this.getAttribute('data-id');
                if (confirm('Are you sure you want to delete this employee?')) {
                    fetch('staff.php', {
                        method: 'DELETE',
                        body: new URLSearchParams({ id: empId })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert('Error deleting employee');
                        }
                    });
                }
            });
        });

        document.getElementById('addEmployeeForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);
            fetch('staff.php', {
                method: 'POST',
                body: formData
            }).then(response => {
                if (response.ok) {
                    location.reload();
                }
            });
        });

        document.getElementById('editEmployeeForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);
            fetch('staff.php', {
                method: 'POST',
                body: formData
            }).then(response => {
                if (response.ok) {
                    location.reload();
                }
            });
        });
    </script>
</body>
</html>

<?php
$conn->close();
?>