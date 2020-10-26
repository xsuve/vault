<?php

require 'public/libs/phpmailer/Exception.php';
require 'public/libs/phpmailer/PHPMailer.php';
require 'public/libs/phpmailer/SMTP.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require 'public/libs/cloudinary-api/Cloudinary.php';
require 'public/libs/cloudinary-api/Uploader.php';
require 'public/libs/cloudinary-api/Helpers.php';
require 'public/libs/cloudinary-api/Api.php';
\Cloudinary::config(array(
  'cloud_name' => 'vaultapp',
  'api_key' => '914742737736637',
  'api_secret' => 'OQTtzRd1RToVMyEpI1oYU70aYe0'
));


require 'public/libs/paypal-php-sdk/autoload.php';
if(!defined("PP_CONFIG_PATH")) {
define("PP_CONFIG_PATH", 'application/config/');
}

class ProfileModel {

  // Database
  function __construct($db) {
    try {
      $this->db = $db;
    } catch (PDOException $e) {
      exit('Database connection could not be established.');
    }
  }

  // Edit Profile
  public function editProfile($user_id, $profile_image) {
    if(!empty($user_id)) {
      $user_id = strip_tags($user_id);

      if($profile_image['size'] != 0) {
        $image_info = getimagesize($profile_image['tmp_name']);

        if(($image_info['mime'] == 'image/png') || ($image_info['mime'] == 'image/jpg') || ($image_info['mime'] == 'image/jpeg')) {
          if(($image_info[0] == 180) && ($image_info[1] == 180)) {
            $upload_image = \Cloudinary\Uploader::upload($profile_image['tmp_name'], array('public_id' => $user_id, 'folder' => 'users'));

            if($upload_image) {
              $sql_edit_profile = 'UPDATE vault_users SET profile_url = :profile_url WHERE id = :user_id';
              $query_edit_profile = $this->db->prepare($sql_edit_profile);
              $query_edit_profile->execute(array(':profile_url' => $upload_image['url'], ':user_id' => $user_id));

              return 'Your profile has been successfully updated.';
            } else {
              return 'Something went wrong in the image upload process.';
            }
          } else {
            return 'The image width and height must be 180 by 180 pixels.';
          }
        } else {
          return 'Please upload only PNG, JPG or JPEG files.';
        }
      } else {
        return 'Please choose a profile image before submitting.';
      }
    }
  }

