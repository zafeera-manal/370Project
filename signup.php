<?php
session_start();
require_once('dbconnect.php');
if(isset($_POST['submit-btn'])) {
  
    $username = $_POST['username'];

    // does username exist?
    $sql = "SELECT * FROM member_details_1 WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {             // if true, username exists
        $_SESSION['message'] = "Username already exists!";
        
    } else {

        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $birth_date = $_POST['birth_date'];
        $sex = $_POST['sex'];
        $phone = $_POST['phone'];
        $phone2 = $_POST['phone2'];
        $address = $_POST['address'];
        $email = $_POST['email'];
        $password = $_POST['password'];
       
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        
        $sql1 = "INSERT INTO member_details_1  
                VALUES ('$username', '$fname', '$lname', '$birth_date', '$sex', '$address', '$email')";
        $result1 = mysqli_query($conn, $sql1);

    
        $sql2 = "INSERT INTO member_phn_details 
                VALUES ('$username', '$phone')";
        $result2 = mysqli_query($conn, $sql2);

        
        $sql3 = "INSERT INTO member_details_2 
                VALUES ('$email','$hashed_password')";
        $result3 = mysqli_query($conn, $sql3);

        $sql4 = "INSERT INTO member_phn_details 
                VALUES ('$username', '$phone2')";
        $result4 = mysqli_query($conn, $sql4);

        
        if($result1 && $result2 && $result3 && $result4) {
            echo "Sign up successful!";
            header("Location: login.php");
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
            <a href="index.php">Home</a>
            <a href="#">About</a>
            <a href="#">Contact</a>
            <button class="admin-btn" onclick="window.location.href='admin_login2.php'">Admin</button>
        </nav>
    </header>

    <div class="wrapper">
        <h2>Sign up</h2>

        <div class="error-msg">
            <?php if(isset($_SESSION['message'])): ?>
                <p><?php echo $_SESSION['message']; ?></p>
                <?php unset($_SESSION['message']); ?> 
            <?php endif; ?>
        </div>

        <div class="form-container">
            <form method="post">
                <div class="input-box">
                    <input type="text" name="username" placeholder="Username" required> 
                </div>

                <div class="input-box">
                    <input type="text" name="fname" placeholder="First name" required> 
                </div>

                <div class="input-box">
                <input type="text" name="lname" placeholder="Last name" required> 
                </div>

                <div class="input-box">
                    <p>(Date of birth)</p>
                    <input type="date" name="birth_date" placeholder="Date of birth" required> 
                </div>

                <div class="select-sex"></div>
                    <input type="radio" name="sex" value="Male" required> Male
                    <input type="radio" name="sex" value="Female" required> Female
                    <input type="radio" name="sex" value="Other" required> Other
                </div>

                <div class="input-box">
                    <input type="tel" name="phone" placeholder="01234567891 (Phone1 required)" required> 
                </div>

                <div class="input-box">
                    <input type="tel" name="phone2" placeholder="01234567891 (Phone2 if any)"> 
                </div>

                <div class="input-box">
                    <input type="text" name="address" placeholder="Address" required> 
                </div>
                <div class="input-box">
                    <input type="email" name="email" placeholder="Email" required> 
                </div>
                <div class="input-box">
                    <input type="password" name="password" placeholder="Password" required> 
                </div>

                <button type="submit" class="btn" name="submit-btn">Submit</button>

                <div class="signup-link">
                    <p>Have an account already? <a href="login.php">Login here!</a></p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>