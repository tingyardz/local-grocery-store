<?php
require_once("../connection.php");

$productId = $_POST['productId'];
$userCartTable = $_POST['userCartTable'];

//select the item from the specific product id
$sql = "SELECT * FROM `product_table` WHERE `Product Id` = '$productId'";
$query = $connect->query($sql) or die ($connect->error);
$row = $query->fetch_assoc();
$total_product = $query->num_rows;

if($total_product == 1){

//get the product information
$productName = $row['Product Name'];
$productPrice = $row['Product Price'];
$productImage = $row['Product Image'];
$productQuantity = 1;
$totalAmount = $productPrice * $productQuantity;

//recheck the item to determine if it is already exist in the users cart
$sql = "SELECT * FROM `$userCartTable` WHERE `Product Id` = '$productId'";
$query = $connect->query($sql) or die ($connect->error);
$row = $query->fetch_assoc();
$total_product = $query->num_rows;

if($total_product > 0){
    echo "The item is already in the cart";
}
elseif($total_product == 0){

    //add the item to the users cart table
    $sql = "INSERT INTO `$userCartTable`(`Product Id`, `Product Name`, `Product Quantity`, `Product Price`, `Product Image`, `Total`) 
            VALUES ('$productId','$productName','$productQuantity','$productPrice','$productImage','$totalAmount')";
    $query = $query = $connect->query($sql) or die ($connect->error);

    //count the items in the cart
    $sql = "SELECT * FROM `$userCartTable`";
    $query = $connect->query($sql) or die ($connect->error);
    $row = $query->fetch_assoc();
    $total_product = $query->num_rows;

    echo $total_product;
}

}
