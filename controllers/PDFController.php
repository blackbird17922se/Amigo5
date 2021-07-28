<?php
require_once('../vendor/autoload.php');
require_once('../models/pdf.php');

$idOrden = $_POST['idOrden'];
$html = getHtml($idOrden);
// $css = file_get_contents("../public/css/css/style.css");
// $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [70,150]]);
$mpdf = new \Mpdf\Mpdf();

// $mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
$mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);
$mpdf->Output("../pdf/pdf-".$idOrden.".pdf","F");