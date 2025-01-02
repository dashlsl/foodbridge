<?php

require_once 'classes/Session.php';
Session::init();

class Donations
{
  private $db;

  public function __construct($db)
  {
    $this->db = $db;
  }

  // Create a new donation
  public function createDonation($data)
  {
    $foodDesc = htmlspecialchars(trim($data['food_desc']));
    $quantity = htmlspecialchars(trim($data['quantity']));
    $pickupDateTime = htmlspecialchars(trim($data['pickup_time']));

    $curDateTime = new DateTime();
    $pickupDateTimeObj = DateTime::createFromFormat('Y-m-d\TH:i', $pickupDateTime);

    // Set status to pending (default)
    $status = 'pending';

    // Check if any required fields are empty
    if (empty($foodDesc) || empty($quantity) || empty($pickupDateTime)) {
      return 'All fields are required.';
    }
    // Validate pickup date
    elseif (!$pickupDateTimeObj || $pickupDateTimeObj <= $curDateTime) {
      return 'Pickup date must be in the future.';
    } else {
      // Insert donation into the database
      $sql = "INSERT INTO food_donations (donor_id, food_description, quantity, pickup_time, status)
              VALUES (:donor_id, :food_description, :quantity, :pickup_time, :status)";
      $stmt = $this->db->pdo->prepare($sql);
      $result = $stmt->execute([
        ':donor_id' => Session::get("id"),
        ':food_description' => $foodDesc,
        ':quantity' => $quantity,
        ':pickup_time' => $pickupDateTimeObj->format('Y-m-d H:i:s'),
        ':status' => $status
      ]);

      return $result ? 'Donation created successfully.' : 'Failed to create donation.';
    }
  }

  // Get donor's address from the users table
  private function getDonorAddress($id)
  {
    $sql = "SELECT address
            FROM users
            WHERE id = :donor_id";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute([
      ':donor_id' => $id
    ]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
      return $result['address'];
    } else {
      return false;
    }
  }

  // Get all donations by user id (donor)
  public function getDonationsByDonorId($id)
  {
    $sql = "SELECT *
            FROM food_donations
            WHERE donor_id = :donor_id
            ORDER BY pickup_time DESC";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute([
      ':donor_id' => $id
    ]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get donor's address
    foreach ($result as $key => $donation) {
      $donorAddress = $this->getDonorAddress($donation['donor_id']);
      $result[$key]['donor_address'] = $donorAddress;
    }

    return $result;
  }

  // Get all donations
  public function getAllDonations()
  {
    $sql = "SELECT *
            FROM food_donations
            ORDER BY pickup_time DESC";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get donor's address
    foreach ($result as $key => $donation) {
      $donorAddress = $this->getDonorAddress($donation['donor_id']);
      $result[$key]['donor_address'] = $donorAddress;
    }

    return $result;
  }

  // Get all donors
  public function getAllDonors()
  {
    $sql = "SELECT *
            FROM users
            WHERE role = 'donor'
            ORDER BY created_at DESC";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Get all donations by status
  public function getDonationsByStatus($status)
  {
    $sql = "SELECT *
            FROM food_donations
            WHERE status = :status
            ORDER BY pickup_time DESC";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute([
      ':status' => $status
    ]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get donor's address
    foreach ($result as $key => $donation) {
      $donorAddress = $this->getDonorAddress($donation['donor_id']);
      $result[$key]['donor_address'] = $donorAddress;
    }

    return $result;
  }

  // Update donation status
  public function updateDonationStatus($donationId, $newStatus)
  {
    if (!in_array($newStatus, ['pending', 'picked_up', 'delivered'])) {
      return 'Invalid status.';
    }

    $sql = "UPDATE food_donations
            SET status = :status
            WHERE id = :donation_id";
    $stmt = $this->db->pdo->prepare($sql);
    $result = $stmt->execute([
      ':status' => $newStatus,
      ':donation_id' => $donationId
    ]);

    // If the donation status is 'delivered', reward the donor
    if ($newStatus == 'delivered') {
      // Call the rewardDonor method and pass the donor ID
      $points = new Points($this->db);
      $points->rewardDonor(Session::get("id"));
    }

    return $result ? 'Donation status updated successfully.' : 'Failed to update donation status.';
  }

  // Delete a donation
  public function deleteDonation($donationId)
  {
    $sql = "DELETE FROM food_donations WHERE id = :donation_id";
    $stmt = $this->db->pdo->prepare($sql);
    $result = $stmt->execute([
      ':donation_id' => $donationId
    ]);

    return $result ? 'Donation deleted successfully.' : 'Failed to delete donation.';
  }
}