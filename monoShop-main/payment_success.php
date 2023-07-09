<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

    <title>Paiement Réussi</title>
</head>
<body>
    <div class="container mt-5">
        <?php
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['message'])) {
            echo '<div class="alert alert-success text-center">' . $_SESSION['message'] . '</div>';
            unset($_SESSION['message']);
        }
        ?>
        <div class="jumbotron text-center">
            <h1 class="display-4">Paiement Réussi</h1>
            <p class="lead">Votre paiement a été traité avec succès. Merci pour votre achat !</p>
            <hr class="my-4">
            <p>Vous pouvez continuer vos achats, consulter votre compte ou télécharger votre facture pour plus d'informations.</p>
            <a class="btn btn-primary btn-lg" href="index.php" role="button">Continuer les achats</a>
            <a class="btn btn-secondary btn-lg" href="#" role="button">Mon compte</a>
            <a class="btn btn-success btn-lg" href="facture/facture.php" role="button">Télécharger la facture</a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>
