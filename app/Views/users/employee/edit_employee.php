<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="card">
        <div class="card-body">
            <div class="basic-form">
                <form id="userForm" class="form-horizontal form-label-left" novalidate  action="<?= base_url('home/aksi_edit_employee')?>" method="post">
                    <input type="hidden" name="id" value="<?= $duar->id_user ?>">

                    <div class="row">
                         <div class="mb-3 col-md-6">
                            <label class="form-label">NIP<span style="color: red;">*</span></label>
                            <input type="Number" id="nip" name="nip" 
                            class="form-control text-capitalize" placeholder="NIP" value="<?= $duar->nip?>">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Employee Name<span style="color: red;">*</span></label>
                            <input type="text" id="nama_karyawan" name="nama_karyawan" 
                            class="form-control text-capitalize" placeholder="Employee Name" value="<?= $duar->nama_karyawan?>">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Gender<span style="color: red;">*</span></label>
                            <div class="col-12">
                            <select id="jk_karyawan" class="form-control col-12" data-validate-length-range="6" data-validate-words="2" name="jk_karyawan" required="required">
                              <option value="<?= $duar->jk_karyawan?>"><?= $duar->jk_karyawan; ?></option>
                              <option value="Male">Male</option>
                              <option value="Female">Female</option>
                            </select>
                          </div>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Place And Date Of Birth<span style="color: red;">*</span></label>
                            <input type="text" id="ttl_karyawan" name="ttl_karyawan" 
                            class="form-control text-capitalize" placeholder="Place And Date Of Birth" value="<?= $duar->ttl_karyawan?>">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Username<span style="color: red;">*</span></label>
                            <input type="text" id="username" name="username" 
                            class="form-control text-capitalize" placeholder="Username" value="<?= $duar->username?>">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Level<span style="color: red;">*</span></label>
                            <div class="col-12">
                                <select id="level" class="form-control col-12" data-validate-length-range="6" data-validate-words="2" name="level" required="required">
                                  <option value="<?= $duar->level?>"><?= $duar->level; ?></option>
                                  <option value="1">Admin</option>
                                  <option value="2">Manager</option>
                                  <option value="3">Employee</option>
                              </select>
                          </div>
                      </div>
                  </div>
                  <a href="<?= base_url('/home/employee')?>" type="submit" class="btn btn-primary">Cancel</a></button>
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
            nip: "<?= $duar->nip ?>",
            nama_karyawan: "<?= $duar->nama_karyawan ?>",
            jk_karyawan: "<?= $duar->jk_karyawan ?>",
            ttl_karyawan: "<?= $duar->ttl_karyawan ?>",
            username: "<?= $duar->username ?>",
            level: "<?= $duar->level ?>"
        };

        userForm.addEventListener("change", function() {
            const currentData = {
                nip: document.getElementById("nip").value.trim(),
                nama_karyawan: document.getElementById("nama_karyawan").value.trim(),
                jk_karyawan: document.getElementById("jk_karyawan").value,
                ttl_karyawan: document.getElementById("ttl_karyawan").value.trim(),
                username: document.getElementById("username").value.trim(),
                level: document.getElementById("level").value
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
        window.location.href = '<?= base_url('/home/employee') ?>'; 
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