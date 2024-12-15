<?php

if (!defined('ACCESS')) {
    http_response_code(404);
    die();
}

$sql = <<<SQL
    CREATE TABLE `users` (
        `user_id` INT AUTO_INCREMENT PRIMARY KEY,
        `name` VARCHAR(255) NOT NULL,
        `email` VARCHAR(255) NOT NULL UNIQUE,
        `password` VARCHAR(255) NOT NULL,
        `role` ENUM('donor', 'volunteer', 'receiver', 'admin') NOT NULL,
        `phone` VARCHAR(15) NOT NULL,
        `address` VARCHAR(255) DEFAULT NULL,
        `status` ENUM('active', 'suspended', 'deleted') DEFAULT 'active',
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

    CREATE TABLE `food_donations` (
        `donation_id` INT AUTO_INCREMENT PRIMARY KEY,
        `donor_id` INT NOT NULL,
        `food_description` TEXT NOT NULL,
        `quantity` VARCHAR(255) NOT NULL, -- e.g., 10kg, 20 packets
        `pickup_time` TIMESTAMP NOT NULL,
        `status` ENUM('pending', 'picked_up', 'delivered') DEFAULT 'pending',
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (`donor_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE
    );

    CREATE TABLE `food_delivery` (
        `delivery_id` INT AUTO_INCREMENT PRIMARY KEY,
        `donation_id` INT NOT NULL,
        `receiver_id` INT NOT NULL,
        `volunteer_id` INT NOT NULL,
        `pickup_status` ENUM('pending', 'in_progress', 'completed') DEFAULT 'pending',
        `delivery_status` ENUM('scheduled', 'delivered') DEFAULT 'scheduled',
        FOREIGN KEY (`donation_id`) REFERENCES `food_donations`(`donation_id`) ON DELETE CASCADE,
        FOREIGN KEY (`receiver_id`) REFERENCES `food_receivers`(`receiver_id`) ON DELETE CASCADE,
        FOREIGN KEY (`volunteer_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE
    );

    CREATE TABLE `food_receivers` (
        `receiver_id` INT AUTO_INCREMENT PRIMARY KEY,
        `user_id` INT NOT NULL, -- Foreign key linking to the 'users' table
        `organization_name` VARCHAR(255) NOT NULL,
        FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE
    );


    -- TBC: Extra Features

    CREATE TABLE `donation_feedback` (
        `feedback_id` INT AUTO_INCREMENT PRIMARY KEY,
        `donation_id` INT NOT NULL,
        `receiver_id` INT NOT NULL,  -- linked to the `food_receivers` table
        `rating` INT NOT NULL,  -- rating for the donation (e.g., 1-5 stars)
        `comments` TEXT DEFAULT NULL,  -- feedback comments
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (`donation_id`) REFERENCES `food_donations`(`donation_id`) ON DELETE CASCADE,
        FOREIGN KEY (`receiver_id`) REFERENCES `food_receivers`(`receiver_id`) ON DELETE CASCADE
    );

    CREATE TABLE `posts` (
        `post_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `user_id` INT NOT NULL,
        `title` VARCHAR(128) NOT NULL,
        `post_text` TEXT NOT NULL,
        `date_posted` DATE NOT NULL,
        `upvotes` INT NOT NULL DEFAULT 0,
        `downvotes` INT NOT NULL DEFAULT 0,
        FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE
    );

    CREATE TABLE `votes` (
        `vote_id` INT AUTO_INCREMENT PRIMARY KEY,
        `post_id` INT NOT NULL,
        `user_id` INT NOT NULL,
        `vote_type` ENUM('upvote', 'downvote') NOT NULL,  -- stores the type of vote
        UNIQUE (`user_id`, `post_id`),  -- Ensures only one vote per user per post
        FOREIGN KEY (`post_id`) REFERENCES `posts`(`post_id`) ON DELETE CASCADE,
        FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE
    );

    CREATE TABLE `notifications` (
        `notification_id` INT AUTO_INCREMENT PRIMARY KEY,
        `user_id` INT NOT NULL,  -- user receiving the notification
        `message` TEXT NOT NULL,
        `status` ENUM('unread', 'read') DEFAULT 'unread',
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE
    );
SQL;