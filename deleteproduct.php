<?php
require_once 'connection.php';
 
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    $query = "DELETE FROM product WHERE id = $id";
    $conn->query($query);

    header("Location:admin.php");
}