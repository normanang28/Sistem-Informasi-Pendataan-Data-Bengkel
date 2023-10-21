<!DOCTYPE html>
<html>
<head>
  <style>
    body {
      font-family: Arial, sans-serif;
      text-transform: capitalize;
    }

    .container {
      max-width: 8000px;
      margin: 0 auto;
      padding: 20px;
    }

    .header {
      text-align: center;
      margin-bottom: 20px;
    }

    .header img {
      width: 100%;
      height: auto;
    }

    .table-container {
      margin-top: 20px;
    }

    table {
      width: 100%; 
      border-collapse: collapse;
    }

    th, td {
      border: 1px solid #000;
      padding: 8px;
      /*text-align: center;*/
    }

    th {
      background-color: #f2f2f2;
    }

    td:nth-child(4) {
      text-align: justify;
      text-transform: capitalize;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <!-- <img src="path_to_your_image.jpg" alt="Your Logo"> -->
      <h1>Invoice Service Vehicle Maintenance</h1>
    </div>

    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th class="text-center">Date</th>
            <th class="text-center">Description</th>
            <th class="text-center">Account Name</th>
            <th class="text-center">Ref</th>
            <th class="text-center">Debit</th>
            <th class="text-center">Kredit</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          $totalSemua = 0;
          foreach ($duar as $gas) {
            if ($gas->status_invoice == 'Paid Off') {
            $totalSemua += $gas->harga_invoice;
          ?>
            <tr>
              <td style="text-align: center;"><?php echo $gas->tanggal_invoice?></td>
              <td style="text-align: center;"><?php echo $gas->merk_kendaraan?> / <?php echo $gas->plat_kendaraan?></td>
              <td><?php echo $gas->metode_pembayaran?></td>
              <td style="text-align: center;"><?php echo $gas->id_invoice?><?php echo $gas->id_kendaraan_invoice?><?php echo $gas->maker_invoice?><?php echo $gas->maker_invoice_kendaraan?></td>
              <td style="text-align: center;">Rp. <?php echo number_format($gas->harga_invoice, 0, ',', '.') ?></td>
              <td style="text-align: center;">~</td>
            </tr>
            <tr>
              <td colspan="2" class="text-right"></td>
              <td style="text-align: right;">Pendapatan</td>
              <td></td>
              <td style="text-align: center;">~</td>
              <td style="text-align: center;">Rp. <?php echo number_format($gas->harga_invoice, 0, ',', '.') ?></td>
            </tr>
          <?php }}?>
        </tbody>
            <tr>
             <td colspan="4" style="text-align: center;"><b>Jumlah</b></td>
             <td style="text-align: center;"><b>Rp. <?php echo number_format($totalSemua, 0, ',', '.') ?></b></td>
             <td style="text-align: center;"><b>Rp. <?php echo number_format($totalSemua, 0, ',', '.') ?></b></td>
           </tr>
      </table>
    </div>
  </div>

  <script>
    window.print();
  </script>
</body>
</html>
