<?php
if (!isset($_POST['nom']) || empty($_POST['nom']) || !isset($_POST['description']) || empty($_POST['description']) || !isset($_POST['prix']) || empty($_POST['prix'])) {
    header('Location: add_pokemon.php?message=Veuillez remplir tous les champs.');
    exit;
}

include('db.php');

// Selection des pokemons de la base de données ayant le même nom que celui entré par l'utilisateur.
$q = 'SELECT * FROM produits WHERE nom = :nom';
$dmd = $bdd->prepare($q);
$dmd->execute([
    'nom' => $_POST['nom']
]);

// Pour stocker les images, on crée un répertoire "images" s'il n'existe pas.
if (!file_exists('photo')) {
    mkdir('photo');
}

// On récupère l'emplacement temporaire du fichier grâce à la superglobale $_FILES.
$source = $_FILES['image']['tmp_name'];

$tableau = explode('.', $_FILES['image']['name']);
$extension = end($tableau);
$nomFichier = 'image' . time() . '.' . $extension;

$destination = 'photo/' . $nomFichier;

$move = move_uploaded_file($source, $destination);

$a = "SELECT * FROM produits WHERE nom = :nom";
// Requête
$re = $bdd->prepare($a); // Préparation de la requête
$re->execute([
    'nom' => $_POST['nom'],
]);

$q = "INSERT INTO produits (nom, description, prix, image) 
VALUES (:nom, :description, :prix, :image)";
// Requête
$req = $bdd->prepare($q); // Préparation de la requête
$req->execute([
    'nom' => $_POST['nom'],
    'description' => $_POST['description'],
    'prix' => $_POST['prix'],
    'image' => $destination,
]);
?>
