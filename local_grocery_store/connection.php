<?php
$serverName = "localhost";
$userName = "root";
$password = "";
$dbName = "mystore_database";

try{

    $connect = mysqli_connect($serverName, $userName, $password, $dbName);

}catch(Exception $e){

    echo $e->getMessage();
    echo "<br>Connection Failed!";
    
}
?>