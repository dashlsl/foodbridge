<?php

require_once 'classes/Session.php';
Session::init();

class Deliveries
{
  private $db;

  public function __construct($db)
  {
    $this->db = $db;
  }

  // Get all available (pending) deliveries
  public function getAvailableDeliveries()
  {
    $sql = "SELECT fd.id, fd.food_description, fd.quantity, fd.pickup_time, fd.status,
                    fd.created_at, dd.pickup_status, dd.delivery_status, 
                    ud.address AS donor_address, ur.address AS receiver_address, r.organization_name
            FROM food_donations fd
            JOIN food_delivery dd ON fd.id = dd.donation_id
            JOIN users ud ON fd.donor_id = ud.id
            JOIN food_receivers r ON dd.receiver_id = r.id
            JOIN users ur ON r.user_id = ur.id
            WHERE dd.pickup_status = 'pending' AND dd.delivery_status = 'scheduled'";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Assign volunteer to a pending delivery
  public function selectDelivery($deliveryId)
  {
    $sql = "UPDATE food_donations
              SET status = 'picked_up' 
              WHERE id = :delivery_id";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute([
      ':delivery_id' => $deliveryId
    ]);

    // Insert into food_delivery table
    $sql = "INSERT INTO food_delivery (donation_id, volunteer_id, receiver_id, pickup_status, delivery_status)
            VALUES (:donation_id, :volunteer_id, null, 'in_progress', 'scheduled')";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute([
      ':donation_id' => $deliveryId,
      ':volunteer_id' => Session::get('id')
    ]);

    return $stmt->rowCount() > 0; // Returns true if the volunteer was successfully assigned
  }

  // Get delivery status
  public function getDeliveryStatus($donationId)
  {
    $sql = "SELECT status
            FROM deliveries
            WHERE donation_id = :donation_id";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute([':donation_id' => $donationId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  // Update delivery status (pickup and delivery)
  public function updateDeliveryStatus($deliveryId, $pickupStatus, $deliveryStatus)
  {
    if (
      !in_array($pickupStatus, ['pending', 'in_progress', 'completed'])
      || !in_array($deliveryStatus, ['scheduled', 'delivered'])
    ) {
      return 'Invalid status.';
    }

    $sql = "UPDATE food_delivery 
            SET pickup_status = :pickup_status, delivery_status = :delivery_status 
            WHERE id = :delivery_id";
    $stmt = $this->db->pdo->prepare($sql);
    $result = $stmt->execute([
      ':pickup_status' => $pickupStatus,
      ':delivery_status' => $deliveryStatus,
      ':delivery_id' => $deliveryId
    ]);

    // If the deliver status is 'delivered', reward the volunteer
    if ($deliveryStatus == 'delivered') {
      // Call the rewardVolunteer method and pass the volunteer ID
      $points = new Points($this->db);
      $points->rewardVolunteer(Session::get("id"));
    }

    return $result ? 'Delivery status updated successfully.' : 'Failed to update delivery status.';
  }

  // Get all deliveries by user id (volunteer)
  public function getDeliveriesByVolunteerId($id)
  {
    $sql = "SELECT *
            FROM food_delivery
            WHERE volunteer_id = :volunteer_id
            ORDER BY pickup_status DESC";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute([
      ':volunteer_id' => $id
    ]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Get all volunteers
  public function getAllVolunteers()
  {
    $sql = "SELECT *
            FROM users
            WHERE role = 'volunteer'
            ORDER BY created_at DESC";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}