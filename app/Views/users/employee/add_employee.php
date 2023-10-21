<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="card">
        <div class="card-body">
            <div class="basic-form">
                <form id="userForm" class="form-horizontal form-label-left" novalidate  action="<?= base_url('home/aksi_add_employee')?>" method="post">

                    <div class="row">
                         <div class="mb-3 col-md-6">
                            <label class="form-label">NIP<span style="color: red;">*</span></label>
                            <input type="Number" id="nip" name="nip" 
                            class="form-control text-capitalize" placeholder="NIP">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Employee Name<span style="color: red;">*</span></label>
                            <input type="text" id="nama_karyawan" name="nama_karyawan" 
                            class="form-control text-capitalize" placeholder="Employee Name">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Gender<span style="color: red;">*</span></label>
                            <div class="col-12">
                            <select id="jk_karyawan" class="form-control col-12" data-validate-length-range="6" data-validate-words="2" name="jk_karyawan" required="required">
                              <option>Select Gender</option>
                              <option value="Male">Male</option>
                              <option value="Female">Female</option>
                            </select>
                          </div>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Place And Date Of Birth<span style="color: red;">*</span></label>
                            <input type="text" id="ttl_karyawan" name="ttl_karyawan" 
                            class="form-control text-capitalize" placeholder="Place And Date Of Birth">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Username<span style="color: red;">*</span></label>
                            <input type="text" id="username" name="username" 
                            class="form-control text-capitalize" placeholder="Username" maxlength="50">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Level<span style="color: red;">*</span></label>
                            <div class="col-12">
                                <select id="level" class="form-control col-12" data-validate-length-range="6" data-validate-words="2" name="level" required="required">
                                  <option>Select Level</option>
                                  <option value="1">Admin</option>
                                  <option value="2">Manager</option>
                                  <option value="3">Employee</option>
                              </select>
                          </div>
                      </div>
                  </div>
                  <a href="<?= base_url('/home/employee')?>" type="submit" class="btn btn-primary">Cancel</a></button>
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
            const nip = document.getElementById("nip").value.trim();
            const nama_karyawan = document.getElementById("nama_karyawan").value.trim();
            const ttl_karyawan = document.getElementById("ttl_karyawan").value.trim();
            const jk_karyawan = document.getElementById("jk_karyawan").value;
            const username = document.getElementById("username").value.trim();
            const level = document.getElementById("level").value;

            if (nip !== "" && nama_karyawan !== "" && ttl_karyawan !== "" && jk_karyawan !== "Select Gender" !== "" !== "" && username !== "" && level !== "Select Level") {
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