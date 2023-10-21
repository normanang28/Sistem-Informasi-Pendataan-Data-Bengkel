<div class="col-12">
  <div class="x_panel">
    <div class="x_title">
      <h2>
        <?php if ($kunci=='view_items') {
        }else if ($kunci=='view_incoming_items') {
        }else if ($kunci=='view_outbound_items') {
        }else if ($kunci=='view_vehicle_maintenance') {
        }else{
        }
        ?>
      </h2>
      <!--  -->
      <div class="clearfix"></div>
    </div>
    <div class="x_content">
      <form class="form-horizontal form-label-left" novalidate

      action="
      <?php if ($kunci=='view_items') {
        echo base_url('home/print_items');
        }else if ($kunci=='view_incoming_items') {
        echo base_url('home/print_incoming_items');
        }else if ($kunci=='view_outbound_items') {
        echo base_url('home/print_outbound_items');
        }else if ($kunci=='view_vehicle_maintenance') {
        echo base_url('home/print_vehicle_maintenance');
        }else{
          echo base_url('home/print_invoice');
        }
        ?>" method="post">

        <div class="item form-group">
          <label class="control-label col-12">Start Date<span style="color: red;">*</span>
          </label>
          <div class="col-12">
            <input id="name" class="form-control col-12" data-validate-length-range="6" data-validate-words="2" name="awal" placeholder="" required="required" type="date">
          </div>
        </div>
        <div class="item form-group">
          <label class="control-label col-12">End Date<span style="color: red;">*</span>
          </label>
          <div class="col-12">
            <input type="date" id="kode" name="akhir" required="required" placeholder="" class="form-control col-12">
          </div>
        </div>
        <div class="form-group">
          <div class="col-12">
            <button id="send" type="submit" class="btn btn-warning"><i class="fa fa-print"></i> Print</button>
          </div>
        </div>
      </form>

      <div class="ln_solid"></div>

      <form class="form-horizontal form-label-left" novalidate

      action="
      <?php if ($kunci=='view_items') {
        echo base_url('home/pdf_items');
        }else if ($kunci=='view_incoming_items') {
        echo base_url('home/pdf_incoming_items');
        }else if ($kunci=='view_outbound_items') {
        echo base_url('home/pdf_outbound_items');
        }else if ($kunci=='view_vehicle_maintenance') {
        echo base_url('home/pdf_vehicle_maintenance');
        }else{
        echo base_url('home/pdf_invoice');
          }
        ?>" method="post" target="_blank">

        <div class="item form-group">
          <label class="control-label col-12">Start Date<span style="color: red;">*</span>
          </label>
          <div class="col-12">
            <input id="name" class="form-control col-12" data-validate-length-range="6" data-validate-words="2" name="awal" placeholder="" required="required" type="date">
          </div>
        </div>
        <div class="item form-group">
          <label class="control-label col-12">End Date<span style="color: red;">*</span>
          </label>
          <div class="col-12">
            <input type="date" id="kode" name="akhir" required="required" placeholder="" class="form-control col-12">
          </div>
        </div>
        <div class="form-group">
          <div class="col-12">
            <button type="submit" class="btn btn-danger"><i class="fa fa-print"></i> PDF</button>
          </div>
        </div>
      </form>

      <div class="ln_solid"></div>

      <form class="form-horizontal form-label-left" novalidate

      action="
      <?php if ($kunci=='view_items') {
        echo base_url('home/excel_items');
        }else if ($kunci=='view_incoming_items') {
        echo base_url('home/excel_incoming_items');
        }else if ($kunci=='view_outbound_items') {
        echo base_url('home/excel_outbound_items');
        }else if ($kunci=='view_vehicle_maintenance') {
        echo base_url('home/excel_vehicle_maintenance');
        }else{
          echo base_url('home/excel_invoice');
        }
        ?>" method="post">

        <div class="item form-group">
          <label class="control-label col-12">Start Date<span style="color: red;">*</span> 
          </label>
          <div class="col-12">
            <input id="name" class="form-control col-12" data-validate-length-range="6" data-validate-words="2" name="awal" placeholder="" required="required" type="date">
          </div>
        </div>
        <div class="item form-group">
          <label class="control-label col-12">End Date<span style="color: red;">*</span>
          </label>
          <div class="col-12">
            <input type="date" id="kode" name="akhir" required="required" placeholder="" class="form-control col-12">
          </div>
        </div>
        <div class="form-group">
          <div class="col-12">
            <button type="submit" class="btn btn-success"><i class="fa fa-print"></i> Excel</button>
          </div>
        </div>
      </form>
      <div class="ln_solid"></div>
      <form class="form-horizontal form-label-left" novalidate
      action="
      <?php if ($kunci=='view_items') {
        echo base_url('home/items');
        }else if ($kunci=='view_incoming_items') {
        echo base_url('home/incoming_items');
        }else if ($kunci=='view_outbound_items') {
        echo base_url('home/outbound_items');
        }else if ($kunci=='view_vehicle_maintenance') {
        echo base_url('home/vehicle_maintenance');
        }else{
          echo base_url('home/invoice');
        }
        ?>" method="post">
      </div>
    </div>
  </div>