<?php

class NotificationsModel {

  // Database
  function __construct($db) {
    try {
      $this->db = $db;
    } catch (PDOException $e) {
      exit('Database connection could not be established.');
    }
  }

  // Get User Notification
  public function getUserNotification($notification_id) {
    $notification_id = strip_tags($notification_id);

    $sql = 'SELECT * FROM vault_notifications WHERE id = :notification_id';
    $query = $this->db->prepare($sql);
    $query->execute(array(':notification_id' => $notification_id));

    return $query->fetch();
  }

  // Get User Notifications
  public function getUserNotifications($user_id) {
    $user_id = strip_tags($user_id);

    $sql = 'SELECT * FROM vault_notifications WHERE user_id = :user_id ORDER BY notification_date DESC';
    $query = $this->db->prepare($sql);
    $query->execute(array(':user_id' => $user_id));

    return $query->fetchAll();
  }

  // Get User Unread Notifications
  public function getUserUnreadNotifications($user_id) {
    $user_id = strip_tags($user_id);

    $sql = 'SELECT * FROM vault_notifications WHERE user_id = :user_id AND unread = :unread';
    $query = $this->db->prepare($sql);
    $query->execute(array(':user_id' => $user_id, ':unread' => 1));

    return $query->fetchAll();
  }

  // Format Notification Date
  public function formatNotificationDate($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
      'y' => array('years', 'year'),
      'm' => array('months', 'month'),
      'w' => array('weeks', 'week'),
      'd' => array('days', 'day'),
      'h' => array('hours', 'hour'),
      'i' => array('minutes', 'minute'),
      's' => array('seconds', 'second')
    );
    foreach($string as $k => &$v) {
      if($diff->$k) {
        $v = $diff->$k . ' ' . ($diff->$k > 1 ? $v[0] : $v[1]);
      } else {
        unset($string[$k]);
      }
    }

    if(!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'some seconds ago';
  }

  // Read Notification
  public function readNotification($notification_id) {
    $notification_id = strip_tags($notification_id);

    $sql = 'UPDATE vault_notifications SET unread = :unread WHERE id = :notification_id';
    $query = $this->db->prepare($sql);
    $query->execute(array(':unread' => 0, ':notification_id' => $notification_id));
  }

}

?>
