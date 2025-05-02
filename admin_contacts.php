<?php include '_dbconnect.php'; ?>

<?php
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if a message ID is set to update status
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "UPDATE contacts SET status='read' WHERE id='$id'";
    $conn->query($sql);
}

// Fetch unread messages
$unreadMessages = $conn->query("SELECT * FROM contacts WHERE status='unread'");

// Fetch older messages
$readMessages = $conn->query("SELECT * FROM contacts WHERE status='read'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal - Contacts</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<!-- Connecting Starts -->
<!-- You can include your database connection here if needed -->
<!-- Connecting Ends -->

<section class="bg-color text-center" style="min-height: 693px;">
  <div class="container">
    <div class="row text-light p-3">
      <!-- Admin Navbar Starts--> 
      <div class="col"> 
        <?php include 'admin_navbar.php';?>              
      </div>
      <!-- Admin Navbar Ends-->

      <div class="col-md-12">
        <h2 class="text-light pt-5">Unread Messages</h2>
        <table class="table table-bordered table-striped text-light">
          <thead>
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Message</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($unreadMessages->num_rows > 0): ?>
              <?php while($row = $unreadMessages->fetch_assoc()): ?>
                <tr>
                  <td><?php echo $row['name']; ?></td>
                  <td><?php echo $row['email']; ?></td>
                  <td><?php echo $row['message']; ?></td>
                  <td><?php echo $row['status']; ?></td>
                  <td><a href="?id=<?php echo $row['id']; ?>" class="btn btn-primary">View</a></td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr><td colspan="5">No unread messages found.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <div class="col-md-12">
        <h2 class="text-light pt-5">Older Messages</h2>
        <table class="table table-bordered table-striped text-light">
          <thead>
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Message</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($readMessages->num_rows > 0): ?>
              <?php while($row = $readMessages->fetch_assoc()): ?>
                <tr>
                  <td><?php echo $row['name']; ?></td>
                  <td><?php echo $row['email']; ?></td>
                  <td><?php echo $row['message']; ?></td>
                  <td><?php echo $row['status']; ?></td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr><td colspan="4">No older messages found.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

    </div>
  </div>
</section>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>