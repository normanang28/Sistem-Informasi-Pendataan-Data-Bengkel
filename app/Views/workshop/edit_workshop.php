<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="card">
        <div class="card-body">
            <div class="basic-form">
                <form id="userForm" class="form-horizontal form-label-left" novalidate  action="<?= base_url('home/aksi_edit_workshop')?>" method="post">
                    <input type="hidden" name="id" value="<?= $duar->id_bengkel ?>">

                    <div class="row">
                         <div class="mb-3 col-md-6">
                            <label class="form-label">Workshop Name<span style="color: red;">*</span></label>
                            <input type="text" id="nama_bengkel" name="nama_bengkel" 
                            class="form-control text-capitalize" placeholder="Workshop Name" value="<?= $duar->nama_bengkel?>">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Number Telephone<span style="color: red;">*</span></label>
                            <input type="number" id="no_bengkel" name="no_bengkel" 
                            class="form-control text-capitalize" placeholder="Number Telephone" value="<?= $duar->no_bengkel?>">
                        </div>
                        <div class="group input-group">
                            <label class="form-label">Address<span style="color: red;">*</span></label>
                            <div class="col-12"></div>
                            <input type="text" id="alamat_bengkel" name="alamat_bengkel" 
                            class="form-control text-capitalize" placeholder="Address" value="<?= $duar->alamat_bengkel?>">
                        </div>
                        <h1></h1>
                        <br>
                  </div>
                  <a href="<?= base_url('/home/workshop')?>" type="submit" class="btn btn-primary">Cancel</a></button>
                  <button type="submit" id="updateButton" class="btn btn-success" disabled>Update</button>
              </form>
          </div>
      </div>
  </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const userForm = document.getElementById("userForm");
        const updateButton = document.getElementById("updateButton");

        const initialData = {
            nama_bengkel: "<?= $duar->nama_bengkel ?>",
            no_bengkel: "<?= $duar->no_bengkel ?>",
            alamat_bengkel: "<?= $duar->alamat_bengkel ?>",

        };

        userForm.addEventListener("change", function() {
            const currentData = {
                nama_bengkel: document.getElementById("nama_bengkel").value.trim(),
                no_bengkel: document.getElementById("no_bengkel").value.trim(),
                alamat_bengkel: document.getElementById("alamat_bengkel").value.trim(),
            };

            const isDataChanged = Object.keys(currentData).some(key => currentData[key] !== initialData[key]);

            if (isDataChanged) {
                updateButton.removeAttribute("disabled");
            } else {
                updateButton.setAttribute("disabled", "disabled");
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
        window.location.href = '<?= base_url('/home/workshop') ?>'; 
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