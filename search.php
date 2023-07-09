<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <!-- <style>
        .barre_blog {
            display : flex;
            justify-content: space-between;
            background-color: red;
            color: red;
            text-decoration: bold;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .article-box {
            width: calc(33.33% - 10px); /* Ajuster la largeur selon vos besoins */
            margin-bottom: 20px;
            border: 1px solid #ccc;
            padding: 10px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .image-placeholder {
            width: 325px;
            height: 325px;
            background-color: #ccc;
            margin-bottom: 10px;
        }

        .introduction {
            max-width: 325px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    </style> -->
    <title>Document</title>
</head>
<body> 
<div class="container">                
    <div class="barre_blog">
    <?php 
	$title = "Blog";
	include('includes/header.php'); ?></div>

        <div class="row mb-3">
        <!-- BARRE DE RECHERCHE -->
        <div class="col-6">
            <form action="search.php" method="GET" style="max-width:100%;">
            <div class="barre_de_recherche">
                <!-- <div class="que-recherchez-vous">Que recherchez-vous ?</div>-->
                <div class="centered-content">
                    <!-- <img class="icon-search icon" src="img/search-icon-white-1@2x.png" alt="icon-search" /> -->
                    <input type="text" name="query" placeholder="Recherchez ici" style="display: inline-block; width : 350px;" />
                    <input type="submit" value="Rechercher" style="display: inline-block;" />
                </div>
            </div>
        </form>
        </div>

        <div class="col-4">
        <!-- FILTRE DE RECHERCHE -->
        <form action="search.php" method="GET" style="max-width:100%;">
            <div class="filtre_article">
                <div class="catgories">
                    <select name="categorie">
                        <option value="">Toutes les catégories</option>
                        <option value="actualite">Actualité</option>
                        <option value="nutrition">Nutrition</option>
                        <option value="exercice_physique">Exercice Physique</option>
                    </select>
                
                <input type="submit" value="Filtrer" style="display: inline-block; margin-right: 10px;" />
                </div>
            </div>
        </form>
    </div>
        <div class="col-2">
        <!-- BOUTON NOUVEL ARTICLE -->
        <a href="post_article.php" style="align-self: flex-end;">
            <div class="bouton_nouvel_article">
                <div class="overlap-group-1"><div class="nouvel-article">Nouvel Article</div></div>
                <!-- <img class="icon-share icon" src="img/modifier-logo-blanc-1@2x.png" alt="icon-share" /> -->
            </div>
        </a>
    </div>
    </div>
    </div>
    
    <div class="container">
        <?php
        try {
            // Connexion à la base de données
            include("includes/db.php");

            // Récupération du terme de recherche saisi par l'utilisateur
            if(isset($_GET['query'])){
            $searchTerm = $_GET['query'];
            }else{
                $searchTerm = "%";
            }
            if(isset($_GET['categorie'])){
                $categorie = $_GET['categorie'];
            }else{
                $categorie = "%";
            }
            // Requête pour récupérer les articles correspondants au terme de recherche et à la catégorie
            $query = 'SELECT * FROM article_post WHERE titre LIKE ? AND categorie LIKE ?';
            


            $stmt = $bdd->prepare($query);

            $stmt->execute([$searchTerm,$categorie]);
            

            
            $stmt->execute([$searchTerm, $categorie]);
            
            $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
            


            // Affichage des résultats
            foreach ($articles as $article) {
                echo '<div class="article-box">';

                if (!empty($article['image'])) {
                    $image_path = 'uploads/' . $article['image'];
                    

                } else {
                    $image_path = "uploads/default.png";
                }
                echo '<img src="uploads/' . $article['image'] . '" alt="Image de l\'article">';

                //Afficher le lien vers les articles *en cours*
                //echo "<h2>" . $article['titre'] . "</h2>";
                echo '<h2><a href="article.php?id=' . $article['id_article'] . '">' . $article['titre'] . '</a></h2>';

                // Récupération des 15 premiers mots du corps de texte de l'article
                $corpsDeTexte = $article['corps_de_texte'];
                $mots = explode(' ', $corpsDeTexte);
                $premiersMots = array_slice($mots, 0, 15);
                $premiersMotsTexte = implode(' ', $premiersMots);

                echo "<p class='introduction'><strong>Introduction:</strong> " . $premiersMotsTexte . "...</p>";
                echo "</div>";
            }
        } catch (PDOException $e) {
            echo "Erreur lors de la connexion à la base de données : " . $e->getMessage();
        }
        ?>
    </div>
</body>
</html>
