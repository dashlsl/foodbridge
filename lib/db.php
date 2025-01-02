<?php

include 'config/config.php';

class Database
{

  private static $instance = null;
  public $pdo;

  public function __construct()
  {
    try {
      $this->pdo = new PDO('mysql:host=' . HOST, USERNAME, PASSWORD);
      $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $this->pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);

      $this->setupDB();

      return $this->pdo;
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  // Get the instance of the Database connection
  public static function getInstance()
  {
    if (self::$instance == null) {
      self::$instance = new Database();
    }
    return self::$instance;
  }

  public function setupDB()
  {
    try {
      // Select the database or create it if it doesn't exist
      $this->pdo->exec("CREATE DATABASE IF NOT EXISTS " . DBNAME);
      $this->pdo->exec("USE " . DBNAME);

      // List of required tables
      $requiredTables = ['users', 'food_donations', 'food_receivers', 'food_delivery'];

      // Fetch the existing tables
      $existingTables = [];
      $stmt = $this->pdo->query("SHOW TABLES");
      while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
        $existingTables[] = $row[0];
      }

      // Check if all required tables exist
      $allTablesExist = !array_diff($requiredTables, $existingTables);

      // If tables are missing, drop all existing tables and recreate them
      if (!$allTablesExist) {
        // Drop all tables
        foreach ($existingTables as $table) {
          $this->pdo->exec("DROP TABLE IF EXISTS $table");
        }

        // Create tables
        $queries = [
          "CREATE TABLE users (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    email VARCHAR(255) NOT NULL UNIQUE,
                    password VARCHAR(255) NOT NULL,
                    role ENUM('donor', 'volunteer', 'receiver') NOT NULL,
                    phone VARCHAR(15) NOT NULL,
                    address VARCHAR(255) DEFAULT NULL,
                    isAdmin BOOLEAN DEFAULT FALSE,
                    points INT DEFAULT 0,
                    status ENUM('active', 'suspended', 'deleted') DEFAULT 'active',
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )",
          "CREATE TABLE food_donations (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    donor_id INT NOT NULL,
                    food_description TEXT NOT NULL,
                    quantity VARCHAR(255) NOT NULL,
                    pickup_time TIMESTAMP NOT NULL,
                    status ENUM('pending', 'picked_up', 'delivered') DEFAULT 'pending',
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    FOREIGN KEY (donor_id) REFERENCES users(id) ON DELETE CASCADE
                )",
          "CREATE TABLE food_receivers (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    user_id INT NOT NULL,
                    organization_name VARCHAR(255) NOT NULL,
                    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
                )",
          "CREATE TABLE food_delivery (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    donation_id INT NOT NULL,
                    receiver_id INT DEFAULT NULL,
                    volunteer_id INT DEFAULT NULL,
                    pickup_status ENUM('pending', 'in_progress', 'completed') DEFAULT 'pending',
                    delivery_status ENUM('scheduled', 'delivered') DEFAULT 'scheduled',
                    FOREIGN KEY (donation_id) REFERENCES food_donations(id) ON DELETE CASCADE,
                    FOREIGN KEY (receiver_id) REFERENCES food_receivers(id) ON DELETE CASCADE,
                    FOREIGN KEY (volunteer_id) REFERENCES users(id) ON DELETE CASCADE
                )"
        ];

        // Execute all table creation queries
        foreach ($queries as $query) {
          $this->pdo->exec($query);
        }
      }
    } catch (PDOException $e) {
      echo "Error setting up database: " . $e->getMessage();
    }
  }
}