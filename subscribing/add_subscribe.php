<?php


// if(empty($_SESSION['email'])){
//     header("location: ../index.php");
//     exit;
// }


include("../includes/db.php");


$check_sub = $bdd -> prepare("SELECT date_fin FROM user_has_subscribing WHERE email=? ORDER BY date_fin DESC LIMIT 1");

$check_sub->execute(['bastienguibert98@gmail.com']);

$results = $check_sub -> fetch(PDO::FETCH_ASSOC);

function writeLogLine($success, $email){
	// Ouverture du flux (fopen)
	$log = fopen('log.txt', 'a+');

	// Construction de la ligne à ajouter ($line)
	$line = date('Y/m/d - H:i:s') .  ($success ? '  Inscription à l\'abonnement ' : '  Renouvellement de l\'abonnement').' de ' . $email . "\n";

	// Ajout de la ligne au flux ouvert (fputs)
	fputs($log, $line);

	// Fermeture du flux (fclose)
	fclose($log);
}




if($check_sub->rowCount() == 0){
    $q = $bdd -> prepare("INSERT INTO user_has_subscribing (email, date_fin) VALUES (?,?)");
    $q -> execute(['bastienguibert98@gmail.com',date('Y-m-d', strtotime('+1 month'))]);
    writeLogLine(True,'bastienguibert98@gmail.com');
    header('location: ../index.php');
    exit;
}




$date = $results['date_fin'];
$date = new DateTime($date);

$date->modify('+1 month');

$newDate = $date->format('Y-m-d');

$update = $bdd -> prepare("UPDATE user_has_subscribing SET date_fin = ? WHERE email=?");

$update ->execute([$newDate,'bastienguibert98@gmail.com']);

writeLogLine(False,'bastienguibert98@gmail.com');

echo "Done";

?>  

