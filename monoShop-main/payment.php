<?php
session_start();
// ...
?>

<!DOCTYPE html>
<html>
<head>
    <!-- Vos balises <head> ici -->
</head>
<body>
    <?php
    // Afficher le message d'erreur s'il existe
    if (isset($_SESSION['message'])) {
        echo '<div class="alert alert-danger" role="alert">
                ' . $_SESSION['message'] . '
              </div>';

        // Supprimer le message de la session
        unset($_SESSION['message']);
    }
    ?>

    <!-- Le reste de votre contenu HTML ici -->

</body>
</html>
