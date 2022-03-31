<?php

require_once('../libs/stripe-php-7.121.0/init.php');
require_once('../../config.php');

// This is your test secret API key.
Stripe\Stripe::setApiKey('sk_test_51KjIjDIOaiHqEU1iOYmoYMPfid6sT1tFIv5z92A1fHVwTVSR2BfBm6iiVgy69Ykmmt4PXoPMGarB2h7gJmUTc7yR00Ex2qwRVQ');

function calculateOrderAmount(): int {
    $endprice = 0;
    foreach($_SESSION["cart"] as $cartobj){
        $cartproduct = $conn->getProduct($cartobj[0]);
        $endprice += $cartobj[1] * $cartproduct["price"];
    }
    return round($endprice, 2) + $shippingprice;
}

header('Content-Type: application/json');

try {
    // retrieve JSON from POST body
    $jsonStr = file_get_contents('php://input');
    $jsonObj = json_decode($jsonStr);

    $conn->CreateOrder($_POST["fullname"], $_POST["email"], $_POST["address"], $_POST["city"], $_POST["state"], $_POST["postcode"], $_SESSION["cart"]);

    // Create a PaymentIntent with amount and currency
    $paymentIntent = Stripe\PaymentIntent::create([
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