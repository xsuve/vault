<?php

class Profile extends Controller {

  public function index() {
    $user = $this->getSessionUser();

    if($user != null) {
      if($user->plan_id != 0) {
        $home_model = $this->loadModel('HomeModel');
        $user_accounts = $home_model->getUserAccounts($user->id);

        $account_model = $this->loadModel('AccountModel');

        $notifications_model = $this->loadModel('NotificationsModel');
        $user_unread_notifications = $notifications_model->getUserUnreadNotifications($user->id);

        $plans_model = $this->loadModel('PlansModel');
        $user_plan = $plans_model->getPlan($user->plan_id);

        require 'application/views/_templates/header.php';
        require 'application/views/_templates/alerts.php';
        require 'application/views/_templates/sidebar.php';
        require 'application/views/profile/index.php';
        require 'application/views/_templates/footer.php';
      } else {
        header('location: ' . URL);
      }
    } else {
      header('location: ' . URL);
    }
  }

  // Edit profile
  public function edit() {
    $user = $this->getSessionUser();

    if($user != null) {
      if($user->plan_id != 0) {
        $home_model = $this->loadModel('HomeModel');
        $user_accounts = $home_model->getUserAccounts($user->id);

        $account_model = $this->loadModel('AccountModel');

        $notifications_model = $this->loadModel('NotificationsModel');
        $user_unread_notifications = $notifications_model->getUserUnreadNotifications($user->id);

        $plans_model = $this->loadModel('PlansModel');
        $user_plan = $plans_model->getPlan($user->plan_id);

        require 'application/views/_templates/header.php';
        require 'application/views/_templates/alerts.php';
        require 'application/views/_templates/sidebar.php';
        require 'application/views/profile/edit.php';
        require 'application/views/_templates/footer.php';
      } else {
        header('location: ' . URL);
      }
    } else {
      header('location: ' . URL);
    }
  }

  // Edit Profile
  public function editProfile() {
    $user = $this->getSessionUser();

    if($user != null) {
      if(isset($_POST['submit_edit_profile'])) {
        $profile_model = $this->loadModel('ProfileModel');
        $edit_profile = $profile_model->editProfile($user->id, $_FILES['profile_image']);

        if(isset($edit_profile) && $edit_profile != null) {
          $_SESSION['alert'] = $edit_profile;
          header('location: ' . URL . 'profile');
        } else {
          header('location: ' . URL . 'profile');
        }
      } else {
        header('location: ' . URL);
      }
    } else {
      header('location: ' . URL);
    }
  }

