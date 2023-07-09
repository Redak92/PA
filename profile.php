
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


            <?php include('includes/message.php'); ?>

            <?php
            include('includes/db.php');

            $q = 'SELECT email, nom, prenom, role, age, image FROM users WHERE email = :email';
            $statement = $bdd->prepare($q);
            $statement->execute(['email' => $_SESSION['email']]);
            $user = $statement->fetch(PDO::FETCH_ASSOC);
            ?>
            <div class="row">
                <div class="col-lg-4">
                    <h2>Informations personnelles</h2>
                    <div class="mb-3 col-6">
                        <a href='userMod.php'>Modifier le profil</a>
                    </div>
                    <p>Adresse e-mail : <?= $user['email'] ?></p>
                    <p>Nom : <?= $user['nom'] ?></p>
                    <p>Prénom : <?= $user['prenom'] ?></p>
                    <p>Rôle : <?= $user['role'] ?></p>
                    <p>Date de naissance : <?= date_format(date_create_from_format('Ymd', $user['age']), 'd/m/Y') ?></p>
                </div>
                

                <div class="col-lg-4">
                    <h2>Image de profil</h2>
                    <img src="uploads/<?= $user['image'] ?>" alt="profil" style="width: 100px; height: 100px">
                    <br><a href="avatar.php">Ou construisez votre propre avatar !</a>
                </div>
                </div>
                <div class="row" style='margin-top : 10px'>
                <div class="col-lg-4">
                    <h2>Mes Events</h2>
                    <button class="btn btn-primary" onclick="toggleSection('evenements')">Voir les événements</button>
                    <div id="evenements" class="mt-3" style="display: none;">
                    <?php
        // Récupération des événements inscrits par l'utilisateur
        $query = "SELECT e.id_event, e.titre, e.categorie
                  FROM event_post AS e
                  INNER JOIN event_subs AS s ON e.id_event = s.id_event
                  INNER JOIN users AS u ON s.id_user = u.id
                  WHERE u.email = :email";

        $stmt = $bdd->prepare($query);
        $stmt->execute(['email' => $_SESSION['email']]);
        $evenements = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($evenements)) {
            foreach ($evenements as $evenement) {
                $id_event = $evenement['id_event'];
                $titre = $evenement['titre'];
                $categorie = $evenement['categorie'];
                echo "<p><strong>Titre :</strong> <a href='event.php?id_event=$id_event'>$titre</a></p>";
                echo "<p><strong>Catégorie :</strong> $categorie</p>";
                echo "<hr>";
            }
        } else {
                            echo "<p>Aucun événement inscrit.</p>";
                        }
                        ?>
                    </div>
                </div>
            
                <div class="col-lg-4">
                    <h2>Derniers Commentaires</h2>
                    <button class="btn btn-primary" onclick="toggleSection('commentaires')">Voir les commentaires</button>
                    <div id="commentaires" class="mt-3" style="display: none;">
                    <?php
        // Requête pour récupérer les commentaires de l'utilisateur
        $q = 'SELECT c.commentaire, c.id_article, c.date, u.email
            FROM article_comment AS c
            INNER JOIN users AS u ON c.id_commentateur = u.id
            INNER JOIN article_post AS a ON c.id_article = a.id_article
            WHERE u.email = :email
            ORDER BY c.date DESC
            LIMIT 5'; // Limite à 5 commentaires, vous pouvez modifier cela selon vos besoins

        $statement = $bdd->prepare($q);
        $statement->execute(['email' => $_SESSION['email']]);
        $commentaires = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($commentaires)) {
            foreach ($commentaires as $commentaire) {
                $comment = $commentaire['commentaire'];
                $date = $commentaire['date'];
                $email = $commentaire['email'];
                $id_article = $commentaire['id_article'];
                echo "<p><strong></strong> <a href='article.php?id_article=$id_article'>$comment</a></p>";
                echo "<p><strong>Date :</strong> $date</p>";
                echo "<hr>";
            }
        } else {
                            echo "<p>Aucun commentaire trouvé.</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        window.onload = function() {
            toggleUsersTable();
        };

        function toggleUsersTable() {
            let usersTable = document.getElementById('usersTable');
            let article = document.getElementById('article');
            let contact = document.getElementById('contact');
            let forumThreads = document.getElementById('forumThreads');
            let forumThreadComments = document.getElementById('forumThreadComments');
            let articleComments = document.getElementById('articleComments');
            let event = document.getElementById('event');

            usersTable.style.display = 'block';
            article.style.display = 'none';
            contact.style.display = 'none';
            forumThreads.style.display = 'none';
            forumThreadComments.style.display = 'none';
            articleComments.style.display = 'none';
        }

        function toggleArticle() {
            let article = document.getElementById('article');
            let usersTable = document.getElementById('usersTable');
            let contact = document.getElementById('contact');
            let forumThreads = document.getElementById('forumThreads');
            let forumThreadComments = document.getElementById('forumThreadComments');
            let articleComments = document.getElementById('articleComments');
            let event = document.getElementById('event');

            article.style.display = 'block';
            usersTable.style.display = 'none';
            contact.style.display = 'none';
            forumThreads.style.display = 'none';
            forumThreadComments.style.display = 'none';
            articleComments.style.display = 'none';
            event.style.display = 'none';
        }

        // Ajoutez ici les autres fonctions pour les autres volets...

        function toggleSection(sectionId) {
            let section = document.getElementById(sectionId);
            if (section.style.display === 'none') {
                section.style.display = 'block';
            } else {
                section.style.display = 'none';
            }
        }
    </script>
</body>
<footer> 
        <?php include('includes/footer.php') ?>
</footer>
<html>