<?php
require_once '../config/db.php';
require_once '../config/stripe_config.php';

$rental_id = $_GET['rental_id'] ?? null;
if (!$rental_id) {
    header('Location: ../index.php');
    exit;
}

$stmt = $conn->prepare("
    SELECT r.*, p.title AS property_title, p.price 
    FROM rentals r
    JOIN properties p ON r.property_id = p.id
    WHERE r.id = ?
");
$stmt->execute([$rental_id]);
$rental = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$rental) {
    header('Location: ../index.php');
    exit;
}

$start = new DateTime($rental['start_date']);
$end = new DateTime($rental['end_date']);
$days = $start->diff($end)->days;
$days = max($days, 1);

//cents
$amount = $rental['price'] * $days * 100;

$session = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card'],
    'line_items' => [[
        'price_data' => [
            'currency' => 'cad',
            'product_data' => [
                'name' => 'Reserva: ' . $rental['property_title'] . " ($days días)",
            ],
            'unit_amount' => $amount,
        ],
        'quantity' => 1,
    ]],
    'mode' => 'payment',
    'success_url' => 'http://localhost/php_trabajos/PHP_Proyecto/Real-Estate-Listing-and-Rental-System/pages/payment_success.php?rental_id=' . $rental_id,
    'cancel_url' => 'http://localhost/php_trabajos/PHP_Proyecto/Real-Estate-Listing-and-Rental-System/pages/payment_cancel.php',
]);

header("Location: " . $session->url);
exit;
?>
