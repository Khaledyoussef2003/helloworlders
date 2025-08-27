<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "oneshoot";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $twelveDigitCode = $_POST['twelve_digit_code'];

    // Validate email and 12-digit input
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address.";
        exit;
    }

    if (!preg_match('/^\d{12}$/', $twelveDigitCode)) {
        echo "Invalid input. Please enter a 12-digit numeric code.";
        exit;
    }

    // Check if email exists
    $stmt = $conn->prepare("SELECT subscription_end_date FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $currentEndDate = $row['subscription_end_date'];

        // Extend or set subscription
        $newEndDate = $currentEndDate && strtotime($currentEndDate) > time()
            ? date('Y-m-d', strtotime($currentEndDate . ' +1 month'))
            : date('Y-m-d', strtotime('+1 month'));

        $updateStmt = $conn->prepare("UPDATE users SET subscription_end_date = ?, subscription_status = 'active' WHERE email = ?");
        $updateStmt->bind_param("ss", $newEndDate, $email);

        if ($updateStmt->execute()) {
            echo "Subscription successful! Your new subscription will end on $newEndDate.";
        } else {
            echo "Failed to update subscription. Please try again.";
        }
        $updateStmt->close();
    } else {
        echo "No account found with this email.";
    }

    $stmt->close();
}

$conn->close();
?>
