<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="card">
        <div class="card-body">
            <div class="basic-form">
                <form id="userForm" class="form-horizontal form-label-left" novalidate  action="<?= base_url('home/aksi_add_workshop')?>" method="post">

                    <div class="row">
                         <div class="mb-3 col-md-6">
                            <label class="form-label">Workshop Name<span style="color: red;">*</span></label>
                            <input type="text" id="nama_bengkel" name="nama_bengkel" 
                            class="form-control text-capitalize" placeholder="Workshop Name">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Number Telephone<span style="color: red;">*</span></label>
                            <input type="number" id="no_bengkel" name="no_bengkel" 
                            class="form-control text-capitalize" placeholder="Number Telephone">
                        </div>
                        <div class="group input-group">
                            <label class="form-label">Address<span style="color: red;">*</span></label>
                            <div class="col-12"></div>
                            <input type="text" id="alamat_bengkel" name="alamat_bengkel" 
                            class="form-control text-capitalize" placeholder="Address">
                        </div>
                        <h1></h1>
                        <br>
                  </div>
                  <a href="<?= base_url('/home/workshop')?>" type="submit" class="btn btn-primary">Cancel</a></button>
                  <button type="submit" id="submitButton" class="btn btn-success" disabled>Submit</button>
              </form>
          </div>
      </div>
  </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const userForm = document.getElementById("userForm");
        const submitButton = document.getElementById("submitButton");

        userForm.addEventListener("change", function() {
            const nama_bengkel = document.getElementById("nama_bengkel").value.trim();
            const no_bengkel = document.getElementById("no_bengkel").value.trim();
            const alamat_bengkel = document.getElementById("alamat_bengkel").value.trim();

            if (nama_bengkel !== "" && no_bengkel !== "" && alamat_bengkel ) {
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