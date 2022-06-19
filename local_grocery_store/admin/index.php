<?php
require_once("../connection.php");
require_once("admin_functions.php");
session_start();

if(!isset($_SESSION['admin-login'])){
    header("Location:login.php");
    exit();
}

if(isset($_GET['remove'])){
    $method->deleteProduct();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Grocery Store</title>
    <link rel="stylesheet" href="css/index.style.css">
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

            <h1>Dashboard:</h1>

            <!-- Users Section -->
            <div class="subwrapper-1">
                    <h3>No. Of Users: <?php echo $method->numberOfUsers(); ?></h3>
                    <div class="form">
                        <input type="text" id="user-name-input">
                        <button id="user-name-button">Search</button>
                    </div>
            </div>

            <div class="subwrapper-2" id="user-table">
                <table>
                    <tr>
                        <th>User Id</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email Address</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Verify</th>
                    </tr>

                <?php
                $query = $method->getAllUsers();
                if($query){
                    $row = $query->fetch_assoc();
                    do{
                ?>

                    <tr>
                        <td><?php echo $row['User Id']; ?></td>
                        <td><?php echo $row['First Name']; ?></td>
                        <td><?php echo $row['Last Name']; ?></td>
                        <td><?php echo $row['Email Address']; ?></td>
                        <td><?php echo $row['Username']; ?></td>
                        <td><?php echo $row['Password']; ?></td>
                        <td><?php echo $row['Verify']; ?></td>
                    </tr>

                <?php
                    }while($row = $query->fetch_assoc());
                }
                ?>
                </table>
            </div>

            <!-- Product Section -->
            <div class="subwrapper-3">
                <h3>No. Of Products: <?php echo $method->numberOfProducts(); ?></h3>
                    <div class="form">
                        <input type="text" id="product-name-input">
                        <button id="product-name-button">Search</button>
                    </div>
            </div>

            <div class="subwrapper-4" id="product-table">
                <table>
                    <tr>
                        <th>Product Id</th>
                        <th>Product Name</th>
                        <th>Product Price</th>
                        <th>Product Stocks</th>
                        <th>Product Image</th>
                        <th>Action A</th>
                        <th>Action B</th>
                    </tr>

                <?php
                $query = $method->getAllProducts();
                if($query){
                    $row = $query->fetch_assoc();
                    do{
                ?>

                    <tr>
                        <td><?php echo $row['Product Id']; ?></td>
                        <td><?php echo $row['Product Name']; ?></td>
                        <td><?php echo $row['Product Price']; ?></td>
                        <td><?php echo $row['Product Stocks']; ?></td>
                        <td><?php echo $row['Product Image']; ?></td>
                        <td><a id="remove<?php echo $row['Product Id']; ?>" onclick="remove(<?php echo $row['Product Id']; ?>)" style="color:red;cursor:pointer"><i class="fa-solid fa-trash-can"></i></a></td>
                        <td><a style="color:blue" href="updateproduct.php?update=&product_id=<?php echo $row['Product Id']; ?>"><i class="fa-solid fa-pencil"></i></a></td>
                    </tr>

                <?php
                    }while($row = $query->fetch_assoc());
                }
                ?>
                </table>
            </div>
            
        </section>
    </div>

    <!-- Javascript -->
    <script>
        //script for searching user
        $(document).ready(function(){
            $('#user-name-input').keyup(function(){
                var input = $('#user-name-input').val();
                $.post(
                    "searchforuser.php",
                    {
                        inputDetails: input
                    },
                    function(data){
                        $('#user-table').html(data);
                    }
                );
            });
        });

        $(document).ready(function(){
            $('#user-name-button').click(function(){
                var input = $('#user-name-input').val();
                $.post(
                    "searchforuser.php",
                    {
                        inputDetails: input
                    },
                    function(data){
                        $('#user-table').html(data);
                        console.log(data);
                    }
                );
            });
        });

        //script for searching product
        $(document).ready(function(){
            $('#product-name-input').keyup(function(){
                var input = $('#product-name-input').val();
                $.post(
                    "searchforproduct.php",
                    {
                        inputDetails: input
                    },
                    function(data){
                        $('#product-table').html(data);
                    }
                );
            });
        });

        $(document).ready(function(){
            $('#product-name-button').click(function(){
                var input = $('#product-name-input').val();
                $.post(
                    "searchforproduct.php",
                    {
                        inputDetails: input
                    },
                    function(data){
                        $('#product-table').html(data);
                    }
                );
            });
        });


        //remove item
        function remove(id){

            var element = document.getElementById('remove'+id);
            var permission = confirm("Click ok to remove the item.");

            if(permission){

                element.href="index.php?remove=&product_id="+id;
            }
        }
    </script>
    

</body>
</html>