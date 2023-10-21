<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="card">
        <div class="card-body">
            <div class="basic-form">
                <form id="menuForm" class="form-horizontal form-label-left" novalidate  action="<?= base_url('home/aksi_add_incoming_items')?>" method="post">

                    <div class="row">
                         <div class="mb-3 col-md-6">
                           <label class="control-label col-12">Items Name<span style="color: red;">*</span></label>  
                            <select name="id_barang" class="form-control text-capitalize" id="id_barang" required>
                                <option>Choose Items Name</option>
                                <?php 
                                foreach ($a as $item) { 
                                ?>
                                    <option class="text-capitalize" value="<?php echo $item->id_barang ?>"><?php echo $item->nama_barang ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Stok<span style="color: red;">*</span></label>
                            <input type="number" id="stok" name="stok" 
                            class="form-control text-capitalize" placeholder="Stok">
                        </div>
                        <div class="group input-group">
                            <label class="form-label">Purchase Price<span style="color: red;">*</span></label>
                            <div class="col-12"></div>
                            <input type="text" id="harga_beli" name="harga_beli" 
                            class="form-control text-capitalize" placeholder="Purchase Price">
                        </div>
                        <h1></h1>
                        <br>
                    </div>
          <a href="<?= base_url('/home/incoming_items')?>" type="submit" class="btn btn-primary">Cancel</a></button>
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
            const id_barang = document.getElementById("id_barang").value;
            const stok = document.getElementById("stok").value.trim();
            const harga_beli = document.getElementById("harga_beli").value.trim();

            if (id_barang !== "Choose Items Name" && stok !== "" && harga_beli !== "") {
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
        window.location.href = '<?= base_url('/home/incoming_items') ?>'; 
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