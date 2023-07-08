<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('location: index.php');
    exit;
}

// Vérification des champs
if(empty($_POST['titre']) || empty($_POST['categorie']) || empty($_POST['corps_de_texte'])) {
    header('Location:coaching.php?message=Veuillez remplir tous les champs.');
    exit();
}

//if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //$titre = $_POST['titre'];
    //$categorie = $_POST['categorie'];
    //$corps_de_texte = $_POST['corps_de_texte'];
    
    include('includes/db.php');

    $q = 'INSERT INTO event_post (titre, categorie, corps_de_texte, :date_event) 
        VALUES (:titre, :categorie, :corps_de_texte, :date_event)';
    $req = $bdd->prepare($q);    
    // Utilisez la variable $result pour exécuter la requête
    $result = $req->execute([
        'titre' => $_POST['titre'],
        'categorie' => $_POST['categorie'],
        'corps_de_texte' => $_POST['corps_de_texte'],
        'date_event' => $_POST['date_event']
    ]);



    // Utilisez $executionResult pour vérifier si l'exécution de la requête a réussi
    if ($result) {
        // Redirection vers la page de succès avec un message de confirmation
        header('Location: coaching.php?message=event publié avec succès.');
        exit;
    } else {
        // Si la requête a échoué, redirection vers la page de formulaire avec un message d'erreur
        header('Location: coaching.php?message=Erreur lors de la publication de l\'event.');
        exit;
    }
    
    var_dump($_POST); // Pour débogage. Affichez le contenu de $_POST avant les redirections.
//}
?>
