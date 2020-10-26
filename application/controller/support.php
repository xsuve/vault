<?php

class Support extends Controller {

  public function index() {
    require 'application/views/_templates/header.php';
    require 'application/views/_templates/alerts.php';
    require 'application/views/support/index.php';
    require 'application/views/_templates/footer.php';
  }

  public function send() {
    if(isset($_POST['submit_send'])) {
      $support_model = $this->loadModel('SupportModel');
      $send = $support_model->sendSupport($_POST['email'], $_POST['subject'], $_POST['message']);

      if(isset($send) && $send != null) {
        $_SESSION['alert'] = $send;
        header('location: ' . URL . 'support');
      } else {
        header('location: ' . URL . 'support');
      }
    } else {
      header('location: ' . URL);
    }
  }

}

?>
