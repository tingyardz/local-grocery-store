<?php
require_once("connection.php");
require_once("functionality.php");

if(isset($_POST['login'])){
    $method->login();
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
    <link rel="stylesheet" href="css/all.min.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.php"><button><i class="fas fa-arrow-left"></i> Back</button></a></li>
        </ul>
    </nav>

    <div class="container">
        <div class="wrapper">
            <div style="display:none" class="alert"><h6>Please check your username and password!</h6></div>
            <form action="login.php" method="POST">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="login">Login</button>
            </form>
            <p>OR</p>
            <div class="signup"><a href="signup.php">Sign Up</a></div>
        </div>
    </div>

    <!-- Javascript -->
    <?php
        if(isset($_GET['mis_unorpass'])){
    ?>
    <script>
        document.querySelector(".alert").style.display = "block";
    </script>
    <?php
        }
    ?>
    
</body>
</html>