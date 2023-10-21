<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="card">
        <div class="card-body">
            <div class="basic-form">
                <form id="profileForm" class="form-horizontal form-label-left" enctype="multipart/form-data" novalidate action="<?= base_url('home/aksi_change_profile')?>" method="post">

                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="control-label col-12">Replace New Profile<span style="color: red;">*</span></label>
                            <div class="col-12">
                                <input type="file" name="foto" class="form-file-input form-control col-12">
                            </div>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">NIP<span style="color: red;">*</span></label>
                            <input type="number" id="nip" name="nip" 
                            class="form-control text-capitalize" placeholder="NIP" value="<?= $users->nip?>">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Employee Name<span style="color: red;">*</span></label>
                            <input type="text" id="nama_karyawan" name="nama_karyawan" 
                            class="form-control text-capitalize" placeholder="Employee Name" value="<?= $users->nama_karyawan?>">
                        </div>
                        <div class="mb-3 col-md-6">
                          <label class="control-label col-12" >Gender<span style="color: red;">*</span>
                          </label>
                          <div class="col-12">
                            <select id="jk_karyawan" class="form-control col-12" data-validate-length-range="6" data-validate-words="2" name="jk_karyawan" required="required">
                              <option  value="<?= $users->jk_karyawan?>"><?= $users->jk_karyawan; ?></option>
                              <option value="Male">Male</option>
                              <option value="Female">Female</option>
                          </select>
                      </div>
                  </div>
                  <div class="mb-3 col-md-6">
                    <label class="form-label">Place And Date Of Birth<span style="color: red;">*</span></label>
                    <input type="text" id="ttl_karyawan" name="ttl_karyawan" 
                    class="form-control text-capitalize" placeholder="Place And Date Of Birth" value="<?= $users->ttl_karyawan?>">
                </div>
                  <div class="mb-3 col-md-6">
                  <label class="form-label" >Username<span style="color: red;">*</span>
                  </label>
                  <input type="text" id="username" name="username" placeholder="Username" required="required" class="form-control text-capitalize" value="<?= $use->username?>">
                </div>
        </div>
        <a onclick="history.back()" type="submit" class="btn btn-primary">Cancel</a></button>
        <button type="submit" id="updateButton" class="btn btn-success" disabled>Update</button>
    </form>
</div>
</div>
</div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const profileForm = document.getElementById("profileForm");
        const updateButton = document.getElementById("updateButton");

        const initialData = {
            nip: "<?= $users->nip ?>",
            nama_karyawan: "<?= $users->nama_karyawan ?>",
            jk_karyawan: "<?= $users->jk_karyawan ?>",
            ttl_karyawan: "<?= $users->ttl_karyawan ?>",
            username: "<?= $use->username ?>"
        };

        profileForm.addEventListener("change", function() {
            const currentData = {
                nip: document.getElementById("nip").value.trim(),
                nama_karyawan: document.getElementById("nama_karyawan").value.trim(),
                jk_karyawan: document.getElementById("jk_karyawan").value,
                ttl_karyawan: document.getElementById("ttl_karyawan").value.trim(),
                username: document.getElementById("username").value.trim(),
                foto: document.querySelector('input[type="file"]').value
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
        window.location.href = '<?= base_url('/home/dashboard') ?>';
    }

    document.addEventListener('mousemove', startTimeout);
    document.addEventListener('keypress', startTimeout);

    startTimeout();

    const tableBody = document.querySelector('.table tbody');
    const pageNumbers = document.getElementById('pageNumbers');

    // Data dan variabel kontrol
    const data = <?= json_encode($duar) ?>; 
    const itemsPerPage = 50;
    let currentPage = 1;
});
</script>