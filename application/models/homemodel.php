<?php

class HomeModel {

  // Database
  function __construct($db) {
    try {
      $this->db = $db;
    } catch (PDOException $e) {
      exit('Database connection could not be established.');
    }
  }

  // Subscribe
  public function subscribe($email) {
    if(!empty($email)) {
      $email = strip_tags($email);

      $sql_check = 'SELECT COUNT(id) AS already_subscribed FROM vault_subscribers WHERE email = :email';
      $query_check = $this->db->prepare($sql_check);
      $query_check->execute(array(':email' => $email));
      $already_subscribed = $query_check->fetch()->already_subscribed;

      if($already_subscribed == 0) {
        $date = date_create();
        $subscribe_date = date_format($date, 'Y-m-d');

        $sql_subscribe = 'INSERT INTO vault_subscribers (email, subscribe_date) VALUES (:email, :subscribe_date)';
        $query_subscribe = $this->db->prepare($sql_subscribe);
        $query_subscribe->execute(array(':email' => $email, ':subscribe_date' => $subscribe_date));

        return 'Thanks for subscribing to Vault!';
      } else {
        return 'You have already been subscribed with this email address.';
      }
    } else {
      return 'Please fill in the email input field.';
    }
  }

  // Get User Accounts
  public function getUserAccounts($user_id) {
    $user_id = strip_tags($user_id);

    $sql = 'SELECT * FROM vault_accounts WHERE user_id = :user_id';
    $query = $this->db->prepare($sql);
    $query->execute(array(':user_id' => $user_id));

    return $query->fetchAll();
  }

  // Get User Shared Accounts
  public function getUserSharedAccounts($user_id) {
    $user_id = strip_tags($user_id);

    $sql = 'SELECT A.* FROM vault_accounts A, vault_shared_accounts S WHERE A.id = S.account_id AND S.user_id = :user_id';
    $query = $this->db->prepare($sql);
    $query->execute(array(':user_id' => $user_id));

    return $query->fetchAll();
  }

}

?>
