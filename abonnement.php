<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('location: index.php');
    exit;
}
include('includes/db.php');
if(isset($_GET['message'])) {
    echo $_GET['message'];
}
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include('includes/header.php') ?>
    <title>Abonnement</title>
</head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
<style>
    .hip_to_be_square {
        display: flex;
        flex-direction: column;
        align-items: center;
        height: 500px;
        background-color: grey;
        justify-content: center;
        text-align: center;
    }
</style>

<body>
    <div class="container">
        <h1>ABONNEMENT TA RACE!</h1>

        <div class="hip_to_be_square">
            <p>Souscrivez à notre abonnement pour accéder à nos services exclusifs tels que le service voiturier, SPA et autre.</p>
            <p>Prix : 2000.00,00 € hors taxe</p> 
            <button class="btn btn-primary">Souscrire</button>
        </div>
    </div>
</body>
<footer>
    <?php include('includes/footer.php') ?>
</footer>
</html>
