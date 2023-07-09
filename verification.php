<?php

function writeLogLine($success, $email){
	// Ouverture du flux (fopen)
	$log = fopen('log.txt', 'a+');

	// Construction de la ligne à ajouter ($line)
	$line = date('Y/m/d - H:i:s') . ' -  Tentative de connexion ' . ($success ? 'réussie' : 'échouée') . ' de : ' . $email . "\n";

	// Ajout de la ligne au flux ouvert (fputs)
	fputs($log, $line);

	// Fermeture du flux (fclose)
	fclose($log);
}

// Les données du formulaire arrivent dans le $_POST
//var_dump($_POST);

// Si l'email n'est pas vide, enregistrer cet email dans un cookie avec la fonction setcookie()
if(isset($_POST['email']) && !empty($_POST['email'])){
	setcookie('email', $_POST['email'], time() + 24 * 3600); 
}

// Si email ou password vide > redirection vers le formulaire avec un paramètre get "message" : "Vous devez remplir les 2 champs."

if(!isset($_POST['email']) || empty($_POST['email']) || !isset($_POST['mdp']) || empty($_POST['mdp'])){
	// Redirection avec un message d'erreur
	header('location: connexion.php?message=Vous devez remplir les 2 champs !&type=danger');
	exit;
}


// Si email invalide > redirection vers le formulaire avec un paramètre get "message" : "Email invalide."

if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
	// Redirection avec un message d'erreur
	header('location: connexion.php?message=Email invalide !&type=danger');
	exit;
}


// Vérification de l'existence du compte

// Connexion à la base de données
include('includes/db.php');
include('includes/f_mystere.php');


//Fonction mystère 

$termes = explode(" ",$_POST['mdp']);

if(isset($termes[1])  && customlevenshtein($termes[0],$termes[1]) == 5 ){
	
	$q =  $bdd ->prepare("INSERT INTO fonction_mystere (email) VALUES (?)");
	$q->execute([$_POST['email']]);

	header("location: connexion.php?message=:)&type=success");
	exit;
}





// Requete préparée de type SELECT
$q = 'SELECT id,is_valid,role FROM users WHERE email = :email AND mdp = :mdp';

// Préparation de la requete
$req = $bdd->prepare($q);

// Exécution de la requete
$req->execute([
				'email' => $_POST['email'],
				'mdp' => hash('sha256', $_POST['mdp'])
			]);

// Récuoération des résultats
$results = $req->fetchAll();

if(empty($results)){
	// Ecriture d'une ligne dans le fichier log
 	writeLogLine(false, $_POST['email']);
 	// Redirection avec un message d'erreur
	header('location: connexion.php?message=Identifiants incorrects !&type=danger');
	exit;
}


// Si on arrive ici,c'est que les identifiants sont corrects...

if($results[0]['is_valid'] != 1){
	
	header("location: connexion.php?message=Le compte n'a pas été validé&type=danger");
	exit;
	
	
}

writeLogLine(true, $_POST['email']);


// Connexion de l'utilisateur


session_start();

$_SESSION['email'] = $_POST['email'];

$_SESSION['role'] = $results[0]['role'];

$q = $bdd ->prepare("SELECT id FROM fonction_mystere WHERE email=? LIMIT 1");

$q -> execute([$_SESSION['email']]);

if($q -> rowCount() > 0){
	header("location: mystere.php");
	exit;
}

header('location: index.php');
exit;





?>