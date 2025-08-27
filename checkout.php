<?php
require_once 'connection.php';
session_start();

if (!isset($_SESSION['user-id'])) {
    header("location:login.php");
    exit;
}

$user_id = $_SESSION['user-id'];
$errors = [];

if (isset($_POST['card_id']) && isset($_POST['shipping_address']) && isset($_POST['billing_address']) 
    && isset($_POST['payment_method']) && isset($_POST['contact_number'])) {
    
    $card_id = (int)$_POST['card_id'];
    $shipping_address = $conn->real_escape_string($_POST['shipping_address']);
    $billing_address = $conn->real_escape_string($_POST['billing_address']);
    $payment_method = $conn->real_escape_string($_POST['payment_method']);
    $contact_number = $conn->real_escape_string($_POST['contact_number']);
    $special_notes = isset($_POST['special_notes']) ? $conn->real_escape_string($_POST['special_notes']) : '';

    try {
        $conn->autocommit(FALSE);
        
        for ($i = 1; $i <= $index; $i++) {
            if (!isset($_POST['Qt'.$i], $_POST['checked'.$i], $_POST['idProduct'.$i], $_POST['UNP'.$i])) {
                continue;
            }

            $quantity = (int)$_POST['Qt'.$i];
            $checked = $_POST['checked'.$i] === 'true' || $_POST['checked'.$i] === 'on' || $_POST['checked'.$i] == 1;
            $product_id = (int)$_POST['idProduct'.$i];
            $unit_price = (float)$_POST['UNP'.$i];
            
            // First verify if the order exists
            $checkOrder = $conn->prepare("SELECT id FROM order1 WHERE id = ? AND user_id = ?");
            if (!$checkOrder) {
                $errors[] = "Error preparing order check: " . htmlspecialchars($conn->error);
                $hasError = true;
                continue;
            }
            $checkOrder->bind_param("ii", $product_id, $user_id);
            $checkOrder->execute();
            $checkOrder->store_result();
            
            if ($checkOrder->num_rows === 0) {
                $errors[] = "Order #$product_id not found";
                $hasError = true;
                continue;
            }
            $checkOrder->close();

            // Update quantity in order1
            $stmt = $conn->prepare("UPDATE order1 SET quantity = ?, status = ? WHERE id = ? AND user_id = ?");
            if (!$stmt) {
                $errors[] = "Error preparing order update: " . htmlspecialchars($conn->error);
                $hasError = true;
                continue;
            }
            $status = $checked ? 'processing' : 'pending';
            $stmt->bind_param("isii", $quantity, $status, $product_id, $user_id);
            if (!$stmt->execute()) {
                $errors[] = "Order update error: " . htmlspecialchars($stmt->error);
                $hasError = true;
            }
            $stmt->close();

            $itemTotal = $unit_price * $quantity;
            $totalPrice += $itemTotal;

            if ($checked) {
                // Add to checkout table
                $checkoutStmt = $conn->prepare("INSERT INTO checkout (total_price, user_id, id_order, created_at) VALUES (?, ?, ?, NOW())");
                if (!$checkoutStmt) {
                    $errors[] = "Error preparing checkout: " . htmlspecialchars($conn->error);
                    $hasError = true;
                    continue;
                }
                $checkoutStmt->bind_param("dii", $itemTotal, $user_id, $product_id);
                if (!$checkoutStmt->execute()) {
                    $errors[] = "Checkout error: " . htmlspecialchars($checkoutStmt->error);
                    $hasError = true;
                }
                $checkoutStmt->close();

                // Save order information
                $infoStmt = $conn->prepare("
                    INSERT INTO order_information 
                    (order_id, shipping_address, billing_address, payment_method, contact_number, special_notes, created_at)
                    VALUES (?, ?, ?, ?, ?, ?, NOW())
                ");
                if (!$infoStmt) {
                    $errors[] = "Error preparing order info: " . htmlspecialchars($conn->error);
                    $hasError = true;
                    continue;
                }
                
                $billing_address = $_POST['billing_address'] ?? $_POST['shipping_address'];
                $contact_number = $_POST['contact_number'] ?? '';
                $special_notes = $_POST['special_notes'] ?? '';
                
                $infoStmt->bind_param(
                    "isssss",
                    $product_id,
                    $_POST['shipping_address'],
                    $billing_address,
                    $_POST['payment_method'],
                    $contact_number,
                    $special_notes
                );
                
                if (!$infoStmt->execute()) {
                    $errors[] = "Order information error: " . htmlspecialchars($infoStmt->error);
                    $hasError = true;
                }
                $infoStmt->close();
            }
        }

        if ($hasError) {
            $conn->rollback();
            echo "<div style='color:red'><strong>Errors occurred:</strong><br>";
            foreach ($errors as $error) {
                echo htmlspecialchars($error) . "<br>";
            }
            echo "</div>";
            echo "<p><a href='shopping2.php'>Return to Cart</a></p>";
        } else {
            if ($conn->commit()) {
                header("location:order_confirmation.php?total=" . urlencode($totalPrice));
                exit;
            } else {
                $errors[] = "Failed to commit transaction: " . htmlspecialchars($conn->error);
                $conn->rollback();
                echo "<div style='color:red'>Checkout failed: " . htmlspecialchars($conn->error) . "</div>";
                echo "<p><a href='shopping2.php'>Return to Cart</a></p>";
            }
        }
    } catch (Exception $e) {
        $conn->rollback();
        echo "<div style='color:red'>System error: " . htmlspecialchars($e->getMessage()) . "</div>";
        echo "<p><a href='shopping2.php'>Return to Cart</a></p>";
    }
} else {
    header("location:shopping2.php?error=" . urlencode("Please fill all required fields"));
    exit;
}
?>
