<?php

require 'public/libs/phpmailer/Exception.php';
require 'public/libs/phpmailer/PHPMailer.php';
require 'public/libs/phpmailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class SupportModel {

  // Database
  function __construct($db) {
    try {
      $this->db = $db;
    } catch (PDOException $e) {
      exit('Database connection could not be established.');
    }
  }

  public function sendSupport($email, $subject, $message) {
    if(!empty($email) && !empty($subject) && !empty($message)) {
      $email = strip_tags($email);
      $subject = strip_tags($subject);
      $message = strip_tags($message);

      $mail = new PHPMailer;
      $mail->From = $email;
      $mail->FromName = 'Vault App User';
      $mail->addAddress(CONTACT_EMAIL);
      $mail->addReplyTo($email, $email);
      $mail->isHTML(true);

      $message = '
        <!DOCTYPE html>
        <html>
          <head>
            <title>Vault - Support</title>
          </head>
          <body>
            ' . $email . ' has contacted the support:<br><br><br>
            Subject: ' . $subject . '<br><br>
            Message: ' . $message . '<br><br><br><br>
            <a href="mailto:' . $email . '">Reply to ' . $email . '</a>
          </body>
        </html>
      ';

      $mail->Subject = 'Vault App - Support';
      $mail->Body = $message;
      $mail->AltBody = '';

      if($mail->send()) {
        return 'Thanks for contacting the support. We will try to reply you as soon as possible.';
      } else {
        return 'The support could not be contacted.';
      }
    } else {
      return 'Please fill in all the required fields.';
    }
  }

}

?>
