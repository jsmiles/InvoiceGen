<?php

require __DIR__ . "/vendor/autoload.php";

use Dompdf\Dompdf;
use Dompdf\Options;

$company = $_POST["company"];
$street = $_POST["street"];
$city = $_POST["city"];
$product = $_POST["product"];
$price = $_POST["price"];

$options = new Options;
$options->setChroot(__DIR__);
$options->setIsRemoteEnabled(true);

$dompdf = new Dompdf($options);
$dompdf->setPaper("A4");

$html = file_get_contents("template.html");
$html = str_replace(["{{ company }}","{{ street }}", "{{ city }}", "{{ product }}", "{{ price }}"], [$company, $street, $city, $product, $price], $html);

$dompdf->loadHtml($html);
$dompdf->render();
$dompdf->addInfo("Title", "An Example PDF"); 
$dompdf->stream("invoice.pdf", ["Attachment" => 0]);

$output = $dompdf->output();
file_put_contents("file.pdf", $output);