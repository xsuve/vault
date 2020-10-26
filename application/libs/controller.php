<?php

class Controller {

  public $db = null;

  function __construct() {
    if(!isset($_SESSION['user'])) {
      session_start();
    }

    $this->openDatabaseConnection();
  }

  // Session Account
  public function getSessionUser() {
    if(isset($_SESSION['user']) && $_SESSION['user'] != '') {
      $sql = 'SELECT * FROM vault_users WHERE email = :email';
      $query = $this->db->prepare($sql);
      $query->execute(array(':email' => $_SESSION['user']));

      return $query->fetch();
    }
  }

  // Generate URL
  public function generateURL($activity_title) {
    $activity_title = strtolower(strip_tags($activity_title));

    return str_replace(' ', '-', preg_replace("/[^A-Za-z0-9 ]/", '', $activity_title));
  }

  private function openDatabaseConnection() {
    $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);
    $this->db = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS, $options);
  }

  public function dp($x) {
    echo '<pre style="overflow-x: auto; white-space: pre-wrap; white-space: -moz-pre-wrap; white-space: -pre-wrap; white-space: -o-pre-wrap; word-wrap: break-word;">';
    print_r($x);
    echo '</pre>';
    die();
  }

  public function loadModel($model_name) {
    require 'application/models/' . strtolower($model_name) . '.php';
    return new $model_name($this->db);
  }

}

?>
