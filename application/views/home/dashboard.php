    <!-- Dashboard -->
    <div class="col-lg-9 p-lg-0 p-0">
      <div class="dashboard">
        <div class="dashboard-top-bar pl-lg-4 pr-lg-4 pt-lg-3 pb-lg-3">
					<div class="row">
						<div class="col-lg-6">
							<div class="dashboard-top-bar-input v-m">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i data-feather="search"></i></span>
                  </div>
                  <input type="text" class="form-control" name="search" placeholder="Search accounts" id="searchInput" autocomplete="off">
                </div>
							</div>
						</div>
					</div>
				</div>

        <div class="dashboard-body p-lg-5">

          <!-- My Accounts -->
          <?php if(count($user_accounts) > 0): ?>
            <div class="dashboard-body-title mb-lg-4">My Accounts</div>
            <div class="dashboard-body-accounts">
              <div class="row">
                <?php foreach($user_accounts as $user_account): ?>
                  <?php
                    $account_shared_users = $account_model->getAccountSharedUsers($user_account->id);
                  ?>
                  <div class="col-lg-4 dashboard-body-account-col">
                    <a href="<?php echo URL; ?>account/<?php echo $user_account->id; ?>">
                      <div class="dashboard-body-account p-lg-4 p-4" data-account-title="<?php echo strtolower($user_account->title); ?>">
                        <div class="dashboard-body-account-title"><?php echo $user_account->title; ?></div>
                        <div class="dashboard-body-account-text mb-lg-2">Expires on <?php echo date('j F, Y', strtotime($user_account->expiration_date)); ?></div>
                        <div class="dashboard-body-account-badges pb-lg-3">
                          <?php if(!empty($user_account->cpanel_username)): ?>
  													<div class="dashboard-body-account-badge mr-lg-1">cPanel</div>
  												<?php endif; ?>
  												<?php if(!empty($user_account->ftp_username)): ?>
  													<div class="dashboard-body-account-badge mr-lg-1">FTP</div>
  												<?php endif; ?>
  												<?php if(!empty($user_account->mysql_username)): ?>
  													<div class="dashboard-body-account-badge mr-lg-1">MySQL</div>
  												<?php endif; ?>
  												<?php if(!empty($user_account->email_username)): ?>
  													<div class="dashboard-body-account-badge mr-lg-1">Email</div>
  												<?php endif; ?>
  												<?php if(!empty($user_account->wordpress_admin_username)): ?>
  													<div class="dashboard-body-account-badge mr-lg-1">WordPress</div>
  												<?php endif; ?>
                        </div>
                        <div class="dashboard-body-account-team mt-lg-3">
                          <div class="dashboard-body-account-team-title">Users</div>
                          <div class="dashboard-body-account-team-text">Shared with <?php echo count($account_shared_users); ?> <?php echo (count($account_shared_users) > 0 ? (count($account_shared_users) > 1 ? 'users' : 'user') : 'users'); ?></div>
                          <div class="row mt-lg-3">
                            <?php if(count($account_shared_users) > 0): ?>
                              <?php $i = 0; ?>
                              <?php foreach($account_shared_users as $account_shared_user): ?>
                                <?php if($i <= 3): ?>
                                  <?php
                                    $account_shared_user_data = $account_model->getSharedAccountUser($account_shared_user->user_id);
                                  ?>
                                  <div class="col-lg-2 pr-lg-0">
                                    <div class="dashboard-body-account-team-user">
                                      <img src="<?php echo (empty($account_shared_user_data->profile_url) ? URL . 'public/img/user.png' : $account_shared_user_data->profile_url); ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo $account_shared_user_data->email; ?>">
                                    </div>
                                  </div>
                                <?php endif; ?>
                                <?php $i++; ?>
                              <?php endforeach; ?>
                            <?php endif; ?>
                            <div class="col-lg-2 pr-lg-0">
                              <div class="dashboard-body-account-team-user-plus text-center"><i data-feather="plus" class="v-m"></i></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          <?php else: ?>
            <!-- Onboarding -->
            <div class="dashboard-onboarding p-lg-5 p-5">
              <div class="row">
                <div class="col-lg-3">
                  <div class="dashboard-onboarding-image">
                    <img src="<?php echo URL; ?>public/img/dashboard-add-account.png">
                  </div>
                </div>
                <div class="col-lg-1"></div>
                <div class="col-lg-8">
                  <div class="v-m">
                    <div class="dashboard-onboarding-title mb-lg-3">Add your first account</div>
                    <div class="dashboard-onboarding-text mb-lg-4">By adding an account, you will be able to share it with your team, so you will never have to do the repetitive copy & paste work ever again!</div>
                    <a href="<?php echo URL; ?>account/new"><button class="btn btn-primary">Add New Account</button></a>
                  </div>
                </div>
              </div>
            </div>
          <?php endif; ?>

          <!-- Shared Accounts -->
          <?php if(count($shared_accounts) > 0): ?>
            <div class="dashboard-body-title mb-lg-4 mt-lg-5">Shared Accounts</div>
            <div class="dashboard-body-accounts">
              <div class="row">
                <?php foreach($shared_accounts as $shared_account): ?>
                  <?php
                    $shared_account_shared_users = $account_model->getAccountSharedUsers($shared_account->id);
                  ?>
                  <div class="col-lg-4 dashboard-body-account-col">
                    <a href="<?php echo URL; ?>account/<?php echo $shared_account->id; ?>">
                      <div class="dashboard-body-account p-lg-4 p-4" data-account-title="<?php echo strtolower($shared_account->title); ?>">
                        <div class="dashboard-body-account-title"><?php echo $shared_account->title; ?></div>
                        <div class="dashboard-body-account-text mb-lg-2">Expires on <?php echo date('j F, Y', strtotime($shared_account->expiration_date)); ?></div>
                        <div class="dashboard-body-account-badges pb-lg-3">
                          <?php if(!empty($shared_account->cpanel_username)): ?>
  													<div class="dashboard-body-account-badge mr-lg-1">cPanel</div>
  												<?php endif; ?>
  												<?php if(!empty($shared_account->ftp_username)): ?>
  													<div class="dashboard-body-account-badge mr-lg-1">FTP</div>
  												<?php endif; ?>
  												<?php if(!empty($shared_account->mysql_username)): ?>
  													<div class="dashboard-body-account-badge mr-lg-1">MySQL</div>
  												<?php endif; ?>
  												<?php if(!empty($shared_account->email_username)): ?>
  													<div class="dashboard-body-account-badge mr-lg-1">Email</div>
  												<?php endif; ?>
  												<?php if(!empty($shared_account->wordpress_admin_username)): ?>
  													<div class="dashboard-body-account-badge mr-lg-1">WordPress</div>
  												<?php endif; ?>
                        </div>
                        <div class="dashboard-body-account-team mt-lg-3">
                          <div class="dashboard-body-account-team-title">Users</div>
                          <div class="dashboard-body-account-team-text">Shared with <?php echo count($shared_account_shared_users); ?> <?php echo (count($shared_account_shared_users) > 0 ? (count($shared_account_shared_users) > 1 ? 'users' : 'user') : 'users'); ?></div>
                          <div class="row mt-lg-3">
                            <?php if(count($shared_account_shared_users) > 0): ?>
                              <?php $i = 0; ?>
                              <?php foreach($shared_account_shared_users as $shared_account_shared_user): ?>
                                <?php if($i <= 3): ?>
                                  <?php
                                    $shared_account_shared_user_data = $account_model->getSharedAccountUser($shared_account_shared_user->user_id);
                                  ?>
                                  <div class="col-lg-2 pr-lg-0">
                                    <div class="dashboard-body-account-team-user">
                                      <img src="<?php echo (empty($shared_account_shared_user_data->profile_url) ? URL . 'public/img/user.png' : $shared_account_shared_user_data->profile_url); ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo $shared_account_shared_user_data->email; ?>">
                                    </div>
                                  </div>
                                <?php endif; ?>
                                <?php $i++; ?>
                              <?php endforeach; ?>
                            <?php endif; ?>
                            <div class="col-lg-2 pr-lg-0">
                              <div class="dashboard-body-account-team-user-plus text-center"><i data-feather="plus" class="v-m"></i></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endif; ?>

        </div>

      </div>
    </div>

  <!-- Container End -->
  </div>
</div>
