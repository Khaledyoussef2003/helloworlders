<?php
session_start();
include "connection.php";

// Only allow admins
if ($_SESSION['isloggedin'] != 1) {
    echo "<script>alert('Access Denied'); window.location.href='index.php';</script>";
    exit;
}

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id']) && isset($_POST['new_status'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['new_status'];
    
    // Update the order status
    $update_sql = "UPDATE `order` SET order_status = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("si", $new_status, $order_id);
    $stmt->execute();
}

// Get filter from URL
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';

$sql = "SELECT 
            o.id AS order_id,
            u.name AS client_name,
            u.username AS client_username,
            p.name AS product_name,
            o.quantity,
            o.total_price,
            o.shipping_address,
            o.billing_address,
            o.payment_method,
            o.contact_number,
            o.special_notes,
            o.created_at AS order_date,
            o.order_status,
            o.order_status
        FROM `order` o
        JOIN user u ON o.user_id = u.id
        JOIN product p ON o.product_id = p.id";

// Add status filter if selected
if (!empty($status_filter)) {
    $sql .= " WHERE o.order_status = '" . $conn->real_escape_string($status_filter) . "'";
}

$sql .= " ORDER BY o.id DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Orders</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f9f9f9;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #e84393;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .empty-msg {
            text-align: center;
            margin-top: 50px;
            color: #888;
        }

        .status-select {
            padding: 8px 30px 8px 12px;
            border: 2px solid #e8e8e8;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            color: #333;
            background: white;
            cursor: pointer;
            transition: all 0.3s ease;
            min-width: 140px;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%23e84393' viewBox='0 0 16 16'%3E%3Cpath d='M8 9.5l-4-4h8l-4 4z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
        }

        .status-select:hover {
            border-color: #e84393;
            box-shadow: 0 2px 8px rgba(232,67,147,0.1);
        }

        .status-select:focus {
            outline: none;
            border-color: #e84393;
            box-shadow: 0 0 0 3px rgba(232,67,147,0.2);
        }

        
        .status-select option[value="pending"] { color: #a05c17; }
        .status-select option[value="confirmed"] { color: #087f75; }
        .status-select option[value="processing"] { color: #0d6832; }
        .status-select option[value="shipped"] { color: #1a5f9c; }
        .status-select option[value="delivered"] { color: #0d7a6a; }
        .status-select option[value="cancelled"] { color: #a01717; }

        .return-menu {
            position: fixed;
            top: 20px;
            left: 20px;
            padding: 12px 24px;
            background: linear-gradient(135deg, #e84393 0%, #d03177 100%);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 4px 15px rgba(232, 67, 147, 0.2);
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .return-menu:hover {
            transform: translateY(-2px);
            background: linear-gradient(135deg, #d03177 0%, #e84393 100%);
            box-shadow: 0 6px 20px rgba(232, 67, 147, 0.3);
        }

        .return-menu i {
            font-size: 16px;
            transition: transform 0.3s ease;
        }

        .return-menu:hover i {
            transform: translateX(-5px);
        }

        .filter-container {
            margin-bottom: 30px;
            display: flex;
            justify-content: center;
        }

        .status-filter-form {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .status-select {
            padding: 12px 35px 12px 15px;
            border: 2px solid #e8e8e8;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 500;
            color: #333;
            background: white;
            cursor: pointer;
            transition: all 0.3s ease;
            min-width: 200px;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23e84393' viewBox='0 0 16 16'%3E%3Cpath d='M8 9.5l-4-4h8l-4 4z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
        }

        .status-select:hover {
            border-color: #e84393;
            box-shadow: 0 2px 8px rgba(232,67,147,0.1);
        }

        .status-select:focus {
            outline: none;
            border-color: #e84393;
            box-shadow: 0 0 0 3px rgba(232,67,147,0.2);
        }

        /* Status badge styles */
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
            text-transform: capitalize;
        }

        .status-pending {
            background-color: #ffd3a5;
            color: #a05c17;
        }

        .status-confirmed {
            background-color: #90f7ec;
            color: #087f75;
        }

        .status-processing {
            background-color: #81fbb8;
            color: #0d6832;
        }

        .status-shipped {
            background-color: #ace0f9;
            color: #1a5f9c;
        }

        .status-delivered {
            background-color: #98f5e1;
            color: #0d7a6a;
        }

        .status-cancelled {
            background-color: #ffbaba;
            color: #a01717;
        }
    </style>
</head>
<body>

<a href="admin.php" class="return-menu">
    <i class="fas fa-arrow-left"></i>
    Back to Menu
</a>

<h2>All Customer Orders</h2>

<div class="filter-container">
    <form method="GET" action="" class="status-filter-form">
        <select name="status" class="status-select" onchange="this.form.submit()">
            <option value="">All Orders</option>
            <option value="pending" <?= $status_filter === 'pending' ? 'selected' : '' ?>>Pending Orders</option>
            <option value="confirmed" <?= $status_filter === 'confirmed' ? 'selected' : '' ?>>Confirmed Orders</option>
            <option value="processing" <?= $status_filter === 'processing' ? 'selected' : '' ?>>Processing Orders</option>
            <option value="shipped" <?= $status_filter === 'shipped' ? 'selected' : '' ?>>Shipped Orders</option>
            <option value="delivered" <?= $status_filter === 'delivered' ? 'selected' : '' ?>>Delivered Orders</option>
            <option value="cancelled" <?= $status_filter === 'cancelled' ? 'selected' : '' ?>>Cancelled Orders</option>
        </select>
    </form>
</div>

<?php
if ($result->num_rows > 0) {
    echo "<table>
        <tr>
            <th>Order ID</th>
            <th>Client Name</th>
            <th>Username</th>
            <th>Product</th>
            <th>Quantity</th>
            <th>Total Price</th>
            <th>Status</th>
            <th>Shipping Address</th>
            <th>Billing Address</th>
            <th>Payment Method</th>
            <th>Contact</th>
            <th>Notes</th>
        </tr>";

    while ($row = $result->fetch_assoc()) {
        $current_status = $row['order_status'];
        echo "<tr>
            <td>{$row['order_id']}</td>
            <td>{$row['client_name']}</td>
            <td>{$row['client_username']}</td>
            <td>{$row['product_name']}</td>
            <td>{$row['quantity']}</td>
            <td>\${$row['total_price']}</td>
            <td>
                <form method='POST' style='margin: 0;'>
                    <input type='hidden' name='order_id' value='{$row['order_id']}'>
                    <select name='new_status' class='status-select' onchange='this.form.submit()'>
                        <option value='pending'" . ($current_status == 'pending' ? ' selected' : '') . ">Pending</option>
                        <option value='confirmed'" . ($current_status == 'confirmed' ? ' selected' : '') . ">Confirmed</option>
                        <option value='processing'" . ($current_status == 'processing' ? ' selected' : '') . ">Processing</option>
                        <option value='shipped'" . ($current_status == 'shipped' ? ' selected' : '') . ">Shipped</option>
                        <option value='delivered'" . ($current_status == 'delivered' ? ' selected' : '') . ">Delivered</option>
                        <option value='cancelled'" . ($current_status == 'cancelled' ? ' selected' : '') . ">Cancelled</option>
                    </select>
                </form>
            </td>
            <td>{$row['shipping_address']}</td>
            <td>{$row['billing_address']}</td>
            <td>{$row['payment_method']}</td>
            <td>{$row['contact_number']}</td>
            <td>{$row['special_notes']}</td>
        </tr>";
    }

    echo "</table>";
} else {
    echo "<p class='empty-msg'>No orders found.</p>";
}
?>

</body>
</html>
