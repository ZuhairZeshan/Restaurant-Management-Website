<?php
include '_dbconnect.php'; // Include your database connection file

// Read the raw POST data (JSON)
$inputData = json_decode(file_get_contents('php://input'), true);

// Log the input data for debugging
file_put_contents('php://stderr', print_r($inputData, TRUE)); // Log the input data

// Check for missing data
if (empty($inputData['cartData']) || empty($inputData['deliveryMethod']) || empty($inputData['paymentMethod'])) {
    echo json_encode(['status' => 'error', 'message' => 'Incomplete order data.']);
    exit;
}

// Extract data from the input JSON
$cartData = json_decode($inputData['cartData'], true); // Decode cart data to array
$deliveryMethod = $inputData['deliveryMethod'];
$paymentMethod = $inputData['paymentMethod'];

// Get User ID from session
$user_id = $_SESSION['sno'];

// Calculate total amount from cart items
$totalAmount = 0;
foreach ($cartData as $itemId => $item) {
    $totalAmount += $item['quantity'] * $item['price'];  // Quantity * Price per item
}

// Prepare and insert order details into the database
$orderDate = date('Y-m-d H:i:s'); // Get current date and time for the order

// SQL query to include user_id
$sql = "INSERT INTO orders (Order_date, User_id, Total_amount, Order_type) VALUES (?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);

if ($stmt === false) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to prepare SQL statement.']);
    exit;
}

// Bind the parameters
mysqli_stmt_bind_param($stmt, 'siis', $orderDate, $user_id, $totalAmount, $deliveryMethod);

// Execute the statement
if (!mysqli_stmt_execute($stmt)) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to place the order.']);
    exit;
}

// Get the order ID
$orderId = mysqli_insert_id($conn);

// Insert each cart item into the quantities table
$sqlItem = "INSERT INTO quantities (Order_id, Item_id, Quantity) VALUES (?, ?, ?)";
$stmtItem = mysqli_prepare($conn, $sqlItem);

if ($stmtItem === false) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to prepare item SQL statement.']);
    exit;
}

// Loop through the cart items and insert them into the database
foreach ($cartData as $itemId => $item) {
    $quantity = $item['quantity'];

    // Bind parameters
    mysqli_stmt_bind_param($stmtItem, 'iii', $orderId, $itemId, $quantity);

    if (!mysqli_stmt_execute($stmtItem)) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add item to the order.']);
        exit;
    }
}

// Insert payment details into the payments table if payment method is online
if ($paymentMethod === 'online') {
    $paymentDetails = $inputData['paymentDetails'];
    $cardNumber = $paymentDetails['cardNumber'];
    $cardExpiry = $paymentDetails['cardExpiry'];
    $cardCVV = $paymentDetails['cardCVV'];

    // Prepare SQL for payment details
    $sqlPayment = "INSERT INTO payments (payment_id, card_number, expiry_date, cvv) VALUES (?, ?, ?, ?)";
    $stmtPayment = mysqli_prepare($conn, $sqlPayment);

    if ($stmtPayment === false) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to prepare payment SQL statement.']);
        exit;
    }

    // Bind parameters for payment
    mysqli_stmt_bind_param($stmtPayment, 'isss', $orderId, $cardNumber, $cardExpiry, $cardCVV);

    // Execute the payment statement
    if (!mysqli_stmt_execute($stmtPayment)) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to process payment.']);
        exit;
    }

    // Close the payment statement
    mysqli_stmt_close($stmtPayment);
}

// Close the prepared statements
mysqli_stmt_close($stmt);
mysqli_stmt_close($stmtItem);

// Send a success response
echo json_encode(['status' => 'success', 'message' => 'Order placed successfully.', 'orderId' => $orderId]);
?>