<?php // Mejora 7 Clase PDFGenerator con composer : composer require setasign/fpdi-tcpdf
require_once 'vendor/tecnickcom/tcpdf/tcpdf.php';
require_once 'vendor/autoload.php';

use setasign\Fpdi\Tcpdf\Fpdi;

class PDFGenerator
{
    private $pdf;

    public function __construct()
    {
        $this->pdf = new Fpdi();
        $this->pdf->SetAutoPageBreak(true, 15);
        $this->pdf->SetMargins(10, 10, 10);
    }

    public function generateClientPDF($cli)
    {
        $this->pdf->AddPage();
        $this->pdf->SetFont('Helvetica', 'B', 16);
        $this->pdf->Cell(0, 10, 'Detalles del Cliente', 0, 1, 'C');
        $this->pdf->Ln(10);

        $this->pdf->SetFont('Helvetica', '', 12);
        $this->addClientDetail('ID', $cli->id);
        $this->addClientDetail('Nombre', $cli->first_name);
        $this->addClientDetail('Apellido', $cli->last_name);
        $this->addClientDetail('Email', $cli->email);
        $this->addClientDetail('Género', $cli->gender);
        $this->addClientDetail('Dirección IP', $cli->ip_address);
        $this->addClientDetail('Teléfono', $cli->telefono);

        // Refactorizable a metodo, Mejora 3
        $imagePath = "app/uploads/" . sprintf("%08d.jpg", $cli->id);
        if (!file_exists($imagePath)) {
            $imagePath = "https://robohash.org/" . $cli->id . "?size=250x250";
        }
        $this->pdf->Image($imagePath, 125, 33, 76, 100);

        $this->pdf->Output('cliente_' . $cli->id . '.pdf', 'D');
    }

    private function addClientDetail($label, $value)
    {
        $this->pdf->SetFont('Helvetica', 'B', 12);
        $this->pdf->Cell(40, 8, $label . ':', 0, 0);
        $this->pdf->SetFont('Helvetica', '', 12);
        $this->pdf->Cell(0, 8, $value, 0, 1);
    }
}
