<?php

class Points
{
  private $db;

  public function __construct($db)
  {
    $this->db = $db;
  }

  // Get user's current points
  public function getPoints($userId)
  {
    $sql = "SELECT points
              FROM users
              WHERE id = :id";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute([
      ':id' => $userId
    ]);
    $points = $stmt->fetch(PDO::FETCH_ASSOC);
    return $points['points'];
  }

  // Add points to user
  public function addPoints($userId, $points)
  {
    $currentPoints = $this->getPoints($userId);
    $newPoints = $currentPoints + $points;

    $sql = "UPDATE users
              SET points = :points
              WHERE id = :id";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute([
      ':points' => $newPoints,
      ':id' => $userId
    ]);
  }

  // Deduct points from user
  public function deductPoints($userId, $points)
  {
    $currentPoints = $this->getPoints($userId);
    $newPoints = $currentPoints - $points;

    if ($newPoints <= 0) {
      return 'Insufficient points.';
    }

    $sql = "UPDATE users
              SET points = :points
              WHERE id = :id";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute([
      ':points' => $newPoints,
      ':id' => $userId
    ]);
  }

  // Reward points for donors
  public function rewardDonor($userId)
  {
    // Example: reward 10 points per donation
    $pointsEarned = 10;
    $this->addPoints($userId, $pointsEarned);
  }

  // Reward points for volunteers
  public function rewardVolunteer($userId)
  {
    // Example: reward 15 points per delivery
    $pointsEarned = 15;
    $this->addPoints($userId, $pointsEarned);
  }
}
