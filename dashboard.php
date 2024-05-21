<?php
session_start();
include_once "dbconnect.php";

// check if user has purchased a plan
function checkUserPlan($username)
{
    global $conn; 
    
    // check if user exists in the purchases table
    $query = "SELECT * FROM purchases WHERE customer_username = '$username'";
    $result = mysqli_query($conn, $query);

    if (!$result || mysqli_num_rows($result) == 0) {
        // if user doesn't exist
        header("Location: payment.php");
        exit();
    } else {
        // if user exists
        $row = mysqli_fetch_assoc($result);
        $plan_id = $row['wplan_id'];

        if ($plan_id == 1) {
            header("Location:workout_plan_1.php?plan_id=1");
            exit();
        } elseif ($plan_id == 2) {
            header("Location:workout_plan_1.php?plan_id=2");
            exit();
        }
        
        exit();
    }
}

if (isset($_POST['my-plans-btn']) && isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    checkUserPlan($username);
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
        </nav>
    </header>

    <div class="dash-menu">
        <div class="row">
            <button class="visit-btn" onclick="window.location.href='daily_challenges.php'">Daily challenges</button>
            <button class="visit-btn" onclick="window.location.href='BMI.php'">Calculate BMI</button>
        </div>
        <div class="row">
            <form method="post">
                <button class="visit-btn" name="my-plans-btn">My plans</button>
            </form>
            <button class="visit-btn" onclick="window.location.href='logout.php'">Logout</button>
        </div>
    </div>
</body>
</html>