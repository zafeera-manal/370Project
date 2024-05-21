<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fitstudio";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$matched_email = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_email = $_POST['user_email'];

    // Check if the entered email matches with the emails from the admin table
    $sql_admin = "SELECT a_email FROM Admin LIMIT 2";
    $result_admin = $conn->query($sql_admin);

    while ($row_admin = $result_admin->fetch_assoc()) {
        if ($user_email == $row_admin["a_email"]) {
            $matched_email = true;
            break;
        }
    }

    if ($matched_email) {
        // Redirect based on the matched email
        if ($user_email == "anikafariha025@gmail.com") {
            header("Location:send_notifications_1.php");
            exit;
        } elseif ($user_email == "fitstudio34@gmail.com") {
            header("Location:send_notifications_2.php");
            exit;
        }
    } else {
        $error_message = "Invalid email!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Domine:wght@400..700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap');

        *{  
        box-sizing: border-box;
        font-family: "Domine", serif;
        }
        body{
        background: #c1e6a4;
        display: flex;
        margin: 10px;
        min-height: 100vh;
        align-items: center;
        justify-content: center;
        text-align: center;
        }
       

        .container {
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .input-field {
            margin-bottom: 10px;
        }

        .btn-bold {
            font-weight: bold;
            margin-top: 10px;
        }
        .navbar{
            background-color: #dfffc7;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed; /* Position navbar fixed at the top */
            top: 5px; /* Stick navbar to the top */
            width: 100%; /* Take full width of viewport */
            z-index: 1000;
        }
        .navbar a {
            border-radius: 5px;
            box-shadow: 0 0 5px #d1c5e1;
            color: black;
            border: 2px solid #ddd;
            padding: 10px;
            text-align: center;
            text-decoration: none;
            font-weight: bold;
        }
        .navbar a:hover {
            background-color: #c1e6a4;
            text-decoration: underline;
            color: white;}
        .error-message {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="navbar">
    <div></div>
    <div>
        <a href="inventory.php">Inventory</a>
        <a href="logout.php">Logout</a>
    </div>
</div>
    <div class="container">
        <h2>Enter your email address:</h2>
        <form method="post">
            <input class="input-field" type="email" name="user_email" required>
            <input class="btn-bold" type="submit" value="Verify Email">
        </form>
        <div class="error-message">
            <?php 
            if (isset($error_message)) {
                echo $error_message;
            }
            ?>
        </div>
    </div>
</body>
</html>
