<?php
// include 2D barcode class (search for installation path)
//require_once(dirname(__FILE__).'/examples/barcodes/tcpdf_barcodes_2d_include.php');
require_once('/Users/terle/git/screwyouticket/Web/pdfGenerating/tcpdf//examples/barcodes/tcpdf_barcodes_2d_include.php');

// set the barcode content and type
$barcodeobj = new TCPDF2DBarcode('http://www.tcpdf.org', 'QRCODE,H');

// output the barcode as PNG image
$barcodeobj->getBarcodePNG(6, 6, array(0,0,0));