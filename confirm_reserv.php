
<?php include '_dbconnect.php';?>

<?php

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$userId = $_SESSION['sno'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_name = $_POST['customer_name'];
    $customer_email = $_POST['customer_email'];
    $table_id = $_POST['table_id'];
    $reservation_time = $_POST['reservation_time'];

    // Insert reservation
    $stmt = $conn->prepare("INSERT INTO reservations (customer_name, customer_email, table_id, User_id, reservation_time) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiis", $customer_name, $customer_email, $table_id, $userId, $reservation_time);
    $stmt->execute();

    // Update table status
    $conn->query("UPDATE tables SET is_occupied = TRUE WHERE id = $table_id");

    echo "<script>alert('Reservation submitted. Please wait for admin approval.');
    window.location.href = '/Restaurant-Management Website/reservation.php'</script>";
            
}
?>