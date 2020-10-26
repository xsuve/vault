<?php

class Logout extends Controller {

  public function index() {
    $user = $this->getSessionUser();

    if($user != null) {
      if($_SESSION['user'] == $user->email) {
      	$log_out_model = $this->loadModel('LogoutModel');
        $log_out_model->logoutUser();

      	header('location: ' . URL);
      } else {
        header('location: ' . URL);
      }
    } else {
      header('location: ' . URL);
    }
  }

}

?>
