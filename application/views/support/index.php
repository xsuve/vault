<!-- Support -->
<div class="container-fluid support form">
	<div class="container v-m">
		<div class="row">
			<div class="col-lg-6 col-12">
				<div class="support-logo mb-lg-5 mb-5">
					<a href="<?php echo URL; ?>"><img src="<?php echo URL; ?>public/img/vault-logo.svg"></a>
				</div>
				<form action="<?php echo URL; ?>support/send" method="post">
					<div class="form-group mb-lg-4 mb-4">
						<label for="supportEmail">Email Address</label>
						<input type="text" name="email" class="form-control" id="supportEmail" placeholder="Email Address">
						<small class="form-text text-muted">Enter your email address. Required field.</small>
					</div>
					<div class="form-group mb-lg-4 mb-4">
						<label for="supportSubject">Subject</label>
						<input type="text" name="subject" class="form-control" id="supportSubject" placeholder="Contact Subject">
						<small class="form-text text-muted">Enter the subject of your inquiry. Required field.</small>
					</div>
					<div class="form-group mb-lg-4 mb-4">
						<label for="supportMessage">Message</label>
						<textarea type="text" name="message" class="form-control support-message" id="supportMessage" placeholder="Contact Message"></textarea>
						<small class="form-text text-muted">Enter the message of your inquiry. Required field.</small>
					</div>
					<button class="btn btn-primary" type="submit" name="submit_send">Contact Support</button>
				</form>
			</div>
		</div>
	</div>
</div>
