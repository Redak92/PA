<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: index.php');
    exit;
}

include('includes/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $id_user = $_SESSION['user_id'];
    $id_event = $_POST['id_event'];
    $date = date('Y-m-d H:i:s');

    $queryEvent = "SELECT id_event FROM event_post WHERE id_event = :id_event";
    $stmtEvent = $bdd->prepare($queryEvent);
    $stmtEvent->bindParam(':id_event', $id_event);
    $stmtEvent->execute();
    $eventExists = $stmtEvent->rowCount();

    if ($eventExists) {
        // Récupération de l'ID de l'utilisateur à partir de la session email
        $email = $_SESSION['email'];
        $queryUser = "SELECT id FROM users WHERE email = :email";
        $stmtUser = $bdd->prepare($queryUser);
        $stmtUser->bindParam(':email', $email);
        $stmtUser->execute();
        $user = $stmtUser->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            $id_user = $user['id'];

            // Insertion de l'inscription dans la table event_subs
            $query = "INSERT INTO event_subs (id_user, id_event, date) VALUES (:id_user, :id_event, :date)";
            $stmt = $bdd->prepare($query);
            $stmt->bindParam(':id_user', $id_user);
            $stmt->bindParam(':id_event', $id_event);
            $stmt->bindParam(':date', $date);

            if ($stmt->execute()) {
                // Redirection vers la page de l'événement avec un message de succès
                header("Location: event.php?id_event=$id_event&success=1");
                exit;
            } else {
                // Redirection vers la page de l'événement avec un message d'erreur
                header("Location: event.php?id_event=$id_event&error=1");
                exit;
            }
        } else {
            echo "Utilisateur introuvable.";
        }
    } else {
        echo "L'événement demandé n'existe pas.";
    }
} else {
    // Redirection vers la page d'accueil si la requête n'est pas de type POST
    header('Location: index.php');
    exit;
}
?>
