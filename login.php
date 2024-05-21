<?php
session_start();
require_once('dbconnect.php');
if(isset($_POST['login'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];


    $sql = "SELECT `password` FROM member_details_2 WHERE email='$email'"; //this is the hashed pass
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];


        if (password_verify($password, $hashed_password)) { //verifying hashed pass
            
            $_SESSION['username'] = $username; //setting session username
            echo "Login successful!";
            header("Location: dashboard.php");
            exit; 
        } else {
            //echo "Invalid email or password";
            $_SESSION['message'] = "Invalid email or password";
        }
    } else {
        //echo "Invalid email or password";
        $_SESSION['message'] = "Invalid email or password";
    }

    $conn->close();
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
            <button class="admin-btn" onclick="window.location.href='admin_login2.php'">Admin</button>
        </nav>
    </header>
    <div class="wrapper">
        <h2>Login</h2>
        
        <div class="error-msg">
            <?php if(isset($_SESSION['message'])): ?>
                <p><?php echo $_SESSION['message']; ?></p>
                <?php unset($_SESSION['message']); ?> <!-- delete the msg after displaying -->
            <?php endif; ?>
        </div>

        <form method="post">
            <div class="input-box">
                <input type="text" placeholder="Username" id="username" name="username" required>
            </div>

            <div class="input-box">
                <input type="email" placeholder="Email" id="email" name="email" required>
            </div>

            <div class="input-box">
            <input type="password" placeholder="Password" id="password" name="password" required>
            </div>

            <button type="submit" class="btn" name="login">Submit</button>

            <div class="signup-link">
                <p>New to FitStudio? <a href="signup.php">Sign up here!</a></p>
            </div>
        </form>
    </div>
</body>
</html>

