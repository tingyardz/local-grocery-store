<?php
class Programs{

    public $connect;

    public function __construct($connect){

        $this->connect = $connect;
    }

    public function deleteAll(){

        $sql = "TRUNCATE `admin_order_table`";
        $query = $this->connect->query($sql) or die ($this->connect->error);

        echo '<script>
                    alert("All orders in the list has been removed...");
                    window.location.href="customers_orders.php";
                </script>';
    }

    public function remove(){

        $remove = $_GET['remove'];
        $sql = "DELETE FROM `admin_order_table` WHERE `Order No` = '$remove'";
        $query = $this->connect->query($sql) or die ($this->connect->error);

        echo '<script>
                    alert("Succefully Removed...");
                    window.location.href="customers_orders.php";
                </script>';

    }

    public function receivedOrder(){

        if(isset($_GET['received'])){

            $table = $_GET['table'];
            $orderNo = $_GET['orderNo'];
            $status = "fa-solid fa-check-to-slot";

            //recheck the status if it is already filled
            $sql = "SELECT * FROM `admin_order_table` WHERE `Order No` = '$orderNo'";
            $query = $this->connect->query($sql) or die ($this->connect->error);
            $row = $query->fetch_assoc();

            //if status has filled request denied
            if($row['Status'] == $status){
                header("Location:customers_orders.php");
                exit();
            }
    
            //filling the status denote as received
            $sql = "UPDATE `admin_order_table` SET `Status`='$status' WHERE `Order No`='$orderNo'";
            $query = $this->connect->query($sql) or die ($this->connect->error);
    
            //clearing the items
            $sql = "TRUNCATE `$table`";
            $query = $this->connect->query($sql) or die ($this->connect->error);

            header("Location:customers_orders.php");
            exit();
        }
    }

    public function selectedProduct(){

        $productId = $_GET['product_id'];
        $sql = "SELECT * FROM `product_table` WHERE `Product Id` = '$productId'";
        $query = $this->connect->query($sql) or die ($this->connect->error);
        $total = $query->num_rows;

        if($total > 0){
            return $query;
        }else{
            return false;
        }
    }

    public function updateProductImage(){

        $productId = $_POST['product-id'];
        $productImage = $_FILES['product-image'];

        //get all the information of the file
        $productImage_name = $_FILES['product-image']['name'];
        $productImage_type = $_FILES['product-image']['type'];
        $productImage_tmp_name = $_FILES['product-image']['tmp_name'];
        $productImage_error = $_FILES['product-image']['error'];
        $productImage_size = $_FILES['product-image']['size'];

        //get the extension/format of the fiqlle
        $productImage_extension = explode('.', $productImage_name);
        $productImage_actual_extension = strtolower(end($productImage_extension));

        $allowed_format = array('jpg', 'jpeg', 'png');

        if(in_array($productImage_actual_extension, $allowed_format)){

            if($productImage_error === 0){
        
                if($productImage_size < 2000000){
        
                    $productImage_name_new = uniqid('', true).".".$productImage_actual_extension;
                    $productImage_destination = '../product_images/'.$productImage_name_new;
                    move_uploaded_file($productImage_tmp_name, $productImage_destination);

                    $sql = "UPDATE `product_table`
                            SET `Product Image`='$productImage_name_new' 
                            WHERE `Product Id`='$productId' ";
                    $query = $this->connect->query($sql) or die ($this->connect->error);
    
    
                    echo '<script>
                            alert("The product image has been updated...");
                            window.location.href="addnewproduct.php";
                        </script>';
                }
                else{
        
                     echo '<script>
                        alert("Your image file is too large!");
                        window.location.href="addnewproduct.php";
                        </script>';
                }
            }else{
        
                echo '<script>
                    alert("There was a problem in your image file!");
                    window.location.href="addnewproduct.php";
                </script>';
            }
        }else{
            echo '<script>
                alert("The file extension which you have been uploaded is prohibited!");
                window.location.href="addnewproduct.php";
            </script>';
        }

    }

