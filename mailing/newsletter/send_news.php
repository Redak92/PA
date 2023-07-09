<?php



/* Faire les vérifs */


include("../../includes/phpmailer.php");
include("../../includes/db.php");

$q = $bdd->prepare("SELECT email FROM emails_newsletter");

$q -> execute([]);

$data = $q->fetchAll();



foreach($data as $value){
    sendmail($_POST['content'],$_POST['objet'],$value['email']);
}




header("location: ../../index.php");
exit;