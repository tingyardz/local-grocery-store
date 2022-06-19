<?php
require_once("connection.php");
require_once("functionality.php");

//create table
$method->createTable();
//create admin Order Management table
$method->adminOrderTable();

//get products from db
$sql = "SELECT * FROM `product_table` LIMIT 20";
$query = $connect->query($sql) or die ($connect->error);
$row = $query->fetch_assoc();
$total_product = $query->num_rows;
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
    <script src="js/jquery.min.js"></script>
</head>
<body>

<!-- Navigation for computer screens -->
<nav id="for-computer-screens" class="for-computer-screens">
    <ul>
        <li class = "shop-name"><p><a href="index.php">T-Yardz Online Store</a></p></li>
        <li class="searching">
                <div class="wrapper">
                    <form id="search-form" action="" method="GET">
                        <input id="product-name" type="text" name="product-name" placeholder="Product Name">
                        <button type="submit" id="search-query" name="search-query"><i class="fa-solid fa-magnifying-glass"></i> Search</button>
                    </form>
                </div>
        </li>
        <li><a href="login.php"><i class="fa-solid fa-right-to-bracket"></i> Login</a></li>
        <li><a href="signup.php"><i class="fa-solid fa-right-to-bracket"></i> Sign Up</a></li>
    </ul>
</nav>

<!-- Navigation for mobile phones -->
<nav id="for-mobile-screens" class="for-mobile-screens">
    <ul>
        <li><button id="menu-bar"><i class="fa-solid fa-bars"></i></button></li>
        <li class = "shop-name"><a href="index.php">T-Yardz Online Store</a></li>
        <li class="search"><button id="search"><i class="fa-solid fa-magnifying-glass"></i></button></li>
    </ul>
</nav>

<!-- pop-up menu -->
<div class="menu">
        <ul>
            <li class="close"><button id="close"><i class="fa-solid fa-xmark"></i></button></li>
            <li><a href="login.php"><button class="login"><i class="fa-solid fa-right-to-bracket"></i>Login</button></a></li>
            <li><a href="signup.php"><button class="signup"><i class="fa-solid fa-right-to-bracket"></i> Sign Up</button></a></li>
        </ul>
</div>

<!-- pop-up search bar -->
<nav id="pop-up-search-bar" class="pop-up-search-bar">
    <ul>
        <li><button class="search-back"><i class="fa-solid fa-arrow-left-long"></i></button></li>
        <li class="form-wrapper">
            <form id="search-form" action="" method="GET">
                <input class="search-input" id="product-name" type="text" name="product-name" placeholder="Product Name">
                <button class="search-submit" type="submit" id="search-query" name="search-query"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
        </li>
    </ul>
