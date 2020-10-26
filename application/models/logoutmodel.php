<?php

class LogoutModel {

  // Logout User
  public function logoutUser() {
    session_destroy();
    session_unset();
  }

}

?>
