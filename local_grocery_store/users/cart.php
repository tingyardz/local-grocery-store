<?php
require_once("../connection.php");
require_once("../functionality.php");

//Determining if the user has logging in
session_start();
if(!isset($_SESSION['OGS-User-login'])){
    header("Location:../index.php");
    exit();
}

//Getting the full name and cart-table-name of the user
$userId = $_SESSION['User Id'];
$sql = "SELECT * FROM `users_table` WHERE `User Id` = '$userId'";
$query = $connect->query($sql) or die ($connect->error);
$row = $query->fetch_assoc();
$name = $row['First Name']." ".$row['Last Name'];
$userCartTable = $row['Username'].$row['User Id']."_table";
$purchaseUserTable = "purchase_".$row['Username'].$row['User Id']."_table";
$username = $row['Username'];

//for logging out the system
if(isset($_GET['logout'])){
    $method->logout();
}

//count the number and select the items in the cart
$sql0 = "SELECT * FROM `$userCartTable`";
$query0 = $connect->query($sql0) or die ($connect->error);
$row0 = $query0->fetch_assoc();
$total0 = $query0->num_rows;

//select the items in the orderList Table
$sql1 = "SELECT * FROM `$purchaseUserTable`";
$query1 = $connect->query($sql1) or die ($connect->error);
$row1 = $query1->fetch_assoc();
$total1 = $query1->num_rows;
$prepareAmount = 0;

//remove item from cart
if(isset($_GET['remove'])){
    $productId = $_GET['remove'];
    $method->removeProductFromCart($productId,$userCartTable);
}

//submit Order
if(isset($_POST['place-order'])){
    $method->submitOrder();
}

//declaring variables
$totalAmount = 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Grocery Store</title>
    <link rel="stylesheet" href="css/cart.style.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="shortcut icon" href="../icon/logo.ico" type="image/x-icon">
    <script src="js/jquery.min.js"></script>
