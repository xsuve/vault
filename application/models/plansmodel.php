<?php

class PlansModel {

  // Database
  function __construct($db) {
    try {
      $this->db = $db;
    } catch (PDOException $e) {
      exit('Database connection could not be established.');
    }
  }

  // Get Plan
  public function getPlan($plan_id) {
    $plan_id = strip_tags($plan_id);

    $sql = 'SELECT * FROM vault_plans WHERE id = :plan_id';
    $query = $this->db->prepare($sql);
    $query->execute(array(':plan_id' => $plan_id));

    return $query->fetch();
  }

  // Get Plan By Name
  public function getPlanByName($plan_name) {
    $plan_name = strip_tags($plan_name);

    $sql = 'SELECT * FROM vault_plans WHERE name = :plan_name';
    $query = $this->db->prepare($sql);
    $query->execute(array(':plan_name' => $plan_name));

    return $query->fetch();
  }

  // Get Plan Feature
  public function getPlanFeature($plan_id, $plan_feature) {
    $plan_id = strip_tags($plan_id);
    $plan_feature = strip_tags($plan_feature);

    $sql = 'SELECT ' . $plan_feature . ' FROM vault_plans WHERE id = :plan_id';
    $query = $this->db->prepare($sql);
    $query->execute(array(':plan_id' => $plan_id));

    return $query->fetch()->$plan_feature;
  }

}

?>
