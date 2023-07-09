<!doctype html>
<html lang="fr">
  <head>
    <!-- ... your head content ... -->
    <title>Product Detail</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
  <header>
  <?php include('include/header.php'); ?>
  </header>

  <main>
    <div class="container py-5">
      <?php
        // Get the product id from the URL
        $productId = $_GET['id'] ?? '';

        // Connect to the database and fetch product information
        try {
          $pdo = new PDO('mysql:host=localhost;port=3306;dbname=projet_annuel', 'root', 'root', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

          $stmt = $pdo->prepare('SELECT * FROM produits WHERE id = ?');
          $stmt->execute([$productId]);
          $produit = $stmt->fetch(PDO::FETCH_ASSOC);

          if ($produit) {
            // Display product details
            echo '<div class="card mb-3" style="max-width: 540px;">';
            echo '<div class="row no-gutters">';
            echo '<div class="col-md-4">';
            echo '<img src="admin/'.$produit['image'].'" class="card-img" alt="Image du produit">';
            echo '</div>';
            echo '<div class="col-md-8">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">'.$produit['nom'].'</h5>';
            echo '<p class="card-text">'.$produit['description'].'</p>'; // Assuming 'description' is the column name for product description in your 'produits' table
            echo '<p class="card-text"><small class="text-muted">Prix: '.$produit['prix'].'€</small></p>';
            echo '</div></div></div></div>';
          } else {
            echo '<p>Produit non trouvé.</p>';
          }

        } catch (Exception $e) {
          die($e->getMessage());
        }
      ?>
    </div>
  </main>

  <!-- your footer content... -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
