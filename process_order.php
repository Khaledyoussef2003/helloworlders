<?php
session_start();
require_once 'connection.php';

if (!isset($_SESSION['user-id'])) {
    header("location:login.php");
    exit;
}

$user_id = $_SESSION['user-id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $shipping_address = $_POST['shipping_address'];
    $billing_address = $_POST['billing_address'];
    $payment_method = $_POST['payment_method'];
    $contact_number = $_POST['contact_number'];
    $special_notes = $_POST['special_notes'] ?? '';
    
    try {
        // Start transaction
        $conn->autocommit(false);
        
        // Get cart items for this user
        $stmt = $conn->prepare("SELECT * FROM card WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $cart_items = $stmt->get_result();
        
        if ($cart_items->num_rows == 0) {
            header("Location: shopping2.php?error=empty_cart");
            exit;
        }
        
        // Move each cart item to order table
        while ($item = $cart_items->fetch_assoc()) {
            $stmt = $conn->prepare("
                INSERT INTO `order` (user_id, product_id, quantity, unit_price, total_price, shipping_address, billing_address, payment_method, contact_number, special_notes)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            
            $stmt->bind_param("iiiidsssss", 
                $item['user_id'], 
                $item['product_id'], 
                $item['quantity'], 
                $item['unit_price'], 
                $item['total_price'],
                $shipping_address, 
                $billing_address, 
                $payment_method, 
                $contact_number, 
                $special_notes
            );
            
            if (!$stmt->execute()) {
                throw new Exception("Failed to create order: " . $stmt->error);
            }
        }
        
        // Clear the cart
        $stmt = $conn->prepare("DELETE FROM card WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        if (!$stmt->execute()) {
            throw new Exception("Failed to clear cart: " . $stmt->error);
        }
        
        // Commit transaction
        $conn->commit();
        
        // Redirect to order confirmation
        header("Location: order_confirmation.php?success=1");
        exit;
        
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        header("Location: shopping2.php?error=" . urlencode($e->getMessage()));
        exit;
    }
}

header("Location: shopping2.php?error=failed");
?>
