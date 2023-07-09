<?php
//connexion bdd
try {
  $pdo = new PDO('mysql:host=localhost;port=3306;dbname=projet_annuel', 'root', 'root', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (Exception $e) {
  die($e->getMessage());
}

$searchText = $_POST['search'];
$query = $pdo->prepare('SELECT * FROM produits WHERE nom LIKE :searchText');
$query->execute(['searchText' => '%' . $searchText . '%']);
$results = $query->fetchAll(PDO::FETCH_ASSOC);

if (!empty($results)) {
  foreach ($results as $produit) {
    echo '<div class="search-result">';
    echo '<h3>' . $produit['nom'] . '</h3>';
    echo '<p>' . implode(' ', array_slice(explode(' ', $produit['description']), 0, 20)) . '...</p>';
    echo '</div>';
  }
} else {
  echo '<p>Aucun résultat trouvé.</p>';
}
?>
