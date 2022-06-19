<?php
require_once("../connection.php");
require_once("admin_functions.php");
session_start();

if(!isset($_SESSION['admin-login'])){
    header("Location:login.php");
    exit();
}

if(isset($_GET['received'])){
    $method->receivedOrder();
}
else if(isset($_GET['remove'])){
    $method->remove();
}
else if(isset($_GET['deleteAll'])){
    $method->deleteAll();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Grocery Store</title>
    <link rel="stylesheet" href="css/customers_orders.style.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="shortcut icon" href="../icon/logo.ico" type="image/x-icon">
    <script src="js/jquery.min.js"></script>
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

        <h1>All Orders:</h1>
        
        <div class="subwrapper-1">

            <div class="mini-wrapper-1" id="order-list">
            
            </div>
        </div>

        <div style="width: 100%; margin-top: 10px"><a id="delete-all" onclick="deleteAllOrders()" href=""><button style="border: none; padding: 10px 20px; background-color: rgb(255, 50, 50); color: white; cursor: pointer"><i class='fa-solid fa-trash-can'></i> Delete All Orders</button></a></div>
            
        </section>
    </div>


    <!-- Javascript -->
    <script>
        $(document).ready(function(){
            reload();

            function reload(){
            
                $.post(
                    "reload_order_table.php",
                    function(data){
                        $('#order-list').html(data);
                    }
                ); 

                setTimeout(() => {

                    reload();
                
                }, 10000);
            
            }
        });

        function remove(id){
            var permission = confirm("Are you sure to remove this order?");
            if(permission){
                document.getElementById('remove'+id).href="customers_orders.php?remove="+id;
            }
        }

        function deleteAllOrders(){
            var permission = confirm("Are you sure to remove all orders in the list?");
            if(permission){
                document.getElementById('delete-all').href="customers_orders.php?deleteAll=";
            }
        }
        
    </script>
    
</body>
</html>