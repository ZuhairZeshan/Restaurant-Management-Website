<?php
include '_dbconnect.php'; // Include your database connection file

// Log Check 1 to the PHP error log or custom debug log
error_log("Check 1"); // Log to PHP error log
file_put_contents('debug_log.txt', "Check 1\n", FILE_APPEND); // Log to custom debug file

// Read the raw POST data (JSON)
$inputData = json_decode(file_get_contents('php://input'), true);

// Log the input data for debugging
file_put_contents('php://stderr', print_r($inputData, TRUE)); // Log the input data to stderr for immediate output

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

// Log Check 2 to the PHP error log or custom debug log
error_log("Check 2"); // Log to PHP error log
file_put_contents('debug_log.txt', "Check 2\n", FILE_APPEND); // Log to custom debug file

// Prepare and insert order details into the database
$orderDate = date('Y-m-d H:i:s'); // Get current date and time for the order

// SQL query to include user_id
$sql = "INSERT INTO orders (Order_date, User_id, Total_amount, Order_type) VALUES (?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);

// Log Check 3 to the PHP error log or custom debug log
error_log("Check 3"); // Log to PHP error log
file_put_contents('debug_log.txt', "Check 3\n", FILE_APPEND); // Log to custom debug file

if ($stmt === false) {
    error_log("Failed to prepare SQL statement for orders table.");
    echo json_encode(['status' => 'error', 'message' => 'Failed to prepare SQL statement.']);
    exit;
}

// Bind the parameters
mysqli_stmt_bind_param($stmt, 'siis', $orderDate, $user_id, $totalAmount, $deliveryMethod);

// Execute the statement
if (!mysqli_stmt_execute($stmt)) {
    error_log("Failed to execute SQL statement for orders table.");
    echo json_encode(['status' => 'error', 'message' => 'Failed to place the order.']);
    exit;
}

// Get the order ID
$orderId = mysqli_insert_id($conn);

// Insert each cart item into the quantities table
$sqlItem = "INSERT INTO quantities (Order_id, Item_id, Quantity) VALUES (?, ?, ?)";
$stmtItem = mysqli_prepare($conn, $sqlItem);

if ($stmtItem === false) {
    error_log("Failed to prepare SQL statement for quantities table.");
    echo json_encode(['status' => 'error', 'message' => 'Failed to prepare item SQL statement.']);
    exit;
}

// Loop through the cart items and insert them into the database
foreach ($cartData as $itemId => $item) {
    $quantity = $item['quantity'];

    // Bind parameters
    mysqli_stmt_bind_param($stmtItem, 'iii', $orderId, $itemId, $quantity);

    if (!mysqli_stmt_execute($stmtItem)) {
        error_log("Failed to add item to the order. Item ID: " . $itemId);
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
        error_log("Failed to prepare payment SQL statement.");
        echo json_encode(['status' => 'error', 'message' => 'Failed to prepare payment SQL statement.']);
        exit;
    }

    // Bind parameters for payment
    mysqli_stmt_bind_param($stmtPayment, 'isss', $orderId, $cardNumber, $cardExpiry, $cardCVV);

    // Execute the payment statement
    if (!mysqli_stmt_execute($stmtPayment)) {
        error_log("Failed to process payment. Order ID: " . $orderId);
        echo json_encode(['status' => 'error', 'message' => 'Failed to process payment.']);
        exit;
    }

    // Close the payment statement
    mysqli_stmt_close($stmtPayment);
}

// Close the prepared statements
mysqli_stmt_close($stmt);
mysqli_stmt_close($stmtItem);

// Log success to PHP error log or custom debug log
error_log("Order placed successfully. Order ID: " . $orderId);
file_put_contents('debug_log.txt', "Order placed successfully. Order ID: " . $orderId . "\n", FILE_APPEND);

// Send a success response
echo json_encode(['status' => 'success', 'message' => 'Order placed successfully.', 'orderId' => $orderId]);
?>
