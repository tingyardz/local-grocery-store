<?php
require_once('connection.php');
require_once('functionality.php');

//User Sign Up
if(isset($_POST['sign-up'])){
    $method->userSignUp();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Grocery Store</title>
    <link rel="stylesheet" href="css/signup.style.css">
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
            <h2>Sign Up</h2>
            <form action="signup.php" method="POST">
                <input id="firstname" type="text" name="firstname" placeholder="First Name" required>
                <input id="lastname" type="text" name="lastname" placeholder="Last Name" required>
                <input id="email" type="email" name="email" placeholder="Email Address" required>
                <input id="username" type="text" name="username" placeholder="Username" required>
                <input id="password" type="password" name="password" placeholder="Password" minlength="8" required>
                <input type="password" name="confirm-password" placeholder="Confirm Password" minlength="8"  required>
                <button type="submit" name="sign-up">Submit Form</button>
            </form>
        </div>
    </div>
    

    <!-- Javascript -->
    <?php
        if(isset($_GET['err'])){
    ?>
    <script>
        alert("Please recheck your password!");
        var firstname = "<?php echo $_GET['firstname']; ?>";
        var lastname = "<?php echo $_GET['lastname']; ?>";
        var email = "<?php echo $_GET['email']; ?>";
        var username = "<?php echo $_GET['username']; ?>";

        document.getElementById("firstname").value = firstname;
        document.getElementById("lastname").value = lastname;
        document.getElementById("email").value = email;
        document.getElementById("username").value = username;
        document.getElementById("password").focus();
        
    </script>
    <?php
        }
    ?>

    
    <?php
        if(isset($_GET['rechange'])){
    ?>
    <script>
        alert("Please change your password because it is very weak!");
        var firstname = "<?php echo $_GET['firstname']; ?>";
        var lastname = "<?php echo $_GET['lastname']; ?>";
        var email = "<?php echo $_GET['email']; ?>";
        var username = "<?php echo $_GET['username']; ?>";

        document.getElementById("firstname").value = firstname;
        document.getElementById("lastname").value = lastname;
        document.getElementById("email").value = email;
        document.getElementById("username").value = username;
        document.getElementById("password").focus();
        
    </script>
    <?php
        }
    ?>
</body>
</html>