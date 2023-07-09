<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: index.php');
    exit;
}
echo '<div class="article_background-image">';

include('includes/db.php');


$title = 'Thread';
include('includes/header.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title><?php echo $title; ?></title>
</head>
<style> 
.pagination a span {
  margin-left: 5px;
}
</style>
<body>
    
    <main>
    <div class="container">
        <?php
        // Vérification si l'ID du thread est présent dans l'URL
        if (isset($_GET['id_thread'])) {
            $threadId = $_GET['id_thread'];

            // Requête pour récupérer les détails du thread correspondant à l'ID
            $query = 'SELECT id_thread, titre, commentaire_zero, date_thread FROM forum_thread WHERE id_thread = :id_thread';
            $stmt = $bdd->prepare($query);
            $stmt->bindParam(':id_thread', $threadId);
            $stmt->execute();
            $thread = $stmt->fetch(PDO::FETCH_ASSOC);

            // Vérification si le thread existe dans la base de données
            if ($thread) {
                $titre = $thread['titre'];
                $commentaire_zero = $thread['commentaire_zero'];
                $date_thread = $thread['date_thread'];

                // Affichage des détails du thread
                echo '<h1>' . $titre . '</h1>';
                $id_thread = $_GET['id_thread'];
$formattedCreationDate = date('d-m-Y', strtotime($date_thread));
echo '<p><strong>Date de création :</strong> ' . $formattedCreationDate . '</p>';                echo '<p>' . $commentaire_zero . '</p>';

                // Section des commentaires
                echo '<h2 style="color: white">Commentaires</h2>';
                echo 
                '<style>
                    html p h1 h2 {
                        color : white;
                    }

                    a {
                        color : white
                    }

                    .container h1{
                        color : white;
                    }

                    html p {
                        color : white;
                    }

                    .article_background-image {
                        background-image: url("imagerie/pexels-victor-freitas-949131.jpg");
                        background-repeat: no-repeat;
                        background-size: cover;
                    }

                    .header, .footer {
                        background-image: url("imagerie/pexels-victor-freitas-949131.jpg");
                        background-repeat: no-repeat;
                        background-size: cover;
                    }
                   .comment_container {
                    background-color: rgba(0, 0, 0, 0.5);
                    width : 30em;
                    display: flex;
                    align-items: flex-start; /* Alignement vertical en haut */
                    gap: 10px; /* Espacement entre les éléments */
                    margin-right : auto;
                    margin-bottom : 5px;
                }
                
                .img_box {
                    display: flex;

                }
                
                .text_box {
                    flex: 1;
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    gap: 1px;
                }
                
                .text_box p {
                    margin: 0;
                }
                </style> 
                ';

                // Récupération des commentaires associés au thread
                $query = 'SELECT id_forum_comment, commentaire, id_commentateur, date
                FROM forum_thread_comment WHERE id_forum_thread = :id_thread';
                $stmt = $bdd->prepare($query);
                $stmt->bindParam(':id_thread', $threadId);
                $stmt->execute();
                $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Vérification s'il y a des commentaires
                if ($comments) {
                    // Pagination des commentaires
                    $commentPerPage = 5; // Nombre de commentaires par page
                    $totalComments = count($comments); // Total des commentaires
                    $totalPages = ceil($totalComments / $commentPerPage); // Total des pages

                    // Vérification du numéro de page
                    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                    if ($currentPage < 1) {
                        $currentPage = 1;
                    } elseif ($currentPage > $totalPages) {
                        $currentPage = $totalPages;
                    }

                    // Indice de départ des commentaires à afficher
                    $startIndex = ($currentPage - 1) * $commentPerPage;
                    $endIndex = $startIndex + $commentPerPage;
                    $displayedComments = array_slice($comments, $startIndex, $commentPerPage);

                    foreach ($displayedComments as $comment) {
                        $commentId = $comment['id_forum_comment'];
                        $commentText = $comment['commentaire'];
                        $commentDate = $comment['date'];
                        $commentateurId = $comment['id_commentateur'];

                        // Requête pour récupérer l'email de l'utilisateur correspondant à l'id_commentateur
                        $queryUser = "SELECT email, image FROM users WHERE id = :id_commentateur";
                        $stmtUser = $bdd->prepare($queryUser);
                        $stmtUser->bindParam(':id_commentateur', $commentateurId);
                        $stmtUser->execute();
                        $user = $stmtUser->fetch(PDO::FETCH_ASSOC);
                        if ($stmtUser -> rowCount() != 0) {
                            $emailCommentateur = $user['email'];
                            $avatarFilename = $user['image']; // Nom du fichier d'image
                            $avatarPath = 'uploads/' . $avatarFilename; // Chemin d'accès à l'avatar
                          
                        } else {
                            $avatarPath = 'uploads/default.png';
                            $emailCommentateur = 'Utilisateur inconnu';
                        }

                        // Affichage du commentaire et des informations du commentateur
                        echo '<div class="comment">';
                                echo '<div class="comment_container">';
                                    echo '<div class="img_box">';
                                            echo "<img src='$avatarPath' alt='Avatar du commentateur' width='50' height='50'>";
                                    echo '</div>';  
                                    echo '<div class="text_box">';
                                    echo '<p>' . $commentText . '</p>';
                                    $formattedDate = date('d-m-Y', strtotime($commentDate));
                                    echo "<p style='display : flex; justify-content: space-between'><em>par <a href='outer_profile.php?user_id=$commentateurId'>$emailCommentateur</a></em><em style='margin-right: 15px'>$formattedDate</em></p>";
                                    
                                    echo '</div>';
                                echo '</div>';
                        echo '</div>';
                    }

                    // Affichage des boutons de pagination
                    echo '<div class="pagination">';
                    if ($currentPage > 1) {
                        $previousPage = $currentPage - 1;
                        echo '<a href="?id_thread=' . $threadId . '&page=' . $previousPage . '"class="btn btn-primary"><span>&larr;</span> Précédent</a>';                    }
                    if ($currentPage < $totalPages) {
                        $nextPage = $currentPage + 1;
                        echo '<a href="?id_thread=' . $threadId . '&page=' . $nextPage . '"class="btn btn-primary">Suivant <span>&rarr;</span></a>';
                    }
                    echo '</div>';
                } else {
                    echo 'Aucun commentaire pour le moment.';
                }

                // Formulaire pour ajouter un commentaire
                echo '<h3 style="color:white">Ajouter un commentaire</h3>';
                echo '<form method="POST" action="forum_comment_verification.php">';
                echo '<textarea name="commentaire" rows="4" cols="50" required></textarea><br>';
                echo ' <input type="hidden" name="id_thread" value="' . $threadId . '">';
                echo '<input type="submit" value="Ajouter le commentaire">';
                echo '</form>';
            } else {
                echo "Le thread demandé n'existe pas.";
            }
        } else {
            echo "Aucun ID de thread spécifié.";
        }
        ?>
    </div>
    </main>
    <?php include('includes/footer.php');
    echo '</div>'; ?>


</body>
</html>
