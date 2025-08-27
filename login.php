<?php
//$_post this is assoc array 
require_once 'connection.php';
if (
    isset($_POST['username']) && !empty($_POST['username'])
    && isset($_POST['password']) && !empty($_POST['password'])
) {
    extract($_POST);
    $sql = "SELECT * FROM user WHERE username='$username'";
    $result = $conn->query($sql);
    if ($result->num_rows == 0) {
        header("Location:index.php");
    } else {
        $row = $result->fetch_assoc();
        if (!password_verify($password, $row['password'])) {
    // Password is incorrect
    header("Location: index.php?error=wrongpass");
    exit();
}
 
        session_start();
        $_SESSION['isloggedin'] = 1;
        $_SESSION['user'] = $row['username'];
        $_SESSION['user-id'] = $row['id'];
        $_SESSION['role-id'] = $row['role_id'];
        if ($_SESSION['isloggedin'] != 1) {
            header("location:index.php");
        } elseif ($_SESSION['role-id'] == 2) {
        $_SESSION['isloggedin'] = 2;

            header("location:client.php");

        } elseif ($_SESSION['role-id'] == 1) {
            header("location:admin.php");
        }

    }

}
?>