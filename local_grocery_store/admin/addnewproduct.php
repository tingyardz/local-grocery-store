<?php
require_once("../connection.php");
require_once("admin_functions.php");
session_start();

if(!isset($_SESSION['admin-login'])){
    header("Location:login.php");
    exit();
}

if(isset($_POST['submit-product'])){
    $method->addNewProduct();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Grocery Store</title>
    <link rel="stylesheet" href="css/addnewproduct.style.css">
    <link rel="shortcut icon" href="../icon/logo.ico" type="image/x-icon">
</head>
<body>

    <div class="container">
        <section class="wrapper-1">
            <div class="subwrapper-1"><h6>ADMIN</h6></div>
            <nav>
                <ul>
                    <li><a class="home" href="index.php">Home</a></li>
                    <li><a class="add-new-product" href="addnewproduct.php">Add New Product</a></li>
                    <li><a class="customers-orders" href="customers_orders.php">Customers Orders</a></li>
                    <li><a href="logout.php">Logout</a></li>
                    
                </ul>
            </nav>

        </section>

        <section class="wrapper-2">

        <h1>Add New Product:</h1>

        <div class="subwrapper-1">
            <form action="addnewproduct.php" method="POST" enctype="multipart/form-data">
                <label for="">Product Name</label>
                <input type="text" name="product-name" id="product-name" required>

                <label for="">Product Price</label>
                <input type="number" step="0.01" name="product-price" id="product-price" required>

                <label for="">Product Stocks</label>
                <input type="number" name="product-stocks" id="product-stocks" required>

                <label for="">Product Details</label>
                <textarea name="product-details" ></textarea>
                
                <label for="">Product Image</label>
                <input type="file" name="product-image" id="product-image" required>

                <button type="submit" name="submit-product">Submit Product</button>
            </form>
        </div>
            
        </section>
    </div>
    
</body>
</html>