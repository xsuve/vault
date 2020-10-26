<?php

class Home extends Controller {

  public function index() {
    $user = $this->getSessionUser();

    if($user != null) {
      if($user->plan_id != 0) {
        $home_model = $this->loadModel('HomeModel');
        $user_accounts = $home_model->getUserAccounts($user->id);
        $shared_accounts = $home_model->getUserSharedAccounts($user->id);

        $account_model = $this->loadModel('AccountModel');

        $notifications_model = $this->loadModel('NotificationsModel');
        $user_unread_notifications = $notifications_model->getUserUnreadNotifications($user->id);

        $plans_model = $this->loadModel('PlansModel');
        $user_plan = $plans_model->getPlan($user->plan_id);

        require 'application/views/_templates/header.php';
        require 'application/views/_templates/alerts.php';
        require 'application/views/_templates/sidebar.php';
        require 'application/views/home/dashboard.php';
        require 'application/views/_templates/footer.php';
      } else {
        require 'application/views/_templates/header.php';
        require 'application/views/_templates/alerts.php';
        require 'application/views/_templates/subscribe-plan.php';
        require 'application/views/_templates/footer.php';
      }
    } else {
      require 'application/views/_templates/header.php';
      require 'application/views/_templates/cookies.php';
      require 'application/views/_templates/alerts.php';
      require 'application/views/_templates/navbar-landing.php';
      require 'application/views/home/index.php';
      require 'application/views/_templates/footer.php';
    }
  }

  // Subscribe
  public function subscribe() {
    $user = $this->getSessionUser();

    if($user == null) {
      if(isset($_POST['submit_subscribe'])) {
        $home_model = $this->loadModel('HomeModel');
        $subscribe = $home_model->subscribe($_POST['email']);

        if(isset($subscribe) && $subscribe != null) {
          $_SESSION['alert'] = $subscribe;
          header('location: ' . URL);
        } else {
          header('location: ' . URL);
        }
      } else {
        header('location: ' . URL);
      }
    } else {
      header('location: ' . URL);
    }
  }

}

?>
