<!-- Alerts -->
<?php if(isset($_SESSION['alert']) && $_SESSION['alert'] != ''): ?>
	<div class="alert p-lg-4 p-4">
		<div class="row">
			<div class="col-lg-3 col-3">
				<div class="alert-icon v-m">
					<i data-feather="alert-circle" class="v-m"></i>
				</div>
			</div>
			<div class="col-lg-9 col-9">
				<div class="alert-text v-m">
					<span><?php echo $_SESSION['alert']; ?></span>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		function showAlert() {
			$('.alert').animate({
				'opacity': 1,
				'right': '25px'
			}, 350);
			setTimeout(hideAlert, 7500);
		}
		function hideAlert() {
			$('.alert').animate({
				'opacity': 0,
				'right': '-500px'
			}, 350);
		}
		showAlert();
	</script>
	<?php $_SESSION['alert'] = ''; ?>
<?php endif; ?>
