<?php
if(isset($_POST['invoice'])){
  $selected_val = $_POST['invoice'];  
  $val_id = substr($selected_val, 0, 1);
  $invoice_pdo = new PDO('sqlite:db.sqlite');
  $inovice_statement = $invoice_pdo->query("SELECT * FROM invoices WHERE id = " . $val_id);
  $inovice_statement->execute();
  $res = $inovice_statement->fetch(PDO::FETCH_ASSOC);
  $company = $res["company"];
  $street = $res["street"];
  $city = $res["city"];
  $product = $res["product"];
  $price = $res["price"];
} else {
  $company = $_POST["company"];
  $street = $_POST["street"];
  $city = $_POST["city"];
  $product = $_POST["product"];
  $price = $_POST["price"];
}


require __DIR__ . "/vendor/autoload.php";

use Dompdf\Dompdf;
use Dompdf\Options;



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