<?php
session_start();
include('bdd.php');

if (!isset($_SESSION['email'])) {
    header('location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<?php
$title = 'Historique des commandes';
include('includes/head.php');
?>
<body>
    <?php include('includes/header.php'); ?>

    <main>
        <div class="container">
            <h1>Historique des commandes</h1>

            <?php
            $q = "SELECT order_date, items, prix FROM orders WHERE id_user = :id_user ORDER BY order_date DESC";
            $stmt = $bdd->prepare($q);
            $stmt->execute(['id_user' => $_SESSION['id_user']]);
            $commandes = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($commandes)) {
                foreach ($commandes as $commande) {
                    $order_date = $commande['order_date'];
                    $items = $commande['items'];
                    $total_cost = $commande['prix'];
                    echo "<p><strong>Date de la commande :</strong> $order_date</p>";
                    echo "<p><strong>Articles commandés :</strong> $items</p>";
                    echo "<p><strong>Coût total :</strong> $total_cost</p>";
                    echo "<hr>";
                }
            } else {
                echo "<p>Aucune commande trouvée.</p>";
            }
            ?>
        </div>
    </main>

    <?php include('includes/footer.php'); ?>
</body>
</html>
