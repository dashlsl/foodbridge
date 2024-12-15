<?php

if (!defined('ACCESS')) {
    http_response_code(404);
    die();
}

$sql = <<<SQL
    INSERT INTO `users` (`name`, `email`, `password`, `role`, `phone`, `status`)
    VALUES
        ("John Doe", "johndoe@email.com", "password123", "donor", "1234567890", "active"),
        ("Jane Smith", "janesmith@email.com", "password123", "volunteer", "0987654321", "active"),
        ("Food Bank", "food.bank@example.com", "password123", "receiver", "1231231234", "active");

    INSERT INTO `addresses` (`user_id`, `address_type`, `address`, `city`, `state`, `zipcode`)
    VALUES
        (1, "pickup", "123 Main St", "Kuala Lumpur", "Selangor", "12345"),
        (2, "pickup", "456 Another St", "Petaling Jaya", "Selangor", "67890"),
        (3, "delivery", "789 Delivery Rd", "Shah Alam", "Selangor", "11223"),
        (1, "delivery", "101 Donor Lane", "Subang Jaya", "Selangor", "45678");

    INSERT INTO `food_donations` (`donor_id`, `food_description`, `quantity`, `donor_address_id`, `pickup_time`, `status`)
    VALUES
        (1, "20 kg of rice", 20, 1, "2024-12-15 10:00:00", "pending"),
        (2, "10 kg of bread", 10, 2, "2024-12-16 11:00:00", "pending");

    INSERT INTO `food_delivery` (`donation_id`, `volunteer_id`, `pickup_address_id`, `pickup_time`, `pickup_status`, `delivery_address_id`, `delivery_time`, `delivery_status`)
    VALUES
        (1, 2, 1, "2024-12-15 10:00:00", "pending", 3, "2024-12-15 12:00:00", "scheduled"),
        (2, 2, 2, "2024-12-16 11:00:00", "pending", 4, "2024-12-16 13:00:00", "scheduled");

    INSERT INTO `food_receivers` (`user_id`, `organization_name`, `receiver_address_id`)
    VALUES
        (3, "Food Bank Malaysia", 3);

    INSERT INTO `donation_feedback` (`donation_id`, `receiver_id`, `rating`, `comments`)
    VALUES
        (1, 1, 5, "Great donation, thank you!"),
        (2, 1, 4, "Thanks for the bread, it's very helpful.");

    INSERT INTO `posts` (`user_id`, `title`, `post_text`, `date_posted`, `upvotes`, `downvotes`)
    VALUES
        (1, "Food Donation Campaign", "We are collecting rice for the needy.", "2024-12-10", 5, 0),
        (2, "Bread Drive", "Help us distribute bread to the homeless.", "2024-12-11", 10, 1);

    INSERT INTO `votes` (`post_id`, `user_id`, `vote_type`)
    VALUES
        (1, 2, "upvote"),
        (2, 1, "downvote");

    INSERT INTO `notifications` (`user_id`, `message`, `status`)
    VALUES
        (1, "Your donation has been scheduled for pickup.", "unread"),
        (2, "New post available for upvoting.", "unread");
SQL;