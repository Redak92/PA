<?php

session_start();

require('fpdf186/fpdf.php');


class PDF extends FPDF
{
    // En-tête
    function Header()
    {
        // Logo
        $this->Image('logo.png',10,6,30);
        // Police Arial gras 15
        $this->SetFont('Arial','B',15);
        // Décalage à droite
        $this->Cell(80);
        // Titre
        $this->Cell(30,10,'Facture',1,0,'C');
        // Saut de ligne
        $this->Ln(20);
    }

    // Pied de page
    function Footer()
    {
        // Positionnement à 1,5 cm du bas
        $this->SetY(-15);
        // Police Arial italique 8
        $this->SetFont('Arial','I',8);
        // Numéro de page
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
}

// Instanciation de la classe dérivée
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);

// Définir les en-têtes de colonnes pour les détails de la facture
$pdf->Cell(60, 10, 'Nom du produit', 1);
$pdf->Cell(40, 10, 'Prix', 1);
$pdf->Cell(30, 10, 'Quantite', 1);
$pdf->Cell(50, 10, 'Total', 1);
$pdf->Ln();

// Ajouter chaque produit dans les détails de la facture
foreach ($_SESSION['facture'] as $id => $details) {
    $pdf->Cell(60, 10, $details['nom'], 1);
    $pdf->Cell(40, 10, $details['prix'], 1);
    $pdf->Cell(30, 10, $details['quantite'], 1);
    $pdf->Cell(50, 10, $details['prix'] * $details['quantite'], 1);
    $pdf->Ln();
}

// Ajouter le total général
$pdf->Cell(130, 10, utf8_decode('Total général'), 1);
$pdf->Cell(50, 10, $_SESSION['total'], 1);

$pdf->Output('D', 'Facture.pdf');
?>