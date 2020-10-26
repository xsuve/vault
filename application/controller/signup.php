<?php

class Signup extends Controller {

  public function index() {
    $user = $this->getSessionUser();

    if($user == null) {
      require 'application/views/_templates/header.php';
      require 'application/views/_templates/alerts.php';
      require 'application/views/signup/index.php';
      require 'application/views/_templates/footer.php';
    } else {
      header('location: ' . URL);
    }
  }

  // Sign Up User
  public function signupUser() {
    $user = $this->getSessionUser();

    if($user == null) {
      if(isset($_POST['submit_signup'])) {
        $sign_up_model = $this->loadModel('SignUpModel');
        $sign_up_user = $sign_up_model->signupUser($_POST['email'], $_POST['password'], $_POST['confirm_password']);

        if(isset($sign_up_user) && $sign_up_user != null) {
          $_SESSION['alert'] = $sign_up_user;
          header('location: ' . URL . 'signup');
        } else {
          header('location: ' . URL . 'login');
        }
      }
    } else {
      header('location: ' . URL);
    }
  }
}

?>
