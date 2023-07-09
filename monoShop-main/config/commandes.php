<!DOCTYPE html>
<html>
  <head>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.0/css/bootstrap.min.css%22%3E">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet" type="text/css">
</head>
div class="order-md-2 mt-3 mt-md-0">
            <a href="add_products.php" class="btn btn-custom">Add New Product</a>
            </div>
</div>


    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th>id</th>
            <th>nom</th>
            <th>Prix</th>
            <th>description</th>
           
            <th>Image</th>
            <th>Action</th>
        </tr>
        </thead>

        <tbody>
       
       <?php
        //connexion bdd
        try{
            $pdo = new PDO('mysql:host=localhost;port=3306;dbname=monoshop', 'root', 'root', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        } catch (Exception $e) {
            die($e->getMessage());
        }
        $bdd = $pdo->query('SELECT * FROM produits')->fetchAll(PDO::FETCH_ASSOC);
        foreach ($bdd as $produits) {
        ?>
                <tr>
                <td><?php echo $produits['id'] ?></td>
                <td><?php echo $produits['nom'] ?></td>
                <td><?php echo $produits['prix'] ?>€</td>
                <td><?php echo $produits['description'] ?>%</td>
                <td><?php echo $produits['image'] ?></td>
                <td>



                
                    <a href="modify_product.php?id=<?php echo $produits['id'] ?>" class="btn btn-info">Modify</a>
                    <a href="delete_product.php?id=<?php echo$produits['id'] ?>"
                       onclick="return confirm('Do you really want to delete <?php echo $produits['name'] ?>');"
                       class="btn btn-danger">Delete</a>
                </td>
                </tr>
            
            <?php
            }
            ?>
        </tbody>
    </table>
</div>


</body>
</html>