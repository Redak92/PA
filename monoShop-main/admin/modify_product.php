<!DOCTYPE html>
<html>
<head>
  <title>Liste des produits</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.0/css/bootstrap.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <style>
  .bd-placeholder-img {
    font-size: 1.125rem;
    text-anchor: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    user-select: none;
  }

  @media (min-width: 768px) {
    .bd-placeholder-img-lg {
      font-size: 3.5rem;
    }
  }
  .search-bar {
      border: 1px solid #bdbdbd;
      border-radius: 25px;
      background-color: #fff;
      width: 60%;
      height: 50px;
      margin: 0 auto;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .search-bar input[type="search"] {
      width: 90%;
      border: none;
      height: 100%;
      font-size: 1.2em;
      padding-left: 20px;
    }

    .search-bar button {
      border: none;
      background: none;
      color: #888;
      font-size: 1.2em;
      cursor: pointer;
    }

    .search-bar button:hover {
      color: #666;
    }
</style>

</head>
<body>
<?php include('../include/header.php'); ?>
</header>

<div class="search-bar" id="searchForm">
    <input type="search" placeholder="Nom du produit" aria-label="Search" name="nom" id="searchInput">
    <button type="submit"><i class="fas fa-search"></i></button>
  </div>
<div class="container">
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th>Nom</th>
            <th>Prix</th>
            <th>Description</th>
            <th>Image</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
        // Connexion à la base de données
        try {
            $bdd = new PDO('mysql:host=localhost;dbname=projet_annuel', 'root', 'root');
            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Erreur de connexion : " . $e->getMessage();
        }

        // Récupérer les produits depuis la base de données
        $query = 'SELECT * FROM produits';
        $stmt = $bdd->query($query);
        $produits = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($produits as $produit) {
        ?>
            <tr>
                <td><?php echo $produit['nom']; ?></td>
                <td><?php echo $produit['prix']; ?>€</td>
                <td><?php echo $produit['description']; ?></td>
                <td><img src="<?php echo $produit['image']; ?>" alt="Image du produit" width="100"></td>
                <td>
                    <a href="modifier.php?id=<?php echo $produit['id']; ?>" class="btn btn-info">Modifier</a>
                    <a href="delete.php?id=<?php echo $produit['id']; ?>"
                       onclick="return confirm('Voulez-vous vraiment supprimer le produit ?');"
                       class="btn btn-danger">Supprimer</a>
                </td>
            </tr>
        <?php
        }
        ?>
        </tbody>
    </table>
</div>
<script>
$(document).ready(function() {
  $('#searchInput').on('input', function() {
    var searchQuery = $(this).val();

    $.ajax({
      url: 'rechercher_produit.php',
      method: 'GET',
      data: { nom: searchQuery },
      success: function(response) {
        // Effacer la table actuelle
        $('table tbody').empty();

        // Parcourir la réponse et ajouter chaque produit à la table
        $.each(response, function(index, produit) {
          var row = $('<tr>');
          row.append('<td>' + produit.nom + '</td>');
          row.append('<td>' + produit.prix + '€</td>');
          row.append('<td>' + produit.description + '</td>');
          row.append('<td><img src="' + produit.image + '" alt="Image du produit" width="100"></td>');
          row.append('<td><a href="modifier.php?id=' + produit.id + '" class="btn btn-info">Modifier</a> <a href="delete.php?id=' + produit.id + '" onclick="return confirm(\'Voulez-vous vraiment supprimer le produit ?\');" class="btn btn-danger">Supprimer</a></td>');
          $('table tbody').append(row);
        });
      },
      error: function(xhr, status, error) {
        alert('Une erreur est survenue lors de la recherche.');
      }
    });
  });
});
</script>



</body>
</html>
