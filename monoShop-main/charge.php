<?php
require_once('include/stripe-php/init.php');

\Stripe\Stripe::setApiKey('sk_test_51NRK2oAOXQtmdB1JidZQS67HYPrlJGTtSgxIiYVxdTwSAcMnlOo2b0m28KqpAEcpq9Yr0U3ujuDoZE1yqu1WHnOD006zLg6ICT');

$token = $_POST['stripeToken'];

// Start the session if not started already
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$total = isset($_SESSION['total']) ? $_SESSION['total'] : 0;
$totalCents = $total * 100;  // Stripe requires the amount to be in cents

try {
    $charge = \Stripe\Charge::create([
        'amount' => $totalCents, // Use total from the cart
        'currency' => 'eur',
        'description' => 'Paiement pour un produit',
        'source' => $token,
    ]);

    // Handle successful payment
    $_SESSION['message'] = 'Paiement effectué avec succès !';

    $dsn = "mysql:host=localhost;dbname=projet_annuel;charset=utf8mb4";
    $dbusername = "root";
    $dbpassword = "root";

    $pdo = new PDO($dsn, $dbusername, $dbpassword);

    // Enregistrer chaque article dans la base de données
   // Enregistrer chaque article dans la base de données
foreach ($_SESSION['panier'] as $article) {
    $stmt = $pdo->prepare("INSERT INTO orders (id_user, items, prix, order_date) VALUES (?, ?, ?, NOW())");
    $stmt->execute([$_SESSION['id'], $article['nom'], $article['prix']]);
}


    $_SESSION['facture'] = $_SESSION['panier'];
    // Clear the cart
    $_SESSION['panier'] = array();

    // Redirect to payment_success.php
    header('Location: payment_success.php');
    exit;

} catch (\Stripe\Error\Card $e) {
    // Handle failed payment
    $_SESSION['message'] = 'Le paiement a été refusé : ' . $e->getMessage();

    // Rediriger vers la page de paiement avec le message d'erreur
    header('Location: payment.php');
    exit;
} catch (PDOException $e) {
    echo '<div class="alert alert-danger" role="alert">
            Erreur de connexion à la base de données: ' . $e->getMessage() . '
          </div>';
}
