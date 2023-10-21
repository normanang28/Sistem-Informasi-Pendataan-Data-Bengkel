<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="card">
        <div class="card-body">
            <div class="basic-form">
                <form id="profileForm" class="form-horizontal form-label-left" enctype="multipart/form-data" novalidate action="<?= base_url('home/aksi_change_profile_user')?>" method="post">

                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="control-label col-12">Replace New Profile<span style="color: red;">*</span></label>
                            <div class="col-12">
                                <input type="file" name="foto" class="form-file-input form-control col-12">
                            </div>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">NIK<span style="color: red;">*</span></label>
                            <input type="number" id="nik" name="nik" 
                            class="form-control text-capitalize" placeholder="NIK" value="<?= $users->nik?>">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Full Name<span style="color: red;">*</span></label>
                            <input type="text" id="nama_pengguna" name="nama_pengguna" 
                            class="form-control text-capitalize" placeholder="Full Name" value="<?= $users->nama_pengguna?>">
                        </div>
                        <div class="mb-3 col-md-6">
                          <label class="control-label col-12" >Gender<span style="color: red;">*</span>
                          </label>
                          <div class="col-12">
                            <select id="jk_pengguna" class="form-control col-12" data-validate-length-range="6" data-validate-words="2" name="jk_pengguna" required="required">
                              <option  value="<?= $users->jk_pengguna?>"><?= $users->jk_pengguna; ?></option>
                              <option value="Male">Male</option>
                              <option value="Female">Female</option>
                            </select>
                          </div>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Place And Date Of Birth<span style="color: red;">*</span></label>
                            <input type="text" id="ttl_pengguna" name="ttl_pengguna" 
                            class="form-control text-capitalize" placeholder="Place And Date Of Birth" value="<?= $users->ttl_pengguna?>">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Telephone Number<span style="color: red;">*</span></label>
                            <input type="Number" id="no_telp_pengguna" name="no_telp_pengguna" 
                            class="form-control text-capitalize" placeholder="Telephone Number" oninput="maxLengthCheck(this)" value="<?= $users->no_telp_pengguna?>">
                            <script>
                                function maxLengthCheck(object) {
                                    if (object.value.length > 20)
                                        object.value = object.value.slice(0, 20);
                                }
                            </script>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Address<span style="color: red;">*</span></label>
                            <input type="text" id="alamat" name="alamat" 
                            class="form-control text-capitalize" placeholder="Address" value="<?= $users->alamat?>">
                        </div>
                        <div class="mb-3 col-md-6">
                          <label class="control-label col-12" >Username<span style="color: red;">*</span>
                          </label>
                            <input type="text" id="username" name="username" placeholder="Username" required="required" class="form-control col-12 text-capitalize" value="<?= $use->username?>">
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
            nik: "<?= $users->nik ?>",
            nama_pengguna: "<?= $users->nama_pengguna ?>",
            jk_pengguna: "<?= $users->jk_pengguna ?>",
            ttl_pengguna: "<?= $users->ttl_pengguna ?>",
            no_telp_pengguna: "<?= $users->no_telp_pengguna ?>",
            alamat: "<?= $users->alamat ?>",
            username: "<?= $use->username ?>"
        };

        profileForm.addEventListener("change", function() {
            const currentData = {
                nik: document.getElementById("nik").value.trim(),
                nama_pengguna: document.getElementById("nama_pengguna").value.trim(),
                jk_pengguna: document.getElementById("jk_pengguna").value,
                ttl_pengguna: document.getElementById("ttl_pengguna").value.trim(),
                no_telp_pengguna: document.getElementById("no_telp_pengguna").value.trim(),
                alamat: document.getElementById("alamat").value.trim(),
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

    const data = <?= json_encode($duar) ?>; 
    const itemsPerPage = 50;
    let currentPage = 1;
});
</script>