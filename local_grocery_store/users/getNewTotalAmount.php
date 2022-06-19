<?php
require_once("../connection.php");

if(isset($_GET['getNewTotalAmount'])){

    $cartTable = $_GET['cartTable'];

    $sql = "SELECT * FROM `$cartTable`";
    $query = $connect->query($sql) or die ($connect->error);
    $row = $query->fetch_assoc();
    $total = $query->num_rows;

    $newTotalAmount = 0;

    do{
        $newTotalAmount = $newTotalAmount + ($row['Product Quantity'] * $row['Product Price']);
    }while($row = $query->fetch_assoc());

    echo $newTotalAmount;
}