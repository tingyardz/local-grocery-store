<?php
require_once("../connection.php");
require_once("admin_functions.php");
session_start();

if(!isset($_SESSION['admin-login'])){
    header("Location:login.php");
    exit();
}

if(isset($_GET['update'])){
    $query = $method->selectedProduct();
    $row = $query->fetch_assoc();
}

if(isset($_GET['update-product'])){
    $method->updateProduct();
}

if(isset($_POST['update-product-image'])){

    $method->updateProductImage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Grocery Store</title>
    <link rel="stylesheet" href="css/updateproduct.style.css">
    <link rel="shortcut icon" href="../icon/logo.ico" type="image/x-icon">
</head>
<body>

    <div class="container">
        <section class="wrapper-1">
            <div class="subwrapper-1"><h6>ADMIN</h6></div>
            <nav>
                <ul>
                    <li><a class="home" href="index.php">Home</a></li>
                    <li><a class="update-product" href="">Update Product</a></li>
                    <li><a class="customers-orders" href="customers_orders.php">Customers Orders</a></li>
                    <li><a href="logout.php">Logout</a></li>
                    
                </ul>
            </nav>

        </section>

        <section class="wrapper-2">

        <h1>Update Product:</h1>

        <div class="subwrapper-1">
            <form action="updateproduct.php" method="GET">
                <input style="display:none" type="number" name="product-id" id="product-id" value="<?php if(isset($_GET['update'])){echo $row['Product Id'];} ?>" required>
                <label for="">Product Name</label>
                <input type="text" name="product-name" id="product-name" value="<?php if(isset($_GET['update'])){echo $row['Product Name'];} ?>" required>

                <label for="">Product Price</label>
                <input type="number" step="0.01" name="product-price" id="product-price" value="<?php if(isset($_GET['update'])){echo $row['Product Price'];} ?>" required>

                <label for="">Product Stocks</label>
                <input type="number" name="product-stocks" id="product-stocks" value="<?php if(isset($_GET['update'])){echo $row['Product Stocks'];} ?>" required>

                <button type="submit" name="update-product">Update Product</button>
            </form>
        </div>

        <div class="subwrapper-2">
            <h3>Do you want to update the image of the product?</h3>
            <form action="updateproduct.php" method="POST" enctype="multipart/form-data">
                <input style="display:none" type="number" name="product-id" id="product-id" value="<?php if(isset($_GET['update'])){echo $row['Product Id'];} ?>" required>
                <label for="">Product Image</label>
                <input type="file" name="product-image" id="product-image" required>
                <button type="submit" name="update-product-image">Update Product Image</button>
            </form>
        </div>
            
        </section>
    </div>
    
</body>
</html>