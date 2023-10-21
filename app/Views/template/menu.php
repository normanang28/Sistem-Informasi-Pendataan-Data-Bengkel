        <div class="deznav">
            <div class="deznav-scroll">
				<ul class="metismenu" id="menu">
  <?php  if(session()->get('id')>0) { ?>
                    <li><a href="<?= base_url('/home/dashboard')?>" class="ai-icon" aria-expanded="false">
                            <i class="flaticon-381-home" title="Dashboard"></i>
                            <span  class="nav-text">Dashboard</span>
                        </a>
                    </li>
  <?php }else{} ?>
  <?php  if(session()->get('level')== 1) { ?>
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                            <i class="flaticon-381-user-9" title="Users"></i>
                            <span class="nav-text">Users</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="<?= base_url('/home/employee')?>">Employee</a></li>
                            <li><a href="<?= base_url('/home/user')?>">User</a></li>
                        </ul>
                    </li>
  <?php }else{} ?>
  <?php  if(session()->get('level')== 2 || session()->get('level')== 3) { ?>
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                            <i class="fas fa-tools" title="Users"></i>
                            <span class="nav-text">Inventory</span>
                        </a>
                        <ul aria-expanded="false">
  <?php  if(session()->get('level')== 2 || session()->get('level')== 3) { ?>
                            <li><a href="<?= base_url('/home/items')?>">Items</a></li>
  <?php }else{} ?>
  <?php  if(session()->get('level')== 2) { ?>
                            <li><a href="<?= base_url('/home/incoming_items')?>">Incoming Items</a></li>
  <?php }else{} ?>
  <?php  if(session()->get('level')== 2 || session()->get('level')== 3) { ?>
                            <li><a href="<?= base_url('/home/outbound_items')?>">Outbound Items</a></li>
  <?php }else{} ?>
                        </ul>
                    </li>
  <?php }else{} ?>
  <?php  if(session()->get('level')== 2 || session()->get('level')== 3 || session()->get('level')== 4) { ?>
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                            <i class="fa fa-car" title="Users"></i>
                            <span class="nav-text">Service</span>
                        </a>
                        <ul aria-expanded="false">
  <?php  if(session()->get('level')== 2 || session()->get('level')== 3 || session()->get('level')== 4) { ?>
                            <li><a href="<?= base_url('/home/vehicle_maintenance')?>">Vehicle Maintenance</a></li>
  <?php }else{} ?>
  <?php  if(session()->get('level')== 2 || session()->get('level')== 4) { ?>
                            <li><a href="<?= base_url('/home/invoice')?>">Invoice</a></li>
  <?php }else{} ?>
                        </ul>
                    </li>
  <?php }else{} ?>
 <?php  if(session()->get('level')== 2 || session()->get('level')== 3) { ?>
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							         <i class="flaticon-381-notepad" title="Report"></i>
							             <span class="nav-text">Inventory Report</span>
						              </a>
                        <ul aria-expanded="false">
  <?php  if(session()->get('level')== 2) { ?>
                            <li><a href="<?= base_url('/home/items_report')?>">Items Report</a></li>
  <?php }else{} ?>
  <?php  if(session()->get('level')== 2) { ?>
                            <li><a href="<?= base_url('/home/incoming_items_report')?>">Incoming Items Report</a></li>
  <?php }else{} ?>
  <?php  if(session()->get('level')== 2 || session()->get('level')== 3) { ?>
                            <li><a href="<?= base_url('/home/outbound_items_report')?>">Outbound Items Report</a></li>
  <?php }else{} ?>
<!--   <?php  if(session()->get('level')== 2 || session()->get('level')== 4) { ?>
                            <li><a href="<?= base_url('/home/invoice_report')?>">VM Report</a></li>
  <?php }else{} ?>
  <?php  if(session()->get('level')== 2 || session()->get('level')== 4) { ?>
                            <li><a href="<?= base_url('/home/invoice_report')?>">Invoice Report</a></li>
  <?php }else{} ?> -->
                        </ul>
                    </li>
  <?php }else{} ?>
 <?php  if(session()->get('level')== 2 || session()->get('level')== 4) { ?>
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="flaticon-381-notepad" title="Report"></i>
                            <span class="nav-text">Service Report</span>
                          </a>
                        <ul aria-expanded="false">
  <?php  if(session()->get('level')== 2 || session()->get('level')== 4) { ?>
                            <li><a href="<?= base_url('/home/vehicle_maintenance_report')?>">VM Report</a></li>
  <?php }else{} ?>
  <?php  if(session()->get('level')== 2 || session()->get('level')== 4) { ?>
                            <li><a href="<?= base_url('/home/invoice_report')?>">Invoice Report</a></li>
  <?php }else{} ?>
                        </ul>
                    </li>
  <?php }else{} ?>

