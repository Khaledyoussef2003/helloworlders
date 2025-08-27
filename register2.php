<?php
require_once 'connection.php';

if (
    isset($_POST["name"]) && !empty($_POST["name"]) &&
    isset($_POST["username"]) && !empty($_POST["username"]) &&
    isset($_POST["password"]) && !empty($_POST["password"]) &&
    isset($_POST["phone"]) && !empty($_POST["phone"]) &&
    isset($_POST["address"]) && !empty($_POST["address"])
) {
    // Sanitize and assign values
    $name = $conn->real_escape_string(trim($_POST['name']));
    $username = $conn->real_escape_string(trim($_POST['username']));
    $password = trim($_POST['password']);
    $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/';

if (!preg_match($pattern, $password)) {
    header("Location: register.php?error=weak_password");
    exit();
}

// Hash the password before storing it
$password = password_hash($password, PASSWORD_DEFAULT);

    $phone = $conn->real_escape_string(trim($_POST['phone']));
    $address = $conn->real_escape_string(trim($_POST['address']));
    $role_id = 2; // assuming role_id = 2 is for normal users

    // Check for existing username
    $query = "SELECT * FROM user WHERE username = '$username'";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        // Username already exists
        header("Location: register.php?error=username_taken");
        exit();
    } else {
        // Insert new user
        $query2 = "INSERT INTO user (name, username, password, phone, address, role_id)
                   VALUES ('$name', '$username', '$password', '$phone', '$address', $role_id)";
        if ($conn->query($query2)) {
            header("Location: index.php?success=1");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>
