oo<?php
require_once 'connection.php';

if (
    isset($_POST['name']) && !empty($_POST['name'])
    && isset($_POST['price']) && !empty($_POST['price'])


) {
    if (!empty($_FILES['productpic']['name'])) {
        if ($_FILES['productpic']['size'] > 5 * 1024 * 1024) {//5 MB
            die('profile picture should not exceed 5 MB');
        }
        $productpic = $_FILES['productpic']['name'];
        $extension = pathinfo($productpic, PATHINFO_EXTENSION);
        if ($extension != 'png' && $extension != 'jpg' && $extension != 'jpeg' && $extension != 'webp') {
            die("profile picture should be an image ");
        }
        move_uploaded_file($_FILES['productpic']['tmp_name'], "images/$productpic");
        $name = $_POST['name'];
        $price = $_POST['price'];



        $query = "SELECT * FROM product WHERE name='$name' ";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            die('product already exists !');
        }
        $query2 = "INSERT INTO product VALUES(NULL ,'$productpic' ,'$name' , '$price')";
        $result2 = $conn->query($query2);
        echo "New Product has been added successfully";
        header("location:admin.php");
    }
}

?>