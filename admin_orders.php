





<?php
require_once 'connection.php';
session_start();

// Security: Allow only admin
if (!isset($_SESSION['admin'])) {
    header("location:login.php");
    exit;
}

$sql = "
    SELECT 
        o.id AS order_id,
        u.username,
        p.name AS product_name,
        o.quantity,
        o.total_price,
        o.shipping_address,
        o.billing_address,
        o.payment_method,
        o.contact_number,
        o.special_notes,
        o.order_status,
        o.created_at
    FROM `order` o
    JOIN user u ON o.user_id = u.id
    JOIN product p ON o.product_id = p.id
    ORDER BY o.created_at DESC
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Orders</title>
    <style>
        body { font-family: Arial; margin: 30px; background: #f5f5f5; }
        h2 { color: #333; }
        table { width: 100%; border-collapse: collapse; background: #fff; box-shadow: 0 0 10px #ccc; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #444; color: white; }
        tr:hover { background-color: #f1f1f1; }
        .address { max-width: 200px; white-space: pre-wrap; }
        .notes { max-width: 200px; white-space: pre-wrap; color: #666; }
        .order-info { font-weight: bold; }
        .status-pending { background: #ffc107; color: #000; padding: 4px 8px; border-radius: 4px; }
        .status-confirmed { background: #28a745; color: #fff; padding: 4px 8px; border-radius: 4px; }
        .status-processing { background: #17a2b8; color: #fff; padding: 4px 8px; border-radius: 4px; }
        .status-shipped { background: #6f42c1; color: #fff; padding: 4px 8px; border-radius: 4px; }
        .status-delivered { background: #20c997; color: #fff; padding: 4px 8px; border-radius: 4px; }
        .status-cancelled { background: #dc3545; color: #fff; padding: 4px 8px; border-radius: 4px; }
    </style>
</head>
<body>
    <h2>Order List</h2>
    <table>
        <tr>
            <th>Order ID</th>
            <th>Client Username</th>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Total Price</th>
            <th>Status</th>
            <th>Payment Method</th>
            <th>Contact Number</th>
            <th>Shipping Address</th>
            <th>Billing Address</th>
            <th>Special Notes</th>
            <th>Order Date</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td class="order-info"><?= $row['order_id'] ?></td>
            <td><?= htmlspecialchars($row['username']) ?></td>
            <td><?= htmlspecialchars($row['product_name']) ?></td>
            <td><?= $row['quantity'] ?></td>
            <td>$<?= number_format($row['total_price'], 2) ?></td>
            <td>
                <span class="status-<?= $row['order_status'] ?>">
                    <?= ucfirst($row['order_status']) ?>
                </span>
            </td>
            <td><?= htmlspecialchars($row['payment_method']) ?></td>
            <td><?= htmlspecialchars($row['contact_number']) ?></td>
            <td class="address"><?= nl2br(htmlspecialchars($row['shipping_address'])) ?></td>
            <td class="address"><?= nl2br(htmlspecialchars($row['billing_address'])) ?></td>
            <td class="notes"><?= nl2br(htmlspecialchars($row['special_notes'])) ?></td>
            <td><?= date('Y-m-d H:i', strtotime($row['created_at'])) ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

