<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

// Database connection
$host = 'localhost';
$dbname = 'kycell';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $e->getMessage()]);
    exit;
}

// Handle different actions
$action = $_GET['action'] ?? ($_POST['action'] ?? '');

switch ($action) {
    case 'dashboard_stats':
        getDashboardStats($pdo);
        break;
    case 'get_orders':
        getOrders($pdo);
        break;
    case 'get_cards':
        getRechargeCards($pdo);
        break;
    case 'get_bundles':
        getDataBundles($pdo);
        break;
    case 'get_gift_cards':
        getGiftCards($pdo);
        break;
    case 'add_card':
        addRechargeCard($pdo);
        break;
    case 'add_bundle':
        addDataBundle($pdo);
        break;
    case 'add_gift_card':
        addGiftCard($pdo);
        break;
    case 'delete_order':
        deleteOrder($pdo);
        break;
    case 'delete_card':
        deleteCard($pdo);
        break;
    case 'delete_bundle':
        deleteBundle($pdo);
        break;
    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
        break;
}

function getDashboardStats($pdo) {
    try {
        // Get total orders
        $stmt = $pdo->query("SELECT COUNT(*) as total_orders FROM orders");
        $total_orders = $stmt->fetchColumn();
        
        // Get completed orders
        $stmt = $pdo->query("SELECT COUNT(*) as completed_orders FROM orders WHERE payment_status = 'paid'");
        $completed_orders = $stmt->fetchColumn();
        
        // Get pending orders
        $stmt = $pdo->query("SELECT COUNT(*) as pending_orders FROM orders WHERE payment_status = 'pending'");
        $pending_orders = $stmt->fetchColumn();
        
        // Get failed orders
        $stmt = $pdo->query("SELECT COUNT(*) as failed_orders FROM orders WHERE payment_status = 'failed'");
        $failed_orders = $stmt->fetchColumn();
        
        // Get recent orders
        $stmt = $pdo->query("SELECT * FROM orders ORDER BY created_at DESC LIMIT 5");
        $recent_orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode([
            'success' => true,
            'total_orders' => $total_orders,
            'completed_orders' => $completed_orders,
            'pending_orders' => $pending_orders,
            'failed_orders' => $failed_orders,
            'recent_orders' => $recent_orders
        ]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error fetching dashboard stats: ' . $e->getMessage()]);
    }
}

function getOrders($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM orders ORDER BY created_at DESC");
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode(['success' => true, 'orders' => $orders]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error fetching orders: ' . $e->getMessage()]);
    }
}

function getRechargeCards($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM recharge_cards ORDER BY created_at DESC");
        $cards = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode(['success' => true, 'cards' => $cards]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error fetching recharge cards: ' . $e->getMessage()]);
    }
}

function getDataBundles($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM data_bundles ORDER BY created_at DESC");
        $bundles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode(['success' => true, 'bundles' => $bundles]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error fetching data bundles: ' . $e->getMessage()]);
    }
}

function getGiftCards($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM gift_cards ORDER BY created_at DESC");
        $gift_cards = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode(['success' => true, 'gift_cards' => $gift_cards]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error fetching gift cards: ' . $e->getMessage()]);
    }
}

function addRechargeCard($pdo) {
    try {
        $operator = $_POST['operator'];
        $amount = $_POST['amount'];
        $price = $_POST['price'];
        $code = $_POST['code'];
        
        // Handle image upload
        $imagePath = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/recharge_cards/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            $fileName = time() . '_' . basename($_FILES['image']['name']);
            $targetPath = $uploadDir . $fileName;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                $imagePath = $targetPath;
            }
        }
        
        $stmt = $pdo->prepare("INSERT INTO recharge_cards (operator, amount, price, code, image, status) VALUES (?, ?, ?, ?, ?, 'available')");
        $stmt->execute([$operator, $amount, $price, $code, $imagePath]);
        
        echo json_encode(['success' => true, 'message' => 'Recharge card added successfully']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error adding recharge card: ' . $e->getMessage()]);
    }
}

function addDataBundle($pdo) {
    try {
        $operator = $_POST['operator'];
        $bundle_name = $_POST['bundle_name'];
        $price = $_POST['price'];
        $validity = $_POST['validity'];
        
        // Handle image upload
        $imagePath = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/data_bundles/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            $fileName = time() . '_' . basename($_FILES['image']['name']);
            $targetPath = $uploadDir . $fileName;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                $imagePath = $targetPath;
            }
        }
        
        $stmt = $pdo->prepare("INSERT INTO data_bundles (operator, bundle_name, price, validity, image) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$operator, $bundle_name, $price, $validity, $imagePath]);
        
        echo json_encode(['success' => true, 'message' => 'Data bundle added successfully']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error adding data bundle: ' . $e->getMessage()]);
    }
}

function addGiftCard($pdo) {
    try {
        $operator = $_POST['operator'];
        $amount = $_POST['amount'];
        $price = $_POST['price'];
        $code = $_POST['code'];
        
        // Handle image upload
        $imagePath = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/gift_cards/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            $fileName = time() . '_' . basename($_FILES['image']['name']);
            $targetPath = $uploadDir . $fileName;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                $imagePath = $targetPath;
            }
        }
        
        $stmt = $pdo->prepare("INSERT INTO gift_cards (operator, amount, price, code, image, status) VALUES (?, ?, ?, ?, ?, 'available')");
        $stmt->execute([$operator, $amount, $price, $code, $imagePath]);
        
        echo json_encode(['success' => true, 'message' => 'Gift card added successfully']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error adding gift card: ' . $e->getMessage()]);
    }
}

function deleteOrder($pdo) {
    try {
        $id = $_GET['id'];
        
        $stmt = $pdo->prepare("DELETE FROM orders WHERE id = ?");
        $stmt->execute([$id]);
        
        echo json_encode(['success' => true, 'message' => 'Order deleted successfully']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error deleting order: ' . $e->getMessage()]);
    }
}

function deleteCard($pdo) {
    try {
        $id = $_GET['id'];
        $type = $_GET['type'];
        
        if ($type === 'recharge') {
            $table = 'recharge_cards';
        } else {
            $table = 'gift_cards';
        }
        
        $stmt = $pdo->prepare("DELETE FROM $table WHERE id = ?");
        $stmt->execute([$id]);
        
        echo json_encode(['success' => true, 'message' => 'Card deleted successfully']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error deleting card: ' . $e->getMessage()]);
    }
}

function deleteBundle($pdo) {
    try {
        $id = $_GET['id'];
        
        $stmt = $pdo->prepare("DELETE FROM data_bundles WHERE id = ?");
        $stmt->execute([$id]);
        
        echo json_encode(['success' => true, 'message' => 'Data bundle deleted successfully']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error deleting data bundle: ' . $e->getMessage()]);
    }
}
?>