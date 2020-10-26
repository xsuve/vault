<!-- Forgot Password -->
<div class="container-fluid header no-bg">
	<div class="container">
		<div class="row">
      <div class="col-lg-6 col-12">
        <form action="<?php echo URL; ?>login/forgotpassword" method="post" class="v-m">
  				<div class="form form-box p-lg-5 p-4">
            <div class="form-title mb-lg-3 mb-3">Forgot password</div>
            <div class="form-text">Follow the form below to reset your account password. We will send a reset password link to you.</div>
            <div class="pt-lg-5 pt-5">
              <div class="form-group mb-lg-4 mb-4">
                <label for="emailAddress">Account email address</label>
                <input type="email" name="email" class="form-control" id="emailAddress" placeholder="Enter account email address">
              </div>
              <button type="submit" name="submit_forgot_password" class="btn btn-primary btn-block">Send Reset Link</button>
            </div>
          </div>
        </form>
			</div>
			<div class="col-lg-6 col-12">
				<div class="header-content v-m">
					<div class="header-logo mb-lg-5 mb-5">
            <a href="<?php echo URL; ?>"><img src="<?php echo URL; ?>public/img/vault-logo.svg"></a>
          </div>
					<div class="header-title mb-lg-4 mb-4">Reset your Vault account password</div>
					<div class="header-text pr-lg-5">Did you forget your password? No worries, we will help you get your account back as soon as possible.</div>
					<div class="header-buttons mt-lg-5 mt-5">
						<a href="<?php echo URL; ?>support"><button class="btn btn-transparent btn-icon"><i data-feather="help-circle"></i><span>Support</span></button></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
