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
<?php  if(session()->get('level')== 3) { ?>
            <div class="alert alert-warning" role="alert">
                <i class="fas fa-exclamation-triangle blinking-icon"></i> Be careful when inputting outbound items data, if there is an error you cannot delete this data!!
            </div>
  <?php }else{} ?>    

            <div class="basic-form">
                <form id="menuForm" class="form-horizontal form-label-left" novalidate  action="<?= base_url('home/aksi_add_outbound_items')?>" method="post">

                    <div class="row">
                         <div class="mb-3 col-md-6">
                           <label class="control-label col-12">Items Name<span style="color: red;">*</span></label>  
                            <select name="id_barang" class="form-control text-capitalize" id="id_barang" required>
                                <option>Choose Items Name</option>
                                <?php 
                                foreach ($a as $item) { 
                                    $isZero = $item->jumlah == 0;
                                ?>
                                <option class="text-capitalize" value="<?php echo $item->id_barang ?>" <?php if ($isZero) echo 'style="color: red;"' ?>><?php echo $item->nama_barang ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Stok<span style="color: red;">*</span></label>
                            <input type="number" id="stok" name="stok" 
                            class="form-control text-capitalize" placeholder="Stok">
                        </div>
                        <div class="group input-group">
                            <label class="form-label">Remark<span style="color: red;">*</span></label>
                            <div class="col-12"></div>
                            <input type="text" id="remark_keluar" name="remark_keluar" 
                            class="form-control text-capitalize" placeholder="Remark">
                        </div>
                        <h1></h1>
                        <br>
                    </div>
          <a href="<?= base_url('/home/outbound_items')?>" type="submit" class="btn btn-primary">Cancel</a></button>
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
            const remark_keluar = document.getElementById("remark_keluar").value.trim();

            if (id_barang !== "Choose Items Name" && stok !== "" && remark_keluar !== "") {
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
        window.location.href = '<?= base_url('/home/outbound_items') ?>'; 
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