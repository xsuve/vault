    <!-- Notifications -->
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

          <!-- Notifications -->
          <div class="dashboard-body-title mb-lg-4">Notifications</div>
          <?php if(count($user_notifications) > 0): ?>
            <div class="dashboard-body-notifications">
              <div class="row">
                <div class="col-lg-6">
                  <?php foreach($user_notifications as $user_notification): ?>
                    <a href="<?php echo $user_notification->notification_link; ?>">
                      <div class="dashboard-body-notification p-lg-4 p-4 <?php echo ($user_notification->unread ? 'unread-notification' : ''); ?>"  data-notification-id="<?php echo $user_notification->id; ?>">
                        <div class="row">
                          <div class="col-lg-2 col-2">
                            <div class="dashboard-body-notification-icon v-m">
                              <i data-feather="user" class="v-m"></i>
                            </div>
                          </div>
                          <div class="col-lg-10 col-10">
                            <div class="v-m">
                              <div class="dashboard-body-notification-title"><?php echo $user_notification->notification_text; ?></div>
                              <div class="dashboard-body-notification-text"><?php echo $notifications_model->formatNotificationDate($user_notification->notification_date); ?></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </a>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          <?php else: ?>
            <div class="dashboard-body-text">You don't have any notifications yet.</div>
          <?php endif; ?>

        </div>

      </div>
    </div>

  <!-- Container End -->
  </div>
</div>
