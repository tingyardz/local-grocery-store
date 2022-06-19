<?php
require_once("../connection.php");

if(isset($_POST['inputDetails'])){

    $input = $_POST['inputDetails'];

        $sql = "SELECT * FROM `product_table` WHERE `Product Name`LIKE'%$input%' ";
        $query = $connect->query($sql) or die ($connect->error);
        $row = $query->fetch_assoc();
        $total = $query->num_rows;

        if($total > 0){
            $a = "<table>
            <tr>
                <th>Product Id</th>
                <th>Product Name</th>
                <th>Product Price</th>
                <th>Product Stocks</th>
                <th>Product Image</th>
                <th>Action A</th>
                <th>Action B</th>
            </tr>";

            $b = "";

            do{
                $productId = $row['Product Id'];
                $productName = $row['Product Name'];
                $productPrice = $row['Product Price'];
                $productStocks = $row['Product Stocks'];
                $productImage = $row['Product Image'];
                $b = "$b"."<tr>
                <td>$productId</td>
                <td>$productName</td>
                <td>$productPrice</td>
                <td>$productStocks</td>
                <td>$productImage</td>
                <td><a style='color:red;cursor:pointer' onclick='remove($productId)' id='remove$productId'><i class='fa-solid fa-trash-can'></i></a></td>
                <td><a style='color:blue' href='updateproduct.php?update=&product_id=$productId'><i class='fa-solid fa-pencil'></i></a></td>
            </tr>";
            }while($row = $query->fetch_assoc());

            $c = "</table>";

            $output = $a.$b.$c;

            echo $output;
        }
        else{

            echo "<h3 style='width:100%;margin-top:50px;text-align:center;color: rgb(110, 110, 110);'>No Data Found!</h3>";
        }
}