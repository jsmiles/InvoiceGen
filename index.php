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

  <style>
			.invoice-box {
				max-width: 800px;
				margin: auto;
				padding: 30px;
				border: 1px solid #eee;
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
				font-size: 16px;
				line-height: 24px;
				font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
				color: #555;
			}

			.invoice-box table {
				width: 100%;
				line-height: inherit;
				text-align: left;
			}

			.invoice-box table td {
				padding: 5px;
				vertical-align: top;
			}

			.invoice-box table tr td:nth-child(2) {
				text-align: right;
			}

			.invoice-box table tr.top table td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.top table td.title {
				font-size: 45px;
				line-height: 45px;
				color: #333;
			}

			.invoice-box table tr.information table td {
				padding-bottom: 40px;
			}

			.invoice-box table tr.heading td {
				background: #eee;
				border-bottom: 1px solid #ddd;
				font-weight: bold;
			}

			.invoice-box table tr.details td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.item td {
				border-bottom: 1px solid #eee;
			}

			.invoice-box table tr.item.last td {
				border-bottom: none;
			}

			.invoice-box table tr.total td:nth-child(2) {
				border-top: 2px solid #eee;
				font-weight: bold;
			}

			@media only screen and (max-width: 600px) {
				.invoice-box table tr.top table td {
					width: 100%;
					display: block;
					text-align: center;
				}

				.invoice-box table tr.information table td {
					width: 100%;
					display: block;
					text-align: center;
				}
			}

			/** RTL **/
			.invoice-box.rtl {
				direction: rtl;
				font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
			}

			.invoice-box.rtl table {
				text-align: right;
			}

			.invoice-box.rtl table tr td:nth-child(2) {
				text-align: left;
			}
		</style>


</head>
<body>
    <main class="container">
      <h1>Welcome to InvoiceGen</h1>
      <p>This tool can be used to view invoices yet to be raised, add new items to the database or generate the PDF of an Invoice required.</p> 
      <table>
        <thead>
          <tr>
            <th scope="col">Index</th>
            <th scope="col">Company</th>
            <th scope="col">Address</th>
            <th scope="col">Amount Due</th>
            <th scope="col">Date Due</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($rows as $k => $v): ?>
          <tr>
            <th scope="row"><?= $v['id']; ?></th>
            <td><?= $v['company']; ?></td>
            <td><?= $v['city']; ?></td>
            <td><?= $v['amount_due']; ?></td>
            <td><?= $v['date_due']; ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      
      <article>
        <form action="index.php#form-anchor" id="form-anchor" method="POST">
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
            $res = $inovice_statement->fetch(PDO::FETCH_ASSOC);#
          } else {
            echo "<h4>Waiting for selection</h4>";
          }
        ?>
      <?php if(isset($res)) : ?>
      <section>
        <div id="">
          <div class="invoice-box">
            <table cellpadding="0" cellspacing="0">
              <tr class="top">
                <td colspan="2">
                  <table>
                    <tr>
                      <td class="title">
                        <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" fill="#000000" viewBox="0 0 256 256"><path d="M160,80a8,8,0,0,1,8-8h64a8,8,0,0,1,0,16H168A8,8,0,0,1,160,80Zm-24,78a42,42,0,0,1-42,42H32a8,8,0,0,1-8-8V64a8,8,0,0,1,8-8H90a38,38,0,0,1,25.65,66A42,42,0,0,1,136,158ZM40,116H90a22,22,0,0,0,0-44H40Zm80,42a26,26,0,0,0-26-26H40v52H94A26,26,0,0,0,120,158Zm128-6a8,8,0,0,1-8,8H169a32,32,0,0,0,56.59,11.2,8,8,0,0,1,12.8,9.61A48,48,0,1,1,248,152Zm-17-8a32,32,0,0,0-62,0Z"></path></svg>
                      </td>

                      <td>
                        Invoice #: 123<br />
                        Created: <?php
                          $date = new DateTime(); 
                          echo $date->format('l jS \o\f F Y');
                          ?>
                        <br />
                        Due: <?php
                          $date = new DateTime(); 
                          $date->add(new DateInterval('P30D'));
                          echo $date->format('l jS \o\f F Y');
                          ?>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>

              <tr class="information">
                <td colspan="2">
                  <table>
                    <tr>
                      <td>
                        <?= $res['company']; ?><br />
                        <?= $res['street']; ?><br />
                        <?= $res['city']; ?><br />
                      </td>

                      <td>
                        Belance Corp.<br />
                        John Doe<br />
                        john@belance.com
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>

              <tr class="heading">
                <td>Payment Method</td>

                <td></td>
              </tr>

              <tr class="details">
                <td>Bank of ACME</td>
                <td>IBAN: GB33BUKB20201555555555</td>
              </tr>

              <tr class="heading">
                <td>Item</td>

                <td>Price</td>
              </tr>

              <tr class="item last">
                <td>Consulting Services</td>

                <td><?= number_format($res['amount_due']);?></td>
              </tr>

              <tr class="total">
                <td></td>

                <td>Total: £<?= number_format($res['amount_due']);?></td>
              </tr>
            </table>
          </div>
        </div>
        </section>
      <?php endif; ?>
      <button style="width: 30%; margin-left: 35%;">Generate PDF Invoice</button>


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