<!-- <?php  if(session()->get('level')== 2 || session()->get('level')== 3 || session()->get('level')== 4) { ?>

  <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
    <i class="flaticon-381-notepad" title="Report"></i>
        <span class="nav-text">Report</span>
      </a>
    <ul aria-expanded="false">
        <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
            <span class="nav-text">Inventory Report</span>
          </a>
          <ul aria-expanded="false">
<?php  if(session()->get('level')== 2) { ?>
          <li><a href="<?= base_url('/home/items_report')?>">Items Report</a></li>
<?php }else{} ?>
<?php  if(session()->get('level')== 2) { ?>
          <li><a href="<?= base_url('/home/incoming_items_report')?>">Incoming Items Report</a></li>
<?php }else{} ?>
<?php  if(session()->get('level')== 2 || session()->get('level')== 3) { ?>
          <li><a href="<?= base_url('/home/outbound_items_report')?>">Outbound Items Report</a></li>
<?php }else{} ?>
          </ul>
        </li>
        <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
            <span class="nav-text">Service Report</span>
          </a>
          <ul aria-expanded="false">
<?php  if(session()->get('level')== 2 || session()->get('level')== 4) { ?>
          <li><a href="<?= base_url('/home/invoice_report')?>">VM Report</a></li>
<?php }else{} ?>
<?php  if(session()->get('level')== 2 || session()->get('level')== 4) { ?>
          <li><a href="<?= base_url('/home/invoice_report')?>">Invoice Report</a></li>
<?php }else{} ?>
          </ul>
        </li>
    </ul>
</li>
<?php }else{} ?> -->
  <?php  if(session()->get('level')== 1) { ?>
                    <li><a href="<?= base_url('/home/workshop')?>" class="ai-icon" aria-expanded="false">
                            <i class="fa fa-wrench" title="Workshop"></i>
                            <span  class="nav-text">Workshop</span>
                        </a>
                    </li>
  <?php }else{} ?>
  <?php  if(session()->get('level')== 1 || session()->get('level')== 2) { ?>
                    <hr class="sidebar-divider">
                    <li><a href="<?= base_url('/home/employee_activity')?>" class="ai-icon" aria-expanded="false">
                            <i class="flaticon-381-folder-18" title="Employee Activity Log"></i>
                            <span class="nav-text">Employee Activity Log</span>
                        </a>
                    </li>
  <?php }else{} ?>
  <?php  if(session()->get('level')== 1) { ?>
                    <li><a href="<?= base_url('/home/settings_control')?>" class="ai-icon" aria-expanded="false">
                            <i class="flaticon-381-settings-4" title="Settings Control"></i>
                            <span class="nav-text">Settings Control</span>
                        </a>
                    </li>
  <?php }else{} ?>
                </ul>
			</div>
        </div>
<div class="content-body">
            <!-- row -->
            <div class="container-fluid">
                <div class="form-head d-flex mb-3 align-items-start">
                    <div class="me-auto d-none d-lg-block">
                        <?php
                        $level = session()->get('level'); 
                        $nama_karyawan = session()->get('nama_karyawan');
                        $nama_pengguna = session()->get('nama_pengguna');
                        $userLevelText = "";

                        if ($level == 1 || $level == 2 || $level == 3) {
                            $userLevelText = $nama_karyawan;
                        } elseif ($level == 4) {
                            $userLevelText = $nama_pengguna;
                        } else {
                            $userLevelText = "Guest";
                        }

                        echo "<p class='mb-0 text-capitalize'>Welcome <b>$userLevelText</b> to " . session()->get('nama_website') . "!</p>";
                        ?>
                    </div>
                    <b><span id="currentDateTime"></span></b>
                </div>


<script>
function updateDateTime() {
    const dateTimeElement = document.getElementById('currentDateTime');
    const options = {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: 'numeric',
        minute: '2-digit',
        second: '2-digit',
        hour12: true, // Menggunakan format 12 jam dengan AM/PM
    };

    const currentDateTime = new Date().toLocaleString(undefined, options);
    dateTimeElement.textContent = currentDateTime.replace(',', ' at');
}

// Perbarui waktu setiap detik
setInterval(updateDateTime, 1000);

// Panggil fungsi untuk menampilkan waktu awal
updateDateTime();
</script>


               