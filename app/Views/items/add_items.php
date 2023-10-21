<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="card">
        <div class="card-body">
            <div class="basic-form">
                <form id="menuForm" class="form-horizontal form-label-left" novalidate  action="<?= base_url('home/aksi_add_items')?>" method="post" enctype="multipart/form-data">

                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="control-label col-12">Replace Image<span style="color: red;">*</span></label>
                            <div class="col-12">
                            <input type="file" name="foto_barang" class="form-file-input form-control col-12">
                          </div>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Items Name<span style="color: red;">*</span></label>
                            <input type="text" id="nama_barang" name="nama_barang" 
                            class="form-control text-capitalize" placeholder="Items Name">
                        </div>
                        <div class="group input-group">
                            <label class="form-label">Description<span style="color: red;">*</span></label>
                            <div class="col-12"></div>
                            <input type="text" id="remark_barang" name="remark_barang" 
                            class="form-control text-capitalize" placeholder="Description">
                        </div>
                        <h1></h1>
                        <br>
                    </div>
          <a href="<?= base_url('/home/items')?>" type="submit" class="btn btn-primary">Cancel</a></button>
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
        const nama_barang = document.getElementById("nama_barang").value.trim();
        const remark_barang = document.getElementById("remark_barang").value.trim();
        foto_barang: document.querySelector('input[type="file"]').value

        if (nama_barang !== "" && remark_barang ) {
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
        window.location.href = '<?= base_url('/home/items') ?>'; 
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