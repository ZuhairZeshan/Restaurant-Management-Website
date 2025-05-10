<?php
require 'vendor/autoload.php';
\Stripe\Stripe::setApiKey('sk_test_yourSecretKey');

$input = json_decode(file_get_contents('php://input'), true);
$cartData = json_decode($input['cartData'], true);
$deliveryMethod = $input['deliveryMethod'];
$userId = $input['userId'];

$line_items = [];

foreach ($cartData as $itemId => $item) {
    $line_items[] = [
        'price_data' => [
            'currency' => 'pkr',
            'product_data' => ['name' => $item['name']],
            'unit_amount' => $item['price'] * 100, // amount in paisa
        ],
        'quantity' => $item['quantity'],
    ];
}

if ($deliveryMethod === 'delivery') {
    $line_items[] = [
        'price_data' => [
            'currency' => 'pkr',
            'product_data' => ['name' => 'Delivery Fee'],
            'unit_amount' => 30000,
        ],
        'quantity' => 1,
    ];
}

$session = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card'],
    'line_items' => $line_items,
    'mode' => 'payment',
    'success_url' => 'https://yourdomain.com/order_success.php?session_id={CHECKOUT_SESSION_ID}',
    'cancel_url' => 'https://yourdomain.com/cart.php?payment=cancelled',
]);

echo json_encode(['url' => $session->url]);
