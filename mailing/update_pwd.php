<?php 

//Penser à rajouter les vérifications des champs


    try{
		include("../includes/db.php");

    }catch (Exception $e) {
        
		header("location: ../index.php");
		exit;
    }
	


$q = $bdd->prepare("UPDATE users SET mdp = ? WHERE confirm_key = ?");

$q-> execute([hash("sha256",$_POST["pwd"]),$_POST['key']]);




$q_id = $bdd->prepare("SELECT id FROM users WHERE confirm_key=?");
$q_id->execute([$_POST['key']]);
$data = $q_id->fetchAll();



$key = "";
	for($i=1;$i < 12;$i++){

    $key .= mt_rand(0,9);

  
}

$key .= $data[0]['id'];


$q = $bdd->prepare("SELECT * FROM users WHERE confirm_key = ?");

$q->execute([$_POST['key']]);

$user = $q->fetch();

$last = $bdd -> prepare("UPDATE users SET confirm_key=? WHERE email=?");
$last->execute([$key,$user['email']]);


header("location: ../connexion.php?message=Le mot de passe a bien été réinitialisé&type=success");
exit;