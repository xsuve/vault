<?php

require 'public/libs/phpmailer/Exception.php';
require 'public/libs/phpmailer/PHPMailer.php';
require 'public/libs/phpmailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class SignupModel {

  // Database
  function __construct($db) {
    try {
      $this->db = $db;
    } catch (PDOException $e) {
      exit('Database connection could not be established.');
    }
  }

  // Create User
  public function signupUser($email, $password, $confirm_password) {
    if(!empty($email) && !empty($password) && !empty($confirm_password)) {
      $email = strip_tags($email);
      $password = strip_tags($password);
      $confirm_password = strip_tags($confirm_password);
      $password_check = preg_match('/^(?=.*\d)(?=.*[_\W]).*$/', $password);

      if((strlen($password) >= 8) && ($password_check == 1)) {
        if($password == $confirm_password) {
          $password_hash = password_hash($password, PASSWORD_DEFAULT);
          $date = date_create();
          $signup_date = date_format($date, 'Y-m-d');
          $token = time() . '-' . mt_rand();
          $verified = 0;
          $login_token = '';
          $plan_id = 0;

          $sql_check = 'SELECT COUNT(id) AS users_with_email FROM vault_users WHERE email = :email';
          $query_check = $this->db->prepare($sql_check);
          $query_check->execute(array(':email' => $email));
          $users_with_email = $query_check->fetch()->users_with_email;
          if($users_with_email == 0) {
            $sql_signup = 'INSERT INTO vault_users (email, profile_url, password, signup_date, token, verified, login_token, plan_id, subscription_token, subscription_start_date, subscription_next_payment_date, subscription_agreement_id) VALUES (:email, :profile_url, :password, :signup_date, :token, :verified, :login_token, :plan_id, :subscription_token, :subscription_start_date, :subscription_next_payment_date, :subscription_agreement_id)';
            $query_signup = $this->db->prepare($sql_signup);
            $query_signup->execute(
              array(
                ':email' => $email,
                ':profile_url' => '',
                ':password' => $password_hash,
                ':signup_date' => $signup_date,
                ':token' => $token,
                ':verified' => $verified,
                ':login_token' => $login_token,
                ':plan_id' => $plan_id,
                ':subscription_token' => '',
                ':subscription_start_date' => $signup_date,
                ':subscription_next_payment_date' => $signup_date,
                ':subscription_agreement_id' => ''
              )
            );

            $mail = new PHPMailer;
            $mail->From = CONTACT_EMAIL;
            $mail->FromName = 'Vault App';
            $mail->addAddress($email);
            $mail->addReplyTo(CONTACT_EMAIL, 'Vault App');
            $mail->isHTML(true);

            $message = '
              <!DOCTYPE html>
              <html>
                <head>
                  <title>Vault - Verify Your Account</title>
                  <meta charset="utf-8">
                  <meta name="viewport" content="width=device-width, initial-scale=1.0">
                  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,600" rel="stylesheet">
                  <style>
                    body {
                      background-color: #fafbfe;
                    }
                    a {
                      text-decoration: none !important;
                    }
                    .box {
                      width: 45%;
                      margin: 30px auto;
                      background-color: #fff;
                      border-radius: 8px;
                      box-shadow: 0px 0px 5px #f1f1f2;
                      padding: 30px;
                      text-align: center;
                    }
                    .box .box-header {
                      border-bottom: 1px solid #eee;
                      padding-bottom: 30px;
                      margin-bottom: 30px;
                    }
                    .box .box-header .box-header-logo {
                      width: 120px;
                    }
                    .box .box-header .box-header-logo img {
                      max-width: 100%;
                      vertical-align: bottom;
                    }
                    .box .box-title {
                      font-family: "Montserrat", sans-serif;
                      font-size: 17px;
                      line-height: 27px;
                      font-weight: 600;
                      color: #071735;
                    }
                    .box .box-text {
                      font-family: "Montserrat", sans-serif;
                      font-size: 14px;
                      line-height: 24px;
                      font-weight: 400;
                      color: #888888;
                      margin: 15px 0px;
                    }
                    .box .box-icon {
                      width: 100px;
                      height: 100px;
                      margin: 30px auto;
                    }
                    .box button {
                      padding: 8px 24px;
                    	border-radius: 4px;
                    	border: 0px;
                    	font-family: "Montserrat", sans-serif;
                    	font-size: 13px;
                    	line-height: 23px;
                    	font-weight: 400;
                      background-color: #9c66e4;
                    	color: #fff;
                      cursor: pointer;
                      display: block;
                      width: 100%;
                    }
                    .box a {
                      font-family: "Montserrat", sans-serif;
                      font-size: 14px;
                      line-height: 24px;
                      font-weight: 400;
                      color: #9c66e4;
                    }
                    .mt-50 {
                      margin-top: 50px;
                    }
                    .mt-30 {
                      margin-top: 30px;
                    }

                    @media (max-width: 575.98px) {
                      .box {
                        width: 80%;
                      }
                    }
                  </style>
                </head>
                <body>
                  <div class="box">
                    <div class="box-header">
                      <div class="box-header-logo">
                        <a href="' . URL . '">
                          <img src="' . URL . 'public/img/vault-logo.svg">
                        </a>
                      </div>
                    </div>
                    <div class="box-title">Hello, ' . $email . '!</div>
                    <div class="box-text">To complete email verification, please click the button below.</div>
                    <div class="box-icon">
                      <img src="' . URL . 'public/img/email.svg">
                    </div>
                    <a href="' . URL . 'login/verifyaccount/' . $email . '/' . $token . '">
                      <button>Verify Your Email</button>
                    </a>
                    <div class="mt-30">
                      <div class="box-text">Or verify using this link: </div>
                    </div>
                    <a href="' . URL . 'login/verifyaccount/' . $email . '/' . $token . '">' . URL . 'login/verifyaccount/' . $email . '/' . $token . '</a>
                    <div class="box-title mt-50">Need help?</div>
                    <div class="box-text">Do not hesitate to contact us at: <a href="mailto:' . CONTACT_EMAIL . '">' . CONTACT_EMAIL . '</a></div>
                  </div>
                </body>
              </html>
            ';

            $mail->Subject = 'Vault App - Verify Your Account';
            $mail->Body = $message;
            $mail->AltBody = 'Verify your Vault account by clicking this link: ' . URL . 'login/verifyaccount/' . $email . '/' . $token;

            if($mail->send()) {
              return 'Your account has been created. Please verify it by following the link from your email inbox. Check Spam inbox too.';
            } else {
              return 'The account could not be created. Please contact us.';
            }
          } else {
            return 'This e-mail has already been registered.';
          }
        } else {
          return 'The two entered passwords do not match.';
        }
      } else {
        return 'The password must be at least 8 characters long and contain at least a number and a symbol.';
      }
    } else {
      return 'Please fill all the input fields.';
    }
  }

}

?>
