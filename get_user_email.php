<?php
include '_dbconnect.php';

header('Content-Type: application/json');

// Get raw POST data
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['userId'])) {
    echo json_encode(['status' => 'error', 'message' => 'User ID is required.']);
    exit;
}

$userId = $data['userId'];

$sql = "SELECT User_email FROM users WHERE User_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $userId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    echo json_encode(['status' => 'success', 'email' => $row['User_email']]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Email not found for this user.']);
}
?>
