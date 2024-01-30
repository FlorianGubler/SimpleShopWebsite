<?php
require_once('../libs/stripe-php-7.121.0/init.php');
require_once('../../config.php');

// This is your test secret API key.
Stripe\Stripe::setApiKey('sk_test_51KjPsIHFwRqfOP6WhwEcFD79kTg1VHx6NtKB8OcgNTELRHJ43pLWOyZ1ALIW6pLxRIpvmbAoaeEI8XtxapInSBI700ZGb9NrNN');

function calculateOrderAmount(): int
{
    global $conn;
    global $shippingprice;

    if (count($_SESSION["cart"]) == 0) return 0;

    $endprice = 0;
    foreach ($_SESSION["cart"] as $cartobj) {
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

    echo json_encode($paymentIntent);
} catch (Error $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
