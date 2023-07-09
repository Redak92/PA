<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un produit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>
<body>
<?php
    include('../include/header.php');
    ?>
<main>
    <div class="container">
        <h1>Ajouter un produit</h1>
    </div>

    <div class="container">
        <form method="POST" action="verif.php" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" name="nom" class="form-control" id="nom" placeholder="Nom" required>
            </div>
            <div class="mb-3">
                <label for="prix" class="form-label">Prix</label>
                <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="text" name="prix" class="form-control" id="prix" placeholder="Prix" required>
                    <span class="input-group-text">.00</span>
                </div>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" name="description" id="description" placeholder="Description" required></textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" class="form-control" name="image" id="image" accept="image/jpeg, image/png, image/gif" required>
            </div>
            <input type="submit" value="Ajouter au catalogue" class="btn btn-primary">
        </form>
    </div>
</main>

</body>
</html>
