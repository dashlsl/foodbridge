<?php

require_once 'classes/Session.php';
Session::init();

class Receivers
{
  private $db;

  public function __construct($db)
  {
    $this->db = $db;
  }

  // Receivers register their organization name
  public function registerOrganization($data)
  {
    $orgName = htmlspecialchars(trim($data['organization_name']));

    // Check if the organization name is empty
    if (empty($orgName)) {
      return 'Organization name is required.';
    } else {
      // Insert organization name into the database
      $sql = "INSERT INTO food_receivers (user_id, organization_name)
              VALUES (:user_id, :organization_name)";
      $stmt = $this->db->pdo->prepare($sql);
      $result = $stmt->execute([
        ':user_id' => Session::get("id"),
        ':organization_name' => $orgName
      ]);

      return $result ? 'Organization registered successfully.' : 'Failed to register organization.';
    }
  }

  // Receivers can select which delivery to be assigned to
  public function selectDelivery($deliveryId)
  {
    $sql = "UPDATE food_delivery
            SET receiver_id = :receiver_id
            WHERE id = :delivery_id AND receiver_id IS NULL";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute([
      ':receiver_id' => Session::get("id"),
      ':delivery_id' => $deliveryId
    ]);

    return $stmt->rowCount() > 0 ? 'Delivery selected successfully.' : 'Failed to select delivery.';
  }

  // Get all receivers
  public function getAllReceivers()
  {
    $sql = "SELECT fr.id, fr.organization_name, u.email, u.phone, u.address
            FROM food_receivers fr
            JOIN users u ON fr.user_id = u.id";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Get receiver by user id
  public function getReceiverByUserId($id)
  {
    $sql = "SELECT fr.id, fr.organization_name, u.email, u.phone, u.address
            FROM food_receivers fr
            JOIN users u ON fr.user_id = u.id
            WHERE fr.user_id = :user_id";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute([':user_id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  // Get all donations made to the receiver's organization
  public function getDonationsToOrg($id)
  {
    $sql = "SELECT fd.id AS donation_id, fd.food_description, fd.quantity, fd.pickup_time, 
                  fd.status AS donation_status, fd.created_at AS donation_created_at,
                  fr.organization_name, u.address AS donor_address
            FROM food_donations fd
            JOIN food_delivery dd ON fd.id = dd.donation_id
            JOIN food_receivers fr ON dd.receiver_id = fr.id
            JOIN users u ON fd.donor_id = u.id
            WHERE fr.organization_name = :organization_name
            ORDER BY fd.created_at DESC";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute([':receiver_id' => $id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Example implementation
    // $donations = $receiverClass->getDonationsToOrg('Food Bank');
    // foreach ($donations as $donation) {
    //   echo "Donation ID: " . $donation['donation_id'] . "<br>";
    //   echo "Food Description: " . $donation['food_description'] . "<br>";
    //   echo "Quantity: " . $donation['quantity'] . "<br>";
    //   echo "Pickup Time: " . $donation['pickup_time'] . "<br>";
    //   echo "Donor Address: " . $donation['donor_address'] . "<br>";
    // }
  }
}
