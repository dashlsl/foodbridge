<?php



class Admin
{
  private $db;

  public function __construct($db)
  {
    $this->db = $db;
  }

  // Check if the current session user is an admin
  public function isAdmin()
  {
    if (!isset($_SESSION['user'])) {
      return false;
    }

    $userId = $_SESSION['user']['id'];
    $sql = "SELECT isAdmin
            FROM users
            WHERE id = :id";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute([
      ':id' => $userId
    ]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user['isAdmin']) {
      return false; // Not an admin
    } else {
      return true; // Admin
    }
  }

  // Select all users
  public function getAllUsers()
  {
    $sql = "SELECT *
            FROM users
            ORDER BY created_at DESC";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Update a user's role
  public function updateUserRole($userId, $newRole)
  {
    if (!in_array($newRole, ['donor', 'volunteer', 'receiver'])) {
      return 'Invalid role.';
    }

    $sql = "UPDATE users
            SET role = :role
            WHERE id = :id";
    $stmt = $this->db->pdo->prepare($sql);
    $result = $stmt->execute([
      ':role' => $newRole,
      ':id' => $userId
    ]);

    return $result ? 'User role updated successfully.' : 'Failed to update user role.';
  }

  // Update user information
  public function updateUserInfo($userId, $newEmail, $newPhone, $newAddress, $newStatus, $newPoints)
  {
    // Validate email
    if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
      return 'Invalid email format.';
    }

    // Update user info in the database
    $sql = "UPDATE users
            SET email = :email, phone = :phone, address = :address, status = :status, points = :points
            WHERE id = :id";
    $stmt = $this->db->pdo->prepare($sql);
    $result = $stmt->execute([
      ':email' => $newEmail,
      ':phone' => $newPhone,
      ':address' => $newAddress,
      ':status' => $newStatus,
      ':points' => $newPoints,
      ':id' => $userId
    ]);

    return $result ? 'User information updated successfully.' : 'Failed to update user information.';
  }

  // Delete a user
  public function deleteUser($userId)
  {
    $sql = "DELETE FROM users WHERE id = :id";
    $stmt = $this->db->pdo->prepare($sql);
    $result = $stmt->execute([
      ':id' => $userId
    ]);

    return $result ? 'User deleted successfully.' : 'Failed to delete user.';
  }
}
