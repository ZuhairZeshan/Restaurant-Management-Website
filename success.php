<?php
require 'vendor/autoload.php';
\Stripe\Stripe::setApiKey('sk_test_yourSecretKey');

$session_id = $_GET['session_id'];

$session = \Stripe\Checkout\Session::retrieve($session_id);
$paymentIntent = \Stripe\PaymentIntent::retrieve($session->payment_intent);

if ($session->payment_status === 'paid') {
    // Log the order in your database as "Paid"
    // Show confirmation to the user
    echo "<h1>Thank you! Your order has been placed.</h1>";
} else {
    echo "<h1>Payment not successful.</h1>";
}
?>
