<?php

require_once("connection.php");
require_once("PHPMailer/PHPMailer.php");
require_once("PHPMailer/SMTP.php");
require_once("PHPMailer/Exception.php");

use PHPMailer\PHPMailer\PHPMailer;

$code = $_GET['cd'];
$email = $_GET['em'];
$sender = "tingards13@gmail.com";
$password = "tingards13";
$name = "T-Yardz Online Grocery Store";
$subject = "Verification Code";
$body = "Please verify your account using this code $code";
$receiver = "$email";

$mail = new PHPMailer();

//smtp settings
$mail->isSMTP();
$mail->Host = "smtp.gmail.com";
$mail->SMTPAuth = true;
$mail->Username = $sender;
$mail->Password = $password;
$mail->Port = 465;
$mail->SMTPSecure = "ssl";

//email settings
$mail->isHTML(true);
$mail->setFrom($sender, $name);
$mail->addAddress($receiver);
$mail->Subject = ("$sender ($subject)");
$mail->Body = $body;


if($mail->send()){

    header("Location:verification.php?1st_ver=&u_id=$code");
}
else{

    $sql = "DELETE FROM `users_table` WHERE `User Id` = '$code'";
    $query = $connect->query($sql) or die ($connect->error);

    echo '<script>
    alert("Registration Failed!\nTry again later!");
    window.location.href="signup.php";
    </script>';
}

?>