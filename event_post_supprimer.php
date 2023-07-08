<?php
session_start();

include('includes/db.php');

if (!isset($_SESSION['email'])) {
    header('location: index.php');
    exit;
}

$email = $_SESSION['email'];

// Requête pour récupérer le rôle de l'utilisateur connecté
$q = 'SELECT role FROM users WHERE email = :email';
$statement = $bdd->prepare($q);
$statement->execute(['email' => $email]);
$user = $statement->fetch(PDO::FETCH_ASSOC);

if ($user && $user['role'] === 'admin') {
    if (isset($_GET['id'])) {
        $eventId = $_GET['id'];

        // Requête pour récupérer les informations du event
        $q = 'SELECT * FROM event_post WHERE id_event = :id';
        $statement = $bdd->prepare($q);
        $statement->execute(['id' => $eventId]);
        $event = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$event) {
            // event non trouvé
            $_SESSION['message'] = 'event introuvable.';
            header('location: users.php');
            exit;
        }

        $title = 'Supprimer event';
        include('includes/head.php');

        // Traitement de la suppression du event
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Requête de suppression du event
            $q = 'DELETE FROM event_post WHERE id_event = :id';
            $statement = $bdd->prepare($q);
            $result = $statement->execute(['id' => $eventId]);

            if ($result) {
                $_SESSION['message'] = 'event supprimé avec succès.';
                header('location: users.php');
                exit;
            } else {
                $_SESSION['message'] = 'Une erreur est survenue lors de la suppression du event.';
                header('location: users.php');
                exit;
            }
        }
?>

        <body>

            <?php include('includes/header.php'); ?>

            <main>
                <div class="container">
                    <h1><?= $title ?></h1>
                    <?php include('includes/message.php'); ?>

                    <div class="alert alert-danger">
                        <p>Êtes-vous sûr de vouloir supprimer ce event ?</p>
                        <p><strong>Titre :</strong> <?= $event['titre'] ?></p>
                        <p><strong>Catégorie : </strong> <?= $event['categorie'] ?></p>
                        <p><strong>Contenu :</strong> <?= $event['corps_de_texte'] ?></p>
                        <p><strong>Prévu ce jour :</strong> <?= date('d-m-Y', strtotime($event['date_event'])) ?></p>
                        <p><strong>Publié le :</strong> <?= date('d-m-Y', strtotime($event['date_post'])) ?></p>

                    </div>

                    <form method="POST" action="">
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                        <a class="btn btn-secondary" href="users.php">Annuler</a>
                    </form>
                </div>
            </main>

        </body>
        <?php include('includes/footer.php'); ?>

        </html>

<?php
    } else {
        $_SESSION['message'] = 'ID du event non spécifié.';
        header('location: users.php');
        exit;
    }
} else {
    // L'utilisateur n'a pas le rôle d'administrateur, redirection vers la page d'accueil ou une autre page d'erreur
    header('location: index.php');
    exit;
}
?>
