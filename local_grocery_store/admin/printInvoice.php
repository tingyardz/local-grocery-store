<?php
require_once("../connection.php");
session_start();

if(!isset($_SESSION['admin-login'])){
    header("Location:login.php");
    exit();
}

$count = 1;
$totalAmount = 0;

if(isset($_GET['table'])){
    $table = $_GET['table'];
    $orderNo = $_GET['orderNo'];
    $customerName = $_GET['customerName'];
    $contactNo = $_GET['contactNo'];
    $address = $_GET['address'];
    $date = $_GET['date'];
    $time = $_GET['time'];
    $status = $status = "fa-solid fa-check-to-slot";
    $denied = "NO";


    //recheck the status if it is already filled
    $sql = "SELECT * FROM `admin_order_table` WHERE `Order No` = '$orderNo'";
    $query = $connect->query($sql) or die ($connect->error);
    $row = $query->fetch_assoc();
    
    //if status has filled then request denied
    if($row['Status'] == $status){
        $denied = "YES";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Invoice</title>
    <link rel="stylesheet" href="css/printInvoice.style.css">
    <link rel="shortcut icon" href="../icon/logo.ico" type="image/x-icon">
</head>
<body>

    <div class="page" id="page">
        <h3>Invoice</h3>
        <h6><label for="">Order No: </label><?php echo $orderNo; ?></h6>
        <h6><label for="">Customer Name: </label><?php echo $customerName; ?></h6>
        <h6><label for="">Contact No: </label><?php echo $contactNo; ?></h6>
        <h6><label for="">Address: </label><?php echo $address; ?></h6>
        <h6><label for="">Date of Purchase: </label><?php echo $date; ?></h6>
        <h6><label for="">Time of Purchase: </label><?php echo $time; ?></h6>

        <div class="wrapper">
            <table>
                <tr>
                    <th>Item No.</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Amount</th>
                </tr>

            <?php
                $sql = "SELECT * FROM `$table`";
                $query = $connect->query($sql) or die ($connect->error);
                $row = $query->fetch_assoc();
                $total = $query->num_rows;
                do{
            ?>

                <tr>
                    <td><?php echo $count; ?></td>
                    <td><?php echo $row['Product Name'] ?></td>
                    <td><?php echo $row['Product Quantity'] ?></td>
                    <td><?php echo $row['Product Price'] ?></td>
                    <td><?php echo $row['Amount'] ?></td>
                </tr>

            <?php
                $count++;
                $totalAmount = $totalAmount + ($row['Product Price'] * $row['Product Quantity']);
                }while($row = $query->fetch_assoc());
            ?>
            </table>
        </div>

        <div class="wrapper-02">
            <strong><label for="">Total Amount: </label></strong><p>&#8369;<?php echo $totalAmount; ?></p>
        </div>
    </div>
    
</body>

    <!-- Javascript -->

    <?php
        if($total == 0 || $denied == "YES"){
    ?>
    <script>
        document.getElementById('page').innerHTML = "<h1 style='text-align:center'>NO PURCHASE ORDER!<br>OR<br>ALREADY RECEIVED THE ITEMS!</h1>";
    </script>
    <?php
        }else{
    ?>
    <script>
        var print = window.print();
    </script>
    <?php
        }
    ?>
</html>