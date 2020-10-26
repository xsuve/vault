<?php

require_once('public/libs/defuse-crypto/defuse-crypto.phar');

class Account extends Controller {

  public function index($account_id) {
    if(isset($account_id)) {
      $user = $this->getSessionUser();

      if($user != null) {
        if($user->plan_id != 0) {
          $account_model = $this->loadModel('AccountModel');
          $account = $account_model->getAccount($account_id);

          $home_model = $this->loadModel('HomeModel');
          $user_accounts = $home_model->getUserAccounts($user->id);

          $notifications_model = $this->loadModel('NotificationsModel');
          $user_unread_notifications = $notifications_model->getUserUnreadNotifications($user->id);

          $is_shared_account = $account_model->isSharedAccount($user->id, $account->id);

          $plans_model = $this->loadModel('PlansModel');
          $user_plan = $plans_model->getPlan($user->plan_id);

          if($account) {
            if($account->user_id == $user->id) {
              require 'application/views/_templates/header.php';
              require 'application/views/_templates/alerts.php';

              if(!isset($_SESSION['account_encryption_key_' . $account->id])) {
                if(isset($_POST['submit_decrypt_data'])) {
                  if(isset($_POST['account_encryption_key']) && !empty($_POST['account_encryption_key'])) {
                    $account_encryption_key = strip_tags($_POST['account_encryption_key']);

                    try {
                      $account->cpanel_username = (!empty($account->cpanel_username) ? \Defuse\Crypto\Crypto::decryptWithPassword($account->cpanel_username, $account_encryption_key) : $account->cpanel_username);
                      $account->cpanel_password = (!empty($account->cpanel_password) ? \Defuse\Crypto\Crypto::decryptWithPassword($account->cpanel_password, $account_encryption_key) : $account->cpanel_password);
                      $account->ftp_username = (!empty($account->ftp_username) ? \Defuse\Crypto\Crypto::decryptWithPassword($account->ftp_username, $account_encryption_key) : $account->ftp_username);
                      $account->ftp_password = (!empty($account->ftp_password) ? \Defuse\Crypto\Crypto::decryptWithPassword($account->ftp_password, $account_encryption_key) : $account->ftp_password);
                      $account->mysql_username = (!empty($account->mysql_username) ? \Defuse\Crypto\Crypto::decryptWithPassword($account->mysql_username, $account_encryption_key) : $account->mysql_username);
                      $account->mysql_password = (!empty($account->mysql_password) ? \Defuse\Crypto\Crypto::decryptWithPassword($account->mysql_password, $account_encryption_key) : $account->mysql_password);
                      $account->email_username = (!empty($account->email_username) ? \Defuse\Crypto\Crypto::decryptWithPassword($account->email_username, $account_encryption_key) : $account->email_username);
                      $account->email_password = (!empty($account->email_password) ? \Defuse\Crypto\Crypto::decryptWithPassword($account->email_password, $account_encryption_key) : $account->email_password);
                      $account->wordpress_admin_username = (!empty($account->wordpress_admin_username) ? \Defuse\Crypto\Crypto::decryptWithPassword($account->wordpress_admin_username, $account_encryption_key) : $account->wordpress_admin_username);
                      $account->wordpress_admin_password = (!empty($account->wordpress_admin_password) ? \Defuse\Crypto\Crypto::decryptWithPassword($account->wordpress_admin_password, $account_encryption_key) : $account->wordpress_admin_password);

                      try {
                        $session_account_encryption_key = \Defuse\Crypto\Crypto::encryptWithPassword(strip_tags($account_encryption_key), $user->password);
                        $_SESSION['account_encryption_key_' . $account->id] = $session_account_encryption_key;
                      } catch(\Defuse\Crypto\Exception\EnvironmentIsBrokenException $ex) {
                        return 'An error has occured while encrypting the account session.';
                      } catch(\Defuse\Crypto\Exception\Exception $ex) {
                        return 'An error has occured while encrypting the account session.';
                      }
                    } catch(\Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException $ex) {
                      $_SESSION['alert'] = 'Invalid encryption key.';
                      header('location: ' . URL . 'account/' . $account->id);
                    } catch(\Defuse\Crypto\Exception\Exception $ex) {
                      $_SESSION['alert'] = 'Invalid encryption key.';
                      header('location: ' . URL . 'account/' . $account->id);
                    }

                    $account_shared_users = $account_model->getAccountSharedUsers($account->id);

                    $max_shared_users_per_account = $plans_model->getPlanFeature($user->plan_id, 'max_shared_users_per_account');

                    require 'application/views/_templates/sidebar.php';
                    require 'application/views/account/index.php';
                  } else {
                    $_SESSION['alert'] = 'Please fill all the required fields.';
                    header('location: ' . URL . 'account/' . $account->id);
                  }
                } else {
                  require 'application/views/_templates/sidebar.php';
                  require 'application/views/account/decrypt_data.php';
                }
              } else {
                if(!empty($_SESSION['account_encryption_key_' . $account->id])) {
                  $session_account_encryption_key = strip_tags($_SESSION['account_encryption_key_' . $account->id]);

                  try {
                    $account_encryption_key = \Defuse\Crypto\Crypto::decryptWithPassword(strip_tags($session_account_encryption_key), $user->password);

                    try {
                      $account->cpanel_username = (!empty($account->cpanel_username) ? \Defuse\Crypto\Crypto::decryptWithPassword($account->cpanel_username, $account_encryption_key) : $account->cpanel_username);
                      $account->cpanel_password = (!empty($account->cpanel_password) ? \Defuse\Crypto\Crypto::decryptWithPassword($account->cpanel_password, $account_encryption_key) : $account->cpanel_password);
                      $account->ftp_username = (!empty($account->ftp_username) ? \Defuse\Crypto\Crypto::decryptWithPassword($account->ftp_username, $account_encryption_key) : $account->ftp_username);
                      $account->ftp_password = (!empty($account->ftp_password) ? \Defuse\Crypto\Crypto::decryptWithPassword($account->ftp_password, $account_encryption_key) : $account->ftp_password);
                      $account->mysql_username = (!empty($account->mysql_username) ? \Defuse\Crypto\Crypto::decryptWithPassword($account->mysql_username, $account_encryption_key) : $account->mysql_username);
                      $account->mysql_password = (!empty($account->mysql_password) ? \Defuse\Crypto\Crypto::decryptWithPassword($account->mysql_password, $account_encryption_key) : $account->mysql_password);
                      $account->email_username = (!empty($account->email_username) ? \Defuse\Crypto\Crypto::decryptWithPassword($account->email_username, $account_encryption_key) : $account->email_username);
                      $account->email_password = (!empty($account->email_password) ? \Defuse\Crypto\Crypto::decryptWithPassword($account->email_password, $account_encryption_key) : $account->email_password);
                      $account->wordpress_admin_username = (!empty($account->wordpress_admin_username) ? \Defuse\Crypto\Crypto::decryptWithPassword($account->wordpress_admin_username, $account_encryption_key) : $account->wordpress_admin_username);
                      $account->wordpress_admin_password = (!empty($account->wordpress_admin_password) ? \Defuse\Crypto\Crypto::decryptWithPassword($account->wordpress_admin_password, $account_encryption_key) : $account->wordpress_admin_password);
                    } catch(\Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException $ex) {
                      $_SESSION['alert'] = 'Invalid encryption key.';
                      header('location: ' . URL . 'account/' . $account->id);
                    } catch(\Defuse\Crypto\Exception\Exception $ex) {
                      $_SESSION['alert'] = 'Invalid encryption key.';
                      header('location: ' . URL . 'account/' . $account->id);
                    }

                    $account_shared_users = $account_model->getAccountSharedUsers($account->id);

                    $max_shared_users_per_account = $plans_model->getPlanFeature($user->plan_id, 'max_shared_users_per_account');

                    require 'application/views/_templates/sidebar.php';
                    require 'application/views/account/index.php';
                  } catch(\Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException $ex) {
                    $_SESSION['account_encryption_key_' . $account->id] = '';
                    $_SESSION['alert'] = 'An error has occured while decrypting the account session. Please try again.';
                    header('location: ' . URL . 'account/' . $account->id);
                  } catch(\Defuse\Crypto\Exception\Exception $ex) {
                    $_SESSION['account_encryption_key_' . $account->id] = '';
                    $_SESSION['alert'] = 'An error has occured while decrypting the account session. Please try again.';
                    header('location: ' . URL . 'account/' . $account->id);
                  }
                } else {
                  $_SESSION['alert'] = 'The account session can not be empty. Please try again.';
                  header('location: ' . URL . 'account/' . $account->id);
                }
              }

              require 'application/views/_templates/footer.php';
            } else {
              if($is_shared_account) {
                $account_shared_users = $account_model->getAccountSharedUsers($account->id);

                $shared_account_owner_user_email = $account_model->getSharedAccountOwnerUserEmail($user->id, $account_id);

                require 'application/views/_templates/header.php';
                require 'application/views/_templates/alerts.php';

                if(!isset($_SESSION['account_encryption_key_' . $account->id])) {
                  if(isset($_POST['submit_decrypt_data'])) {
                    if(isset($_POST['account_encryption_key']) && !empty($_POST['account_encryption_key'])) {
                      $account_encryption_key = strip_tags($_POST['account_encryption_key']);

                      try {
                        $account->cpanel_username = (!empty($account->cpanel_username) ? \Defuse\Crypto\Crypto::decryptWithPassword($account->cpanel_username, $account_encryption_key) : $account->cpanel_username);
                        $account->cpanel_password = (!empty($account->cpanel_password) ? \Defuse\Crypto\Crypto::decryptWithPassword($account->cpanel_password, $account_encryption_key) : $account->cpanel_password);
                        $account->ftp_username = (!empty($account->ftp_username) ? \Defuse\Crypto\Crypto::decryptWithPassword($account->ftp_username, $account_encryption_key) : $account->ftp_username);
                        $account->ftp_password = (!empty($account->ftp_password) ? \Defuse\Crypto\Crypto::decryptWithPassword($account->ftp_password, $account_encryption_key) : $account->ftp_password);
                        $account->mysql_username = (!empty($account->mysql_username) ? \Defuse\Crypto\Crypto::decryptWithPassword($account->mysql_username, $account_encryption_key) : $account->mysql_username);
                        $account->mysql_password = (!empty($account->mysql_password) ? \Defuse\Crypto\Crypto::decryptWithPassword($account->mysql_password, $account_encryption_key) : $account->mysql_password);
                        $account->email_username = (!empty($account->email_username) ? \Defuse\Crypto\Crypto::decryptWithPassword($account->email_username, $account_encryption_key) : $account->email_username);
                        $account->email_password = (!empty($account->email_password) ? \Defuse\Crypto\Crypto::decryptWithPassword($account->email_password, $account_encryption_key) : $account->email_password);
                        $account->wordpress_admin_username = (!empty($account->wordpress_admin_username) ? \Defuse\Crypto\Crypto::decryptWithPassword($account->wordpress_admin_username, $account_encryption_key) : $account->wordpress_admin_username);
                        $account->wordpress_admin_password = (!empty($account->wordpress_admin_password) ? \Defuse\Crypto\Crypto::decryptWithPassword($account->wordpress_admin_password, $account_encryption_key) : $account->wordpress_admin_password);

                        try {
                          $session_account_encryption_key = \Defuse\Crypto\Crypto::encryptWithPassword(strip_tags($account_encryption_key), $user->password);
                          $_SESSION['account_encryption_key_' . $account->id] = $session_account_encryption_key;
                        } catch(\Defuse\Crypto\Exception\EnvironmentIsBrokenException $ex) {
                          return 'An error has occured while encrypting the account session.';
                        } catch(\Defuse\Crypto\Exception\Exception $ex) {
                          return 'An error has occured while encrypting the account session.';
                        }
                      } catch(\Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException $ex) {
                        $_SESSION['alert'] = 'Invalid encryption key.';
                        header('location: ' . URL . 'account/' . $account->id);
                      } catch(\Defuse\Crypto\Exception\Exception $ex) {
                        $_SESSION['alert'] = 'Invalid encryption key.';
                        header('location: ' . URL . 'account/' . $account->id);
                      }

                      $account_shared_users = $account_model->getAccountSharedUsers($account->id);

                      $max_shared_users_per_account = $plans_model->getPlanFeature($user->plan_id, 'max_shared_users_per_account');

                      require 'application/views/_templates/sidebar.php';
                      require 'application/views/account/index.php';
                    } else {
                      $_SESSION['alert'] = 'Please fill all the required fields.';
                      header('location: ' . URL . 'account/' . $account->id);
                    }
                  } else {
                    require 'application/views/_templates/sidebar.php';
                    require 'application/views/account/decrypt_data.php';
                  }
                } else {
                  if(!empty($_SESSION['account_encryption_key_' . $account->id])) {
                    $session_account_encryption_key = strip_tags($_SESSION['account_encryption_key_' . $account->id]);

                    try {
                      $account_encryption_key = \Defuse\Crypto\Crypto::decryptWithPassword(strip_tags($session_account_encryption_key), $user->password);

                      try {
                        $account->cpanel_username = (!empty($account->cpanel_username) ? \Defuse\Crypto\Crypto::decryptWithPassword($account->cpanel_username, $account_encryption_key) : $account->cpanel_username);
                        $account->cpanel_password = (!empty($account->cpanel_password) ? \Defuse\Crypto\Crypto::decryptWithPassword($account->cpanel_password, $account_encryption_key) : $account->cpanel_password);
                        $account->ftp_username = (!empty($account->ftp_username) ? \Defuse\Crypto\Crypto::decryptWithPassword($account->ftp_username, $account_encryption_key) : $account->ftp_username);
                        $account->ftp_password = (!empty($account->ftp_password) ? \Defuse\Crypto\Crypto::decryptWithPassword($account->ftp_password, $account_encryption_key) : $account->ftp_password);
                        $account->mysql_username = (!empty($account->mysql_username) ? \Defuse\Crypto\Crypto::decryptWithPassword($account->mysql_username, $account_encryption_key) : $account->mysql_username);
                        $account->mysql_password = (!empty($account->mysql_password) ? \Defuse\Crypto\Crypto::decryptWithPassword($account->mysql_password, $account_encryption_key) : $account->mysql_password);
                        $account->email_username = (!empty($account->email_username) ? \Defuse\Crypto\Crypto::decryptWithPassword($account->email_username, $account_encryption_key) : $account->email_username);
                        $account->email_password = (!empty($account->email_password) ? \Defuse\Crypto\Crypto::decryptWithPassword($account->email_password, $account_encryption_key) : $account->email_password);
                        $account->wordpress_admin_username = (!empty($account->wordpress_admin_username) ? \Defuse\Crypto\Crypto::decryptWithPassword($account->wordpress_admin_username, $account_encryption_key) : $account->wordpress_admin_username);
                        $account->wordpress_admin_password = (!empty($account->wordpress_admin_password) ? \Defuse\Crypto\Crypto::decryptWithPassword($account->wordpress_admin_password, $account_encryption_key) : $account->wordpress_admin_password);
                      } catch(\Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException $ex) {
                        $_SESSION['alert'] = 'Invalid encryption key.';
                        header('location: ' . URL . 'account/' . $account->id);
                      } catch(\Defuse\Crypto\Exception\Exception $ex) {
                        $_SESSION['alert'] = 'Invalid encryption key.';
                        header('location: ' . URL . 'account/' . $account->id);
                      }

                      $account_shared_users = $account_model->getAccountSharedUsers($account->id);

                      $max_shared_users_per_account = $plans_model->getPlanFeature($user->plan_id, 'max_shared_users_per_account');

                      require 'application/views/_templates/sidebar.php';
                      require 'application/views/account/index.php';
                    } catch(\Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException $ex) {
                      $_SESSION['account_encryption_key_' . $account->id] = '';
                      $_SESSION['alert'] = 'An error has occured while decrypting the account session. Please try again.';
                      header('location: ' . URL . 'account/' . $account->id);
                    } catch(\Defuse\Crypto\Exception\Exception $ex) {
                      $_SESSION['account_encryption_key_' . $account->id] = '';
                      $_SESSION['alert'] = 'An error has occured while decrypting the account session. Please try again.';
                      header('location: ' . URL . 'account/' . $account->id);
                    }
                  } else {
                    $_SESSION['alert'] = 'The account session can not be empty. Please try again.';
                    header('location: ' . URL . 'account/' . $account->id);
                  }
                }

                require 'application/views/_templates/footer.php';
              } else {
                header('location: ' . URL);
              }
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

  // New Account
  public function new() {
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

        $max_accounts = $plans_model->getPlanFeature($user->plan_id, 'max_accounts');
        $wordpress_account_details = $plans_model->getPlanFeature($user->plan_id, 'wordpress_account_details');

        if(count($user_accounts) < $max_accounts) {
          require 'application/views/_templates/header.php';
          require 'application/views/_templates/alerts.php';
          require 'application/views/_templates/sidebar.php';
          require 'application/views/account/new.php';
          require 'application/views/account/new_account_footer.php';
        } else {
          require 'application/views/_templates/header.php';
          require 'application/views/_templates/alerts.php';
          require 'application/views/_templates/upgrade-plan.php';
          require 'application/views/_templates/footer.php';
        }
      } else {
        header('location: ' . URL);
      }
    } else {
      header('location: ' . URL);
    }
  }

  // New Account
  public function newAccount() {
    $user = $this->getSessionUser();

    if($user != null) {
      if(isset($_POST['submit_add_account'])) {
        $home_model = $this->loadModel('HomeModel');
        $user_accounts = $home_model->getUserAccounts($user->id);

        $plans_model = $this->loadModel('PlansModel');
        $max_accounts = $plans_model->getPlanFeature($user->plan_id, 'max_accounts');

        if(count($user_accounts) < $max_accounts) {
          $account_model = $this->loadModel('AccountModel');
          $add_new_account = $account_model->newAccount($user->id, $_POST['account_encryption_key'], $_POST['account_title'], $_POST['account_domain_url'], $_POST['account_expiration_date'], $_POST['account_ip_address'], $_POST['account_cpanel_port'], $_POST['account_cpanel_username'], $_POST['account_cpanel_password'], $_POST['account_ftp_port'], $_POST['account_ftp_username'], $_POST['account_ftp_password'], $_POST['account_ftp_path'], $_POST['account_mysql_host'], $_POST['account_mysql_port'], $_POST['account_mysql_username'], $_POST['account_mysql_password'], $_POST['account_email_username'], $_POST['account_email_password'], $_POST['account_email_smtp_url'], $_POST['account_email_smtp_port'], $_POST['account_email_imap_url'], $_POST['account_email_imap_port'], $_POST['account_email_pop3_url'], $_POST['account_email_pop3_port'], ($_POST['account_wordpress_admin_url'] != null ? $_POST['account_wordpress_admin_url'] : ''), ($_POST['account_wordpress_admin_username'] != null ? $_POST['account_wordpress_admin_username'] : ''), ($_POST['account_wordpress_admin_password'] != null ? $_POST['account_wordpress_admin_password'] : ''));

          if(isset($add_new_account) && $add_new_account != null) {
            $_SESSION['alert'] = $add_new_account;
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
      header('location: ' . URL . 'login');
    }
  }

  // Edit Account
  public function edit($account_id) {
    if(isset($account_id)) {
      $user = $this->getSessionUser();

      if($user != null) {
        if($user->plan_id != 0) {
          $account_model = $this->loadModel('AccountModel');
          $account = $account_model->getAccount($account_id);

          if($account) {
            if($account->user_id == $user->id) {
              $notifications_model = $this->loadModel('NotificationsModel');
              $user_unread_notifications = $notifications_model->getUserUnreadNotifications($user->id);

              $home_model = $this->loadModel('HomeModel');
              $user_accounts = $home_model->getUserAccounts($user->id);

              $plans_model = $this->loadModel('PlansModel');
              $user_plan = $plans_model->getPlan($user->plan_id);
              $wordpress_account_details = $plans_model->getPlanFeature($user->plan_id, 'wordpress_account_details');


              if(isset($_SESSION['account_encryption_key_' . $account->id]) && !empty($_SESSION['account_encryption_key_' . $account->id])) {
                $session_account_encryption_key = strip_tags($_SESSION['account_encryption_key_' . $account->id]);

                try {
                  $account_encryption_key = \Defuse\Crypto\Crypto::decryptWithPassword(strip_tags($session_account_encryption_key), $user->password);

                  try {
                    $account->cpanel_username = (!empty($account->cpanel_username) ? \Defuse\Crypto\Crypto::decryptWithPassword($account->cpanel_username, $account_encryption_key) : $account->cpanel_username);
                    $account->cpanel_password = (!empty($account->cpanel_password) ? \Defuse\Crypto\Crypto::decryptWithPassword($account->cpanel_password, $account_encryption_key) : $account->cpanel_password);
                    $account->ftp_username = (!empty($account->ftp_username) ? \Defuse\Crypto\Crypto::decryptWithPassword($account->ftp_username, $account_encryption_key) : $account->ftp_username);
                    $account->ftp_password = (!empty($account->ftp_password) ? \Defuse\Crypto\Crypto::decryptWithPassword($account->ftp_password, $account_encryption_key) : $account->ftp_password);
                    $account->mysql_username = (!empty($account->mysql_username) ? \Defuse\Crypto\Crypto::decryptWithPassword($account->mysql_username, $account_encryption_key) : $account->mysql_username);
                    $account->mysql_password = (!empty($account->mysql_password) ? \Defuse\Crypto\Crypto::decryptWithPassword($account->mysql_password, $account_encryption_key) : $account->mysql_password);
                    $account->email_username = (!empty($account->email_username) ? \Defuse\Crypto\Crypto::decryptWithPassword($account->email_username, $account_encryption_key) : $account->email_username);
                    $account->email_password = (!empty($account->email_password) ? \Defuse\Crypto\Crypto::decryptWithPassword($account->email_password, $account_encryption_key) : $account->email_password);
                    $account->wordpress_admin_username = (!empty($account->wordpress_admin_username) ? \Defuse\Crypto\Crypto::decryptWithPassword($account->wordpress_admin_username, $account_encryption_key) : $account->wordpress_admin_username);
                    $account->wordpress_admin_password = (!empty($account->wordpress_admin_password) ? \Defuse\Crypto\Crypto::decryptWithPassword($account->wordpress_admin_password, $account_encryption_key) : $account->wordpress_admin_password);
                  } catch(\Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException $ex) {
                    $_SESSION['alert'] = 'Invalid encryption key.';
                    header('location: ' . URL . 'account/' . $account->id);
                  } catch(\Defuse\Crypto\Exception\Exception $ex) {
                    $_SESSION['alert'] = 'Invalid encryption key.';
                    header('location: ' . URL . 'account/' . $account->id);
                  }

                  require 'application/views/_templates/header.php';
                  require 'application/views/_templates/alerts.php';
                  require 'application/views/_templates/sidebar.php';
                  require 'application/views/account/edit.php';
                  require 'application/views/account/edit_account_footer.php';
                } catch(\Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException $ex) {
                  $_SESSION['alert'] = 'An error has occured while decrypting the account session. Please try again.';
                  header('location: ' . URL . 'account/' . $account->id);
                } catch(\Defuse\Crypto\Exception\Exception $ex) {
                  $_SESSION['alert'] = 'An error has occured while decrypting the account session. Please try again.';
                  header('location: ' . URL . 'account/' . $account->id);
                }
              } else {
                $_SESSION['alert'] = 'The account session can not be empty. Please try again.';
                header('location: ' . URL . 'account/' . $account->id);
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

  // Edit Account
  public function editAccount($account_id) {
    if(isset($account_id)) {
      $user = $this->getSessionUser();

      if($user != null) {
        if(isset($_POST['submit_edit_account'])) {
          $account_model = $this->loadModel('AccountModel');
          $account = $account_model->getAccount($account_id);

          if($account) {
            if($account->user_id == $user->id) {
              if(isset($_SESSION['account_encryption_key_' . $account->id]) && !empty($_SESSION['account_encryption_key_' . $account->id])) {
                $session_account_encryption_key = strip_tags($_SESSION['account_encryption_key_' . $account->id]);

                try {
                  $account_encryption_key = \Defuse\Crypto\Crypto::decryptWithPassword(strip_tags($session_account_encryption_key), $user->password);

                  $edit_account = $account_model->editAccount($account_id, $account_encryption_key, $_POST['account_title'], $_POST['account_domain_url'], $_POST['account_expiration_date'], $_POST['account_ip_address'], $_POST['account_cpanel_port'], $_POST['account_cpanel_username'], $_POST['account_cpanel_password'], $_POST['account_ftp_port'], $_POST['account_ftp_username'], $_POST['account_ftp_password'], $_POST['account_ftp_path'], $_POST['account_mysql_host'], $_POST['account_mysql_port'], $_POST['account_mysql_username'], $_POST['account_mysql_password'], $_POST['account_email_username'], $_POST['account_email_password'], $_POST['account_email_smtp_url'], $_POST['account_email_smtp_port'], $_POST['account_email_imap_url'], $_POST['account_email_imap_port'], $_POST['account_email_pop3_url'], $_POST['account_email_pop3_port'], ($_POST['account_wordpress_admin_url'] != null ? $_POST['account_wordpress_admin_url'] : ''), ($_POST['account_wordpress_admin_username'] != null ? $_POST['account_wordpress_admin_username'] : ''), ($_POST['account_wordpress_admin_password'] != null ? $_POST['account_wordpress_admin_password'] : ''));

                  if(isset($edit_account) && $edit_account != null) {
                    $_SESSION['alert'] = $edit_account;
                    header('location: ' . URL . 'account/edit/' . $account->id);
                  } else {
                    header('location: ' . URL . 'account/edit/' . $account->id);
                  }
                } catch(\Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException $ex) {
                  $_SESSION['alert'] = 'An error has occured while decrypting the account session. Please try again.';
                  header('location: ' . URL . 'account/' . $account->id);
                } catch(\Defuse\Crypto\Exception\Exception $ex) {
                  $_SESSION['alert'] = 'An error has occured while decrypting the account session. Please try again.';
                  header('location: ' . URL . 'account/' . $account->id);
                }
              } else {
                $_SESSION['alert'] = 'The account session can not be empty. Please try again.';
                header('location: ' . URL . 'account/' . $account->id);
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
        header('location: ' . URL . 'login');
      }
    } else {
      header('location: ' . URL);
    }
  }

  // Delete Account
  public function delete($account_id) {
    if(isset($account_id)) {
      $user = $this->getSessionUser();

      if($user != null) {
        $account_model = $this->loadModel('AccountModel');
        $account = $account_model->getAccount($account_id);

        if($account) {
          if($account->user_id == $user->id) {
            $delete_account = $account_model->deleteAccount($account_id);

            if(isset($delete_account) && $delete_account != null) {
              if(isset($_SESSION['account_encryption_key_' . $account_id]) && !empty($_SESSION['account_encryption_key_' . $account_id])) {
                unset($_SESSION['account_encryption_key_' . $account_id]);
              }

              $_SESSION['alert'] = $delete_account;
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

  // cPanel Connect
  public function cpanelConnect($account_id) {
    if(isset($account_id)) {
      $user = $this->getSessionUser();

      if($user != null) {
        $account_model = $this->loadModel('AccountModel');
        $account = $account_model->getAccount($account_id);

        if($account) {
          if($account->user_id == $user->id) {
            $res = $account_model->cpanelConnect($account_id);

            // // die($this->dp($res));
            // preg_match_all('/Set-Cookie: (.*)\b/', $res[0], $cookie);
            // header(explode(' secure', $cookie[0][1])[0]);
            // header('location: ' . $res[1]);
            // // echo explode(' secure', $cookie[0][1])[0];
            echo $res[0];
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

  // Search User by Email
  public function searchUserByEmail($email, $account_id) {
    if(isset($email) && isset($account_id)) {
      $user = $this->getSessionUser();

      if($user != null) {
        $account_model = $this->loadModel('AccountModel');
        $account = $account_model->getAccount($account_id);

        if($account) {
          if($account->user_id == $user->id) {
            $check_users = $account_model->searchUserByEmail($user->email, $email);
            $users_by_email = [];

            if(count($check_users) > 0) {
              foreach($check_users as $check_user) {
                if(!$account_model->isSharedWithAccountUser($check_user->id, $account->id)) {
                  array_push($users_by_email, $check_user);
                }
              }

              echo json_encode($users_by_email);
            }
          }
        }
      }
    }
  }

  // Share Account
  public function shareAccount($account_id) {
    if(isset($account_id)) {
      $user = $this->getSessionUser();

      if($user != null) {
        if(isset($_POST['submit_share_account'])) {
          $account_model = $this->loadModel('AccountModel');
          $account = $account_model->getAccount($account_id);

          if($account) {
            if($account->user_id == $user->id) {
              $account_shared_users = $account_model->getAccountSharedUsers($account->id);

              $plans_model = $this->loadModel('PlansModel');
              $max_shared_users_per_account = $plans_model->getPlanFeature($user->plan_id, 'max_shared_users_per_account');

              if(count($account_shared_users) < $max_shared_users_per_account) {
                $share_account = $account_model->shareAccount($user->id, $account_id, $_POST['user_email']);

                if(isset($share_account) && $share_account != null) {
                  $_SESSION['alert'] = $share_account;
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
      } else {
        header('location: ' . URL . 'login');
      }
    } else {
      header('location: ' . URL);
    }
  }

  // Remove Share
  public function removeShared($shared_user_id, $account_id) {
    if(isset($shared_user_id) && isset($account_id)) {
      $user = $this->getSessionUser();

      if($user != null) {
        $account_model = $this->loadModel('AccountModel');
        $shared_account_user = $account_model->getSharedUser($shared_user_id);

        if($shared_account_user) {
          $account = $account_model->getAccount($account_id);

          if($account) {
            if($account->user_id == $user->id) {
              if($account_model->isSharedWithAccountUser($shared_account_user->id, $account_id)) {
                $remove_shared = $account_model->removeShared($shared_user_id);

                if(isset($remove_shared) && $remove_shared != null) {
                  $_SESSION['alert'] = $remove_shared;
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
      } else {
        header('location: ' . URL);
      }
    } else {
      header('location: ' . URL);
    }
  }

}

?>
