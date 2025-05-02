<?php
require 'vendor/autoload.php'; // Load Composer's autoloader

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include '_dbconnect.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reservation_id = $_POST['reservation_id'];
    $status = $_POST['status'];

    // Update reservation status
    $stmt = $conn->prepare("UPDATE reservations SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $reservation_id);
    $stmt->execute();

    // Check for errors during execution
    if ($stmt->error) {
        die("Execute failed: " . $stmt->error);
    }

    // Send email notification when status is approved
    if ($status === 'approved') {
        // Get customer email from the reservation
        $result = $conn->query("SELECT customer_email FROM reservations WHERE id = $reservation_id");
        $row = $result->fetch_assoc();
        $customer_email = $row['customer_email'];

        // Create a new PHPMailer instance
        $mail = new PHPMailer(true);
        
        try {
            // Server settings
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'zuhairzeshan60@gmail.com';             // SMTP username (your Gmail address)
            $mail->Password = 'PAKSAT zz1r';              // SMTP password (use App Password if 2FA is enabled)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Enable TLS encryption
            $mail->Port = 587;                                    // TCP port to connect to

            // Recipients
            $mail->setFrom('your-email@gmail.com', 'Delight Inn');
            $mail->addAddress($customer_email);                   // Add a recipient

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Reservation Approved - Confirmation Required';
            $mail->Body    = 'Dear Customer,<br><br>Your reservation has been approved.<br><br>Best regards,<br>[Delight Inn]';

            // Send the email
            $mail->send();
            echo "Email sent successfully.";
        } catch (Exception $e) {
            echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    // Update table status based on the reservation status
    if ($status === 'rejected' || $status === 'completed') {
        // Get table ID from the reservation
        $result = $conn->query("SELECT table_id FROM reservations WHERE id = $reservation_id");
        $row = $result->fetch_assoc();
        $table_id = $row['table_id'];

        // Update table status to available
        $conn->query("UPDATE tables SET is_occupied = FALSE WHERE id = $table_id");
    }

    // Close the prepared statement
    $stmt->close();

    echo "<script>alert('Reservation status updated to \"$status\".');
    window.location.href = '/Restaurant-Management Website/admin_reserve.php'</script>";
}
?>