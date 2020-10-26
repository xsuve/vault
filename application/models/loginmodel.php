<?php

require 'public/libs/phpmailer/Exception.php';
require 'public/libs/phpmailer/PHPMailer.php';
require 'public/libs/phpmailer/SMTP.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class LoginModel {

  // Database
  function __construct($db) {
    try {
      $this->db = $db;
    } catch (PDOException $e) {
      exit('Database connection could not be established.');
    }
  }

  // Login User
  // $_SESSION['user'] = $user->email;
  public function loginUser($email, $password) {
    if(!empty($email) && !empty($password)) {
      $email = strip_tags($email);
      $password = strip_tags($password);

      $sql_check = 'SELECT * FROM vault_users WHERE email = :email';
      $query_check = $this->db->prepare($sql_check);
      $query_check->execute(array(':email' => $email));
      $user = $query_check->fetch();
      if($user) {
        if($user->verified == 1) {
          if(password_verify($password, $user->password)) {
            if($user->login_token == '') {
              $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
              $charactersLength = strlen($characters);
              $token = '';
              $length = 32;
              for($i = 0; $i < $length; $i++) {
                $token .= $characters[rand(0, $charactersLength - 1)];
              }

              $sql_login_link = 'UPDATE vault_users SET login_token = :login_token WHERE email = :email';
              $query_login_link = $this->db->prepare($sql_login_link);
              $query_login_link->execute(array(':email' => $email, ':login_token' => $token));

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
                    <title>Vault - Login Link</title>
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
                      <div class="box-title">Welcome back, ' . $email . '!</div>
                      <div class="box-text">To log into your account, please click the button below.</div>
                      <div class="box-icon">
                        <img src="' . URL . 'public/img/login-link.svg">
                      </div>
                      <a href="' . URL . 'login/loginlink/' . $email . '/' . $token . '">
                        <button>Log into Vault</button>
                      </a>
                      <div class="mt-30">
                        <div class="box-text">Or login using this link: </div>
                      </div>
                      <a href="' . URL . 'login/loginlink/' . $email . '/' . $token . '">' . URL . 'login/loginlink/' . $email . '/' . $token . '</a>
                      <div class="box-title mt-50">Need help?</div>
                      <div class="box-text">Do not hesitate to contact us at: <a href="mailto:' . CONTACT_EMAIL . '">' . CONTACT_EMAIL . '</a></div>
                    </div>
                  </body>
                </html>
              ';

              $mail->Subject = 'Vault App - Login Link';
              $mail->Body = $message;
              $mail->AltBody = 'Your one time login link is: ' . URL . 'login/loginlink/' . $email . '/' . $token;

              if($mail->send()) {
                return 'Your one time login link has been sent to your e-mail address. Check Spam inbox too.';
              } else {
                return 'There was an error. Please contact us.';
              }
            } else {
              return 'You did not use your one time login link from the previous login. Check Spam inbox too.';
            }
          } else {
            return 'Please try again with the valid informations.';
          }
        } else {
          return 'This account has not been verified yet.';
        }
      } else {
        return 'This account does not exist.';
      }
    } else {
      return 'Please fill all the input fields.';
    }
  }

  // Forgot Password
  public function forgotPassword($email) {
    if(!empty($email)) {
      $email = strip_tags($email);

      $sql_check = 'SELECT * FROM vault_users WHERE email = :email';
      $query_check = $this->db->prepare($sql_check);
      $query_check->execute(array(':email' => $email));
      $user = $query_check->fetch();
      if($user) {
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
              <title>Vault - Reset Password</title>
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
                <div class="box-title">Reset your account password</div>
                <div class="box-text">To reset your account password, please click the button below.</div>
                <div class="box-icon">
                  <img src="' . URL . 'public/img/login-link.svg">
                </div>
                <a href="' . URL . 'login/reset/' . $email . '/' . $user->token . '">
                  <button>Reset Password</button>
                </a>
                <div class="mt-30">
                  <div class="box-text">Or reset your password using this link: </div>
                </div>
                <a href="' . URL . 'login/reset/' . $email . '/' . $user->token . '">' . URL . 'login/reset/' . $email . '/' . $user->token . '</a>
                <div class="box-title mt-50">Need help?</div>
                <div class="box-text">Do not hesitate to contact us at: <a href="mailto:' . CONTACT_EMAIL . '">' . CONTACT_EMAIL . '</a></div>
              </div>
            </body>
          </html>
        ';

        $mail->Subject = 'Vault App - Reset Password';
        $mail->Body = $message;
        $mail->AltBody = 'Your reset password link is: ' . URL . 'login/reset/' . $email . '/' . $user->token;

        if($mail->send()) {
          return 'The reset password link has been sent to the e-mail address. Check Spam inbox too.';
        } else {
          return 'There was an error. Please contact us.';
        }
      } else {
        return 'This account does not exist.';
      }
    } else {
      return 'Please fill all the input fields.';
    }
  }

  // Check Reset Password Token
  public function checkResetPasswordToken($email, $token) {
    if(!empty($email) && !empty($token)) {
      $email = strip_tags($email);
      $token = strip_tags($token);

      $sql_check = 'SELECT * FROM vault_users WHERE email = :email';
      $query_check = $this->db->prepare($sql_check);
      $query_check->execute(array(':email' => $email));
      $user = $query_check->fetch();
      if($user) {
        if($user->token == $token) {
          return true;
        } else {
          return false;
        }
      } else {
        return false;
      }
    } else {
      return false;
    }
  }

  // Reset Password
  public function resetPassword($email, $new_password, $confirm_new_password) {
    if(!empty($email) && !empty($new_password) && !empty($confirm_new_password)) {
      $email = strip_tags($email);
      $new_password = strip_tags($new_password);
      $confirm_new_password = strip_tags($confirm_new_password);

      $sql_check = 'SELECT * FROM vault_users WHERE email = :email';
      $query_check = $this->db->prepare($sql_check);
      $query_check->execute(array(':email' => $email));
      $user = $query_check->fetch();
      if($user) {
        if($new_password == $confirm_new_password) {
          $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);

          $sql_update_password = 'UPDATE vault_users SET password = :new_password WHERE id = :user_id';
          $query_update_password = $this->db->prepare($sql_update_password);
          $query_update_password->execute(array(':new_password' => $new_password_hash, ':user_id' => $user->id));

          return 'Your password has been successfully updated.';
        } else {
          return 'The new password and the confirmation password do not match.';
        }
      } else {
        return 'This account does not exist.';
      }
    } else {
      return 'Please fill all the input fields.';
    }
  }

  // Login Link
  public function loginLink($email, $token) {
    if(!empty($email) && !empty($token)) {
      $email = strip_tags($email);
      $token = strip_tags($token);

      $sql_check = 'SELECT * FROM vault_users WHERE email = :email';
      $query_check = $this->db->prepare($sql_check);
      $query_check->execute(array(':email' => $email));
      $user = $query_check->fetch();
      if($user) {
        if($user->login_token == $token) {
          $sql_login_link = 'UPDATE vault_users SET login_token = :login_token WHERE email = :email';
          $query_login_link = $this->db->prepare($sql_login_link);
          $query_login_link->execute(array(':email' => $email, ':login_token' => ''));

          $_SESSION['user'] = $user->email;
        } else {
          return 'Invalid login link.';
        }
      } else {
        return 'This account does not exist.';
      }
    } else {
      return 'Invalid login link.';
    }
  }

  // Verify User
  public function verifyUser($email, $token) {
    if(!empty($email) && !empty($token)) {
      $email = strip_tags($email);
      $token = strip_tags($token);

      $sql_email_check = 'SELECT * FROM vault_users WHERE email = :email';
      $query_email_check = $this->db->prepare($sql_email_check);
      $query_email_check->execute(array(':email' => $email));
      $user = $query_email_check->fetch();
      if($user) {
        if($user->token === $token) {
          if($user->verified == 0) {
            $sql_verify_account = 'UPDATE vault_users SET verified = :verified WHERE id = :user_id';
            $query_verify_account = $this->db->prepare($sql_verify_account);
            $query_verify_account->execute(array(':verified' => 1, ':user_id' => $user->id));

            return 'Your account has been verified. You can now login into the platform.';
          } else {
            return 'This account has already been verified.';
          }
        } else {
          return 'The verification token is invalid.';
        }
      } else {
        return 'This account does not exist.';
      }
    } else {
      return 'Invalid verification link.';
    }
  }

}

?>
