<?php
// Vérifier si l'ID du produit à modifier a été passé en tant que paramètre dans l'URL
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Connexion à la base de données
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=projet_annuel', 'root', 'root');
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Erreur de connexion : " . $e->getMessage();
    }

    // Récupérer les détails du produit à partir de la base de données
    $query = "SELECT * FROM produits WHERE id = :id";
    $stmt = $bdd->prepare($query);
    $stmt->bindParam(':id', $product_id);
    $stmt->execute();
    $produit = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifier si le formulaire de modification a été soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Récupérer les nouvelles valeurs du produit à partir du formulaire
        $new_nom = $_POST['nom'];
        $new_prix = $_POST['prix'];
        $new_description = $_POST['description'];

        // Vérifier si un nouveau fichier d'image a été téléchargé
        if ($_FILES['image']['name']) {
            // Chemin du dossier de destination des images
            $upload_directory = "photo/";

            // Informations sur le fichier image téléchargé
            $file_name = $_FILES['image']['name'];
            $file_tmp = $_FILES['image']['tmp_name'];
            $file_size = $_FILES['image']['size'];
            $file_error = $_FILES['image']['error'];

            // Vérifier si le fichier a été téléchargé avec succès
            if ($file_error === UPLOAD_ERR_OK) {
                // Générer un nom de fichier unique pour éviter les conflits
                $file_destination = $upload_directory . uniqid() . '_' . $file_name;

                // Déplacer le fichier téléchargé vers le dossier de destination
                if (move_uploaded_file($file_tmp, $file_destination)) {
                    // Mettre à jour le chemin de l'image dans la base de données
                    $update_image_query = "UPDATE produits SET image = :image WHERE id = :id";
                    $update_image_stmt = $bdd->prepare($update_image_query);
                    $update_image_stmt->bindParam(':image', $file_destination);
                    $update_image_stmt->bindParam(':id', $product_id);
                    $update_image_stmt->execute();
                } else {
                    echo "Erreur lors du téléchargement de l'image.";
                }
            } else {
                echo "Erreur lors du téléchargement de l'image : " . $file_error;
            }
        }

        // Mettre à jour les autres valeurs du produit dans la base de données
        $update_query = "UPDATE produits SET nom = :nom, prix = :prix, description = :description WHERE id = :id";
        $update_stmt = $bdd->prepare($update_query);
        $update_stmt->bindParam(':nom', $new_nom);
        $update_stmt->bindParam(':prix', $new_prix);
        $update_stmt->bindParam(':description', $new_description);
        $update_stmt->bindParam(':id', $product_id);

        if ($update_stmt->execute()) {
            echo "Le produit a été modifié avec succès.";
            // Rediriger vers la page de liste des produits
            header("Location: modify_product.php");
            exit();
        } else {
            echo "Erreur lors de la modification du produit : " . $update_stmt->errorInfo()[2];
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Modifier un produit</title>
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
  <style>
    .container {
      max-width: 500px;
      margin-top: 50px;
    }
  </style>
</head>
<body>
    <header>
    <?php include('../include/header.php'); ?>
</header>
  <div class="container">
    <h2>Modifier un produit</h2>
<form action="modifier.php?id=<?php echo $produit['id']; ?>" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="nom" class="form-label">Nom</label>
        <input type="text" class="form-control" id="nom" name="nom" value="<?php echo $produit['nom']; ?>">
    </div>
    <div class="mb-3">
        <label for="prix" class="form-label">Prix</label>
        <input type="number" class="form-control" id="prix" name="prix" value="<?php echo $produit['prix']; ?>">
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" name="description"><?php echo $produit['description']; ?></textarea>
    </div>
    <div class="mb-3">
        <label for="image" class="form-label">Image</label>
        <input type="file" class="form-control" id="image" name="image">
    </div>
    <button type="submit" class="btn btn-primary">Modifier</button>
</form>
</body>
</html>
