<?php 
require_once 'connection.php';
$sql = "SELECT * FROM product";
    $result = $conn->query($sql);
    if ($result->num_rows == 0) {
       $result=[];
    } else {
        $data = [];
        $index = 0;
         while($row=$result->fetch_assoc()){
            $data[$index]=$row;
            $index ++;
         }
        $result = $data;
    
        }
?>