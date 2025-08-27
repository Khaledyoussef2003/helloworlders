<?php
session_start();
require_once 'connection.php';

// Check if user is logged in
if (!isset($_SESSION['user-id'])) {
    header("location:login.php");
    exit;
}

// Get order details
$user_id = $_SESSION['user-id'];

if (isset($_GET['success'])) {
    // Get recent orders for this user
    $sql = "SELECT o.*, p.name as product_name 
            FROM `order` o 
            JOIN product p ON o.product_id = p.id 
            WHERE o.user_id = ?
            ORDER BY o.created_at DESC";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $orders = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    
    if (empty($orders)) {
        header("location:client.php");
        exit;
    }

    // Calculate total order amount
    $orderTotal = 0;
    foreach ($orders as $order) {
        $orderTotal += $order['total_price'];
    }
    
} else {
    header("location:client.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation</title>
    <style>
        body {
            font-family: Arial;
            max-width: 800px;
            margin: 20px auto;
            background: #f4f4f4;
            padding: 20px;
        }
        .card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .success-header {
            background: #28a745;
            color: white;
            text-align: center;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .row {
            display: flex;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .label {
            font-weight: bold;
            width: 150px;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }
        th {
            background: #f8f9fa;
        }
        .total-row {
            font-weight: bold;
            border-top: 2px solid #ddd;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="success-header">
        <h2>Thank You for Your Order!</h2>
        <p>Your order has been placed successfully.</p>
        <p><strong>Order Total: $<?= number_format($orderTotal, 2) ?></strong></p>
    </div>

    <?php if (!empty($orders)): 
        $firstOrder = $orders[0];
    ?>
    <div class="card">
        <h3>Order Details</h3>
        <div class="row">
            <div class="label">Order Date:</div>
            <div><?= date('F j, Y, g:i a', strtotime($firstOrder['created_at'])) ?></div>
        </div>
        <div class="row">
            <div class="label">Shipping Address:</div>
            <div><?= nl2br(htmlspecialchars($firstOrder['shipping_address'])) ?></div>
        </div>
        <div class="row">
            <div class="label">Payment Method:</div>
            <div><?= htmlspecialchars($firstOrder['payment_method']) ?></div>
        </div>
        <div class="row">
            <div class="label">Contact Number:</div>
            <div><?= htmlspecialchars($firstOrder['contact_number']) ?></div>
        </div>
        <?php if (!empty($firstOrder['special_notes'])): ?>
        <div class="row">
            <div class="label">Special Notes:</div>
            <div><?= nl2br(htmlspecialchars($firstOrder['special_notes'])) ?></div>
        </div>
        <?php endif; ?>

        <h3>Ordered Items</h3>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th style="text-align: right">Quantity</th>
                    <th style="text-align: right">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= htmlspecialchars($order['product_name']) ?></td>
                    <td style="text-align: right"><?= $order['quantity'] ?></td>
                    <td style="text-align: right">$<?= number_format($order['total_price'], 2) ?></td>
                </tr>
                <?php endforeach; ?>
                <tr class="total-row">
                    <td colspan="2" style="text-align: right">Total:</td>
                    <td style="text-align: right">$<?= number_format($orderTotal, 2) ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <?php else: ?>
        <div class="card">
            <p>Order details are being processed...</p>
        </div>
    <?php endif; ?>

    <a href="client.php" class="btn">Continue Shopping</a>
</body>
</html>