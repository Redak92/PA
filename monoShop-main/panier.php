<!DOCTYPE html>
<html>
<head>
    <title>Panier</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php
    include('include/header.php');
    ?>
<div class="container mt-5">
    <?php


    // Connexion à la base de données
    include('admin/db.php');

    // Initialize the total variable
    $total = 0;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!isset($_SESSION['panier'])) {
            $_SESSION['panier'] = array();
        }

        if (isset($_POST['id']) && $_POST['id'] != '') {
            // Récupération de l'id du produit et de l'id de l'utilisateur
            $id_produit = $_POST['id'];
            $id_utilisateur = $_SESSION['id'];

            // Requête pour vérifier si le produit est déjà dans le panier
            $q = $bdd->prepare('SELECT * FROM panier WHERE id_produit = :id_produit AND id_utilisateur = :id_utilisateur');
            $q->execute(['id_produit' => $id_produit, 'id_utilisateur' => $id_utilisateur]);
            $result = $q->fetch();

            if ($result) {
                // Si le produit est déjà dans le panier, on augmente la quantité
                $q = $bdd->prepare('UPDATE panier SET quantite = quantite + 1 WHERE id_produit = :id_produit AND id_utilisateur = :id_utilisateur');
                $q->execute(['id_produit' => $id_produit, 'id_utilisateur' => $id_utilisateur]);
            } else {
                // Sinon, on ajoute le produit au panier avec une quantité de 1
                $q = $bdd->prepare('INSERT INTO panier (id_produit, id_utilisateur, quantite) VALUES (:id_produit, :id_utilisateur, 1)');
                $q->execute(['id_produit' => $id_produit, 'id_utilisateur' => $id_utilisateur]);
            }

            $stmt = $bdd->prepare('SELECT * FROM produits WHERE id = ?');
            $stmt->execute([$_POST['id']]);
            $produit = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($produit) {
                $produitId = $produit['id'];

                // If product is already in the cart, increment the quantity
                if (isset($_SESSION['panier'][$produitId])) {
                    $_SESSION['panier'][$produitId]['quantite']++;
                } else {
                    // Otherwise, add the product to the cart with a quantity of 1
                    $produit['quantite'] = 1;
                    $_SESSION['panier'][$produitId] = $produit;
                }
            }
        }

        // If delete request, remove the product from the cart
        if (isset($_POST['delete'])) {
            unset($_SESSION['panier'][$_POST['delete']]);
        }

        // If reset request, clear the entire cart
        if (isset($_POST['reset'])) {
            $_SESSION['panier'] = array();
        }
    }

    if (!empty($_SESSION['panier'])) {
        echo '<table class="table">';
        echo '<thead><tr><th>Nom du produit</th><th>Prix</th><th>Quantité</th><th>Total</th><th>Actions</th></tr></thead>';
        echo '<tbody>';

        foreach ($_SESSION['panier'] as $produitId => $produit) {
            if (empty($produit['id']) || empty($produit['nom']) || empty($produit['prix'])) {
                unset($_SESSION['panier'][$produitId]);
                continue;
            }
            $nomProduit = htmlspecialchars($produit['nom'] ?? '');
            $prixProduit = htmlspecialchars($produit['prix'] ?? 0);
            $quantiteProduit = htmlspecialchars($produit['quantite'] ?? 0);
            $idProduit = htmlspecialchars($produit['id'] ?? '');

            $totalProduit = $prixProduit * $quantiteProduit;
            $total += $totalProduit;
            echo '<tr><td>' . $nomProduit . '</td><td>' . $prixProduit . '€</td><td>' . $quantiteProduit . '</td><td>' . $totalProduit . '€</td><td>
            <form action="panier.php" method="post">
                <input type="hidden" name="delete" value="' . $idProduit . '">
                <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
            </form></td></tr>';
        }

        echo '<tr><td colspan="3" class="text-right"><strong>Total</strong></td><td>' . $total . '€</td></tr>';
        echo '</tbody>';
        echo '</table>';

        // Payment form
        echo '<h2 class="text-center">Paiement:</h2>';
        echo '<form action="process_payment.php" method="post">';
        echo '<input type="hidden" name="total" value="' . ($total * 100) . '">';
        echo '<button type="submit" class="btn btn-primary">Payer</button>';
        echo '</form>';

        $_SESSION['total'] = $total;

    } else {
        echo '<h2 class="text-center">Votre panier est vide.</h2>';
    }
    ?>

</div>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

</body>
</html>
