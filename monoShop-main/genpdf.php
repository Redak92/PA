<?php
use Dompdf\Dompdf;
use Dompdf\Options;

require_once 'admin/db.php';

$sql = 'SELECT * FROM users';

$query = $db->query($sql);

$users = $query->fetchAll();

var_dump($users); // "V" en minuscule pour var_dump
die; // "d" en minuscule pour die

require_once 'include/dompdf/autoload.inc.php';

$options = new Options();
$options->set('defaultFont', 'courier');

$dompdf = new Dompdf($options);

$dompdf->loadHtml('happy');

$dompdf->setPaper('A4', 'portrait');

$dompdf->render();

$fichier = 'mon-pdf.pdf';
$dompdf->stream($fichier);
?>
