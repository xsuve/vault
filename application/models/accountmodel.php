<?php

require_once('public/libs/defuse-crypto/defuse-crypto.phar');

class AccountModel {

  // Database
  function __construct($db) {
    try {
      $this->db = $db;
    } catch (PDOException $e) {
      exit('Database connection could not be established.');
    }
  }

  // Get User
  public function getUser($user_id) {
    $user_id = strip_tags($user_id);

    $sql = 'SELECT * FROM vault_users WHERE id = :user_id';
    $query = $this->db->prepare($sql);
    $query->execute(array(':user_id' => $user_id));

    return $query->fetch();
  }

  // Get Account
  public function getAccount($account_id) {
    $account_id = strip_tags($account_id);

    $sql = 'SELECT * FROM vault_accounts WHERE id = :account_id';
    $query = $this->db->prepare($sql);
    $query->execute(array(':account_id' => $account_id));

    return $query->fetch();
  }

  // Get Account Shared Users
  public function getAccountSharedUsers($account_id) {
    $account_id = strip_tags($account_id);

    $sql = 'SELECT * FROM vault_shared_accounts WHERE account_id = :account_id';
    $query = $this->db->prepare($sql);
    $query->execute(array(':account_id' => $account_id));

    return $query->fetchAll();
  }

  // Is Shared Account
  public function isSharedAccount($current_user_id, $account_id) {
    $current_user_id = strip_tags($current_user_id);
    $account_id = strip_tags($account_id);

    $sql = 'SELECT COUNT(A.id) AS is_shared_account FROM vault_shared_accounts S, vault_accounts A WHERE S.account_id = A.id AND A.id = :account_id AND S.user_id = :user_id';
    $query = $this->db->prepare($sql);
    $query->execute(array(':account_id' => $account_id, ':user_id' => $current_user_id));

    $result = $query->fetch()->is_shared_account;

    if($result > 0) {
      return true;
    } else {
      return false;
    }
  }

  // Get Shared Account Owner User Email
  public function getSharedAccountOwnerUserEmail($current_user_id, $account_id) {
    $current_user_id = strip_tags($current_user_id);
    $account_id = strip_tags($account_id);

    $sql = 'SELECT U.email FROM vault_users U, vault_shared_accounts S, vault_accounts A WHERE S.account_id = A.id AND A.id = :account_id AND S.user_id = :user_id AND A.user_id = U.id';
    $query = $this->db->prepare($sql);
    $query->execute(array(':account_id' => $account_id, ':user_id' => $current_user_id));

    return $query->fetch();
  }

  // Get Shared Account User
  public function getSharedAccountUser($user_id) {
    $user_id = strip_tags($user_id);

    $sql = 'SELECT * FROM vault_users U, vault_shared_accounts S WHERE U.id = S.user_id AND S.user_id = :user_id';
    $query = $this->db->prepare($sql);
    $query->execute(array(':user_id' => $user_id));

    return $query->fetch();
  }

  // Get Shared User
  public function getSharedUser($shared_user_id) {
    $shared_user_id = strip_tags($shared_user_id);

    $sql = 'SELECT U.* FROM vault_users U, vault_shared_accounts S WHERE U.id = S.user_id AND S.id = :shared_user_id';
    $query = $this->db->prepare($sql);
    $query->execute(array(':shared_user_id' => $shared_user_id));

    return $query->fetch();
  }

  // cPanel Connect
  public function cpanelConnect($account_id) {
    $account_id = strip_tags($account_id);
    $account = $this->getAccount($account_id);

    if(!empty($account->ip_address) && !empty($account->cpanel_port)) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://' . $account->ip_address . ':' . $account->cpanel_port . '/login/');
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_COOKIESESSION, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'user=' . $account->cpanel_username . '&pass=' . $account->cpanel_password);
        curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookies.txt');
        curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookies.txt');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        $h = curl_exec($ch);
        $c = curl_getinfo($ch, CURLINFO_COOKIELIST);
        $redir = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
        curl_close($ch);

