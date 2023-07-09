<?php

// Connexion à la base de données pour les membres
try {
    $bdd_membre = new PDO('mysql:host=localhost;dbname=projet_annuel;charset=utf8;', 'root', 'root');
    $bdd_membre->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die($e->getMessage());
}

return [
    'pdo' => $bdd_membre,
    'bdd_membre' => $bdd_membre
];
?>
