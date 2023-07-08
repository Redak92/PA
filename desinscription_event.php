<?php
session_start();
if(!isset($_SESSION['email'])){
    header('location: index.php');
    exit;
}

include('includes/db.php');

// Vérification si le formulaire de désinscription a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération de l'ID de l'événement depuis le formulaire
    $id_event = $_POST['id_event'];

    // Vérification si l'ID de l'événement n'est pas vide
    if (!empty($id_event)) {
        // Récupération de l'ID de l'utilisateur à partir de son email
        $queryUser = 'SELECT id FROM users WHERE email = :email';
        $stmtUser = $bdd->prepare($queryUser);
        $stmtUser->bindParam(':email', $_SESSION['email']);
        $stmtUser->execute();
        $user = $stmtUser->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $userId = $user['id'];

            // Suppression de l'inscription de l'utilisateur à l'événement
            $query = "DELETE FROM event_subs WHERE id_event = :id_event AND id_user = :id_user";
            $stmt = $bdd->prepare($query);
            $stmt->bindParam(':id_event', $id_event);
            $stmt->bindParam(':id_user', $userId);
            
            if ($stmt->execute()) {
                // Redirection vers la page de l'événement après la désinscription
                header("Location: event.php?id_event=$id_event");
                exit;
            } else {
                echo "Une erreur s'est produite lors de la désinscription de l'événement.";
            }
        } else {
            echo "Utilisateur introuvable.";
        }
    } else {
        echo "L'ID de l'événement n'a pas été spécifié.";
    }
} else {
    echo "Le formulaire de désinscription n'a pas été soumis.";
}
?>
