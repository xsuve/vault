<?php

class Login extends Controller {

  public function index() {
    $user = $this->getSessionUser();

    if($user == null) {
      require 'application/views/_templates/header.php';
      require 'application/views/_templates/alerts.php';
      require 'application/views/login/index.php';
      require 'application/views/_templates/footer.php';
    } else {
      header('location: ' . URL);
    }
  }

  // Forgot
  public function forgot() {
    $user = $this->getSessionUser();

    if($user == null) {
      require 'application/views/_templates/header.php';
      require 'application/views/_templates/alerts.php';
      require 'application/views/login/forgot_password.php';
      require 'application/views/_templates/footer.php';
    } else {
      header('location: ' . URL);
    }
  }

  // Forgot Password
  public function forgotPassword() {
    $user = $this->getSessionUser();

    if($user == null) {
      if(isset($_POST['submit_forgot_password'])) {
        $log_in_model = $this->loadModel('LoginModel');
        $forgot_password = $log_in_model->forgotPassword($_POST['email']);

        if(isset($forgot_password) && $forgot_password != null) {
          $_SESSION['alert'] = $forgot_password;
          header('location: ' . URL . 'login');
        } else {
          header('location: ' . URL . 'login');
        }
      } else {
        header('location: ' . URL);
      }
    }
  }

  // Reset
  public function reset($email = null, $token = null) {
    if(isset($email) && isset($token)) {
      $log_in_model = $this->loadModel('LoginModel');
      $check_reset_password_token = $log_in_model->checkResetPasswordToken($email, $token);

      if($check_reset_password_token) {
        $user = $this->getSessionUser();

        if($user == null) {
          require 'application/views/_templates/header.php';
          require 'application/views/_templates/alerts.php';
          require 'application/views/login/reset_password.php';
          require 'application/views/_templates/footer.php';
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

  // Forgot Password
  public function resetPassword($email = null, $token = null) {
    if(isset($email) && isset($token)) {
      $log_in_model = $this->loadModel('LoginModel');
      $check_reset_password_token = $log_in_model->checkResetPasswordToken($email, $token);

      if($check_reset_password_token) {
        $user = $this->getSessionUser();

        if($user == null) {
          if(isset($_POST['submit_reset_password'])) {
            $reset_password = $log_in_model->resetPassword($email, $_POST['new_password'], $_POST['confirm_new_password']);

            if(isset($reset_password) && $reset_password != null) {
              $_SESSION['alert'] = $reset_password;
              header('location: ' . URL . 'login');
            } else {
              header('location: ' . URL . 'login');
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

  // Log In User
  public function loginUser() {
    $user = $this->getSessionUser();

    if($user == null) {
      if(isset($_POST['submit_login'])) {
        $log_in_model = $this->loadModel('LoginModel');
        $log_in_user = $log_in_model->loginUser($_POST['email'], $_POST['password']);

        if(isset($log_in_user) && $log_in_user != null) {
          $_SESSION['alert'] = $log_in_user;
          header('location: ' . URL . 'login');
        } else {
          header('location: ' . URL . 'login');
        }
      } else {
        header('location: ' . URL);
      }
    }
  }

  // Log In Link
  public function loginLink($email = null, $token = null) {
    if(isset($email) && isset($token)) {
      $user = $this->getSessionUser();

      if($user == null) {
        $login_model = $this->loadModel('LogInModel');
        $log_in_link = $login_model->loginLink($email, $token);

        if(isset($log_in_link) && $log_in_link != null) {
          $_SESSION['alert'] = $log_in_link;
          header('location: ' . URL . 'login');
        } else {
          header('location: ' . URL . 'login');
        }
      } else {
        header('location: ' . URL);
      }
    } else {
      header('location: ' . URL . 'login');
    }
  }

  // Verify User
  public function verifyUser($email = null, $token = null) {
    if(isset($email) && isset($token)) {
      $user = $this->getSessionUser();

      if($user == null) {
        $login_model = $this->loadModel('LogInModel');
        $verify_user = $login_model->verifyUser($email, $token);

        if(isset($verify_user) && $verify_user != null) {
          $_SESSION['alert'] = $verify_user;
          header('location: ' . URL);
        } else {
          header('location: ' . URL . 'login');
        }
      } else {
        header('location: ' . URL);
      }
    } else {
      header('location: ' . URL . 'login');
    }
  }

}

?>
