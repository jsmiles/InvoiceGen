<?php
// To refresh the database with new values
try {
  // Create (connect to) SQLite database in file
  $my_conn = new PDO('sqlite:db.sqlite');

  // Set errormode to exceptions
  $my_conn->setAttribute(PDO::ATTR_ERRMODE, 
                          PDO::ERRMODE_EXCEPTION);
  
  $count=$my_conn->prepare("DROP TABLE invoices");
  $count->execute();



  // Create table student
  $count=$my_conn->prepare("CREATE TABLE IF NOT EXISTS
      invoices(id integer primary key, 
                    company text, 
                    street text, 
                    city text,
                    product integer, 
                    price integer 
                    )");
          
if($count->execute()){
  echo "TABLE invoices created";
} else{
    echo "Not able to create invoices table";
}	
 
 $my_conn->exec("INSERT INTO `invoices` 
  (`id`, `company`, `street`, `city`, `product`, `price`) VALUES
  (1, 'Evil Empire Inc.', '7 Main St', 'NYC', 'Laser Beams', 7200),
  (2, 'Stark Enterprises', '12 Broadway', 'Chicago', 'Rocket Packs', 2400),
  (3, 'Dow Chemical Corp', '148 Ponce De Leon', 'Atlanta', 'Chemical Waste', 3000),
  (4, 'Tesla', '1800 San Mateo Drive', 'Palo Alto', 'Batteries', 12000);");
  // Close file db connection
  $my_conn = null;
}
  catch(PDOException $e) 
  {
    // Print PDOException message
    echo $e->getMessage();
  }
 

header("Location: /index.php");
die(); 
?>