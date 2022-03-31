<?php
require_once('../libs/stripe-php-7.121.0/init.php');
require_once('../../config.php');

// This is your test secret API key.
Stripe\Stripe::setApiKey('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');

function calculateOrderAmount(): int {
    global $conn;
    global $shippingprice;

    if(count($_SESSION["cart"]) == 0) return 0;

    $endprice = 0;
    foreach($_SESSION["cart"] as $cartobj){
        $cartproduct = $conn->getProduct($cartobj[0]);
        $endprice += $cartobj[1] * $cartproduct["price"];
    }
    return intval((round($endprice, 2) + $shippingprice) * 100);
}

header('Content-Type: application/json');

try {
    // Create a PaymentIntent with amount and currency
    $paymentIntent = \Stripe\PaymentIntent::create([
        'amount' => calculateOrderAmount(),
        'currency' => 'chf',
        'automatic_payment_methods' => [
            'enabled' => true,
        ],
    ]);

    $output = [
        'clientSecret' => $paymentIntent->client_secret,
    ];

    echo json_encode($output);
} catch (Error $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}