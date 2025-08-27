<?php
session_start();
require_once 'connection.php';

if (!isset($_SESSION['user-id'])) {
    header("location:login.php");
    exit;
}

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $user_id = $_SESSION['user-id'];
    
    // Get product price
    $sql = "SELECT unit_price FROM product WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    
    if ($product) {
        // Calculate total price
        $quantity = 1;
        $total_price = $product['unit_price'] * $quantity;
        
        // Insert into cart table
        $sql = "INSERT INTO card (user_id, product_id, quantity, unit_price, total_price) 
                VALUES (?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiidd", $user_id, $product_id, $quantity, $product['unit_price'], $total_price);
        
        if ($stmt->execute()) {
            header("location:client.php");
            exit;
        } else {
            echo "Error adding product to cart: " . $conn->error;
        }
    }
}
?>
    $sql = "SELECT unit_price FROM product WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    
    if ($product) {
        // Insert into cart table with initial/empty order information
        $sql = "INSERT INTO card (user_id, product_id, quantity, unit_price, total_price) 
                VALUES (?, ?, 1, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        $total_price = $product['unit_price'];
        $stmt->bind_param("iidd", $user_id, $product_id, $product['unit_price'], $total_price);
        
        if ($stmt->execute()) {
            header("location:client.php");
        } else {
            echo "Error adding product to cart: " . $conn->error;
        }
    }

?>