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
                    amount_due integer, 
                    date_due integer 
                    )");
          
if($count->execute()){
  echo "TABLE invoices created";
} else{
    echo "Not able to create invoices table";
}	
 
 $my_conn->exec("INSERT INTO `invoices` 
  (`id`, `company`, `street`, `city`, `amount_due`, `date_due`) VALUES
  (1, 'Evil Empire Inc.', '7 Main St', 'NYC', 7200, 1023),
  (2, 'Stark Enterprises', '12 Broadway', 'Chicago', 2400, 1023),
  (3, 'Dow Chemical Corp', '148 Ponce De Leon', 'Atlanta', 3000, 1123),
  (4, 'Tesla', '1800 San Mateo Drive', 'Palo Alto', 12000, 1223);");
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