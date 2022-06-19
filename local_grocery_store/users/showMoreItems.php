<?php
require_once("../connection.php");

if(isset($_POST['productName'])){
    $product = $_POST['productName'];
    $newItemCounts = $_POST['newItemCounts'];
    $sql = "SELECT * FROM `product_table` WHERE `Product Name` LIKE '%$product%' LIMIT $newItemCounts";
    $query = $connect->query($sql) or die ($connect->error);
    $row = $query->fetch_assoc();
    $total_product = $query->num_rows;

    if($total_product > 0){
        
        do{

            $productId = $row['Product Id'];
            $productImage = $row['Product Image'];
            $productName = $row['Product Name'];
            $productPrice = $row['Product Price'];
            $productStocks = $row['Product Stocks'];
    
            $product = "
                <div class='sub-wrapper'>
                <div class='mini-wrapper-1'><img src='../product_images/$productImage'></div>
                <div class='mini-wrapper-2'><h3>$productName</h3></div>
                <div class='mini-wrapper-3'><h4>&#8369;$productPrice</h4></div>
                <div class='mini-wrapper-4'><h5>Stocks: $productStocks</h5></div>
                <div class='mini-wrapper-5'><button class='add-to-cart 'onclick='addToCart($productId)'><i class='fa-solid fa-cart-shopping'></i> Add to Cart</button></div>
                </div>
                ";

    
            echo $product;
        
        }while($row = $query->fetch_assoc());
    }
}
else{
    $newItemCounts = $_POST['newItemCounts'];
    $sql = "SELECT * FROM `product_table` LIMIT $newItemCounts";
    $query = $connect->query($sql) or die ($connect->error);
    $row = $query->fetch_assoc();
    $total_product = $query->num_rows;

    if($total_product > 0){

        do{

            $productId = $row['Product Id'];
            $productImage = $row['Product Image'];
            $productName = $row['Product Name'];
            $productPrice = $row['Product Price'];
            $productStocks = $row['Product Stocks'];
    
            $product = "
                <div class='sub-wrapper'>
                <div class='mini-wrapper-1'><img src='../product_images/$productImage'></div>
                <div class='mini-wrapper-2'><h3>$productName</h3></div>
                <div class='mini-wrapper-3'><h4>&#8369;$productPrice</h4></div>
                <div class='mini-wrapper-4'><h5>Stocks: $productStocks</h5></div>
                <div class='mini-wrapper-5'><button class='add-to-cart 'onclick='addToCart($productId)'><i class='fa-solid fa-cart-shopping'></i> Add to Cart</button></div>
                </div>
                ";

    
            echo $product;
        
        }while($row = $query->fetch_assoc());
    }
}


?>