</head>
<body>

    <!-- for computer screens -->
    <nav class="for-computer-screens"> 
        <ul>
            <li class="searching">
                <div class="wrapper">
                    <form id="search-form" action="" method="GET">
                        <input id="product-name" type="text" name="product-name" placeholder="Product Name">
                        <button type="submit" id="search-query" name="search-query"><i class="fa-solid fa-magnifying-glass"></i> Search</button>
                    </form>
                </div>
            </li>
            <li><a href="index.php"><i class="fa-solid fa-user-large"></i><?php echo " ".$name; ?></a></li>
                <li><a class="cart-counter" href=""><i class="fa-solid fa-cart-shopping"></i> Cart <p id="cart"><?php if($total0 > 0){echo $total0;}else{echo "0";}?></p></a></li>
                <li><a id="logout" onclick="logout()" href=""><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>          
        </ul>
    </nav>

    <!-- for mobile screens -->
    <nav class="for-mobile-screens" id="for-mobile-screens">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a class="cart-counter" href="cart.php"><i class="fa-solid fa-cart-shopping"></i> Cart <p id="mobile-cart"><?php if($total0 > 0){echo $total0;}else{echo "0";}?></p></a></li>
            <li><a id="mobile-logout" onclick="logout()" href=""><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
        </ul>
    </nav>

    <div class="container" id="container">
        <h6>My Cart</h6>
        <section>
            <table class="table0">
                <tr>
                    <th>Product Image</th>
                    <th>Product Description</th>
                    <th>Quantity</th>
                    <th>Amount</th>
                    <th>Action</th>
                </tr>
        <?php
            if($total0 > 0){
                do{
                    $productAmount = $row0['Product Quantity'] * $row0['Product Price'];
                    $totalAmount = $totalAmount + $productAmount;
        ?>
                <tr>
                    <td class="product-image"><img src="../product_images/<?php echo $row0['Product Image']; ?>" alt=""></td>
                    <td><?php echo $row0['Product Name']; ?><h3 style="color:red">&#8369;<?php echo $row0['Product Price']; ?></h3></td>
                    <td><button id="minus-quantity" onclick="minusQuantity(<?php echo $row0['Product Id']; ?>)"><i class="fa-solid fa-minus"></i></button><input type="text" onkeyup="alterQuantity(<?php echo $row0['Product Id']; ?>)" value="<?php echo $row0['Product Quantity']; ?>" id="quantity<?php echo $row0['Product Id']; ?>"><button id="plus-quantity" onclick="plusQuantity(<?php echo $row0['Product Id']; ?>)"><i class="fa-solid fa-plus"></i></button></td>
                    <td id="product-amount<?php echo $row0['Product Id'] ?>">&#8369;<?php echo $productAmount ?></td>
                    <td><a class="remove" href="cart.php?remove=<?php echo $row0['Product Id']; ?>"><i class="fa-solid fa-trash-can"></i></a></td>
                </tr>
            <?php
                }while($row0 = $query0->fetch_assoc());
            }else{
            ?>
            <div class="empty-cart-alert">
                <h3>The Cart Is Empty!</h3>
            </div>
            <script>
            $(document).ready(function(){
                $('.table0').css("display","none");
                $('.checkout').css("display","none");
            });
            </script>
            <?php
                }
            ?>
        </table>
        </section>
        <div class="checkout">
            <h4>Total Amount: <p style="margin-bottom: 10px;display:inline-block;color:red" id="total-amount">&#8369;<?php echo $totalAmount; ?></p></h4>
            <button id="checkOut" onclick="placeOrder()">Check Out (<?php echo $total0; ?>)</button>
        </div>
    </div>

    <div class="container1" id="container1">
        <h6>Purchased Order</h6>
        <section>
            <table class="table1">
                <tr>
                    <th>Product Image</th>
                    <th>Product Description</th>
                    <th>Quantity</th>
                    <th>Amount</th>
                </tr>
        <?php
            if($total1 > 0){
                do{
                    $productAmount = $row1['Product Quantity'] * $row1['Product Price'];
        ?>
                <tr>
                    <td class="product-image1"><img src="../product_images/<?php echo $row1['Product Image']; ?>" alt=""></td>
                    <td><?php echo $row1['Product Name']; ?><h3 style="color:red">&#8369;<?php echo $row1['Product Price']; ?></h3></td>
                    <td><?php echo $row1['Product Quantity']; ?></td>
                    <td>&#8369;<?php echo $productAmount ?></td>
                </tr>
            <?php
                $prepareAmount = $prepareAmount + $row1['Amount'];
                }while($row1 = $query1->fetch_assoc());
            }else{
            ?>
            <div class="empty-cart-alert1">
                <h3>No Orders!</h3>
            </div>
            <script>
            $(document).ready(function(){
                $('.table1').css("display","none");
                $('.noOfItems').css("display","none");
            });
            </script>
            <?php
                }
            ?>
        </table>
        </section>
        <div class="noOfItems">
            <h4>No. Of Items: <p style="display:inline-block;color:red"><?php echo $total1; ?></p></h4>
            <h4>Prepare For An Amount Of: <p style="display:inline-block;color:red">&#8369;<?php echo $prepareAmount; ?></p></h4>
        </div>
    </div>

    <div class="place-order">
        <div class="wrapper">
            <form action="cart.php" method="POST">
                <input type="text" name="date"  id="date" required>
                <input type="text" name="time" id="time" required>
                <input type="text" name="user-cart-table" id="user-cart-table" value="<?php echo $userCartTable; ?>" required>
                <input type="text" name="user-fullname" id="user-fullname" value="<?php echo $name; ?>" required>
                <textarea name="address" placeholder="Please enter your specific location or address..." required></textarea>
                <input type="text" name="contact-number" placeholder="Please enter your contact number" required>
                <button type="submit" name="place-order">Place Order</button>
                <button id="place-order-cancel" onclick="placeOrderCancel()">Cancel</button>
            </form>
        </div>
    </div>

    
    <!-- Javascript -->
    <script>
        function placeOrder(){
            document.querySelector('.place-order').style.display="flex";
            var date_time = new Date();
            document.getElementById('time').value = date_time.toLocaleTimeString();
            document.getElementById('date').value = date_time.toDateString();
        }

        function placeOrderCancel(){
            document.querySelector('.place-order').style.display="none";
        }

        function alterQuantity(id){    
            $(document).ready(function(){
                var quantity = $('#quantity'+id);
                var amount = $('#product-amount'+id);
                var totalAmount = $('#total-amount');
                var tableName = "<?php echo $userCartTable; ?>";
                var newQuant = $('#quantity'+id).val();
                $.post(
                    "quantity_alteration.php",
                    {
                        productId: id,
                        alterQuantity: "alter",
                        cartTable: tableName,
                        newQuantity: newQuant
                    }
                );

                setTimeout(function(){
                    $.get(
                        "quantity_alteration.php",
                        {
                            productId: id,
                            getNewAmount: "amount",
                            cartTable: tableName
                        },
                        function(data){
                            amount.html("&#8369;"+data);
                        }
                    );

                    $.get(
                        "getNewTotalAmount.php",
                        {
                            getNewTotalAmount: "amount",
                            cartTable: tableName
                        },
                        function(data){
                            totalAmount.html("&#8369;"+data);
                        }
                    );
                },3000);
                
            });      
        }

        function minusQuantity(id){    
            $(document).ready(function(){
                var quantity = $('#quantity'+id);
                var amount = $('#product-amount'+id);
                var totalAmount = $('#total-amount');
                var tableName = "<?php echo $userCartTable; ?>";
                $.post(
                    "quantity_alteration.php",
                    {
                        productId: id,
                        minusQuantity: "minus",
                        cartTable: tableName
                    },
                    function(data){
                        quantity.val(data);
                    }
                );

                setTimeout(function(){
                    $.get(
                        "quantity_alteration.php",
                        {
                            productId: id,
                            getNewAmount: "amount",
                            cartTable: tableName
                        },
                        function(data){
                            amount.html("&#8369;"+data);
                        }
                    );

                    $.get(
                        "getNewTotalAmount.php",
                        {
                            getNewTotalAmount: "amount",
                            cartTable: tableName
                        },
                        function(data){
                            totalAmount.html("&#8369;"+data);
                        }
                    );
                },3000);

                
            });      
        }
               
        function plusQuantity(id){          
            $(document).ready(function(){
                var quantity = $('#quantity'+id);
                var amount = $('#product-amount'+id);
                var totalAmount = $('#total-amount');
                var tableName = "<?php echo $userCartTable; ?>";
                $.post(
                    "quantity_alteration.php",
                    {
                        productId: id,
                        plusQuantity: "plus",
                        cartTable: tableName
                    },
                    function(data){
                        quantity.val(data);
                    }
                );

                setTimeout(function(){
                    $.get(
                        "quantity_alteration.php",
                        {
                            productId: id,
                            getNewAmount: "amount",
                            cartTable: tableName
                        },
                        function(data){
                            amount.html("&#8369;"+data);
                        }
                    );

                    $.get(
                        "getNewTotalAmount.php",
                        {
                            getNewTotalAmount: "amount",
                            cartTable: tableName
                        },
                        function(data){
                            totalAmount.html("&#8369;"+data);
                        }
                    );
                },3000);
            });
        }

        //for logging out the system
        function logout(){
            var permission = confirm("If you are sure to logging out the system click ok...");
            if(permission){
                document.getElementById('logout').href="index.php?logout=";
            }
        }

    </script>


    
    
</body>
</html>