<?php
    if(isset($_POST['login'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        if($username == "admin" && $password == "tingards"){
            session_start();
            $_SESSION['admin-login'] = true;
            header("Location:index.php");
            exit();
        }
        else{
            echo '<script>
            alert("Please recheck your username or password!");
            window.location.href="login.php";
            </script>';
        }
        

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Grocery Store</title>
    <link rel="stylesheet" href="css/login.style.css">
    <link rel="shortcut icon" href="../icon/logo.ico" type="image/x-icon">
</head>
<body>
    <div class="container">
        <div class="wrapper">
            <div><h6>T-Yardz Online Store Admin</h6></div>
            <form action="login.php" method="POST">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="login">Login</button>
            </form>
        </div>
        
    </div>
    
</body>
</html>