    public function updateProduct(){

        $productId = $_GET['product-id'];
        $productName = $_GET['product-name'];
        $productPrice = $_GET['product-price'];
        $productStocks = $_GET['product-stocks'];


        $sql = "UPDATE `product_table`
                SET `Product Name`='$productName',`Product Price`='$productPrice',`Product Stocks`='$productStocks' 
                WHERE `Product Id`='$productId' ";
        $query = $this->connect->query($sql) or die ($this->connect->error);

        echo '<script>
                    alert("The product has been updated...");
                    window.location.href="index.php";
            </script>';

    }

    public function deleteProduct(){

        $productId = $_GET['product_id'];
        $sql = "DELETE FROM `product_table` WHERE `Product Id` = '$productId'";
        $query = $this->connect->query($sql) or die ($this->connect->error);

        echo '<script>
                    alert("You have successfully remove the product...");
                    window.location.href="index.php";
            </script>';

    }

    public function addNewProduct(){

        $productName = $_POST['product-name'];
        $productPrice = $_POST['product-price'];
        $productStocks = $_POST['product-stocks'];
        $productDetails = $_POST['product-details'];
        $productImage = $_FILES['product-image'];

        //get all the information of the file
        $productImage_name = $_FILES['product-image']['name'];
        $productImage_type = $_FILES['product-image']['type'];
        $productImage_tmp_name = $_FILES['product-image']['tmp_name'];
        $productImage_error = $_FILES['product-image']['error'];
        $productImage_size = $_FILES['product-image']['size'];

        //get the extension/format of the file
        $productImage_extension = explode('.', $productImage_name);
        $productImage_actual_extension = strtolower(end($productImage_extension));

        $allowed_format = array('jpg', 'jpeg', 'png');

        if(in_array($productImage_actual_extension, $allowed_format)){

            if($productImage_error === 0){
        
                if($productImage_size < 2000000){
        
                    $productImage_name_new = uniqid('', true).".".$productImage_actual_extension;
                    $productImage_destination = '../product_images/'.$productImage_name_new;
                    move_uploaded_file($productImage_tmp_name, $productImage_destination);

                    $sql = "INSERT INTO `product_table`(`Product Name`, `Product Price`, `Product Stocks`, `Product Details`, `Product Image`) 
                            VALUES ('$productName','$productPrice','$productStocks','$productDetails','$productImage_name_new')";
                    $query = $this->connect->query($sql) or die ($this->connect->error);
    
    
                    echo '<script>
                            alert("You have successfully added the new product...");
                            window.location.href="addnewproduct.php";
                        </script>';
                }
                else{
        
                     echo '<script>
                        alert("Your image file is too large!");
                        window.location.href="addnewproduct.php";
                        </script>';
                }
            }else{
        
                echo '<script>
                    alert("There was a problem in your image file!");
                    window.location.href="addnewproduct.php";
                </script>';
            }
        }else{
            echo '<script>
                alert("The file extension which you have been uploaded is prohibited!");
                window.location.href="addnewproduct.php";
            </script>';
        }

    }

    public function getOrders(){

        $sql = "SELECT * FROM `admin_order_table`";
        $query = $this->connect->query($sql) or die ($this->connect->error);
        $total = $query->num_rows;

        if($total > 0){
            return $query;
        }else{
            return false;
        }
    }

    public function numberOfUsers(){

        $sql = "SELECT * FROM `users_table`";
        $query = $this->connect->query($sql) or die ($this->connect->error);
        $row = $query->fetch_assoc();
        $total = $query->num_rows;

        return $total;
    }

    public function getAllUsers(){

        $sql = "SELECT * FROM `users_table`";
        $query = $this->connect->query($sql) or die ($this->connect->error);
        $total = $query->num_rows;

        if($total > 0){
            return $query;
        }else{
            return false;
        }
    }

    public function numberOfProducts(){

        $sql = "SELECT * FROM `product_table`";
        $query = $this->connect->query($sql) or die ($this->connect->error);
        $row = $query->fetch_assoc();
        $total = $query->num_rows;

        return $total;
    }

    public function getAllProducts(){

        $sql = "SELECT * FROM `product_table`";
        $query = $this->connect->query($sql) or die ($this->connect->error);
        $total = $query->num_rows;

        if($total > 0){
            return $query;
        }else{
            return false;
        }
    }

}

$method = new Programs($connect);


?>