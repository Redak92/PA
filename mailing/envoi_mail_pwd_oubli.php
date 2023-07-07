<?


if(empty($_POST['email'])){
	header("location: index.php");
}


include("../includes/db.php");
include("../includes/phpmailer.php");

$q = $bdd -> prepare("SELECT confirm_key FROM users WHERE email=?");

$q -> execute([$_POST['email']]);

$q = $q->fetchAll();

$message = "Bonjour, changez votre mot de passe avec ce lien : 127.0.0.1/site finale/mailing/verif_pwd.php?key=".$q[0][0];
$objet = "Changement de mot de passe jib-sports";
$destinataire = $_POST['email'];

sendmail($message,$objet,$destinataire);

header("location: ../connexion.php?message=Un email a été envoyé pour réintinialiser votre mot de passe&type=success");
exit;


?>