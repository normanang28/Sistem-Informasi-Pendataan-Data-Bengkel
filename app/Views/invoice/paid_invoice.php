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
            <?php  if(session()->get('level')== 4) { ?>
                <div class="alert alert-warning" role="alert">
                    <i class="fas fa-exclamation-triangle blinking-icon"></i> Be careful when paying bills service vehicle maintenance!!
                </div>
            <?php }else{} ?> 

            <h4 class="text">Invoice Service Vehicle Maintenance</h4>
            <label class="control-label col-12">Please select a payment method below. If you would like to make a payment using BCA BANK, you can choose the virtual account (VA) payment method.<span class="required"></span></label>
            <label class="control-label col-12">With VA Number: 1434721161066<span class="required"></span></label>
            <a href="https://www.bca.co.id/id/informasi/Edukatips/2022/07/07/09/19/cara-bayar-menggunakan-bca-virtual-account" target="_blank" class="link-underline">How to Pay Using BCA Virtual Account</a>
            <style>
                .link-underline {
                    text-decoration: underline;
                    color: blue; 
                }
                .text {
                    color: blue;
                }
            </style>
            <br>
            <div class="card-body"></div>
            <div class="basic-form">
                <form id="menuForm" class="form-horizontal form-label-left" novalidate  action="<?= base_url('home/aksi_paid_invoice')?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $duar->id_invoice ?>">

                    <div class="row">
                       <div class="mb-3 col-md-6">
                        <label class="control-label col-12">Proof Of Payment<span style="color: red;">*</span></label>
                        <div class="col-12">
                            <input type="file" name="bukti_pembayaran" class="form-file-input form-control col-12">
                        </div>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Payment Method<span style="color: red;">*</span></label>
                        <div class="col-12">
                            <select id="metode_pembayaran" class="form-control col-12" data-validate-length-range="6" data-validate-words="2" name="metode_pembayaran" required="required">
                                <option>Select Payment Method</option>
                                <option value="Credit Card">Credit Card</option>
                                <option value="Bank Transfer / Virtual Account">Bank Transfer / Virtual Account</option>
                                <option value="E-Wallet">E-Wallet</option>
                                <option value="Cash">Cash</option>
                            </select>
                        </div>
                    </div>
                </div>
                <a href="<?= base_url('/home/invoice')?>" type="submit" class="btn btn-primary">Cancel</a></button>
                <button type="submit" id="submitButton" class="btn btn-success" disabled>Pay</button>
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
            const metode_pembayaran = document.getElementById("metode_pembayaran").value.trim();

            if (metode_pembayaran !== "" ) {
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