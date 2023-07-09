<?php
// Vérifier si l'ID du produit à supprimer a été passé en tant que paramètre dans l'URL
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Connexion à la base de données
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=projet_annuel', 'root', 'root');
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Erreur de connexion : " . $e->getMessage();
        exit(); // Quitter le script en cas d'erreur de connexion
    }

    // Requête pour supprimer le produit de la base de données
    $query = "DELETE FROM produits WHERE id = :id";
    $stmt = $bdd->prepare($query);
    $stmt->bindParam(':id', $product_id);

    // Exécuter la requête de suppression
    if ($stmt->execute()) {
        echo "Le produit a été supprimé avec succès.";
        header("location: modify_product.php");
        exit(); // Quitter le script après la redirection
    } else {
        echo "Erreur lors de la suppression du produit : " . $stmt->errorInfo()[2];
    }
}
?>
