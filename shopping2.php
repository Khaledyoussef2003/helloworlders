<?php
session_start();
require_once 'connection.php';

// Security check - must be logged in
if (!isset($_SESSION['user-id'])) {
    header("location:login.php");
    exit;
}

$user_id = $_SESSION['user-id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update quantities and shipping information
    if (isset($_POST['update_cart']) && isset($_POST['quantity'])) {
        foreach ($_POST['quantity'] as $card_id => $new_quantity) {
            $stmt = $conn->prepare("
                UPDATE card 
                SET quantity = ?,
                    total_price = (SELECT unit_price FROM product WHERE id = card.product_id) * ?
                WHERE id = ? AND user_id = ?
            ");
            $stmt->bind_param("iiii", $new_quantity, $new_quantity, $card_id, $user_id);
            $stmt->execute();
        }
    }

    if (isset($_POST['place_order'])) {
        $shipping_address = $_POST['shipping_address'] ?? '';
        $billing_address = $_POST['billing_address'] ?? '';
        $payment_method = $_POST['payment_method'] ?? '';
        $contact_number = $_POST['contact_number'] ?? '';
        $special_notes = $_POST['special_notes'] ?? '';

        // Calculate total
        $stmt = $conn->prepare("
            SELECT SUM(total_price) as total 
            FROM card 
            WHERE user_id = ?
        ");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $total = $result->fetch_assoc()['total'];

        // Move items from cart to order table
        $stmt = $conn->prepare("
            INSERT INTO `order` (user_id, product_id, quantity, unit_price, total_price, 
                               shipping_address, billing_address, payment_method, 
                               contact_number, special_notes)
            SELECT user_id, product_id, quantity, unit_price, total_price,
                   ?, ?, ?, ?, ?
            FROM card 
            WHERE user_id = ?
        ");
        
        $stmt->bind_param("sssssi", 
            $shipping_address, 
            $billing_address, 
            $payment_method, 
            $contact_number, 
            $special_notes, 
            $user_id
        );
        
        if ($stmt->execute()) {
            // Clear the cart after successful order
            $stmt = $conn->prepare("DELETE FROM card WHERE user_id = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            
            // Redirect to order confirmation
            header("Location: order_confirmation.php?success=1");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-image: url("img.webp");
            background-size: cover;
            background-position: center;
            padding: 20px;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: lightpink;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #04AA6D;
            color: white;
            position: sticky;
            top: 0;
        }

        tr:nth-child(even) {
            background-color: lightyellow;
        }

        img {
            max-width: 80px;
            height: auto;
            border-radius: 5px;
        }

        .btn-group {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-checkout {
            background-color: #4CAF50;
            color: white;
        }

        .btn-back {
            background-color: #f44336;
            color: white;
        }

        .btn:hover {
            opacity: 0.8;
            transform: translateY(-2px);
        }

        .order-info {
            margin-top: 30px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        textarea.form-control {
            min-height: 80px;
        }
        /* Add these to your existing styles */
#creditCardForm {
    transition: all 0.3s ease;
}
#cardnumber, #expiry, #cvv {
    background: white;
}
.row {
    display: flex;
    gap: 15px;
}
.col-md-6 {
    flex: 1;
}

        .empty-cart {
            text-align: center;
            padding: 40px;
            font-size: 18px;
        }
    </style>
    <script>
        // Only handle credit card form visibility
        document.addEventListener('DOMContentLoaded', function() {
    </script>
</head>
<body>
    <div class="container">
        <?php
        // Get cart items using prepared statement
        $stmt = $conn->prepare("
            SELECT c.id, c.quantity, c.total_price, 
                   p.name, p.image, p.unit_price
            FROM card c
            INNER JOIN product p ON c.product_id = p.id 
            WHERE c.user_id = ?
        ");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0): 
        ?>
                        <!-- Form for updating quantities -->
                <form method="POST" id="updateForm">
                <input type="hidden" name="update_cart" value="1">
                <table>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Image</th>
                            <th>Unit Price</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $index = 1;
                        while ($row = $result->fetch_assoc()): 
                            $total_price = $row["unit_price"] * $row["quantity"];
                        ?>
                            <tr>
                                <td><?= htmlspecialchars($row["name"]) ?></td>
                                <td><img src="images/<?= htmlspecialchars($row["image"]) ?>" alt="<?= htmlspecialchars($row["name"]) ?>"></td>
                                <td>$<?= number_format($row["unit_price"], 2) ?></td>
                                <td>
                                    <input type="number" 
                                           min="1" 
                                           value="<?= $row["quantity"] ?>"
                                           name="quantity[<?= $row["id"] ?>]"
                                           style="width: 60px"
                                           onchange="this.form.submit()">
                                <td class="total-price" id="total<?= $index ?>">
                                    <?= number_format($total_price, 2) ?>$
                                </td>
                                <td>
                                    <a href="delete_from_cart.php?id=<?= $row['id'] ?>" class="fas fa-trash" style="font-size:24px; color: #f44336;"
                                       onclick="return confirm('Are you sure you want to remove this item?')"></a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

                </form>
                <!-- Separate form for order submission -->
                <form method="POST" id="orderForm">
                <div class="order-info">
                    <h3>Order Information</h3>
                    <div class="form-group">
                        <label for="shipping_address">Shipping Address*</label>
                        <textarea name="shipping_address" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="billing_address">Billing Address*</label>
                        <textarea name="billing_address" class="form-control" required></textarea>
                    </div>
<!-- Payment Method Section -->
<div class="form-group">
    <label for="payment_method">Payment Method*</label>
    <select name="payment_method" class="form-control" required id="paymentMethod">
        <option value="">Select payment method</option>
        <option value="Cash on Delivery">Cash on Delivery</option>
        <option value="Credit Card">Credit Card</option>
    </select>
</div>

<!-- Credit Card Form (hidden by default) -->
<div id="creditCardForm" style="display:none; background:#f8f9fa; padding:15px; border-radius:5px; margin-top:10px;">
    <div class="form-group">
        <label for="cardholder">Cardholder Name*</label>
        <input type="text" name="cardholder" class="form-control" id="cardholder">
    </div>
    <div class="form-group">
        <label for="cardnumber">Card Number*</label>
        <input type="text" name="cardnumber" class="form-control" id="cardnumber" maxlength="19" placeholder="1234 5678 9012 3456">
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="expiry">Expiry Date*</label>
                <input type="text" name="expiry" class="form-control" id="expiry" placeholder="MM/YY" maxlength="5">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="cvv">CVV*</label>
                <input type="password" name="cvv" class="form-control" id="cvv" maxlength="4" placeholder="123">
            </div>
        </div>
    </div>
</div>
                    <div class="form-group">
                        <label for="contact_number">Contact Number*</label>
                        <input type="text" name="contact_number" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="special_notes">Special Notes</label>
                        <textarea name="special_notes" class="form-control"></textarea>
                    </div>
                </div>

                <div class="btn-group">
                    <a href="client.php" class="btn btn-back">Back to Shopping</a>
                    <input type="hidden" name="place_order" value="1">
                    <button type="submit" class="btn btn-checkout">Place Order</button>
                </div>
            </form>
        <?php else: ?>
            <div class="empty-cart">
                <p>Your cart is empty</p>
                 <br>
                <a href="client.php" class="btn btn-back">Continue Shopping</a>
            </div>
        <?php endif; ?>
    </div>

    <script>
        // Toggle credit card form visibility
        document.getElementById('paymentMethod').addEventListener('change', function() {
            const ccForm = document.getElementById('creditCardForm');
            ccForm.style.display = (this.value === 'Credit Card') ? 'block' : 'none';
            
            // Toggle required attribute for credit card inputs
            document.querySelectorAll('#creditCardForm input').forEach(input => {
                input.required = (this.value === 'Credit Card');
            });
        });

        // Validate and format credit card number
        document.getElementById('cardnumber').addEventListener('input', function(e) {
            // Remove any non-digits and spaces
            let value = this.value.replace(/\D/g, '');
            
            // Limit to 16 digits
            value = value.substr(0, 16);
            
            // Add spaces after every 4 digits
            value = value.replace(/(\d{4})/g, '$1 ').trim();
            
            this.value = value;
        });

        // Validate and format CVV
        document.getElementById('cvv').addEventListener('input', function(e) {
            // Remove any non-digits
            let value = this.value.replace(/\D/g, '');
            
            // Limit to 3 digits
            this.value = value.substr(0, 3);
        });

        // Format and validate expiry date (MM/YY)
        document.getElementById('expiry').addEventListener('input', function(e) {
            let value = this.value.replace(/\D/g, '');
            
            // Format MM/YY
            if (value.length >= 2) {
                // Ensure month is between 01 and 12
                let month = parseInt(value.substr(0, 2));
                if (month > 12) {
                    value = '12' + value.substr(2);
                } else if (month < 1) {
                    value = '01' + value.substr(2);
                }
                value = value.substr(0, 2) + '/' + value.substr(2, 2);
            }
            this.value = value.substr(0, 5);
        });

        // Form submission validation
        document.getElementById('orderForm').addEventListener('submit', function(e) {
            if (document.getElementById('paymentMethod').value === 'Credit Card') {
                const cardNumber = document.getElementById('cardnumber').value.replace(/\s/g, '');
                const cvv = document.getElementById('cvv').value;
                const expiry = document.getElementById('expiry').value;
                const cardholder = document.getElementById('cardholder').value;

                if (cardNumber.length !== 16) {
                    alert('Please enter a valid 16-digit card number');
                    e.preventDefault();
                    return false;
                }

                if (cvv.length !== 3) {
                    alert('Please enter a valid 3-digit CVV');
                    e.preventDefault();
                    return false;
                }

                if (!expiry.match(/^\d{2}\/\d{2}$/)) {
                    alert('Please enter a valid expiry date (MM/YY)');
                    e.preventDefault();
                    return false;
                }

                // Validate month and year
                const [month, year] = expiry.split('/').map(num => parseInt(num));
                
                if (month < 1 || month > 12) {
                    alert('Please enter a valid month (01-12)');
                    e.preventDefault();
                    return false;
                }

                if (year < 26) {
                    alert('Card expiry year must be 2026 or later');
                    e.preventDefault();
                    return false;
                }

                if (cardholder.trim() === '') {
                    alert('Please enter the cardholder name');
                    e.preventDefault();
                    return false;
                }
            }
        });
    </script>
</body>
</html>