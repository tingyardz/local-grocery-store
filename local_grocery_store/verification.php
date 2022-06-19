<?php
require_once("connection.php");
require_once("functionality.php");
session_start();

if(!isset($_SESSION['verification'])){
    header("Location:index.php");
    exit();
}

if(isset($_POST['verify'])){
    $method->verify();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Grocery Store</title>
    <link rel="stylesheet" href="css/verification.style.css">
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
            <h2>Please Verify Your Account</h2>
            <div class="sub-wrapper">
                <div class="alert"><h4>The code you entered is incorrect!</h4></div>
                <form action="verification.php" method="POST">
                    <input type="number" name="verification-code" placeholder="Enter the code here" required>
                    <input type="number" name="userId" style="display:none" value="<?php echo $_GET['u_id']; ?>">
                    <button type="submit" name="verify">Submit Code</button>
                </form>
            </div>
            <h5>Please check your email for your verification code</h5>
        </div>
    </div>

    <!-- Javascript -->
    <?php
        if(isset($_GET['1st_ver'])){
    ?>
        <script>
            alert("Please check your email for the verification code!");
        </script>
    <?php
        }
    ?>

    <?php
        if(isset($_GET['m_code'])){
    ?>
        <script>document.querySelector('.alert').style.display = "block";</script>
    <?php
        }
    ?>
    
</body>

</html>