<!-- Container Start -->
<div class="container-fluid">
	<div class="row">

		<!-- Sidebar -->
		<div class="col-lg-3 p-lg-0">
			<div class="sidebar">
				<div class="sidebar-top-bar p-lg-4">
					<div class="row">
						<div class="col-lg-8">
							<div class="sidebar-top-bar-logo v-m">
								<a href="<?php echo URL; ?>"><img src="<?php echo URL; ?>public/img/vault-logo.svg"></a>
							</div>
						</div>
						<div class="col-lg-4 text-right">
							<a href="<?php echo URL; ?>notifications" class="mr-lg-4 mr-4">
								<div class="sidebar-top-bar-link-icon v-m <?php echo (count($user_unread_notifications) > 0 ? 'has-notifications' : ''); ?>">
									<i data-feather="bell"></i>
								</div>
							</a>
							<a href="<?php echo URL; ?>logout">
								<div class="sidebar-top-bar-link-icon v-m">
									<i data-feather="power"></i>
								</div>
							</a>
						</div>
					</div>
				</div>

				<div class="sidebar-body">
					<div class="sidebar-body-user p-lg-4">
						<div class="sidebar-body-user-profile mb-lg-3">
							<img src="<?php echo (empty($user->profile_url) ? URL . 'public/img/user.png' : $user->profile_url); ?>">
						</div>
						<div class="sidebar-body-user-badge mb-lg-2 mb-2"><?php echo $user_plan->title; ?> PLAN</div>
						<div class="sidebar-body-user-email"><?php echo $user->email; ?></div>
						<div class="sidebar-body-user-text">Member since <?php echo date('j F, Y', strtotime($user->signup_date)); ?></div>
						<div class="row mt-lg-4">
							<div class="col-lg-7">
								<a href="<?php echo URL; ?>account/new"><button class="btn btn-primary btn-block">New Account</button></a>
							</div>
							<div class="col-lg-5">
								<a href="<?php echo URL; ?>profile"><button class="btn btn-outline-primary btn-block">Profile</button></a>
							</div>
						</div>
					</div>

					<?php if(count($user_accounts) > 0): ?>
						<?php $i = 0; ?>
						<div class="sidebar-body-accounts">
							<?php foreach($user_accounts as $user_account): ?>
								<?php
									$account_shared_users_count = count($account_model->getAccountSharedUsers($user_account->id));
								?>
								<a href="<?php echo URL; ?>account/<?php echo $user_account->id; ?>">
									<div class="sidebar-body-account pr-lg-4 pl-lg-4 pt-lg-3 pb-lg-3 <?php echo ($i == (count($user_accounts) - 1) ? 'last' : ($i == 0 ? 'first' : '')); ?>">
										<div class="row">
											<div class="col-lg-10">
												<div class="sidebar-body-account-title"><?php echo $user_account->title; ?></div>
												<div class="sidebar-body-account-text">Shared with <?php echo $account_shared_users_count; ?> <?php echo ($account_shared_users_count > 0 ? ($account_shared_users_count > 1 ? 'users' : 'user') : 'users'); ?></div>
											</div>
											<div class="col-lg-2 text-right">
												<div class="sidebar-body-account-arrow v-m">
													<i data-feather="chevron-right"></i>
												</div>
											</div>
											<div class="col-lg-12 mt-lg-2">
												<?php if(!empty($user_account->cpanel_username)): ?>
													<div class="sidebar-body-account-badge mr-lg-1">cPanel</div>
												<?php endif; ?>
												<?php if(!empty($user_account->ftp_username)): ?>
													<div class="sidebar-body-account-badge mr-lg-1">FTP</div>
												<?php endif; ?>
												<?php if(!empty($user_account->mysql_username)): ?>
													<div class="sidebar-body-account-badge mr-lg-1">MySQL</div>
												<?php endif; ?>
												<?php if(!empty($user_account->email_username)): ?>
													<div class="sidebar-body-account-badge mr-lg-1">Email</div>
												<?php endif; ?>
												<?php if(!empty($user_account->wordpress_admin_username)): ?>
													<div class="sidebar-body-account-badge mr-lg-1">WordPress</div>
												<?php endif; ?>
											</div>
										</div>
									</div>
								</a>
								<?php $i++; ?>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>

				</div>
			</div>
		</div>
