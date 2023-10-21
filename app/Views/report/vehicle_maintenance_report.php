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
      text-align: center;
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
      <h1>Laporan Pemeliharaan Kendaraan</h1>
    </div>

    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>No</th>
            <th>Vehicle Brand</th>
            <th>Plat Number</th>
            <th>Workshop Name</th>
            <th>Workshop Address</th>
            <th>Vehicle Service</th>
            <th>Status</th>
            <th>Maker</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          foreach ($duar as $gas) {
            if ($gas->status_kendaraan === "Already Serviced") {
            ?>
            <tr>
              <td><?php echo $no++ ?></td>
              <td><?php echo $gas->merk_kendaraan?></td>
              <td><?php echo $gas->plat_kendaraan?></td>
              <td><?php echo $gas->nama_bengkel?> (<?php echo $gas->no_bengkel?>)</td>
              <td><?php echo $gas->alamat_bengkel?></td>
              <td><?php echo $gas->service_kendaraan?> ~ <?php echo $gas->tanggal_service?></td>
              <td><?php echo $gas->status_kendaraan?></td>
              <td><?php echo $gas->username?> / <?php echo $gas->tanggal_kendaraan?></td>
            </tr>
          <?php }}?>
        </tbody>
      </table>
    </div>
  </div>

  <script>
    window.print();
  </script>
</body>
</html>