  // Update Password
  public function updatePassword() {
    $user = $this->getSessionUser();

    if($user != null) {
      if(isset($_POST['submit_update_password'])) {
        $profile_model = $this->loadModel('ProfileModel');
        $update_password = $profile_model->updatePassword($user->id, $_POST['old_password'], $_POST['new_password'], $_POST['confirm_new_password']);

        if(isset($update_password) && $update_password != null) {
          $_SESSION['alert'] = $update_password;
          header('location: ' . URL . 'profile');
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

  // Subscribe Plan
  public function subscribe($plan_name) {
    if(isset($plan_name)) {
      $user = $this->getSessionUser();

      if($user != null) {
        if($user->plan_id == 0) {
          $profile_model = $this->loadModel('ProfileModel');
          $plans_model = $this->loadModel('PlansModel');

          $plan = $plans_model->getPlanByName($plan_name);

          if($plan) {
            $subscribe_plan = $profile_model->subscribePlan($plan_name, $plan->id, $user->id);

            if(isset($subscribe_plan) && $subscribe_plan != null) {
              switch($subscribe_plan[0]) {
                case 'url':
                  header('location: ' . $subscribe_plan[1]);
                break;
                case 'success':
                  $_SESSION['alert'] = $subscribe_plan[1];
                  header('location: ' . URL);
                break;
                case 'error':
                  $_SESSION['alert'] = $subscribe_plan[1];
                  header('location: ' . URL);
                break;
              }
            } else {
              header('location: ' . URL);
            }
          } else {
            header('location: ' . URL);
          }
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

  // Subscribe Plan
  public function upgrade($plan_name = null) {
    if(isset($plan_name) && $plan_name != null) {
      $user = $this->getSessionUser();

      if($user != null) {
        if($user->plan_id == 1) {
          $profile_model = $this->loadModel('ProfileModel');
          $plans_model = $this->loadModel('PlansModel');

          $plan = $plans_model->getPlanByName($plan_name);

          if($plan) {
            $upgrade_plan = $profile_model->upgradePlan($plan_name, $plan->id, $user->id);

            if(isset($upgrade_plan) && $upgrade_plan != null) {
              switch($upgrade_plan[0]) {
                case 'url':
                  header('location: ' . $upgrade_plan[1]);
                break;
                case 'success':
                  $_SESSION['alert'] = $upgrade_plan[1];
                  header('location: ' . URL);
                break;
                case 'error':
                  $_SESSION['alert'] = $upgrade_plan[1];
                  header('location: ' . URL);
                break;
              }
            } else {
              header('location: ' . URL);
            }
          } else {
            header('location: ' . URL);
          }
        } else {
          header('location: ' . URL);
        }
      } else {
        header('location: ' . URL);
      }
    } else {
      require 'application/views/_templates/header.php';
      require 'application/views/_templates/alerts.php';
      require 'application/views/_templates/upgrade-plan.php';
      require 'application/views/_templates/footer.php';
    }
  }

  // Unsubscribe Plan
  public function unsubscribe() {
    $user = $this->getSessionUser();

    if($user != null) {
      if($user->plan_id != 0) {
        $profile_model = $this->loadModel('ProfileModel');
        $plans_model = $this->loadModel('PlansModel');

        $plan = $plans_model->getPlan($user->plan_id);

        if($plan) {
          if($plan->price != 0) {
            $unsubscribe_plan = $profile_model->unsubscribePlan($user->id, $user->subscription_agreement_id);

            if(isset($unsubscribe_plan) && $unsubscribe_plan != null) {
              $_SESSION['alert'] = $unsubscribe_plan;
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
      } else {
        header('location: ' . URL);
      }
    } else {
      header('location: ' . URL);
    }
  }

  // Check Subscription
  public function checkSubscription() {
    $user = $this->getSessionUser();

    if($user != null) {
      if(!empty($_GET['success'])) {
  	    $success = strip_tags($_GET['success']);

  	    if($success && !empty($_GET['token'])) {
  		    $token = strip_tags($_GET['token']);

          if(!empty($_GET['plan'])) {
            $plan_name = strip_tags($_GET['plan']);

            $plans_model = $this->loadModel('PlansModel');
            $plan = $plans_model->getPlanByName($plan_name);

            if($plan) {
              if($plan->price != 0) {
                $profile_model = $this->loadModel('ProfileModel');
                $check_subscription = $profile_model->checkSubscription($token, $plan->id, $user->id, $user->email);

                if(isset($check_subscription) && $check_subscription != null) {
                  if($check_subscription[0] == 'error') {
                    $_SESSION['alert'] = $check_subscription[1];
                    header('location: ' . URL . 'home/checksubscription/?success=true&plan=' . $plan_name . '&token=' . $token);
                  } else {
                    $_SESSION['alert'] = $check_subscription[1];
                    header('location: ' . URL);
                  }
                } else {
                  header('location: ' . URL);
                }
              } else {
                header('location: ' . URL);
              }
            } else {
              header('location: ' . URL);
            }
          } else {
            header('location: ' . URL);
          }
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

  // Subscription Webhooks
  public function subscriptionWebhooks() {
    $profile_model = $this->loadModel('ProfileModel');
    $subscription_webhooks = $profile_model->subscriptionWebhooks();

    return $subscription_webhooks;
  }

}

?>
