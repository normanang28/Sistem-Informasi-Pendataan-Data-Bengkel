	<div class="profile-uoloaded-post border-bottom-1 pb-5 custom-card">
		<div class="row align-items-center">
			<div class="col-md-6">
				<img src="<?= base_url('assets/images/barang/' . $gas->foto_barang) ?>" alt="" class="img-fluid custom-image rounded-start">
			</div>
			<div class="col-md-6">
				<a class="post-title">
					<h3 class="text-black text-capitalize"><?php echo $gas->nama_barang ?></h3>
				</a>
				<p><?php echo $gas->remark_barang ?></p>
				<div class="d-flex justify-content-end"> 
				    <a href="<?= base_url('/home/items/') ?>"><button class="btn btn-info" style="margin-right: 10px;"><i class="fa fa-reply"></i></button></a>
  <?php  if(session()->get('level')== 2) { ?>
				    <a href="<?= base_url('/home/edit_items/'.$gas->id_barang)?>"><button class="btn btn-warning" style="margin-right: 10px;"><i class="fa fa-edit"></i></button></a>
				    <a href="<?= base_url('/home/delete_items/'.$gas->id_barang)?>"><button class="btn btn-danger"><i class="fa fa-trash"></i></button></a>
  <?php }else{} ?>

				</div>
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