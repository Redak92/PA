<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<?php
$title = 'Mon profil';
include('includes/head.php');
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
<body>

    <?php include('includes/header.php'); ?>

    <main>
        <div class="container">
            <h1>Mon profil</h1>
            <div class="mb-3">
                <button type="submit" class="btn btn-secondary" onclick="window.location.href='user_modifier.php';">Modifier le profil</button>
            </div>

            <?php include('includes/message.php'); ?>

            <?php
            include('includes/db.php');

            $q = 'SELECT email, nom, prenom, role, image FROM users WHERE email = :email';
            $statement = $bdd->prepare($q);
            $statement->execute(['email' => $_SESSION['email']]);
            $user = $statement->fetch(PDO::FETCH_ASSOC);
            ?>
            <div class="row">
                <div class="col-lg-4">
                    <h2>Informations personnelles</h2>
                    <p>Adresse e-mail : <?= $user['email'] ?></p>
                    <p>Nom : <?= $user['nom'] ?></p>
                    <p>Prénom : <?= $user['prenom'] ?></p>
                    <p>Rôle : <?= $user['role'] ?></p>
                </div>
                <div class="col-lg-4">
                    <h2>Image de profil</h2>
                    <img src="uploads/<?= $user['image'] ?>" alt="profil" style="width: 100px; height: 100px">
                    <br><a href="avatar.php">Ou construisez votre propre avatar !</a>
                    <?php
                    // Chemin complet du fichier

                    //$filePath = 'uploads/' . $fileName;

                    // Lecture du fichier et vérification des erreurs
                   // $fileContent = file_get_contents($filePath);
                    ?>
                </div>
                <div class="col-lg-12">
                    <h2>Derniers Commentaires</h2>

                    <?php
                    // Requête pour récupérer les commentaires de l'utilisateur
                    $q = 'SELECT c.commentaire, c.date, u.email
                        FROM article_comment AS c
                        INNER JOIN users AS u ON c.id_commentateur = u.id
                        WHERE u.email = :email
                        ORDER BY c.date DESC
                        LIMIT 5'; // Limite à 5 commentaires, vous pouvez modifier cela selon vos besoins

                    $statement = $bdd->prepare($q);
                    $statement->execute(['email' => $_SESSION['email']]);
                    $commentaires = $statement->fetchAll(PDO::FETCH_ASSOC);
                    ?>

                    <!-- Affichage des commentaires -->
                    <?php if (!empty($commentaires)): ?>
                        <?php foreach ($commentaires as $commentaire): ?>
                            <div>
                                <p>Commentaire: <?= $commentaire['commentaire'] ?></p>
                                <p>Date: <?= $commentaire['date'] ?></p>
                                <p>Auteur: <?= $commentaire['email'] ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Aucun commentaire trouvé.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

</body>

</html>