</nav>



    <div class="container">
        <div class="wrapper-1">
            <section>
                <h1>Add to Cart Now <i class="fa-solid fa-cart-shopping"></i></h1>
            </section>
            
        </div>

        <div class="wrapper-2">

        <center>
            <div id="product-container">
                    <?php if($total_product > 0){
                                do{
                    ?>
                    <div class="sub-wrapper">
                        <div class="mini-wrapper-1"><img src="product_images/<?php echo $row['Product Image']; ?>"></div>
                        <div class="mini-wrapper-2"><label for=""><strong><?php echo $row['Product Name']; ?></strong></label></div>
                        <div class="mini-wrapper-3"><label for=""><em>&#8369;<?php echo $row['Product Price']; ?></em></label></div>
                        <div class="mini-wrapper-4"><label for=""><small>Stocks: <?php echo $row['Product Stocks']; ?></small></label></div>
                        <div class="mini-wrapper-5"><button onclick="addToCart()" class="add-to-cart"><i class="fa-solid fa-cart-shopping"></i> Add to Cart</button></div>
                    </div>  
                    <?php 
                                }while($row = $query->fetch_assoc());
                        }
                    ?>
            </div>

            <div class="products-from-search">
                <?php
                    if(isset($_GET['search-query'])){
                        $query = $method->searchItem();               
                        if($query){
                            $row = $query->fetch_assoc();
                            do{
                ?>               
                            <div class="sub-wrapper">
                                <div class="mini-wrapper-1"><img src="product_images/<?php echo $row['Product Image']; ?>"></div>
                                <div class="mini-wrapper-2"><label for=""><strong><?php echo $row['Product Name']; ?></strong></label></div>
                                <div class="mini-wrapper-3"><label for=""><em>&#8369;<?php echo $row['Product Price']; ?></em></label></div>
                                <div class="mini-wrapper-4"><label for=""><small>Stocks: <?php echo $row['Product Stocks']; ?></small></label></div>
                                <div class="mini-wrapper-5"><button onclick="addToCart()" class="add-to-cart"><i class="fa-solid fa-cart-shopping"></i> Add to Cart</button></div>
                            </div>
                <?php
                            }while($row = $query->fetch_assoc());
                        }
                        else{
                ?>
                            <h3 style="margin-top: 15px; color: rgb(110,110,110);">No Item Found!</h3>
                            <script>
                                $(document).ready(function(){
                                    $('#show-more-items-02').css("display","none");
                                });
                            </script>
                <?php
                        }
                    }
                ?>                
            </div>
        </center>
            <div class="sub-wrapper-2" id="show-more-01"><button id="show-more-items-01">Show More Items</button></div>
            <div class="sub-wrapper-2" id="show-more-02"><button id="show-more-items-02">Show More Items</button></div>          
        </div>
    </div>

    <!-- Javascript -->
    <script>
        $(document).ready(function(){
            $('#menu-bar').click(function(){
                $('.menu').fadeIn();
            });
            $('#close').click(function(){
                $('.menu').fadeOut();
            });
            $('#search').click(function(){
                $('#for-mobile-screens').hide();
                $('#pop-up-search-bar').fadeIn(function(){
                    $('.search-input').focus();
                });
                
            });
            $('.search-back').click(function(){
                $('#for-mobile-screens').show();
                $('#pop-up-search-bar').hide();
            });
        });
        
    </script>


    <script>
        var productsShowed01 = $('#product-container').html();
        var productsShowed02 = $('.products-from-search').html();
        //showing more items#1
        $(document).ready(function(){
            var newCounts = 20;
            var dataLen = 0;
            $('#show-more-items-01').click(function(){
                newCounts = newCounts + 20;
                $('#product-container').load(
                    "showMoreItems.php",
                    {
                        newItemCounts: newCounts
                    },
                    function(data){
                        if(data.length <= productsShowed01.length){
                            $('#show-more-items-01').html("No More Available Items");
                        }else{
                            productsShowed01 = data;
                        }
                        
                    }
                );
            });           
        });

        //showing more items#2
        $(document).ready(function(){
            var newCounts = 20;
            var dataLen = 0;
            $('#show-more-items-02').click(function(){
                newCounts = newCounts + 20;
                var product = "<?php if(isset($_GET['search-query'])){ echo $_GET['product-name']; }?>";
                $('.products-from-search').load(
                    "showMoreItems.php",
                    {
                        newItemCounts: newCounts,
                        productName: product
                    },
                    function(data){
                        if(data.length <= productsShowed02.length){
                            $('#show-more-items-02').html("No More Available Items");
                        }else{
                            productsShowed02 = data;
                        }
                    }
                );
            });
        });

        //for logging out the system
        function logout(){
            var permission = confirm("If you are sure to logging out the system click ok...");
            console.log(permission);
            if(permission){
                document.getElementById('logout').href="index.php?logout=";
            }
        }

        //adding item to the cart       
        function addToCart(){
            alert("Please login your account!");
        }         

    </script>

    <!-- displaying product from searching -->
    <?php
        if(isset($_GET['search-query'])){
    ?>
    <script>
        $(document).ready(function(){
            $('#product-container').css("display","none");
            $('#show-more-01').css("display","none");
        });
    </script>
    <?php
        }else{
    ?>
    <script>
        $(document).ready(function(){
            $('#show-more-02').css("display","none");
        });
    </script>
    <?php
        }
    ?>
    
</body>
</html>