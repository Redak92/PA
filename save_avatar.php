<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('location: index.php');
    exit;
}

include('includes/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_SESSION['email'];
    $avatarData = $_POST['avatar-input'];

    // Créer un nom de fichier unique pour l'avatar
    $fileName = uniqid('avatar_') . time() . '.' . '.png';

    // Chemin du dossier de destination pour les avatars créés
    $destinationFolder = 'uploads/';

    // Chemin complet du fichier de destination
    $destinationPath = $destinationFolder . $fileName;

    // Convertir les données de l'avatar en image PNG et enregistrer le fichier
    //ça merde ici, enlever base64 et faire en sorte que l'image à le même que celui enregistrer dans la table
    $imageData = str_replace('data:image/png;base64,', '', $avatarData);
    $imageData = str_replace(' ', '+', $imageData);
    $imageData = base64_decode($imageData);
    file_put_contents($destinationPath, $imageData);

    // Insérer le chemin de l'avatar dans la colonne 'image' de la table 'users'
    $insertQuery = "UPDATE users SET image = :image WHERE email = :email";
    $req = $bdd->prepare($insertQuery);
    $result = $req->execute([
        'image' => $fileName,
        'email' => $email
    ]);



    if ($result) {
        header('location:profile.php?message=Avatar enregistré avec succès.');
        exit;

        // Rafraîchir la variable de session avec le nouveau chemin de l'image
        $_SESSION['image'] = $destinationPath;
    } else {
        echo 'Une erreur s\'est produite lors de l\'enregistrement de l\'avatar.';
    }
}
?>
