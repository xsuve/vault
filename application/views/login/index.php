<!-- Log In -->
<div class="container-fluid header no-bg">
	<div class="container">
		<div class="row">
      <div class="col-lg-6 col-12">
        <form action="<?php echo URL; ?>login/loginuser" method="post" class="v-m">
  				<div class="form form-box p-lg-5 p-4">
            <div class="form-title mb-lg-3 mb-3">Log in</div>
            <div class="form-text">Follow the form below to log into your Vault account. A one time login link will be sent to your email address.</div>
            <div class="pt-lg-5 pt-5">
              <div class="form-group mb-lg-4 mb-4">
                <label for="emailAddress">Email address</label>
                <input type="email" name="email" class="form-control" id="emailAddress" placeholder="Enter email address">
              </div>
              <div class="form-group mb-lg-4 mb-4">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Enter password">
              </div>
              <button type="submit" name="submit_login" class="btn btn-primary btn-block">Log In</button>
              <div class="form-text mt-lg-5 mt-5">Forgot Password? <a href="<?php echo URL; ?>login/forgot">Forgot Password</a></div>
            </div>
          </div>
        </form>
			</div>
			<div class="col-lg-6 col-12">
				<div class="header-content v-m">
					<div class="header-logo mb-lg-5 mb-5">
            <a href="<?php echo URL; ?>"><img src="<?php echo URL; ?>public/img/vault-logo.svg"></a>
          </div>
					<div class="header-title mb-lg-4 mb-4">Log into your Vault account</div>
					<div class="header-text pr-lg-5">Welcome back, user! Glad to have you back on Vault.<br><br><br>Don't have an account?</div>
					<div class="header-buttons mt-lg-5 mt-5">
						<a href="<?php echo URL; ?>signup"><button class="btn btn-transparent btn-icon"><i data-feather="user"></i><span>Sign Up</span></button></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
