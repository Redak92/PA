<?php


if(!isset($_POST['email'])){
	// Redirection avec un message d'erreur
	header('location: formulaire_newsletter.php?message=Vous devez remplir les 2 champs !&type=danger');
	exit;
}


// Si email invalide > redirection vers le formulaire avec un paramètre get "message" : "Email invalide."

if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){

	header('location: formulaire_newsletter.php?message=Email invalide !&type=danger');
	exit;
}


include("../../includes/db.php");

$q = $bdd->prepare("INSERT INTO emails_newsletter (email) VALUES (?)");

$q -> execute([$_POST['email']]);


header('location: formulaire_newsletter.php?message=Email ajouté&type=success');
exit;