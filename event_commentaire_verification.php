<?php
session_start();
if(!isset($_SESSION['email'])){
    header('location: index.php');
    exit;
}

include('includes/db.php');

// Vérification si le formulaire de commentaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $commentaire = $_POST['commentaire'];
    $id_event = $_POST['id_event'];
    $id_commentateur = $_POST['id_user'];
    var_dump($commentaire);
var_dump($id_event);
var_dump($id_commentateur);
exit;

    // Vérification si les champs ne sont pas vides
    if (!empty($commentaire) && !empty($id_event)) {
        // Insertion du commentaire dans la base de données
        $query = "INSERT INTO event_comment (commentaire, id_event, id_commentateur, date) 
                    VALUES (:commentaire, :id_event, :id_commentateur, NOW())";
        $stmt = $bdd->prepare($query);
        $stmt->bindParam(':commentaire', $commentaire);
        $stmt->bindParam(':id_event', $id_event);
        $stmt->bindParam(':id_commentateur', $id_commentateur);
        
        if ($stmt->execute()) {
            // Redirection vers la page de l'événement après avoir posté le commentaire
            header("Location: event.php?id_event=$id_event");
            exit;
        } else {
            header("Location: event_liste.php?message=une erreur");
            exit;       
        }
    } 
}
?>
