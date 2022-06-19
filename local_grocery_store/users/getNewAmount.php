<?php
require_once("../connection.php");

if(isset($_GET['getNewAmount'])){

    $productId = $_GET['productId'];
    $cartTable = $_GET['cartTable'];

    $sql = "SELECT * FROM `$cartTable` WHERE `Product Id` = '$productId'";
    $query = $connect->query($sql) or die ($connect->error);
    $row = $query->fetch_assoc();
    $total = $query->num_rows;

    $newAmount = $row['Product Quantity'] * $row['Product Price'];

    echo $newAmount;
}