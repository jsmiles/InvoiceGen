# InvoiceGen
Generate Invoice PDFs. A tool that can be used to view invoices yet to be raised, add new items to the database or generate the PDF of an Invoice required.

# Technology
I have used base PHP and SQLite for this project. The main styling library used is [Pico CSS](https://picocss.com/). The PDFs are generated using [Dompdf](https://github.com/dompdf/dompdf) and have been styled partially by [Gutenberg](https://github.com/BafS/Gutenberg). 

- index.php: the main file
- db_store.php: storing records to the sqlite db
- db_gen.php: refreshing the database with the base entries
- gen.php: the php to generate the PDF
- template.html: html template used by gen.php
- package.json: could not use the cdn so had to use npm to access Gutenberg
- composer.json: to manage Dompdf

# Lessons Learned
It was great fun learning so many new pieces of technology. I had initially thought that using [Puppeteer](https://pptr.dev/) might be the approach I would take. No doubt I will use it in a future project. I found Dompdf especially useful and easy to use. The current invoice is basic but with more time no doubt you could create a more elaborate theme. 
