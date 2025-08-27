<?php
// Database Migration Script - Simple 2-table approach
require_once 'connection.php';

echo "<h2>Database Migration for Flower Shop</h2>";
echo "<p>This script will create the new 2-table structure: 'card' (cart) and 'order' (completed orders).</p>";

try {
    // First, let's backup the existing card table
    $result = $conn->query("SHOW TABLES LIKE 'card'");
    if ($result->num_rows > 0) {
        echo "<p>Backing up existing 'card' table to 'card_backup'...</p>";
        $conn->query("CREATE TABLE card_backup AS SELECT * FROM card");
        echo "<p>✓ Backup created</p>";
        
        // Drop the original card table
        $conn->query("DROP TABLE card");
        echo "<p>✓ Original card table dropped</p>";
    }

    // Create new card table (for shopping cart)
    $sql = "CREATE TABLE IF NOT EXISTS `card` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `user_id` int(11) NOT NULL,
      `product_id` int(11) NOT NULL,
      `quantity` int(11) NOT NULL DEFAULT 1,
      `unit_price` decimal(10,2) NOT NULL,
      `total_price` decimal(10,2) NOT NULL,
      `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      KEY `user_id` (`user_id`),
      KEY `product_id` (`product_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    if ($conn->query($sql) === TRUE) {
        echo "<p>✓ New 'card' table (cart) created successfully</p>";
    }

    // Create order table (for completed orders)
    $sql = "CREATE TABLE IF NOT EXISTS `order` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `user_id` int(11) NOT NULL,
      `product_id` int(11) NOT NULL,
      `quantity` int(11) NOT NULL,
      `unit_price` decimal(10,2) NOT NULL,
      `total_price` decimal(10,2) NOT NULL,
      `shipping_address` text NOT NULL,
      `billing_address` text NOT NULL,
      `payment_method` varchar(50) NOT NULL,
      `contact_number` varchar(20) NOT NULL,
      `special_notes` text,
      `order_status` enum('pending','confirmed','processing','shipped','delivered','cancelled') DEFAULT 'confirmed',
      `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      KEY `user_id` (`user_id`),
      KEY `product_id` (`product_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    if ($conn->query($sql) === TRUE) {
        echo "<p>✓ 'order' table created successfully</p>";
    }

    // Check if we have backup data to migrate
    $result = $conn->query("SHOW TABLES LIKE 'card_backup'");
    if ($result->num_rows > 0) {
        $result = $conn->query("SELECT COUNT(*) as count FROM card_backup");
        $count = $result->fetch_assoc()['count'];
        
        if ($count > 0) {
            echo "<p>Found $count records in backup table</p>";
            
            // Migrate cart items (items without shipping address)
            $sql = "INSERT INTO card (user_id, product_id, quantity, unit_price, total_price, created_at)
                    SELECT user_id, product_id, quantity, 
                           (total_price / quantity) as unit_price, 
                           total_price, created_at
                    FROM card_backup 
                    WHERE shipping_address IS NULL OR shipping_address = ''";
            
            if ($conn->query($sql)) {
                $cart_migrated = $conn->affected_rows;
                echo "<p>✓ Migrated $cart_migrated cart items</p>";
            }
            
            // Migrate orders (items with shipping address)
            $sql = "INSERT INTO `order` (user_id, product_id, quantity, unit_price, total_price, 
                           shipping_address, billing_address, payment_method, contact_number, 
                           special_notes, created_at)
                    SELECT user_id, product_id, quantity, 
                           (total_price / quantity) as unit_price, 
                           total_price, shipping_address, billing_address, 
                           payment_method, contact_number, special_notes, created_at
                    FROM card_backup 
                    WHERE shipping_address IS NOT NULL AND shipping_address != ''";
            
            if ($conn->query($sql)) {
                $orders_migrated = $conn->affected_rows;
                echo "<p>✓ Migrated $orders_migrated completed orders</p>";
            }
        }
    }

    echo "<h3>Migration completed successfully!</h3>";
    echo "<p>Now you have:</p>";
    echo "<ul>";
    echo "<li><strong>'card' table</strong> - for shopping cart items (temporary)</li>";
    echo "<li><strong>'order' table</strong> - for completed orders with shipping info</li>";
    echo "</ul>";
    echo "<p><a href='admin_orders.php'>View Admin Orders</a> | <a href='client.php'>Shop Now</a></p>";
    
} catch (Exception $e) {
    echo "<p style='color: red'>Error: " . $e->getMessage() . "</p>";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Database Migration</title>
    <style>
        body { font-family: Arial; margin: 30px; }
        h2 { color: #333; }
        p { margin: 10px 0; }
        .success { color: green; }
        .error { color: red; }
    </style>
</head>
<body>
</body>
</html>
