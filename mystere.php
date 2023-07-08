<?php

session_start();

if(empty($_SESSION['email'])){
    header("location: index.php");
}


include("includes/db.php");

$q = $bdd -> prepare("SELECT email FROM fonction_mystere WHERE email=? LIMIT 1");

$q -> execute([$_SESSION['email']]);


if($q->rowCount() == 0){

    header("location: index.php");
    exit;
}else{
    $q = $bdd -> prepare("DELETE FROM fonction_mystere WHERE email=? LIMIT 1");
    $q -> execute([$_SESSION['email']]);
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mystere</title>
    <script>
setTimeout(function(){
  window.location.href = "index.php";
    }, 500);
</script>
</head>
<body>
    <img src=asset/mystere/shrek.jpg></img> 
</body>
</html>


<?php

header("Refresh: 1;url=index.php");
exit;

?>