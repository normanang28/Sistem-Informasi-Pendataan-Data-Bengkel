	<div class="profile-uoloaded-post border-bottom-1 pb-5 custom-card">
		<div class="row align-items-center">
			<div class="col-md-6">
				<img src="<?= base_url('assets/images/service/' . $gas->foto_kendaraan) ?>" alt="" class="img-fluid custom-image rounded-start">
			</div>
			<div class="col-md-6">
				<a class="post-title">
					<h3 class="text-black text-capitalize"><?php echo $gas->merk_kendaraan ?> / <?php echo $gas->plat_kendaraan ?></h3>
					<h5 class="text-black text-capitalize"><?php echo $gas->nama_bengkel ?> (<?php echo $gas->no_bengkel ?>)</h5>
					<h5 class="text-black text-capitalize"><?php echo $gas->alamat_bengkel ?></h5>
				</a>
				<br>
				<h5 >Vehicle Service : <?php echo $gas->service_kendaraan ?> ~ <?php echo $gas->tanggal_service ?></h5> 
				<br>
				<h6 style="float: right;" class=" <?php echo ($gas->status_kendaraan === 'Not Approved') ? 'text-danger' : (($gas->status_kendaraan === 'Already Serviced') ? 'text-success' : 'text-dark'); ?>"><?php echo $gas->status_kendaraan ?></h6>
			</div>
			<div class="d-flex justify-content-end"> 
			    <a href="<?= base_url('/home/vehicle_maintenance/') ?>">
			        <button class="btn btn-info" style="margin-right: 10px;"><i class="fa fa-reply"></i> Back</button>
			    </a>
<?php if (session()->get('level') == 2 && $gas->status_kendaraan == "Not Approved") { ?>
			   	<a href="<?= base_url('/home/approved/' . $gas->id_kendaraan) ?>">
			        <button class="btn btn-success"><i class="fa fa-check"></i> Approved</button>
			    </a>
<?php }else{} ?>

<?php if (session()->get('level') == 3 && $gas->status_kendaraan == "Approved") { ?>
				    <a href="<?= base_url('/home/already_serviced/' . $gas->id_kendaraan) ?>">
				        <button class="btn btn-success"><i class="fas fa-check"></i> Already Serviced</button>
				    </a>
<?php }else{} ?>
			</div>
		</div>
	</div>
</div>
</div>
<style>
	.custom-image {
		width: 10000px; 
		height: 325px; 
		object-fit: cover; 
		border-top-left-radius: 10px; 
		border-bottom-left-radius: 10px; 
	}

	.custom-card {
		background-color: #fff; 
		padding: 20px; 
		border-radius: 10px; 
		box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
		margin-bottom: 20px; 
	}

	.custom-card {
		text-align: justify; 
	}
</style>
<script>
	document.addEventListener('DOMContentLoaded', function () {
		let timeout;
		const timeoutDuration = 2 * 60 * 1000; 

		function startTimeout() {
			clearTimeout(timeout); 
			timeout = setTimeout(redirectToDashboard, timeoutDuration);
		}

		function redirectToDashboard() {
			window.location.href = '<?= base_url('/home/vehicle_maintenance') ?>'; 
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