<?php

// PDO: define, write sql, run
$pdo = new PDO('sqlite:db.sqlite');
$statement = $pdo->query("SELECT * FROM invoices");
$rows = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css">
  <title>InvoiceGen</title>

</head>
<body>
    <main class="container">
      <h1>Welcome to InvoiceGen</h1>
      <p>This tool can be used to view invoices yet to be raised, add new items to the database or generate the PDF of an Invoice required.</p> 

      <article>
        <h4>Please Input each field to generate the Invoice</h4>
        <form method="post">
          
          <label for="company">Company</label>
          <input type="text" name="company" id="company">
          <label for="street">Street</label>
          <input type="text" name="street" id="street">
          <label for="city">City</label>
          <input type="text" name="city" id="city"> 
          <label for="product">Product</label>
          <input type="text" name="product" id="product">
          <label for="price">Price</label>
          <input type="text" name="price" id="price">
          
          <button style="width: 30%; margin-left: 35%;" formaction="gen.php">Generate PDF Invoice</button>
          <button style="width: 30%; margin-left: 35%;" formaction="db_store.php" class="secondary">Save in DB</button>
        </form>
      </article>

      <h4>Currently Stored Invoices</h4>
      <table>
        <thead>
          <tr>
            <th scope="col">Index</th>
            <th scope="col">Company</th>
            <th scope="col">Address</th>
            <th scope="col">Product</th>
            <th scope="col">Price</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($rows as $k => $v): ?>
          <tr>
            <th scope="row"><?= $v['id']; ?></th>
            <td><?= $v['company']; ?></td>
            <td><?= $v['city']; ?></td>
            <td><?= $v['product']; ?></td>
            <td><?= $v['price']; ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      
      <article>
        <form action="gen.php" id="form-anchor" method="POST">
          <label for="invoice">Invoice to be Generated</label>
          <select id="invoice" name="invoice" required>
            <option value="" selected>Select an Invoice</option>
            <?php foreach($rows as $k => $v): ?>
              <option><?= $v['id'] . ' - ' . $v['company']; ?></option>
            <?php endforeach; ?>
          </select> 
          <button type="submit" name="submit" style="width: 30%; margin-left: 35%;" class="secondary">Select Invoice</button>       
        </form>
        <?php
          if(isset($_POST['submit'])){
            $selected_val = $_POST['invoice'];  
            echo "<h3>You have selected: " .$selected_val ."</h3>";
            
            $val_id = substr($selected_val, 0, 1);
            $invoice_pdo = new PDO('sqlite:db.sqlite');
            $inovice_statement = $invoice_pdo->query("SELECT * FROM invoices WHERE id = " . $val_id);
            $inovice_statement->execute();
            $res = $inovice_statement->fetch(PDO::FETCH_ASSOC);
          } else {
            echo "";
          }
        ?>
      </article>

    </main>
    <footer style="padding-left: 47%;"> 
      <a href="/db_gen.php" style="padding-right: 4px;">Refresh DB</a>
      <a href="https://github.com/jsmiles/InvoiceGen">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256"><path d="M208.31,75.68A59.78,59.78,0,0,0,202.93,28,8,8,0,0,0,196,24a59.75,59.75,0,0,0-48,24H124A59.75,59.75,0,0,0,76,24a8,8,0,0,0-6.93,4,59.78,59.78,0,0,0-5.38,47.68A58.14,58.14,0,0,0,56,104v8a56.06,56.06,0,0,0,48.44,55.47A39.8,39.8,0,0,0,96,192v8H72a24,24,0,0,1-24-24A40,40,0,0,0,8,136a8,8,0,0,0,0,16,24,24,0,0,1,24,24,40,40,0,0,0,40,40H96v16a8,8,0,0,0,16,0V192a24,24,0,0,1,48,0v40a8,8,0,0,0,16,0V192a39.8,39.8,0,0,0-8.44-24.53A56.06,56.06,0,0,0,216,112v-8A58.14,58.14,0,0,0,208.31,75.68ZM200,112a40,40,0,0,1-40,40H112a40,40,0,0,1-40-40v-8a41.74,41.74,0,0,1,6.9-22.48A8,8,0,0,0,80,73.83a43.81,43.81,0,0,1,.79-33.58,43.88,43.88,0,0,1,32.32,20.06A8,8,0,0,0,119.82,64h32.35a8,8,0,0,0,6.74-3.69,43.87,43.87,0,0,1,32.32-20.06A43.81,43.81,0,0,1,192,73.83a8.09,8.09,0,0,0,1,7.65A41.72,41.72,0,0,1,200,104Z"></path></svg>
      </a>
    </footer>
  </body>
</html>