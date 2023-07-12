<?php 

$company = $_POST["company"];
$street = $_POST["street"];
$city = $_POST["city"];
$product = $_POST["product"];
$price = $_POST["price"];


try {
  // Create (connect to) SQLite database in file
  $db = new PDO('sqlite:db.sqlite');
  $sql = "INSERT INTO invoices (company, street, city, product, price) VALUES
          (:company, :street, :city, :product, :price)";
  $stmt = $db->prepare($sql);

  $stmt->bindValue(':company', $company, PDO::PARAM_STR);
  $stmt->bindValue(':street', $street, PDO::PARAM_STR);
  $stmt->bindValue(':city', $city, PDO::PARAM_STR);
  $stmt->bindValue(':product', $product, PDO::PARAM_STR);
  $stmt->bindValue(':price', $price, PDO::PARAM_INT);

  $success = $stmt->execute();
  if($success) {
    echo "Record added";
  } else {
    echo "Sorry, something went wrong";
  }

  
  $db = null;
}
  catch(PDOException $e) 
  {
    // Print PDOException message
    echo $e->getMessage();
  }

header("Location: /index.php");
die(); 
?>