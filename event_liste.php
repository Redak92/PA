<?php
    session_start();

    if (!isset($_SESSION['email'])) {
        header('location: index.php');
        exit;
    }
    $eventPosted = false;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        include('includes/db.php');
        
        if (empty($_POST['titre']) || empty($_POST['categorie']) || empty($_POST['corps_de_texte'])) {
            $eventPosted = "Veuillez remplir tous les champs.";
        } else {
            $titre = $_POST['titre'];
            $categorie = $_POST['categorie'];
            $date_event = $_POST['date_event'];
            $corps_de_texte = $_POST['corps_de_texte'];
            $date_event = $_POST['date_event'];

            $query = 'INSERT INTO event_post (titre, categorie, corps_de_texte, date_event) 
            VALUES (:titre, :categorie, :corps_de_texte, :date_event)';
            $stmt = $bdd->prepare($query);

            $params = [
                'titre' => $titre,
                'categorie' => $categorie,
                'corps_de_texte' => $corps_de_texte,
                'date_event' => $date_event
            ];

            if ($stmt->execute($params)) {
                $eventPosted = "Événement publié avec succès";
            } else {
                $eventPosted = "Erreur lors de la publication de l'événement";
            }
        }
    }

    // Retrieve events
    include('includes/db.php');
    $query = 'SELECT * FROM event_post';
    $stmt = $bdd->prepare($query);
    $stmt->execute();
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <div class="background-image">

    <!DOCTYPE html>
    <html lang="fr">
    <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des événements</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <?php include('includes/header.php'); ?>

    </head>
    <body>
    <style>
        p h1 h2 {
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

                .blogliste {
                    min-height: 720px;

                }

                .background-image {
                    background-image: url('imagerie/pexels-victor-freitas-949131.jpg');
                    background-repeat: no-repeat;
                    background-size: cover;
                }


                .header, .footer {
                    background-image: url('imagerie/pexels-victor-freitas-949131.jpg');
                    background-repeat: no-repeat;
                    background-size: cover;
                }

                .blogliste {
                    display: flex;
                    flex-direction: row;
                }

                .article-box {
                    width : 300px;
                    background-color: ;
                    color : ;
                    margin-bottom: 10px;
                    margin-top: 10px;
                }
                    input[type="email"],
                    input[type="password"] {
                    background-color: transparent;
                    border: none;
                    border-bottom: 1px solid white;
                    color: white;
                    outline: none;
                    }

                    input[type="email"]::placeholder,
                    input[type="password"]::placeholder {
                    color: white;
                    }
                .article-box img {
                    justify-content: center;
                    margin-left : auto;
                    margin-right: auto;
                    max-width:300px;
                    border-radius: 20p; 
                }
    </style>

    <div class="container">
        <h1>Liste des événements</h1>
        
        <?php if ($eventPosted): ?>
            <div class="alert alert-info">
                <?php echo $eventPosted; ?>
            </div>
        <?php endif; ?>
        <?php 
        $email = $_SESSION['email'];

        // Requête pour récupérer le rôle de l'utilisateur connecté
        $q = 'SELECT role FROM users WHERE email = :email';
        $statement = $bdd->prepare($q);
        $statement->execute(['email' => $email]);
        $user = $statement->fetch(PDO::FETCH_ASSOC);
        
        if ($user && $user['role'] === 'admin' || $user['role'] === 'administrateur') {
            echo '
        <form action="" method="post" id="posterEvent">
            <div class="mb-3">
                <label for="titre" class="form-label">Titre:</label>
                <input type="text" class="form-control" id="titre" name="titre" required>
            </div>

            <div class="mb-3">
                <label for="categorie" class="form-label">Catégorie:</label>
                <select class="form-control" id="categorie" name="categorie" required>
                    <option value="coaching">Coaching</option>
                    <option value="cuisine">Cuisine</option>
                </select>
            </div>
            <label for="date">Date de l\'event :</label>
        <input type="datetime-local" id="date_event" name="date_event">

            <div class="mb-3">
                <label for="corps_de_texte" class="form-label">Corps de texte:</label>
                <textarea class="form-control" id="corps_de_texte" name="corps_de_texte" rows="3" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Publier</button>
        </form>';
        } else {
            echo '<p style="color:white">Ici vous trouverez la liste des évenement de la salle de sport. Vous y trouverz des séances
             de coaching, des cours de cuisines ainsi que des challenge</p>';
        }?> 

        <h2 class="mt-5"  style="color:white">Événements</h2>
        <table>
        <thead>
            <tr>
                <th style="color:white">Titre</th>
                <th style="color:white">Catégorie</th>
                <th style="color:white">Date de l'Event</th>
                <th style="color:white">Description</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($events as $event) : ?>
            <tr>
                <td style="color:white">
                    <strong>
                        <?php if (strtotime($event['date_event']) >= strtotime(date('Y-m-d H:i:s'))) : ?>
                            <a href="event.php?id_event=<?php echo $event['id_event']; ?>">
                                <?php echo $event['titre']; ?>
                            </a>
                        <?php else : ?>
                            <?php echo $event['titre']; ?>
                        <?php endif; ?>
                    </strong>
                </td>
                <td style="color:white"><?php echo $event['categorie']; ?></td>
                <td style="color:white"><?php echo date('d-m-Y', strtotime($event['date_event'])); ?></td>
                <td style="color:white"><?php echo $event['corps_de_texte']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>

    </table>

    </body>
    </div>
    <footer>
        <?php include('includes/footer.php') ?>
    </footer>
    </html>

