<?php
require_once("../connection.php");

$sql = "SELECT * FROM `admin_order_table` ORDER BY `Order No` DESC";
$query = $connect->query($sql) or die ($connect->error);
$row = $query->fetch_assoc();
$total = $query->num_rows;

$a = "<table>
    <tr>
        <th> </th>
        <th class='orderNo'>Order No.</th>
        <th class='action'>Action</th>
        <th class='status'>Status</th>
        <th class='purchase-table'>Customer Orders</th>
        <th class='customer-name'>Customer Name</th>
        <th class='contact-number'>Contact Number</th>
        <th class='address'>Address</th>
        <th class='date'>Date</th>
        <th class='time'>Time</th>
    </tr>";
$b = "";
$c = "</table>";

if($total > 0){

    do{

        $orderNo = $row['Order No'];
        $table = $row['Purchase User Table'];
        $status = $row['Status'];
        $customerName = $row['Customer Name'];
        $contactNo = $row['Contact Number'];
        $address = $row['Specific Address'];
        $date = $row['Date'];
        $time = $row['Time'];

        $b = $b."<tr>
                    <td><a onclick='remove($orderNo)' id='remove$orderNo' class='remove' href=''><i class='fa-solid fa-trash-can'></i></a></td>
                    <td>$orderNo</td>
                    <td><a href='customers_orders.php?table=$table&orderNo=$orderNo&received='>Received</a></td>
                    <td id='status'><i class='$status'></i></td>
                    <td><a target='_blank' href='printInvoice.php?table=$table&orderNo=$orderNo&customerName=$customerName&contactNo=$contactNo&address=$address&date=$date&time=$time' >Print Invoice</a></td>
                    <td>$customerName</td>
                    <td>$contactNo</td>
                    <td>$address</td>
                    <td>$date</td>
                    <td>$time</td>
                </tr>";
    }while($row = $query->fetch_assoc());
}

$output = $a.$b.$c;

echo $output;




?>