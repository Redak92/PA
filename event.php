    <?php
    session_start();
    if(!isset($_SESSION['email'])){
        header('location: index.php');
        exit;
    }
    ?>
    <?php
    echo '<div class="event_background-image">';
    include('includes/db.php');

    $title = 'Event';

    // Vérification si l'ID de l'event est présent dans l'URL
    if (isset($_GET['id_event'])) {
        $eventId = $_GET['id_event'];

        // Requête pour récupérer les détails de l'event correspondant à l'ID
        $query = 'SELECT id_event, titre, categorie, corps_de_texte FROM event_post WHERE id_event = :id_event';
        $stmt = $bdd->prepare($query);
        $stmt->bindParam(':id_event', $eventId);
        $stmt->execute();
        $event = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérification si l'event existe dans la base de données
        if ($event) {
            $titre = $event['titre'];
            $corps_de_texte = $event['corps_de_texte'];
            
            // Affichage de l'event
            include('includes/header.php');


            echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
            ';
            echo "<style>
            p, h1, h2 {
                color : white;
            }

            a {
                color : white
            }

            .container h1{
                color : white;
            }

            .main {
                min-height : 500px;

            }

            html p {
                color : white;
            }

            .event_background-image {
                background-image: url('imagerie/pexels-victor-freitas-949131.jpg');
                background-repeat: no-repeat;
                background-size: cover;
            }

            .header, .footer {
                background-image: url('imagerie/pexels-victor-freitas-949131.jpg');
                background-repeat: no-repeat;
                background-size: cover;
            }
        </style>";
            //la page affichée

            echo '<div class="container">';
                
                //titre
                echo "<h1>$titre</h1>"; 
                //Retour à la page blog
                echo "<em> <a href='event_liste.php'>Retour à la liste des events</a></em>";
                //structure du corps de texte
                //Image bannière
                echo "<p>$image</p>";
                echo '<div class="col-6">';
                    echo "<p>$corps_de_texte</p>";
                echo '</div>';

                // Bloc d'inscription/désinscription
    // Récupération de l'ID de l'utilisateur à partir de son email
    $email = $_SESSION['email'];
    $queryUser = "SELECT id FROM users WHERE email = :email";
    $stmtUser = $bdd->prepare($queryUser);
    $stmtUser->bindParam(':email', $email);
    $stmtUser->execute();
    $user = $stmtUser->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        $id_commentateur = $user['id'];
    

        // Requête pour vérifier si l'utilisateur est inscrit à l'événement
        $querySub = 'SELECT id_user FROM event_subs WHERE id_event = :id_event AND id_user = :id_user';
        $stmtSub = $bdd->prepare($querySub);
        $stmtSub->bindParam(':id_event', $eventId);
        $stmtSub->bindParam(':id_user', $id_commentateur);
        $stmtSub->execute();
        $isSubscribed = $stmtSub->fetch(PDO::FETCH_ASSOC);

        if ($isSubscribed) { 
            // L'utilisateur est inscrit à l'événement, affiche le bouton "Se désinscrire"
            echo '<h2>Se désinscrire de l\'événement</h2>';
            echo '<form action="desinscription_event.php" method="post">';
            echo '<input type="hidden" name="id_event" value="' . htmlspecialchars($eventId) . '">'; // Champ caché pour transmettre l'ID de l'événement
            echo '<button type="submit" class="btn btn-danger">Se désinscrire</button>';
            echo '</form>';
        } else {
            // L'utilisateur n'est pas inscrit à l'événement, affiche le bouton "S'inscrire"
            echo '<h2>Inscription à l\'événement</h2>';
            echo '<form action="inscription_event.php" method="post">';
            echo '<input type="hidden" name="id_event" value="' . htmlspecialchars($eventId) . '">'; // Champ caché pour transmettre l'ID de l'événement
            echo '<button type="submit" class="btn btn-primary">S\'inscrire</button>';
            echo '</form>';
        }
    
                
                echo '<main>';
                

                //Espace commentaire *en cours*
                //écrire le fichier commentaire.php
                //créer la table commentaires
                    //clé étrangère de l'event pour les commentaires 
                    //clé primaire 'id' pour chaque commentaire
                
                echo '<h2>Commentaires</h2>';
                echo '
                    <form action="event_commentaire_verification.php" method="POST">
                    <div class="form-group">
                            <label for="exampleFormControlTextarea1">Ecrire son commentaire</label><br>
                            <textarea class"form-control" id="commentaire" name="commentaire" rows="2" style="width : 50%"></textarea>
                            <input type="hidden" name="id_event" value="' . $event['id_event'] . '">
                    </div>
                    <button type="submit" class="btn btn-success">Poster</button>
                    </form>
                ';

            echo '</div>';

        } else {
            echo "L'event demandé n'existe pas.";
        }
                        // Requête pour récupérer les commentaires associés à l'event
                        $query = "SELECT id_event_comment, commentaire, date, id_commentateur FROM event_comment WHERE id_event = :id_event";
                        $stmt = $bdd->prepare($query);
                        $stmt->bindParam(':id_event', $eventId);
                        $stmt->execute();
                        $commentaires = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        // Vérification s'il y a des commentaires
                        if ($commentaires) {
                            // Affichage des commentaires
                            foreach ($commentaires as $commentaire) {
                                $commentId = $commentaire['id_event_comment'];
                                $commentText = $commentaire['commentaire'];
                                $commentDate = $commentaire['date'];
                                $idCommentateur = $commentaire['id_commentateur'];

                                // Requête pour récupérer l'email de l'utilisateur correspondant à l'id_commentateur
                                $queryUser = "SELECT email FROM users WHERE id = :id_commentateur";
                                $stmtUser = $bdd->prepare($queryUser);
                                $stmtUser->bindParam(':id_commentateur', $idCommentateur);
                                $stmtUser->execute();
                                $user = $stmtUser->fetch(PDO::FETCH_ASSOC);

                                if ($user) {
                                    $emailCommentateur = $user['email'];
                                } else {
                                    $emailCommentateur = 'Utilisateur inconnu';
                                }
                                

                                echo 
                                '<style>
                                    .comment_container {
                                        background-color : lightgrey;
                                        max-width: 500px;
                                        margin-left : 70px;
                                        border-radius : ;
                                        border: white; 
                                    }

                                </style>';

                                echo '<div class="comment_container">';
                                    echo "<p>Commentaire #$commentId (le $commentDate) :</p>";
                                    echo "<p>$commentText</p>";
                                    echo "<p style='justify-content: right'><em>par $emailCommentateur</p>";
                                echo '</div>';
                            }
                        } else {
                            echo "
                            <div class='comment_container'>
                                <p style='color:white'> Aucun commentaire pour cet event.</p>
                            </div>";
                        }

    } else {
        echo "Aucun ID d'event spécifié.";
    }
    include('includes/footer.php');
    //<input type="hidden" name="id_user" value="' . $_SESSION['user_id'] . '">
    }
    ?>
