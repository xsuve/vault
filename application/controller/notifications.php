<?php

class Notifications extends Controller {

  public function index() {
    $user = $this->getSessionUser();

    if($user != null) {
      if($user->plan_id != 0) {
        $home_model = $this->loadModel('HomeModel');
        $user_accounts = $home_model->getUserAccounts($user->id);
        $shared_accounts = $home_model->getUserSharedAccounts($user->id);

        $plans_model = $this->loadModel('PlansModel');
        $user_plan = $plans_model->getPlan($user->plan_id);

        $account_model = $this->loadModel('AccountModel');

        $notifications_model = $this->loadModel('NotificationsModel');
        $user_notifications = $notifications_model->getUserNotifications($user->id);
        $user_unread_notifications = $notifications_model->getUserUnreadNotifications($user->id);

        require 'application/views/_templates/header.php';
        require 'application/views/_templates/alerts.php';
        require 'application/views/_templates/sidebar.php';
        require 'application/views/notifications/index.php';
        require 'application/views/_templates/footer.php';
      } else {
        header('location: ' . URL);
      }
    } else {
      header('location: ' . URL);
    }
  }

  // Search User by Email
  public function readNotification($notification_id) {
    if(isset($notification_id)) {
      $user = $this->getSessionUser();

      if($user != null) {
        $notifications_model = $this->loadModel('NotificationsModel');
        $notification = $notifications_model->getUserNotification($notification_id);

        if($notification) {
          if($notification->user_id == $user->id) {
            if($notification->unread == true) {
              $read_notification = $notifications_model->readNotification($notification_id);
            }
          }
        }
      }
    }
  }

}

?>
