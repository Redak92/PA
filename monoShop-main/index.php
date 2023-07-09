<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.80.0">
    <title>Album example · Bootstrap v5.0</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    
    <style>
      .card {
        height: 100%;
      }
      .card-img {
        height: 200px;
        object-fit: cover;
      }
    </style>
  </head>
  <body>
  <?php
    include('include/header.php');
    ?>

    <main>
      <div class="album py-5 bg-light">
        <div class="container">
          <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 card-height">
            <?php
              try {
                $pdo = new PDO('mysql:host=localhost;port=3306;dbname=projet_annuel', 'root', 'root', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
              } catch (Exception $e) {
                die($e->getMessage());
              }

              $bdd = $pdo->query('SELECT * FROM produits')->fetchAll(PDO::FETCH_ASSOC);

              foreach ($bdd as $produit) {
            ?>
            <div class="col">
              <div class="card shadow-sm">
                <h3><?php echo $produit['nom'] ?></h3>
                <a href="product.php?id=<?php echo $produit['id']; ?>">
                  <img src="admin/<?php echo $produit['image'] ?>" class="card-img" alt="Image du produit">
                </a>

                <div class="card-body">
                  <form action="panier.php" method="post">
                    <div class="d-flex justify-content-between align-items-center">
                      <div class="btn-group">
                        <button type="submit" name="id" value="<?php echo $produit['id']; ?>" class="btn btn-sm btn-success" onclick="return confirmPurchase()">Ajouter au panier</button>
                      </div>
                      <small class="text" style="font-weight: bold;"><?php echo $produit['prix'] ?>€</small>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </main>

    

  </body>
</html>