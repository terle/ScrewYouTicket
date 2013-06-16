<?php

// Include the main TCPDF library (search for installation path).
require_once('/Users/terle/git/screwyouticket/Web/pdfGenerating/tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Powered by Pixel');
$pdf->SetTitle('First Test pdf');
$pdf->SetSubject('Ticket pdf');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// NOTE: 2D barcode algorithms must be implemented on 2dbarcode.php class file.

// set font
$pdf->SetFont('helvetica', '', 11);

// add a page
$pdf->AddPage();

// print a message
// Set some content to print
$html = <<<EOD
<h1>Test pdf!</h1>
<i>Dette er skrevet i HTML med TCPDF library.</i>
<h2>Her kan står en masse skrammel.</h2>
<p>Det kan styles i HTML (GO TUE!!!)</p>
<p>Tak for at læse</p>
EOD;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
$pdf->SetFont('helvetica', '', 10);


// new style
$style = array(
    'border' => 6,
    'padding' => 'auto',
    //'fgcolor' => array(0,0,255),
    //'bgcolor' => array(255,255,64)
);


// QRCODE,H : QR-CODE Best error correction
//$pdf->write2DBarcode('www.randomwebsite.com/', 'QRCODE,H', 100, 20, 50, 50, $style, 'N');
$pdf->write2DBarcode('www.randomwebsite.com/', 'QRCODE,H', 80, 80, 50, 50, $style, 'N');
$pdf->Text(80, 140, 'QRCODE H - Til RandomWebsite.com');

/*
// new style
$style = array(
    'border' => false,
    'padding' => 0,
    'fgcolor' => array(128,0,0),
    'bgcolor' => false
);
*/
// QRCODE,H : QR-CODE Best error correction
//$pdf->write2DBarcode('www.tcpdf.org', 'QRCODE,H', 140, 210, 50, 50, $style, 'N');
//$pdf->Text(140, 205, 'QRCODE H - NO PADDING');

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_050.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
 