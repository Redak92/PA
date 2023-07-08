<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['email'])) {
    header('location: index.php');
    exit;

}
// Inclure le fichier de connexion à la base de données
include('includes/db.php');

// Récupérer l'identifiant de l'utilisateur à partir de l'URL
if (isset($_GET['user_id'])) {
    $userId = $_GET['user_id'];

    // Requête pour récupérer les informations de l'utilisateur
    $query = 'SELECT email, nom, prenom, role, age, image FROM users WHERE id = :user_id';
    $stmt = $bdd->prepare($query);
    $stmt->bindParam(':user_id', $userId);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifier si l'utilisateur existe
    if ($user) {
        // Inclure le fichier d'en-tête
        include('includes/header.php');
        ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

        <h1>Profil de <?php echo $user['prenom'] . ' ' . $user['nom']; ?></h1>
        <img src="uploads/<?= $user['image'] ?>" alt="profil" style="width: 100px; height: 100px">
        <p>Email: <?php echo $user['email']; ?></p>
        <p>Âge: <?php echo $user['age']; ?></p>
        <p>Rôle: <?php echo $user['role']; ?></p>

        <?php
        // Inclure le fichier de pied de page
        include('includes/footer.php');
    } else {
        echo "L'utilisateur demandé n'existe pas.";
    }
} else {
    echo "Aucun identifiant d'utilisateur spécifié.";
}

?>

