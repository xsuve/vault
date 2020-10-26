    <!-- Edit Profile -->
    <div class="col-lg-9 p-lg-0 p-0">
      <div class="dashboard">
        <div class="dashboard-top-bar pl-lg-4 pr-lg-4 pt-lg-3 pb-lg-3">
					<div class="row">
						<div class="col-lg-6">
							<div class="dashboard-top-bar-back-link v-m">
                <a href="<?php echo URL; ?>profile">
                  <i data-feather="chevron-left"></i>
                  <span>Profile</span>
                </a>
              </div>
						</div>
					</div>
				</div>

        <div class="dashboard-body p-lg-5">
          <form action="<?php echo URL; ?>profile/editprofile" method="post" enctype="multipart/form-data">
            <div class="row">
              <div class="col-lg-6 text-left">
                <div class="dashboard-body-account-title mb-lg-2 mb-2">Edit your profile</div>
                <div class="dashboard-body-account-text mb-lg-4 mb-4">Click the image below to choose a new profile image for your Vault account. The image size must be 180 by 180 pixels.</div>
                <div class="row">
                  <div class="col-lg-4">
                    <div class="dashboard-body-profile-image">
                      <div class="dashboard-body-profile-image-mask">
                        <i data-feather="plus" class="v-m"></i>
                      </div>
                      <input type="file" name="profile_image" id="editProfileChooseImage">
                      <img src="<?php echo (empty($user->profile_url) ? URL . 'public/img/user.png' : $user->profile_url); ?>" id="editProfileImagePreview">
                    </div>
                  </div>
                  <div class="col-lg-8">
                    <div class="v-m">
                      <button type="submit" name="submit_edit_profile" class="btn btn-primary" id="editProfileBtn" disabled>Edit Profile</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>

          <form action="<?php echo URL; ?>profile/updatepassword" method="post">
            <div class="form mt-lg-5 mt-5">
              <div class="dashboard-body-account-title mb-lg-4 mb-4">Update your password</div>
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group mb-lg-4 mb-4">
                    <label for="userOldPassword">Old Password</label>
                    <input type="password" name="old_password" class="form-control" id="userOldPassword" placeholder="Old Password">
                    <small class="form-text text-muted">Your old password.</small>
                  </div>
                  <div class="form-group mb-lg-4 mb-4">
                    <label for="userNewPassword">New Password</label>
                    <input type="password" name="new_password" class="form-control" id="userNewPassword" placeholder="New Password">
                    <small class="form-text text-muted">Your new password.</small>
                  </div>
                  <div class="form-group mb-lg-4 mb-4">
                    <label for="userConfirmNewPassword">Confirm New Password</label>
                    <input type="password" name="confirm_new_password" class="form-control" id="userConfirmNewPassword" placeholder="Confirm New Password">
                    <small class="form-text text-muted">Your new password confirmation.</small>
                  </div>
                  <button type="submit" name="submit_update_password" class="btn btn-primary">Update Password</button>
                </div>
              </div>
            </div>
          </form>
        </div>

      </div>
    </div>

  <!-- Container End -->
  </div>
</div>
