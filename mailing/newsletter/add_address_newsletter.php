<?php


if(!isset($_POST['email'])){
	// Redirection avec un message d'erreur
	header('location: ../../index.php?message=Vous devez remplir les 2 champs !&type=danger');
	exit;
}


// Si email invalide > redirection vers le formulaire avec un paramètre get "message" : "Email invalide."

if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){

	header('location: ../../index.php?message=Email invalide !&type=danger');
	exit;
}


include("../../includes/db.php");

$q = $bdd -> prepare("SELECT id FROM emails_newsletter WHERE email = ?");

$q -> execute([$_POST['email']]);



if($q -> rowCount() != 0){
	
	header("location: ../../index.php?message=Email déjà ajouté&type=danger");
	exit;
}


$q = $bdd->prepare("INSERT INTO emails_newsletter (email) VALUES (?)");

$q -> execute([$_POST['email']]);


header('location: ../../index.php?message=Email ajouté&type=success');
exit;