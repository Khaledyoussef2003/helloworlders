<?php
require_once 'connection.php';
$idproduct = 0;
$status = '';
if (isset($_GET["id"]) && !empty($_GET["id"])) {
    $id = $_GET["id"];
    $idproduct = $id;
    $sql = "SELECT * FROM product WHERE id = $id";
    $result = $conn->query($sql);

    if (!$result)
        die("No result found...");
    $row = $result->fetch_assoc();
    $image = $row['image'];
    $name = $row['name'];
    $price = $row['unit_price'];


    
 

    // $query = "UPDATE `product` SET  `name` = '$namee' `unit_price` = '$pricee' WHERE `product`.`id` = $id";
    // $result1 = $conn->query($query1);
    // header("location:admin.php");
    // UPDATE `product` SET `unit_price` = '19.00$' WHERE `product`.`id` = 5;
    // header("location:admin.php");
}

if(isset($_POST['nname']) && isset($_POST['pprice'])){
  //  $id = $_GET["id"];

   $namee = $_POST['nname'];
   $id = $_POST['nid'];

    $pricee = $_POST['pprice'];
    $query1 = "UPDATE `product` SET  `name` = '$namee' , `unit_price` = '$pricee' WHERE `product`.`id` = $id";
   if($conn->query($query1)){
        $status = 'succesfully updated ';
   }
   else{
    $status = 'Failed updated ';
   }
header("location:admin.php");
}
?>