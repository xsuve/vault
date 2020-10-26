    <!-- Profile -->
    <div class="col-lg-9 p-lg-0 p-0">
      <div class="dashboard">
        <div class="dashboard-top-bar pl-lg-4 pr-lg-4 pt-lg-3 pb-lg-3">
					<div class="row">
						<div class="col-lg-6">
							<div class="dashboard-top-bar-back-link v-m">
                <a href="<?php echo URL; ?>">
                  <i data-feather="chevron-left"></i>
                  <span>Back</span>
                </a>
              </div>
						</div>
					</div>
				</div>

        <div class="dashboard-body p-lg-5">

          <!-- Profile -->
          <div class="dashboard-body-user mb-lg-5 mb-5 pb-lg-5 pb-5">
            <div class="row">
              <div class="col-lg-2 col-2">
                <div class="dashboard-body-user-profile">
                  <a href="<?php echo URL; ?>profile/edit">
                    <img src="<?php echo (empty($user->profile_url) ? URL . 'public/img/user.png' : $user->profile_url); ?>">
                  </a>
                </div>
              </div>
              <div class="col-lg-7 col-7">
                <div class="v-m">
                  <div class="dashboard-body-user-badge mb-lg-2 mb-2"><?php echo $user_plan->title; ?> PLAN</div>
                  <div class="dashboard-body-user-email"><?php echo $user->email; ?></div>
                  <div class="dashboard-body-user-text">Member since <?php echo date('j F, Y', strtotime($user->signup_date)); ?></div>
                </div>
              </div>
              <div class="col-lg-3 col-3 text-right">
                <div class="v-m">
                  <a href="<?php echo URL; ?>profile/edit"><button class="btn btn-outline-primary">Edit Profile</button></a>
                </div>
              </div>
            </div>
          </div>

          <!-- Your Subscription -->
          <div class="dashboard-body-title mb-lg-4">Your Plan</div>
          <div class="row">
            <div class="col-lg-6 col-12">
              <div class="dashboard-user-subscription p-lg-4 p-4">
                <div class="row mb-lg-4 mb-4">
                  <div class="col-lg-9 col-9">
                    <div class="dashboard-user-subscription-title mb-lg-3 mb-3"><?php echo $user_plan->title; ?> PLAN</div>
                    <div class="dashboard-user-subscription-price"><sup>$</sup><?php echo number_format($user_plan->price, 2, '.', ''); ?> <sub>/ month</sub></div>
                  </div>
                  <div class="col-lg-3 col-3">
                    <div class="v-m">
                      <div class="dashboard-user-subscription-badge">ACTIVE</div>
                    </div>
                  </div>
                </div>
                <div class="dashboard-user-subscription-info p-lg-4 p-4">
                  <div class="row">
                    <div class="col-lg-7 col-7">
                      <div class="dashboard-user-subscription-info-subtitle">Next Payment</div>
                      <div class="dashboard-user-subscription-info-title">$<?php echo number_format($user_plan->price, 2, '.', ''); ?> on <?php echo date('j F, Y', strtotime($user->subscription_next_payment_date)); ?></div>
                    </div>
                    <div class="col-lg-5 col-5">
                      <div class="dashboard-user-subscription-info-subtitle">Started</div>
                      <div class="dashboard-user-subscription-info-title"><?php echo date('j F, Y', strtotime($user->subscription_start_date)); ?></div>
                    </div>
                  </div>
                </div>
                <?php if($user_plan->name != 'free'): ?>
                  <div class="mt-lg-4 mt-4">
                    <a href="<?php echo URL; ?>profile/unsubscribe"><button class="btn btn-primary btn-block">Unsubscribe</button></a>
                  </div>
                <?php endif; ?>
              </div>
            </div>
            <?php if($user_plan->name == 'free'): ?>
              <div class="col-lg-6 text-right">
                <div class="dashboard-body-upgrade-plan p-lg-4 p-4 text-left">
                  <div class="dashboard-body-upgrade-plan-mask">
                    <i data-feather="star"></i>
                  </div>
                  <div class="dashboard-body-upgrade-plan-title mb-lg-2 mb-2">Upgrade to Vault Pro</div>
                  <div class="dashboard-body-upgrade-plan-text mb-lg-4 mb-4">Get unlimited features for only $<?php echo VAULT_PRO_PRICE; ?> / mo!</div>
                  <a href="<?php echo URL; ?>profile/upgrade"><button class="btn btn-light">Upgrade Plan</button></a>
                </div>
              </div>
            <?php endif; ?>
          </div>

        </div>

      </div>
    </div>

  <!-- Container End -->
  </div>
</div>