        return array($h, $redir);
    } else {
      return 'This account has no cPanel login details.';
    }
  }

  // New Account
  public function newAccount($user_id, $account_encryption_key, $account_title, $account_domain_url, $account_expiration_date, $account_ip_address, $account_cpanel_port, $account_cpanel_username, $account_cpanel_password, $account_ftp_port, $account_ftp_username, $account_ftp_password, $account_ftp_path, $account_mysql_host, $account_mysql_port, $account_mysql_username, $account_mysql_password, $account_email_username, $account_email_password, $account_email_smtp_url, $account_email_smtp_port, $account_email_imap_url, $account_email_imap_port, $account_email_pop3_url, $account_email_pop3_port, $account_wordpress_admin_url, $account_wordpress_admin_username, $account_wordpress_admin_password) {
    if(!empty($account_encryption_key) && !empty($account_title) && !empty($account_domain_url) && !empty($account_expiration_date) && !empty($account_ip_address)) {
      $user_id = strip_tags($user_id);
      $account_encryption_key = strip_tags($account_encryption_key);
      $account_title = strip_tags($account_title);
      $account_domain_url = strip_tags($account_domain_url);
      $account_expiration_date = strip_tags($account_expiration_date);
      $account_ip_address = strip_tags($account_ip_address);

      try {
        $account_cpanel_port = strip_tags($account_cpanel_port);
        $account_cpanel_username = (!empty($account_cpanel_username) ? \Defuse\Crypto\Crypto::encryptWithPassword(strip_tags($account_cpanel_username), $account_encryption_key) : '');
        $account_cpanel_password = (!empty($account_cpanel_password) ? \Defuse\Crypto\Crypto::encryptWithPassword(strip_tags($account_cpanel_password), $account_encryption_key) : '');

        $account_ftp_port = strip_tags($account_ftp_port);
        $account_ftp_username = (!empty($account_ftp_username) ? \Defuse\Crypto\Crypto::encryptWithPassword(strip_tags($account_ftp_username), $account_encryption_key) : '');
        $account_ftp_password = (!empty($account_ftp_password) ? \Defuse\Crypto\Crypto::encryptWithPassword(strip_tags($account_ftp_password), $account_encryption_key) : '');
        $account_ftp_path = strip_tags($account_ftp_path);

        $account_mysql_host = strip_tags($account_mysql_host);
        $account_mysql_port = strip_tags($account_mysql_port);
        $account_mysql_username = (!empty($account_mysql_username) ? \Defuse\Crypto\Crypto::encryptWithPassword(strip_tags($account_mysql_username), $account_encryption_key) : '');
        $account_mysql_password = (!empty($account_mysql_password) ? \Defuse\Crypto\Crypto::encryptWithPassword(strip_tags($account_mysql_password), $account_encryption_key) : '');

        $account_email_username = (!empty($account_email_username) ? \Defuse\Crypto\Crypto::encryptWithPassword(strip_tags($account_email_username), $account_encryption_key) : '');
        $account_email_password = (!empty($account_email_password) ? \Defuse\Crypto\Crypto::encryptWithPassword(strip_tags($account_email_password), $account_encryption_key) : '');
        $account_email_smtp_url = strip_tags($account_email_smtp_url);
        $account_email_smtp_port = strip_tags($account_email_smtp_port);
        $account_email_imap_url = strip_tags($account_email_imap_url);
        $account_email_imap_port = strip_tags($account_email_imap_port);
        $account_email_pop3_url = strip_tags($account_email_pop3_url);
        $account_email_pop3_port = strip_tags($account_email_pop3_port);

        $account_wordpress_admin_url = strip_tags($account_wordpress_admin_url);
        $account_wordpress_admin_username = (!empty($account_wordpress_admin_username) ? \Defuse\Crypto\Crypto::encryptWithPassword(strip_tags($account_wordpress_admin_username), $account_encryption_key) : '');
        $account_wordpress_admin_password = (!empty($account_wordpress_admin_password) ? \Defuse\Crypto\Crypto::encryptWithPassword(strip_tags($account_wordpress_admin_password), $account_encryption_key) : '');

        $sql_new_account = 'INSERT INTO vault_accounts (user_id, title, expiration_date, domain_url, ip_address, cpanel_port, cpanel_username, cpanel_password, ftp_port, ftp_username, ftp_password, ftp_path, mysql_host, mysql_port, mysql_username, mysql_password, email_username, email_password, email_smtp_url, email_smtp_port, email_imap_url, email_imap_port, email_pop3_url, email_pop3_port, wordpress_admin_url, wordpress_admin_username, wordpress_admin_password) VALUES (:account_user_id, :account_title, :account_expiration_date, :account_domain_url, :account_ip_address, :account_cpanel_port, :account_cpanel_username, :account_cpanel_password, :account_ftp_port, :account_ftp_username, :account_ftp_password, :account_ftp_path, :account_mysql_host, :account_mysql_port, :account_mysql_username, :account_mysql_password, :account_email_username, :account_email_password, :account_email_smtp_url, :account_email_smtp_port, :account_email_imap_url, :account_email_imap_port, :account_email_pop3_url, :account_email_pop3_port, :account_wordpress_admin_url, :account_wordpress_admin_username, :account_wordpress_admin_password)';
        $query_new_account = $this->db->prepare($sql_new_account);
        $query_new_account->execute(array(
          ':account_user_id' => $user_id,
          ':account_title' => $account_title,
          ':account_expiration_date' => $account_expiration_date,
          ':account_domain_url' => $account_domain_url,
          ':account_ip_address' => $account_ip_address,
          ':account_cpanel_port' => $account_cpanel_port,
          ':account_cpanel_username' => $account_cpanel_username,
          ':account_cpanel_password' => $account_cpanel_password,
          ':account_ftp_port' => $account_ftp_port,
          ':account_ftp_username' => $account_ftp_username,
          ':account_ftp_password' => $account_ftp_password,
          ':account_ftp_path' => $account_ftp_path,
          ':account_mysql_host' => $account_mysql_host,
          ':account_mysql_port' => $account_mysql_port,
          ':account_mysql_username' => $account_mysql_username,
          ':account_mysql_password' => $account_mysql_password,
          ':account_email_username' => $account_email_username,
          ':account_email_password' => $account_email_password,
          ':account_email_smtp_url' => $account_email_smtp_url,
          ':account_email_smtp_port' => $account_email_smtp_port,
          ':account_email_imap_url' => $account_email_imap_url,
          ':account_email_imap_port' => $account_email_imap_port,
          ':account_email_pop3_url' => $account_email_pop3_url,
          ':account_email_pop3_port' => $account_email_pop3_port,
          ':account_wordpress_admin_url' => $account_wordpress_admin_url,
          ':account_wordpress_admin_username' => $account_wordpress_admin_username,
          ':account_wordpress_admin_password' => $account_wordpress_admin_password
        ));

        return 'The account has been successfully added.';
      } catch(\Defuse\Crypto\Exception\EnvironmentIsBrokenException $ex) {
        return 'An error has occured while encrypting the data.';
      } catch(\Defuse\Crypto\Exception\Exception $ex) {
        return 'An error has occured while encrypting the data.';
      }
    } else {
      return 'Please fill all the required input fields.';
    }
  }

  // Edit Account
  public function editAccount($account_id, $account_encryption_key, $account_title, $account_domain_url, $account_expiration_date, $account_ip_address, $account_cpanel_port, $account_cpanel_username, $account_cpanel_password, $account_ftp_port, $account_ftp_username, $account_ftp_password, $account_ftp_path, $account_mysql_host, $account_mysql_port, $account_mysql_username, $account_mysql_password, $account_email_username, $account_email_password, $account_email_smtp_url, $account_email_smtp_port, $account_email_imap_url, $account_email_imap_port, $account_email_pop3_url, $account_email_pop3_port, $account_wordpress_admin_url, $account_wordpress_admin_username, $account_wordpress_admin_password) {
    if(!empty($account_title) && !empty($account_domain_url) && !empty($account_expiration_date) && !empty($account_ip_address)) {
      $account_id = strip_tags($account_id);
      $account_encryption_key = strip_tags($account_encryption_key);
      $account_title = strip_tags($account_title);
      $account_domain_url = strip_tags($account_domain_url);
      $account_expiration_date = strip_tags($account_expiration_date);
      $account_ip_address = strip_tags($account_ip_address);

      try {
        $account_cpanel_port = strip_tags($account_cpanel_port);
        $account_cpanel_username = (!empty($account_cpanel_username) ? \Defuse\Crypto\Crypto::encryptWithPassword(strip_tags($account_cpanel_username), $account_encryption_key) : '');
        $account_cpanel_password = (!empty($account_cpanel_password) ? \Defuse\Crypto\Crypto::encryptWithPassword(strip_tags($account_cpanel_password), $account_encryption_key) : '');

        $account_ftp_port = strip_tags($account_ftp_port);
        $account_ftp_username = (!empty($account_ftp_username) ? \Defuse\Crypto\Crypto::encryptWithPassword(strip_tags($account_ftp_username), $account_encryption_key) : '');
        $account_ftp_password = (!empty($account_ftp_password) ? \Defuse\Crypto\Crypto::encryptWithPassword(strip_tags($account_ftp_password), $account_encryption_key) : '');
        $account_ftp_path = strip_tags($account_ftp_path);

        $account_mysql_host = strip_tags($account_mysql_host);
        $account_mysql_port = strip_tags($account_mysql_port);
        $account_mysql_username = (!empty($account_mysql_username) ? \Defuse\Crypto\Crypto::encryptWithPassword(strip_tags($account_mysql_username), $account_encryption_key) : '');
        $account_mysql_password = (!empty($account_mysql_password) ? \Defuse\Crypto\Crypto::encryptWithPassword(strip_tags($account_mysql_password), $account_encryption_key) : '');

        $account_email_username = (!empty($account_email_username) ? \Defuse\Crypto\Crypto::encryptWithPassword(strip_tags($account_email_username), $account_encryption_key) : '');
        $account_email_password = (!empty($account_email_password) ? \Defuse\Crypto\Crypto::encryptWithPassword(strip_tags($account_email_password), $account_encryption_key) : '');
        $account_email_smtp_url = strip_tags($account_email_smtp_url);
        $account_email_smtp_port = strip_tags($account_email_smtp_port);
        $account_email_imap_url = strip_tags($account_email_imap_url);
        $account_email_imap_port = strip_tags($account_email_imap_port);
        $account_email_pop3_url = strip_tags($account_email_pop3_url);
        $account_email_pop3_port = strip_tags($account_email_pop3_port);

        $account_wordpress_admin_url = strip_tags($account_wordpress_admin_url);
        $account_wordpress_admin_username = (!empty($account_wordpress_admin_username) ? \Defuse\Crypto\Crypto::encryptWithPassword(strip_tags($account_wordpress_admin_username), $account_encryption_key) : '');
        $account_wordpress_admin_password = (!empty($account_wordpress_admin_password) ? \Defuse\Crypto\Crypto::encryptWithPassword(strip_tags($account_wordpress_admin_password), $account_encryption_key) : '');

        $sql_edit_account = 'UPDATE vault_accounts SET title = :account_title, expiration_date = :account_expiration_date, domain_url = :account_domain_url, ip_address = :account_ip_address, cpanel_port = :account_cpanel_port, cpanel_username = :account_cpanel_username, cpanel_password = :account_cpanel_password, ftp_port = :account_ftp_port, ftp_username = :account_ftp_username, ftp_password = :account_ftp_password, ftp_path = :account_ftp_path, mysql_host = :account_mysql_host, mysql_port = :account_mysql_port, mysql_username = :account_mysql_username, mysql_password = :account_mysql_password, email_username = :account_email_username, email_password = :account_email_password, email_smtp_url = :account_email_smtp_url, email_smtp_port = :account_email_smtp_port, email_imap_url = :account_email_imap_url, email_imap_port = :account_email_imap_port, email_pop3_url = :account_email_pop3_url, email_pop3_port = :account_email_pop3_port, wordpress_admin_url = :account_wordpress_admin_url, wordpress_admin_username = :account_wordpress_admin_username, wordpress_admin_password = :account_wordpress_admin_password WHERE id = :account_id';
        $query_edit_account = $this->db->prepare($sql_edit_account);
        $query_edit_account->execute(array(
          ':account_id' => $account_id,
          ':account_title' => $account_title,
          ':account_expiration_date' => $account_expiration_date,
          ':account_domain_url' => $account_domain_url,
          ':account_ip_address' => $account_ip_address,
          ':account_cpanel_port' => $account_cpanel_port,
          ':account_cpanel_username' => $account_cpanel_username,
          ':account_cpanel_password' => $account_cpanel_password,
          ':account_ftp_port' => $account_ftp_port,
          ':account_ftp_username' => $account_ftp_username,
          ':account_ftp_password' => $account_ftp_password,
          ':account_ftp_path' => $account_ftp_path,
          ':account_mysql_host' => $account_mysql_host,
          ':account_mysql_port' => $account_mysql_port,
          ':account_mysql_username' => $account_mysql_username,
          ':account_mysql_password' => $account_mysql_password,
          ':account_email_username' => $account_email_username,
          ':account_email_password' => $account_email_password,
          ':account_email_smtp_url' => $account_email_smtp_url,
          ':account_email_smtp_port' => $account_email_smtp_port,
          ':account_email_imap_url' => $account_email_imap_url,
          ':account_email_imap_port' => $account_email_imap_port,
          ':account_email_pop3_url' => $account_email_pop3_url,
          ':account_email_pop3_port' => $account_email_pop3_port,
          ':account_wordpress_admin_url' => $account_wordpress_admin_url,
          ':account_wordpress_admin_username' => $account_wordpress_admin_username,
          ':account_wordpress_admin_password' => $account_wordpress_admin_password
        ));

        return 'The account has been successfully edited.';
      } catch(\Defuse\Crypto\Exception\EnvironmentIsBrokenException $ex) {
        return 'An error has occured while encrypting the data.';
      } catch(\Defuse\Crypto\Exception\Exception $ex) {
        return 'An error has occured while encrypting the data.';
      }
    } else {
      return 'Please fill all the required input fields.';
    }
  }

  // Delete Account
  public function deleteAccount($account_id)  {
    $account_id = strip_tags($account_id);

    $sql_delete_account_shared_accounts = 'DELETE FROM vault_shared_accounts WHERE account_id = :account_id';
    $query_delete_account_shared_accounts = $this->db->prepare($sql_delete_account_shared_accounts);
    $query_delete_account_shared_accounts->execute(array(':account_id' => $account_id));

    $sql_delete_account = 'DELETE FROM vault_accounts WHERE id = :account_id';
    $query_delete_account = $this->db->prepare($sql_delete_account);
    $query_delete_account->execute(array(':account_id' => $account_id));

    return 'The account has been successfully deleted.';
  }

  // Search User by Email
  public function searchUserByEmail($current_user_email, $user_email) {
    $current_user_email = strip_tags($current_user_email);
    $user_email = strip_tags($user_email);

    $sql = 'SELECT id, email, profile_url FROM vault_users WHERE email LIKE :user_email AND email <> :current_user_email AND verified = :verified';
    $query = $this->db->prepare($sql);
    $query->execute(array(':current_user_email' => $current_user_email, ':user_email' => '%' . $user_email . '%', ':verified' => 1));

    return $query->fetchAll();
  }

  // Is Shared User
  public function isSharedWithAccountUser($user_id, $account_id) {
    $user_id = strip_tags($user_id);
    $account_id = strip_tags($account_id);

    $sql = 'SELECT COUNT(id) AS is_shared_with_account_user FROM vault_users WHERE id = :user_id AND id IN (SELECT user_id FROM vault_shared_accounts WHERE account_id = :account_id)';
    $query = $this->db->prepare($sql);
    $query->execute(array(':account_id' => $account_id, ':user_id' => $user_id));

    $result = $query->fetch()->is_shared_with_account_user;

    if($result > 0) {
      return true;
    } else {
      return false;
    }
  }

  // get User by Email
  public function getUserByEmail($user_email) {
    $user_email = strip_tags($user_email);

    $sql = 'SELECT * FROM vault_users WHERE email = :user_email';
    $query = $this->db->prepare($sql);
    $query->execute(array(':user_email' => $user_email));

    return $query->fetch();
  }

  // Share Account
  public function shareAccount($current_user_id, $account_id, $user_email) {
    if(!empty($user_email)) {
      $current_user_id = strip_tags($current_user_id);
      $account_id = strip_tags($account_id);
      $user_email = strip_tags($user_email);

      $user = $this->getUserByEmail($user_email);
      $current_user = $this->getUser($current_user_id);

      if($current_user) {
        if($user) {
          if(!$this->isSharedWithAccountUser($user->id, $account_id)) {
            $sql_share_account = 'INSERT INTO vault_shared_accounts (account_id, user_id, privileges) VALUES (:account_id, :user_id, :privileges)';
            $query_share_account = $this->db->prepare($sql_share_account);
            $query_share_account->execute(array(':account_id' => $account_id, ':user_id' => $user->id, ':privileges' => 'all'));

            $notification_text = $current_user->email . ' has shared an account with you.';
            $today = time();
            $notification_date = date('Y-m-d H:i:s', $today);
            $notification_link = URL . 'account/' . $account_id;

            $sql_notification = 'INSERT INTO vault_notifications (user_id, notification_text, notification_date, notification_link, unread) VALUES (:user_id, :notification_text, :notification_date, :notification_link, :unread)';
            $query_notification = $this->db->prepare($sql_notification);
            $query_notification->execute(array(':user_id' => $user->id, ':notification_text' => $notification_text, ':notification_date' => $notification_date, ':notification_link' => $notification_link, ':unread' => 1));

            return 'This account has been shared with ' . $user_email;
          } else {
            return 'This account has already been shared with this user.';
          }
        } else {
          return 'This user does not exist.';
        }
      } else {
        return 'No valid current user.';
      }
    } else {
      return 'Please fill all the input fields.';
    }
  }

  // Remove Shared
  public function removeShared($shared_user_id) {
    if(!empty($shared_user_id)) {
      $shared_user_id = strip_tags($shared_user_id);

      $sql_remove_shared = 'DELETE FROM vault_shared_accounts WHERE id = :shared_user_id';
      $query_remove_shared = $this->db->prepare($sql_remove_shared);
      $query_remove_shared->execute(array(':shared_user_id' => $shared_user_id));

      return 'The user has been removed from the team for this account.';
    } else {
      return 'No shared user provided.';
    }
  }

}

?>
