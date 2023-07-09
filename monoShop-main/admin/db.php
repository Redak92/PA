<?php
try {
    $bdd = new PDO('mysql:host=localhost;dbname=projet_annuel', 'root', 'root');
} catch (Exception $e) {
    die('Erreur: ' . $e->getMessage());
}
?>