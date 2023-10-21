<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="card">
        <div class="card-body">
            <style>
                @keyframes blink {
                    0% { opacity: 1; }
                    50% { opacity: 0; }
                    100% { opacity: 1; }
                }

                .alert i.blinking-icon {
                    animation: blink 2s infinite;
                }
            </style>
            <?php  if(session()->get('level')== 4) { ?>
            <div class="alert alert-warning" role="alert">
                <i class="fas fa-exclamation-triangle blinking-icon"></i> Be careful when inputting vehicle maintenance data, if there is an error you cannot update this data!!
            </div>
            <?php }else{} ?> 

            <div class="basic-form">
                <form id="menuForm" class="form-horizontal form-label-left" novalidate  action="<?= base_url('home/aksi_add_vehicle_maintenance')?>" method="post" enctype="multipart/form-data">

                    <div class="row">
                        <label class="control-label col-12">Workshop Location<span style="color: red;">*</span></label>
                           <div class="col-12">
                            <select name="id_bengkel" class="form-control text-capitalize" id="id_bengkel" required>
                                <option>Choose Workshop Location</option>
                                <?php foreach ($bengkel as $workshop) { ?>
                                    <option class="text-capitalize" value="<?php echo $workshop->id_bengkel ?>"><?php echo $workshop->nama_bengkel ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <h1></h1>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Vehicle Brand<span style="color: red;">*</span></label>
                            <input type="text" id="merk_kendaraan" name="merk_kendaraan" 
                            class="form-control text-capitalize" placeholder="Vehicle Brand">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Plat Number<span style="color: red;">*</span></label>
                            <input type="text" id="plat_kendaraan" name="plat_kendaraan" 
                            class="form-control text-uppercase" placeholder="Plat Number" maxlength="11">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Service<span style="color: red;">*</span></label>
                            <div class="col-12">
                            <select id="service_kendaraan" class="form-control col-12" data-validate-length-range="6" data-validate-words="2" name="service_kendaraan" required="required">
                              <option>Select Service</option>
                              <option value="Routine Service">Routine Service</option>
                              <option value="Repair Machine">Repair Machine</option>
                              <option value="Transmission Repair">Transmission Repair</option>
                              <option value="Electrical System Repair">Electrical System Repair</option>
                              <option value="Suspension System Repair">Suspension System Repair</option>
                              <option value="Brake System Repair">Brake System Repair</option>
                              <option value="Car AC Maintenance">Car AC Maintenance</option>
                              <option value="Fuel System Repair">Fuel System Repair</option>
                              <option value="Tire Maintenance">Tire Maintenance</option>
                              <option value="Tune-up Service">Tune-up Service</option>
                              <option value="General Maintenance Services">General Maintenance Services</option>
                              <option value="Body and Paint Repair">Body and Paint Repair</option>
                              <option value="Towing Services">Towing Services</option>
                              <option value="Glass Replacement Service">Glass Replacement Service</option>
                              <option value="Lock and Lockout Services">Lock and Lockout Services</option>
                              <option value="Braking System Repair">Braking System Repair</option>
                              <option value="Electric Vehicle Services">Electric Vehicle Services</option>
                              <option value="Special Vehicle Services">Special Vehicle Services</option>
                            </select>
                          </div>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Service Date<span style="color: red;">*</span></label>
                            <input type="datetime-local" id="tanggal_service" name="tanggal_service" 
                            class="form-control text-capitalize" placeholder="Service Date">
                        </div>
                    </div>
          <a href="<?= base_url('/home/vehicle_maintenance')?>" type="submit" class="btn btn-primary">Cancel</a></button>
          <button type="submit" id="submitButton" class="btn btn-success" disabled>Submit</button>
        </form>
    </div>
</div>
</div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
    const menuForm = document.getElementById("menuForm");
    const submitButton = document.getElementById("submitButton");

    const id_bengkel = document.getElementById("id_bengkel");
    const merk_kendaraan = document.getElementById("merk_kendaraan");
    const plat_kendaraan = document.getElementById("plat_kendaraan");
    const service_kendaraan = document.getElementById("service_kendaraan");
    const tanggal_service = document.getElementById("tanggal_service");

    function checkInputs() {
        if (
            id_bengkel.value !== "Choose Workshop Location" &&
            merk_kendaraan.value.trim() !== "" &&
            plat_kendaraan.value.trim() !== "" &&
            service_kendaraan.value !== "Select Service" &&
            tanggal_service.value.trim() !== ""
        ) {
            submitButton.removeAttribute("disabled");
        } else {
            submitButton.setAttribute("disabled", "disabled");
        }
    }

    id_bengkel.addEventListener("input", checkInputs);
    merk_kendaraan.addEventListener("input", checkInputs);
    plat_kendaraan.addEventListener("input", checkInputs);
    service_kendaraan.addEventListener("input", checkInputs);
    tanggal_service.addEventListener("input", checkInputs);

    checkInputs();
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    let timeout;
    const timeoutDuration = 2 * 60 * 1000; 

    function startTimeout() {
        clearTimeout(timeout); 
        timeout = setTimeout(redirectToDashboard, timeoutDuration);
    }

    function redirectToDashboard() {
        window.location.href = '<?= base_url('/home/vehicle_maintenance') ?>'; 
    }

    document.addEventListener('mousemove', startTimeout);
    document.addEventListener('keypress', startTimeout);

    startTimeout();

    const tableBody = document.querySelector('.table tbody');
    const pageNumbers = document.getElementById('pageNumbers');

    const data = <?= json_encode($duar) ?>; 
    const itemsPerPage = 50;
    let currentPage = 1;
});
</script>