<?php
header('Content-Type: application/json');
$nom = $_GET['nom'];

try {
    $bdd = new PDO('mysql:host=localhost;dbname=projet_annuel', 'root', 'root');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}

$query = $bdd->prepare('SELECT * FROM produits WHERE nom LIKE ?');
$query->execute([$nom.'%']);
$produits = $query->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($produits);
?>
