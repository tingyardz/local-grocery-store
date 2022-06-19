<?php
require_once("../connection.php");

if(isset($_POST['minusQuantity'])){

    $productId = $_POST['productId'];
    $cartTable = $_POST['cartTable'];

    $sql = "SELECT * FROM `$cartTable` WHERE `Product Id` = '$productId'";
    $query = $connect->query($sql) or die ($connect->error);
    $row = $query->fetch_assoc();
    $total = $query->num_rows;

    if($total == 1){
        $currentQuantity = $row['Product Quantity'];
        if($currentQuantity > 0){
            $newQuantity = $currentQuantity - 1;
            $sql = "UPDATE `$cartTable` 
                    SET `Product Quantity`='$newQuantity'
                    WHERE `Product Id` = '$productId'";
            $query = $connect->query($sql) or die ($connect->error);

            echo $newQuantity;
        }else{
            echo "0";
        }
    }
}elseif(isset($_POST['plusQuantity'])){

    $productId = $_POST['productId'];
    $cartTable = $_POST['cartTable'];

    $sql = "SELECT * FROM `$cartTable` WHERE `Product Id` = '$productId'";
    $query = $connect->query($sql) or die ($connect->error);
    $row = $query->fetch_assoc();
    $total = $query->num_rows;

    if($total == 1){
        $currentQuantity = $row['Product Quantity'];
            $newQuantity = $currentQuantity + 1;
            $sql = "UPDATE `$cartTable` 
                    SET `Product Quantity`='$newQuantity'
                    WHERE `Product Id` = '$productId'";
            $query = $connect->query($sql) or die ($connect->error);

            echo $newQuantity;
    }
}elseif(isset($_POST['alterQuantity'])){

    $productId = $_POST['productId'];
    $cartTable = $_POST['cartTable'];
    $newQuantity = $_POST['newQuantity'];

    if(!empty($newQuantity)){

        $sql = "SELECT * FROM `$cartTable` WHERE `Product Id` = '$productId'";
        $query = $connect->query($sql) or die ($connect->error);
        $row = $query->fetch_assoc();
        $total = $query->num_rows;

        if($total == 1){
            $sql = "UPDATE `$cartTable` 
                    SET `Product Quantity`='$newQuantity'
                    WHERE `Product Id` = '$productId'";
            $query = $connect->query($sql) or die ($connect->error);
        }
    }

    
}elseif(isset($_GET['getNewAmount'])){

    $productId = $_GET['productId'];
    $cartTable = $_GET['cartTable'];

    $sql = "SELECT * FROM `$cartTable` WHERE `Product Id` = '$productId'";
    $query = $connect->query($sql) or die ($connect->error);
    $row = $query->fetch_assoc();
    $total = $query->num_rows;

    $newAmount = $row['Product Quantity'] * $row['Product Price'];

    echo $newAmount;
}
