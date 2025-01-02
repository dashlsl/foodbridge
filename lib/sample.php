<?php

$sql = <<<SQL
  -- Insert sample users into users table
  INSERT INTO users (email, password, role, phone, address, isAdmin, points, status) 
  VALUES 
    ('donor@example.com', 'hashed_password', 'donor', '0123456789', '123 Donor St, Donor City', FALSE, 100, 'active'),
    ('volunteer@example.com', 'hashed_password', 'volunteer', '0198764567', '123 Volunteer Ave, Volunteer City', FALSE, 50, 'active'),
    ('receiver@example.com', 'hashed_password', 'receiver', '0174563498', '123 Receiver Rd, Receiver City', FALSE, 0, 'active'),
    ('admin@example.com', 'hashed_password', 'admin', '0139874606', '123 Admin Blvd, Admin City', TRUE, 200, 'active');

  -- Insert sample food donations into food_donations table
  INSERT INTO food_donations (donor_id, food_description, quantity, pickup_time, status) 
  VALUES 
    (1, 'Canned goods', '20 cans', '2024-12-20 10:00:00', 'pending'),
    (1, 'Rice', '50kg', '2024-12-21 12:00:00', 'pending');

  -- Insert sample food receivers into food_receivers table
  INSERT INTO food_receivers (user_id, organization_name) 
  VALUES 
    (3, 'Food Bank of City');

  -- Insert sample food delivery assignments into food_delivery table
  INSERT INTO food_delivery (donation_id, receiver_id, volunteer_id, pickup_status, delivery_status)
  VALUES 
    (1, 1, 2, 'pending', 'scheduled'),
    (2, 1, 2, 'pending', 'scheduled');
SQL;