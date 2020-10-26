<?php

/*

	Vault

*/

  require 'application/config/config.php';

  if(MAINTENANCE_MODE == false) {
    require 'application/libs/application.php';
    require 'application/libs/controller.php';

    $app = new Application();
  } else {
    echo 'Platform maintenance. Please come back later.';
  }

?>
