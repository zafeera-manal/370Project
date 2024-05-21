<?php
session_start();
require_once('dbconnect.php');
if(isset($_POST['submit-btn'])) {
  
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];

    // does username exist?
    $sql = "SELECT * FROM admin WHERE a_email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['message'] = "Email already registered!";
        
        //echo "Username already exists!";
        //header("Location: signup.php");
        
    } else {
 
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
      
        $sql1 = "INSERT INTO admin VALUES ('$name', '$email', '$hashed_password', '$phone')";
        $result1 = mysqli_query($conn, $sql1);

        
        if($result1) {
            echo "Sign up successful!";
            header("Location: admin_login2.php");
            exit;
            
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    
    }
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitStudio</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <header> 
        <div class="logo"><img src="fitstudiologo.png" alt="Logo"></div>
        <nav class="nav-bar">
            <a href="#">Home</a>
            <a href="#">About</a>
            <a href="#">Contact</a>
            <!--<button class="admin-btn" onclick="window.location.href='admin_login.php'">Admin</button>-->
        </nav>
    </header>

    <div class="wrapper">
        <h2>Admin Registration</h2>

        <div class="error-msg">
            <?php if(isset($_SESSION['message'])): ?>
                <p><?php echo $_SESSION['message']; ?></p>
                <?php unset($_SESSION['message']); ?> 
            <?php endif; ?>
        </div>

        <div class="form-container">
            <form method="post">

                <div class="input-box">
                    <input type="text" name="name" placeholder="Name" required> 
                </div>
                
                <div class="input-box">
                    <input type="email" name="email" placeholder="Email" required> 
                </div>
                <div class="input-box">
                    <input type="password" name="password" placeholder="Password" required> 
                </div>

                <div class="input-box">
                    <input type="tel" name="phone" placeholder="01234567891" required> 
                </div>

                <button type="submit" class="btn" name="submit-btn">Submit</button>

                <div class="signup-link">
                    <p>Have an account already? <a href="admin_login2.php">Login here</a></p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>