  // Update Password
  public function updatePassword($user_id, $old_password, $new_password, $confirm_new_password) {
    if(!empty($user_id)) {
      $user_id = strip_tags($user_id);

      if(!empty($old_password) && !empty($new_password) && !empty($confirm_new_password)) {
        $old_password = strip_tags($old_password);
        $new_password = strip_tags($new_password);
        $confirm_new_password = strip_tags($confirm_new_password);

        if($new_password == $confirm_new_password) {
          $sql_user = 'SELECT password FROM vault_users WHERE id = :user_id';
          $query_user = $this->db->prepare($sql_user);
          $query_user->execute(array(':user_id' => $user_id));
          $user_password = $query_user->fetch()->password;

          if(password_verify($old_password, $user_password)) {
            $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);

            $sql_edit_profile = 'UPDATE vault_users SET password = :new_password WHERE id = :user_id';
            $query_edit_profile = $this->db->prepare($sql_edit_profile);
            $query_edit_profile->execute(array(':new_password' => $new_password_hash, ':user_id' => $user_id));

            return 'Your password has been successfully updated.';
          } else {
            return 'Invalid old user password.';
          }
        } else {
          return 'The new password and the confirmation password do not match.';
        }
      } else {
        return 'Please fill all the input fields.';
      }
    }
  }

  // Subscribe Plan
  public function subscribePlan($plan_name, $plan_id, $user_id) {
    if(!empty($plan_name) && !empty($plan_id)) {
      $plan_name = strip_tags($plan_name);
      $plan_id = strip_tags($plan_id);
      $user_id = strip_tags($user_id);
      $date = date_create();
      $subscription_date = date_format($date, 'Y-m-d');

      switch($plan_name) {
        case 'free':
          $sql_update_user_plan = 'UPDATE vault_users SET plan_id = :plan_id, subscription_start_date = :subscription_start_date, subscription_next_payment_date = :subscription_next_payment_date WHERE id = :user_id';
          $query_update_user_plan = $this->db->prepare($sql_update_user_plan);
          $query_update_user_plan->execute(array(':plan_id' => $plan_id, ':user_id' => $user_id, ':subscription_start_date' => $subscription_date, ':subscription_next_payment_date' => $subscription_date));

          return array('success', 'Welcome to Vault!');
        break;
        case 'pro':
          $paypal = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
              (PAYPAL_SANDBOX ? PAYPAL_SANDBOX_CLIENT_ID : PAYPAL_CLIENT_ID),
              (PAYPAL_SANDBOX ? PAYPAL_SANDBOX_SECRET : PAYPAL_SECRET)
            )
          );

          $plan = new \PayPal\Api\Plan();

          $plan->setName('Vault Pro')
            ->setDescription('Get extra features in your Vault account.')
            ->setType('INFINITE');

          $paymentDefinition = new \PayPal\Api\PaymentDefinition();
          $paymentDefinition->setName('Regular Payment')
            ->setType('REGULAR')
            ->setFrequency('MONTH') // MONTH
            ->setFrequencyInterval("1")
            ->setAmount(new \PayPal\Api\Currency(array('value' => VAULT_PRO_PRICE, 'currency' => 'USD')));

          $merchantPreferences = new \PayPal\Api\MerchantPreferences();

          $merchantPreferences->setReturnUrl(URL . 'profile/checksubscription/?success=true&plan=' . $plan_name)
            ->setCancelUrl(URL . 'profile/checksubscription/?success=false')
            ->setAutoBillAmount("yes")
            ->setInitialFailAmountAction("CONTINUE")
            ->setMaxFailAttempts("0")
            ->setSetupFee(new \PayPal\Api\Currency(array('value' => VAULT_PRO_PRICE, 'currency' => 'USD')));

          $plan->setPaymentDefinitions(array($paymentDefinition));
          $plan->setMerchantPreferences($merchantPreferences);

          $createdPlan = $plan->create($paypal);

          $patch = new \PayPal\Api\Patch();
          $value = new \PayPal\Common\PayPalModel('{
            "state":"ACTIVE"
          }');

          $patch->setOp('replace')
            ->setPath('/')
            ->setValue($value);
          $patchRequest = new \PayPal\Api\PatchRequest();
          $patchRequest->addPatch($patch);

          $createdPlan->update($patchRequest, $paypal);
          $createdPlan = \PayPal\Api\Plan::get($createdPlan->getId(), $paypal);

          $agreement = new \PayPal\Api\Agreement();

          $agreement->setName('Vault Pro Subscription')
            ->setDescription('Initial payment of $' . VAULT_PRO_PRICE . ' followed by a recurring payment of $' . VAULT_PRO_PRICE . ' on the ' . date('jS') . ' of every month.')
            ->setStartDate(gmdate("Y-m-d\TH:i:s\Z", strtotime("+1 month", time()))); // +1 month

          $plan = new \PayPal\Api\Plan();
          $plan->setId($createdPlan->getId());
          $agreement->setPlan($plan);

          $payer = new \PayPal\Api\Payer();
          $payer->setPaymentMethod('paypal');
          $agreement->setPayer($payer);

          $agreement = $agreement->create($paypal);
          $approvalUrl = $agreement->getApprovalLink();

          return array('url', $approvalUrl);
        break;
      }
    } else {
      return array('error', 'No plan provided.');
    }
  }

  // Upgrade Plan
  public function upgradePlan($plan_name, $plan_id, $user_id) {
    if(!empty($plan_name) && !empty($plan_id)) {
      $plan_name = strip_tags($plan_name);
      $plan_id = strip_tags($plan_id);
      $user_id = strip_tags($user_id);
      $date = date_create();
      $subscription_date = date_format($date, 'Y-m-d');

      switch($plan_name) {
        case 'free':
          return array('error', 'You can not upgrade to Vault Free.');
        break;
        case 'pro':
          $paypal = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
              (PAYPAL_SANDBOX ? PAYPAL_SANDBOX_CLIENT_ID : PAYPAL_CLIENT_ID),
              (PAYPAL_SANDBOX ? PAYPAL_SANDBOX_SECRET : PAYPAL_SECRET)
            )
          );

          $plan = new \PayPal\Api\Plan();

          $plan->setName('Vault Pro')
            ->setDescription('Get extra features in your Vault account.')
            ->setType('INFINITE');

          $paymentDefinition = new \PayPal\Api\PaymentDefinition();
          $paymentDefinition->setName('Regular Payment')
            ->setType('REGULAR')
            ->setFrequency('MONTH') // MONTH
            ->setFrequencyInterval("1")
            ->setAmount(new \PayPal\Api\Currency(array('value' => VAULT_PRO_PRICE, 'currency' => 'USD')));

          $merchantPreferences = new \PayPal\Api\MerchantPreferences();

          $merchantPreferences->setReturnUrl(URL . 'profile/checksubscription/?success=true&plan=' . $plan_name)
            ->setCancelUrl(URL . 'profile/checksubscription/?success=false')
            ->setAutoBillAmount("yes")
            ->setInitialFailAmountAction("CONTINUE")
            ->setMaxFailAttempts("0")
            ->setSetupFee(new \PayPal\Api\Currency(array('value' => VAULT_PRO_PRICE, 'currency' => 'USD')));

          $plan->setPaymentDefinitions(array($paymentDefinition));
          $plan->setMerchantPreferences($merchantPreferences);

          $createdPlan = $plan->create($paypal);

          $patch = new \PayPal\Api\Patch();
          $value = new \PayPal\Common\PayPalModel('{
            "state":"ACTIVE"
          }');

          $patch->setOp('replace')
            ->setPath('/')
            ->setValue($value);
          $patchRequest = new \PayPal\Api\PatchRequest();
          $patchRequest->addPatch($patch);

          $createdPlan->update($patchRequest, $paypal);
          $createdPlan = \PayPal\Api\Plan::get($createdPlan->getId(), $paypal);

          $agreement = new \PayPal\Api\Agreement();

          $agreement->setName('Vault Pro Subscription')
            ->setDescription('Initial payment of $' . VAULT_PRO_PRICE . ' followed by a recurring payment of $' . VAULT_PRO_PRICE . ' on the ' . date('jS') . ' of every month.')
            ->setStartDate(gmdate("Y-m-d\TH:i:s\Z", strtotime("+1 month", time()))); // +1 month

          $plan = new \PayPal\Api\Plan();
          $plan->setId($createdPlan->getId());
          $agreement->setPlan($plan);

          $payer = new \PayPal\Api\Payer();
          $payer->setPaymentMethod('paypal');
          $agreement->setPayer($payer);

          $agreement = $agreement->create($paypal);
          $approvalUrl = $agreement->getApprovalLink();

          return array('url', $approvalUrl);
        break;
      }
    } else {
      return array('error', 'No plan provided.');
    }
  }

  // Unsubscribe Plan
  public function unsubscribePlan($user_id, $subscription_agreement_id) {
    if(!empty($user_id) && !empty($subscription_agreement_id)) {
      $user_id = strip_tags($user_id);
      $subscription_agreement_id = strip_tags($subscription_agreement_id);
      $date = date_create();
      $unsubscription_date = date_format($date, 'Y-m-d');
      $plan_id = 1;

      $paypal = new \PayPal\Rest\ApiContext(
        new \PayPal\Auth\OAuthTokenCredential(
          (PAYPAL_SANDBOX ? PAYPAL_SANDBOX_CLIENT_ID : PAYPAL_CLIENT_ID),
          (PAYPAL_SANDBOX ? PAYPAL_SANDBOX_SECRET : PAYPAL_SECRET)
        )
      );

      $agreement = new \PayPal\Api\Agreement();
      $agreement->setId($subscription_agreement_id);
      $agreementStateDescriptor = new \PayPal\Api\AgreementStateDescriptor();
      $agreementStateDescriptor->setNote("Cancel the agreement.");

      if($agreement->getId()) {
        $agreement->cancel($agreementStateDescriptor, $paypal);
        $cancelAgreementDetails = \PayPal\Api\Agreement::get($agreement->getId(), $paypal);

        $sql_cancel_subscription = 'UPDATE vault_users SET plan_id = :plan_id, subscription_start_date = :subscription_start_date, subscription_next_payment_date = :subscription_next_payment_date WHERE id = :user_id';
        $query_cancel_subscription = $this->db->prepare($sql_cancel_subscription);
        $query_cancel_subscription->execute(array(':plan_id' => $plan_id, ':user_id' => $user_id, ':subscription_start_date' => $unsubscription_date, ':subscription_next_payment_date' => $unsubscription_date));

        return 'You have been successfully unsubscribed from Vault Pro.';
      } else {
        return 'An error has occured. Please contact us.';
      }
    } else {
      return 'No plan provided.';
    }
  }

  // Check Subscription
  public function checkSubscription($token, $plan_id, $user_id, $user_email) {
    if(!empty($user_id) && !empty($user_email)) {
      $user_id = strip_tags($user_id);
      $user_email = strip_tags($user_email);

      if(!empty($token)) {
        $token = strip_tags($token);

        if(!empty($plan_id)) {
          $plan_id = strip_tags($plan_id);

          $paypal = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
              (PAYPAL_SANDBOX ? PAYPAL_SANDBOX_CLIENT_ID : PAYPAL_CLIENT_ID),
              (PAYPAL_SANDBOX ? PAYPAL_SANDBOX_SECRET : PAYPAL_SECRET)
            )
          );

          $agreement = new \PayPal\Api\Agreement();
          $agreement->execute($token, $paypal);

          if($agreement->getId()) {
            $agreement_id = $agreement->getId();
            $date = date_create();
            $subscription_start_date = date_format($date, 'Y-m-d');

            $agreement_check = \PayPal\Api\Agreement::get($agreement_id, $paypal);
            $agreement_details = $agreement_check->getAgreementDetails();
            $agreement_date = date_create($agreement_details->getNextBillingDate());
            $subscription_next_payment_date = date_format($agreement_date, 'Y-m-d');

            $sql_update_user_plan = 'UPDATE vault_users SET plan_id = :plan_id, subscription_token = :subscription_token, subscription_start_date = :subscription_start_date, subscription_next_payment_date = :subscription_next_payment_date, subscription_agreement_id = :subscription_agreement_id WHERE id = :user_id';
            $query_update_user_plan = $this->db->prepare($sql_update_user_plan);
            $query_update_user_plan->execute(array(':plan_id' => $plan_id, ':user_id' => $user_id, ':subscription_token' => $token, ':subscription_start_date' => $subscription_start_date, ':subscription_next_payment_date' => $subscription_next_payment_date, ':subscription_agreement_id' => $agreement_id));

            $mail = new PHPMailer;
            $mail->From = CONTACT_EMAIL;
            $mail->FromName = 'Vault App';
            $mail->addAddress($user_email);
            $mail->addReplyTo(CONTACT_EMAIL, 'Vault App');
            $mail->isHTML(true);

            $message = '
              <!DOCTYPE html>
              <html>
                <head>
                  <title>Vault - Pro Account ' . $user_email . '</title>
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
                    <div class="box-title">Thanks for your Vault Pro subscription!</div>
                    <div class="box-text">Your account has been upgraded to the Vault Pro plan.</div>
                    <div class="box-icon">
                      <img src="' . URL . 'public/img/payment.svg">
                    </div>
                    <div class="mt-30">
                      <div class="box-text">Initial payment of <strong>$' . VAULT_PRO_PRICE . '</strong> followed by a recurring payment of <strong>$' . VAULT_PRO_PRICE . '</strong> on the <strong>' . date("jS") . '</strong> of every month.</div>
                    </div>
                    <div class="mt-30">
                      <div class="box-text">Next payment date is <strong>' . date("F j, Y", strtotime("+1 month")) . '</strong>.<br>You can unsubscribe whenever you want from your account profile section.</div>
                    </div>
                    <div class="box-title mt-50">Need help?</div>
                    <div class="box-text">Do not hesitate to contact us at: <a href="mailto:' . CONTACT_EMAIL . '">' . CONTACT_EMAIL . '</a></div>
                  </div>
                </body>
              </html>
            ';

            $mail->Subject = 'Vault App - Pro Account';
            $mail->Body = $message;
            $mail->AltBody = 'Your account has been upgraded to the Vault Pro plan. Thank you!';

            if($mail->send()) {
              return array('success', 'You have successfully upgraded your plan.');
            }
          } else  {
            return array('error', 'Something went wrong with the payment.');
          }
        } else {
          return array('error', 'No plan provided.');
        }
      } else {
        return array('error', 'No token provided.');
      }
    }
  }

  // Subscription Webhooks
  public function subscriptionWebhooks() {
    $paypal = new \PayPal\Rest\ApiContext(
      new \PayPal\Auth\OAuthTokenCredential(
        (PAYPAL_SANDBOX ? PAYPAL_SANDBOX_CLIENT_ID : PAYPAL_CLIENT_ID),
        (PAYPAL_SANDBOX ? PAYPAL_SANDBOX_SECRET : PAYPAL_SECRET)
      )
    );

    $bodyReceived = file_get_contents('php://input');
    $headers = getallheaders();
    $headers = array_change_key_case($headers, CASE_UPPER);

    if(isset($headers['PAYPAL-AUTH-ALGO']) && isset($headers['PAYPAL-TRANSMISSION-ID']) && isset($headers['PAYPAL-CERT-URL'])) {
      $signatureVerification = new \PayPal\Api\VerifyWebhookSignature();
      $signatureVerification->setWebhookId(PAYPAL_SANDBOX ? PAYPAL_SANDBOX_WEBHOOK_ID : PAYPAL_WEBHOOK_ID);
      $signatureVerification->setAuthAlgo($headers['PAYPAL-AUTH-ALGO']);
      $signatureVerification->setTransmissionId($headers['PAYPAL-TRANSMISSION-ID']);
      $signatureVerification->setCertUrl($headers['PAYPAL-CERT-URL']);
      $signatureVerification->setTransmissionSig($headers['PAYPAL-TRANSMISSION-SIG']);
      $signatureVerification->setTransmissionTime($headers['PAYPAL-TRANSMISSION-TIME']);

      $webhookEvent = new \PayPal\Api\WebhookEvent();
      $webhookEvent->fromJson($bodyReceived);
      $signatureVerification->setWebhookEvent($webhookEvent);
      $request = clone $signatureVerification;

      $output = $signatureVerification->post($paypal);

      $verificationStatus = $output->getVerificationStatus();
      $responseArray = json_decode($request->toJSON(), true);

      $event = $responseArray['webhook_event']['event_type'];

      $outputArray = json_decode($output->toJSON(), true);

      if($verificationStatus == 'SUCCESS') {
        $date = date_create();
        $subscription_date = date_format($date, 'Y-m-d');

        switch($event) {
          case 'BILLING.SUBSCRIPTION.CANCELLED':
            $agreement_id = $responseArray['webhook_event']['resource']['id'];

            if($agreement_id) {
              $sql_update_user_plan = 'UPDATE vault_users SET plan_id = :plan_id, subscription_start_date = :subscription_start_date, subscription_next_payment_date = :subscription_next_payment_date WHERE subscription_agreement_id = :subscription_agreement_id';
              $query_update_user_plan = $this->db->prepare($sql_update_user_plan);
              $query_update_user_plan->execute(array(':plan_id' => 1, ':subscription_agreement_id' => $agreement_id, ':subscription_start_date' => $subscription_date, ':subscription_next_payment_date' => $subscription_date));
            }
          case 'BILLING.SUBSCRIPTION.SUSPENDED':
            // subscription canceled: agreement id = $responseArray['webhook_event']['resource']['id']
          break;
          case 'PAYMENT.SALE.COMPLETED':
            //subscription payment recieved: agreement id = $responseArray['webhook_event']['resource']['billing_agreement_id']
          break;
        }
      }
    } else {
      header('location: ' . URL);
    }
  }

}

?>
