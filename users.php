<script defer src="js/search.js"></script>
<script defer src="js/event.js"></script>

<?php
// Pour que la page ne soit accessible qu'aux admins
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

// Vérification du rôle de l'utilisateur
if ($user && $user['role'] === 'admin') {
    // L'utilisateur a le rôle d'administrateur, le contenu de la page est accessible
    $title = 'Administration';
	
    include('includes/head.php');
    ?>
	


    
    
    <body>

        <?php include('includes/header.php'); ?>


        <div class="container">
                <h1><?= $title ?></h1>
                <div class="container mt-4">
                        <button class="btn btn-primary" onclick="toggleUsersTable()">Utilisateurs</button>
                        <button class="btn btn-primary" onclick="toggleArticle()">Article</button>
                        <button class="btn btn-primary" onclick="toggleContact()">Contact</button>
                        <button class="btn btn-primary" onclick="toggleForumThreads()">Forum Threads</button>
                        <button class="btn btn-primary" onclick="toggleForumThreadComments()">Forum Thread Comments</button>
                        <button class="btn btn-primary" onclick="toggleArticleComments()">Article Comments</button>
                        <button class="btn btn-primary" onclick="toggleEvent()">Liste des Event</button>

                    </div> <br>

                <?php include('includes/message.php'); ?>

                

                <div id="usersTable" style="display: none;">
                    <h2>Liste des utilisateurs</h2>
                    <?php include('includes/db.php'); ?>

                    <?php
                    $q = 'SELECT id, nom, prenom, sexe, age, email, role FROM users';
                    $req = $bdd->query($q);
                    $users = $req->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                <input type="text" id="searchInput" placeholder="Rechercher par email">
                    <table class="table table-striped mt-4">
                        <tr>
                            <th>#</th>
                            <th>nom</th>
                            <th>prenom</th>
                            <th>sexe</th>
                            <th>age</th>
                            <th>role</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    <tbody id="searchResults">

                        <?php
                        foreach ($users as $index => $user) {
                            echo '<tr>
                                <td>' . $user['id'] . '</td>
                                <td>' . $user['nom'] . '</td>
                                <td>' . $user['prenom'] . '</td>
                                <td>' . $user['sexe'] . '</td>
                                <td>' . $user['age'] . '</td>
                                <td>' . $user['role'] . '</td>
                                <td>' . $user['email'] . '</td>
                                <td>
                                    <a class="btn btn-secondary btn-sm" href="user_consulter.php?id=' . $user['id'] . '">Consulter</a>
                                    <a class="btn btn-primary btn-sm" href="user_modifier.php?id=' . $user['id'] . '">Modifier</a>
                                    <a class="btn btn-danger btn-sm" href="user_supprimer.php?id=' . $user['id'] . '">Supprimer</a>
                                </td>
                              </tr>';
                        }
                        ?>
                    </tbody>>

                    </table>
                </div>

                <div id="article" style="display: none;">
    <h2>Articles de Blog</h2>
    <?php include('includes/db.php'); ?>

    <?php
    $q = 'SELECT id_article, nom, prenom, titre, categorie, LEFT(corps_de_texte, 20) AS extrait, image FROM article_post LIMIT 5';
    $req = $bdd->query($q);
    $articles = $req->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <table class="table table-striped mt-4">
        <tr>
            <th>#</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Titre</th>
            <th>Catégorie</th>
            <th>Extrait</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>

        <?php
        foreach ($articles as $index => $article) {
            echo '<tr>
                <td>' . $article['id_article'] . '</td>
                <td>' . $article['nom'] . '</td>
                <td>' . $article['prenom'] . '</td>
                <td>' . $article['titre'] . '</td>
                <td>' . $article['categorie'] . '</td>
                <td>' . $article['extrait'] . '</td>
                <td>' . $article['image'] . '</td>
                <td>
                    <a class="btn btn-secondary btn-sm" href="article_consulter.php?id=' . $article['id_article'] . '">Consulter</a>
                    <a class="btn btn-primary btn-sm" href="article_modifier.php?id=' . $article['id_article'] . '">Modifier</a>
                    <a class="btn btn-danger btn-sm" href="article_supprimer.php?id=' . $article['id_article'] . '">Supprimer</a>
                </td>
              </tr>';
        }
        ?>

    </table>
</div>


                <div id="contact" style="display: none;">
                    <h2>Contact</h2>
                    <table class="table table-striped mt-4">
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Objet</th>
                            <th>Message</th>
                            <th>Action</th>
                        </tr>
                        <?php
                        $q = 'SELECT * FROM contact';
                        $req = $bdd->query($q);
                        $contacts = $req->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($contacts as $contact) {
                            echo '<tr>
                                    <td>' . $contact['id'] . '</td>
                                    <td>' . $contact['nom'] . '</td>
                                    <td>' . $contact['email'] . '</td>
                                    <td>' . $contact['telephone'] . '</td>
                                    <td>' . $contact['objet'] . '</td>
                                    <td>' . $contact['contact_commentaire'] . '</td>
                                    <td>
                                        <a href="contact_supprimer.php?id=' . $contact['id'] . '" class="btn btn-danger btn-sm">Supprimer</a>
                                    </td>
                                </tr>';
                        }
                        ?>
                    </table>
                </div>


                <div id="forumThreads" style="display: none;">
                    <h2>Forum Threads</h2>

                    <table class="table table-striped mt-4">
                        <tr>
                            <th>#</th>
                            <th>Titre</th>
                            <th style="width: 50%;">Post original</th>
                            <th>Auteur</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                        <?php
                        $q = 'SELECT * FROM forum_thread';
                        $req = $bdd->query($q);
                        $forumThreads = $req->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($forumThreads as $thread) {
                            echo '<tr>
                                    <td>' . $thread['id_thread'] . '</td>
                                    <td>' . $thread['titre'] . '</td>
                                    <td>' . $thread['commentaire_zero'] . '</td>
                                    <td>' . $thread['author'] . '</td>
                                    <td>' . $thread['date_thread'] . '</td>
                                    <td>
                                        <a class="btn btn-primary" href="forum_thread_consulter.php?id=' . $thread['id_thread'] . '">Consulter</a>
                                    <br><br>
                                        <a class="btn btn-danger" href="forum_thread_supprimer.php?id=' . $thread['id_thread'] . '">Supprimer</a>
                                    </td>
                                </tr>';
                        }
                        ?>
                    </table>
                </div>

                <div id="forumThreadComments" style="display: none;">
                    <h2>Forum Thread Comments</h2>

                    <table class="table table-striped mt-4">
                        <tr>
                            <th>#</th>
                            <th>Thread ID</th>
                            <th>Auteur</th>
                            <th>Commentaire</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                        <?php
                        $q = 'SELECT * FROM forum_thread_comment';
                        $req = $bdd->query($q);
                        $forumThreadComments = $req->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($forumThreadComments as $comment) {
                            echo '<tr>
                                    <td>' . $comment['id_forum_comment'] . '</td>
                                    <td>' . $comment['id_forum_thread'] . '</td>
                                    <td>' . $comment['id_commentateur'] . '</td>
                                    <td>' . $comment['commentaire'] . '</td>
                                    <td>' . $comment['date'] . '</td>
                                    <td>
                                        <a href="forum_thread_comment_supprimer.php?id=' . $comment['id_forum_comment'] . '" class="btn btn-danger">Supprimer</a>
                                    </td>
                                </tr>';
                        }
                        ?>
                    </table>
                </div>


                <div id="articleComments" style="display: none;">
                    <h2>Article Comments</h2>

                    <table class="table table-striped mt-4">
                        <tr>
                            <th>#</th>
                            <th>Commentaire</th>
                            <th>ID Commentateur</th>
                            <th>ID Article</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                        <?php
                        $q = 'SELECT * FROM article_comment';
                        $req = $bdd->query($q);
                        $articleComments = $req->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($articleComments as $comment) {
                            echo '<tr>
                                    <td>' . $comment['id_comment'] . '</td>
                                    <td>' . $comment['commentaire'] . '</td>
                                    <td>' . $comment['id_commentateur'] . '</td>
                                    <td>' . $comment['id_article'] . '</td>
                                    <td>' . $comment['date'] . '</td>
                                    <td>
                                        <a href="article_comment_supprimer.php?id=' . $comment['id_comment'] . '" class="btn btn-danger">Supprimer</a>
                                    </td>
                                </tr>';
                        }
                        ?>
                    </table>
                </div>
                <div id="event" style="display: none;">
                    <h2>Liste des Events</h2>

                    <table class="table table-striped mt-4">
                        <tr>
                            <th>#</th>
                            <th>Titre</th>
                            <th>Catégorie</th>
                            <th>Corps de texte</th>
                            <th>Date</th>
                            <th>Publié le</th>
                            <th>Action</th>
                        </tr>
                        <?php
                        $q = 'SELECT * FROM event_post';
                        $req = $bdd->query($q);
                        $event = $req->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($event as $event) {
                            echo '<tr>
                                    <td>' . $event['id_event'] . '</td>
                                    <td>' . $event['titre'] . '</td>
                                    <td>' . $event['categorie'] . '</td>
                                    <td>' . $event['corps_de_texte'] . '</td>
                                    <td>' . date('d-m-Y', strtotime($event['date_event'])) . '</td>
                                    <td>' . date('d-m-Y', strtotime($event['date_post'])) . '</td>
                                    <td>
                                        <a href="event_post_supprimer.php?id=' . $event['id_event'] . '" class="btn btn-danger">Supprimer</a>
                                    </td>
                                </tr>';
                        }
                        ?>
                    </table>
                </div>


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
                        
                        articleComments.style.display = 'none';
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
                        articleComments.style.display = 'none';


                        article.style.display = 'block';
                        usersTable.style.display = 'none';
                        contact.style.display = 'none';
                        forumThreads.style.display = 'none';
                        forumThreadComments.style.display = 'none';
                        articleComments.style.display = 'none';
                    }

                    function toggleContact() {
                        let article = document.getElementById('article');
                        let usersTable = document.getElementById('usersTable');
                        let contact = document.getElementById('contact');
                        let forumThreads = document.getElementById('forumThreads');
                        let forumThreadComments = document.getElementById('forumThreadComments');
                        let articleComments = document.getElementById('articleComments');
                        let event = document.getElementById('event');
                        articleComments.style.display = 'none';
                        contact.style.display = 'block';
                        usersTable.style.display = 'none';
                        article.style.display = 'none';
                        forumThreads.style.display = 'none';
                        forumThreadComments.style.display = 'none';
                        articleComments.style.display = 'none';
                    }

                    function toggleForumThreads() {
                        let forumThreads = document.getElementById('forumThreads');
                        let usersTable = document.getElementById('usersTable');
                        let article = document.getElementById('article');
                        let contact = document.getElementById('contact');
                        let forumThreadComments = document.getElementById('forumThreadComments');
                        let articleComments = document.getElementById('articleComments');
                        let event = document.getElementById('event');
                        articleComments.style.display = 'none';
                        forumThreads.style.display = 'block';
                        usersTable.style.display = 'none';
                        article.style.display = 'none';
                        contact.style.display = 'none';
                        forumThreadComments.style.display = 'none';
                        articleComments.style.display = 'none';
                    }

                    function toggleForumThreadComments() {
                        let forumThreadComments = document.getElementById('forumThreadComments');
                        let usersTable = document.getElementById('usersTable');
                        let article = document.getElementById('article');
                        let contact = document.getElementById('contact');
                        let forumThreads = document.getElementById('forumThreads');
                        let articleComments = document.getElementById('articleComments');
                        let event = document.getElementById('event');
                        articleComments.style.display = 'none';
                        forumThreadComments.style.display = 'block';
                        usersTable.style.display = 'none';
                        article.style.display = 'none';
                        contact.style.display = 'none';
                        forumThreads.style.display = 'none';
                        articleComments.style.display = 'none';
                    }

                    function toggleArticleComments() {
                        let articleComments = document.getElementById('articleComments');
                        let usersTable = document.getElementById('usersTable');
                        let article = document.getElementById('article');
                        let contact = document.getElementById('contact');
                        let forumThreads = document.getElementById('forumThreads');
                        let forumThreadComments = document.getElementById('forumThreadComments');
                        let event = document.getElementById('event');
                        articleComments.style.display = 'none';
                        articleComments.style.display = 'block';
                        usersTable.style.display = 'none';
                        article.style.display = 'none';
                        contact.style.display = 'none';
                        forumThreads.style.display = 'none';
                        forumThreadComments.style.display = 'none';
                    }
                    
                        function toggleEvent() {
                        let articleComments = document.getElementById('articleComments');
                        let usersTable = document.getElementById('usersTable');
                        let article = document.getElementById('article');
                        let contact = document.getElementById('contact');
                        let forumThreads = document.getElementById('forumThreads');
                        let forumThreadComments = document.getElementById('forumThreadComments');
                        let event = document.getElementById('event');


                        articleComments.style.display = 'none';
                        usersTable.style.display = 'none';
                        article.style.display = 'none';
                        contact.style.display = 'none';
                        forumThreads.style.display = 'none';
                        forumThreadComments.style.display = 'none';
                        event.style.display = 'block'; 
                    }
                </script>

            </div>
			
			<a href = "mailing/newsletter/form_send.php" > Newsletter </a>
        </main>

        <?php include('includes/footer.php'); ?>

    </body>

    </html>
<?php } else {
    // L'utilisateur n'a pas le rôle d'administrateur, rediriger vers une autre page par exemple
    header('location: index.php');
    exit;
}
