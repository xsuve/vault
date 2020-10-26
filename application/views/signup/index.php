<!-- Sign Up -->
<div class="container-fluid header no-bg">
	<div class="container">
		<div class="row">
      <div class="col-lg-6 col-12">
        <form action="<?php echo URL; ?>signup/signupuser" method="post" class="v-m">
  				<div class="form form-box p-lg-5 p-4">
            <div class="form-title mb-lg-3 mb-3">Sign up</div>
            <div class="form-text">Follow the form below to sign up on Vault.</div>
            <div class="pt-lg-5 pt-5">
              <div class="form-group mb-lg-4 mb-4">
                <label for="emailAddress">Email address</label>
                <input type="email" name="email" class="form-control" id="emailAddress" placeholder="Enter email address">
              </div>
              <div class="form-group mb-lg-4 mb-4">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Enter password">
								<small class="form-text text-muted">The password must be at least 8 characters long and contain at least a number and a symbol.</small>
              </div>
              <div class="form-group mb-lg-4 mb-4">
                <label for="confirmPassword">Confirm password</label>
                <input type="password" name="confirm_password" class="form-control" id="confirmPassword" placeholder="Enter password again">
              </div>
              <button type="submit" name="submit_signup" class="btn btn-primary btn-block">Sign Up</button>
            </div>
          </div>
        </form>
			</div>
			<div class="col-lg-6 col-12">
				<div class="header-content v-m">
					<div class="header-logo mb-lg-5 mb-5">
            <a href="<?php echo URL; ?>"><img src="<?php echo URL; ?>public/img/vault-logo.svg"></a>
          </div>
					<div class="header-title mb-lg-4 mb-4">Sign up for a Vault account</div>
					<div class="header-text pr-lg-5">Welcome to Vault!<br>Vault makes it easy for developers and teams to connect, share and manage the contact details of all their website accounts.<br><br><br>Already have an account?</div>
					<div class="header-buttons mt-lg-5 mt-5">
						<a href="<?php echo URL; ?>login"><button class="btn btn-transparent btn-icon"><i data-feather="user"></i><span>Log In</span></button></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
