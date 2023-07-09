<?php

///Code suivant non fonctionnel
///page blanche à l'upload du post
///post non enregistré dans la bdd
if($_FILES['image']['error'] != 4) { // un fic a été envoyé
    // vérifier le type
    $acceptable = [
        'image/jpeg',
        'image/png',
        'image/gif'];
    if (!in_array($_FILES['image']['type'],$acceptable)){
        header('location:post_article_verification.php?message=L\'image doit être au bon format');
        exit;
    }
    // enregistrer le fic sur le serveur
    //créer un dossier upload s'il n'existe pas
    //pour le PA:
    if(!file_exists('uploads')){
        mkdir('uploads');
    }
    //le fichier image ne s'envoie pas au serveur
    //les fichiers images ensuite stockées sont donc vides
    $from = $_FILES['image']['tmp_name'];
    if (!$_FILES['image']['error'] != 4){
        echo "ko";
        die("stop");    }

    $array = explode('.', $_FILES['image']['name']); //['profile', 'min', 'png']
    $ext = end($array);
    $filename = 'image-'.time().'.'.$ext;
 
    $destination = 'uploads/' . $filename;
    $move = move_uploaded_file($from, $destination); //renvoie un booléen 
    if(!$move) {
        header('location:post_article_verification.php?message=erreur lors de l enregistrement de l image');
        exit;
    }
} 

///Fonctionnel à partir d'en dessous

include('includes/db.php');


    
    // Vérification des champs
    if(empty($_POST['nom']) || empty($_POST['categorie']) || empty($_POST['corps_de_texte']) || empty($_POST['titre'])) {
        header('Location: contact.php?message=Veuillez remplir tous les champs.');
        exit();
    }
    

    // Récupération du nom de fichier de l'image
    $array = explode('.', $_FILES['image']['name']);
    $ext = end($array);
    $filename = 'image-' . time() . '.' . $ext;

   

    // Requête SQL
    $q = 'INSERT INTO article_post (nom, prenom, titre, categorie, image, corps_de_texte) 
        VALUES (:nom, :prenom, :titre, :categorie, :image, :corps_de_texte)';
    $req = $bdd->prepare($q);
    $result = $req->execute([
        'nom' => $_POST['nom'],
        'prenom' => $_POST['prenom'],
        'titre' => $_POST['titre'],
        'categorie' => $_POST['categorie'],
        'image' => isset($filename) ? $filename : '',
        'corps_de_texte' => $_POST['corps_de_texte']
    ]);

    if ($result) {
        // Redirection vers la page de succès avec un message de confirmation
        header('Location: article_post.php?message=Article publié avec succès.');
        exit;
    } else {
        // Si la requête a échoué, redirection vers la page de formulaire avec un message d'erreur
        header('Location: article_post.php?message=Erreur lors de la publication de l\'article.');
        exit;
    }


/* inutile et utilité inconnue
// Récupération des clés depuis la base de données
$query = 'SELECT cle FROM post_article';
$stmt = $bdd->query($query);
$cles = $stmt->fetchAll(PDO::FETCH_COLUMN);

// Affichage des résultats
foreach ($cles as $cle) {
    echo $cle . '<br>';
}
*/

?>
