<?php
session_start();

if(!isset($_SESSION['email'])){
    header("/PA/PA/");
    exit;
}


?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<header class="mb-4">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link <?= $title == 'Accueil' ? 'active' : '' ?>" href="/PA/PA/monoShop-main/index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/PA/PA/">Index</a>
                    </li>
                  <?php  if($_SESSION['role'] == 'admin'){
                    echo '
                    <li class="nav-item">
                        <a class="nav-link" href="/PA/PA/monoShop-main/admin/modify_product.php">Modifier</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/PA/PA/monoShop-main/admin/index.php">Ajouter</a>
                    </li>';}
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/PA/PA/monoShop-main/panier.php">Panier</a>
                    </li>
                  
                    
                    
                </ul>
            </div>
        </div>
    </nav>
</header>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
