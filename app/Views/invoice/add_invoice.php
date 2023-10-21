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
            <?php  if(session()->get('level')== 2) { ?>
                <div class="alert alert-warning" role="alert">
                    <i class="fas fa-exclamation-triangle blinking-icon"></i> Be careful when inputting invoice data, if there is an error you cannot update and delete this data!!
                </div>
            <?php }else{} ?> 
            <div class="basic-form">
                <form id="menuForm" class="form-horizontal form-label-left" novalidate  action="<?= base_url('home/aksi_add_invoice')?>" method="post">

                    <div class="row">
                       <div class="mb-3 col-md-6">
                        <label class="control-label col-12">Vehicle Brand ~ Plat Number<span style="color: red;">*</span></label>  
                        <select name="id_kendaraan" class="form-control text-capitalize" id="id_kendaraan" required>
                            <option>Choose Vehicle Brand ~ Plat Number</option>
                            <?php 
                            foreach ($kendaraan as $item) { 
                                if ($item->status_kendaraan == 'Already Serviced') {
                            ?>
                                <option class="text-capitalize" value="<?php echo $item->id_kendaraan ?>"><?php echo $item->merk_kendaraan ?> ~ <?php echo $item->plat_kendaraan ?></option>
                            <?php 
                                }
                            } 
                            ?>
                        </select>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Service Price<span style="color: red;">*</span></label>
                        <input type="number" id="harga_invoice" name="harga_invoice" 
                        class="form-control text-capitalize" placeholder="Service Price">
                    </div>
                    <div class="group input-group">
                        <label class="form-label">Remark<span style="color: red;">*</span></label>
                        <div class="col-12">
                            <input type="text" id="remark" name="remark" 
                            class="form-control text-capitalize" placeholder="Remark">
                        </div>
                    </div>
                    <br>
                    <h1></h1>
                </div>
                <a href="<?= base_url('/home/invoice')?>" type="submit" class="btn btn-primary">Cancel</a></button>
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

        menuForm.addEventListener("change", function() {
            const id_kendaraan = document.getElementById("id_kendaraan").value;
            const harga_invoice = document.getElementById("harga_invoice").value.trim();
            const remark = document.getElementById("remark").value.trim();

            if (id_kendaraan !== "Choose Vehicle Brand / Plat Number" && harga_invoice !== "" && remark !== "") {
                submitButton.removeAttribute("disabled");
            } else {
                submitButton.setAttribute("disabled", "disabled");
            }
        });
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
            window.location.href = '<?= base_url('/home/invoice') ?>'; 
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