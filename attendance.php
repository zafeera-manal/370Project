<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php"); // Redirect to login page if username is not set
    exit;
}
$loggedin_username = $_SESSION["username"];
require_once('dbconnect.php');



if ($_SERVER["REQUEST_METHOD"] == "POST") {  // Checking if the form is submitted
    
    if (isset($_POST["username"])) {  //Checking if the "username" key is set in the $_POST array
        
        $username = $_POST["username"];  // Get the username  
        if ($loggedin_username !== $username) {
            echo "Invalid username! Please enter your own username.";
            //exit; // Stop further processing
        }
        else{
        $check_username_query = "SELECT * FROM member_details_1 WHERE username = '$username'"; // Checking if username exists in the database
        $result = $conn->query($check_username_query);

        if ($result->num_rows > 0) { // Username exists in database if result return more than 0 rows
            $date = date("Y-m-d"); //current date
            $check_last_visit_query = "SELECT last_visit_date, Streak FROM Progress_Report WHERE received_username = '$username'"; //last visit date and streak for the user
            $result = $conn->query($check_last_visit_query);

            if ($result->num_rows > 0) { //storing the last_visit_date and streak of the user here
                $row = $result->fetch_assoc();
                $last_visit_date = $row["last_visit_date"];
                $streak = $row["Streak"];
                
                if ($last_visit_date == $date) { //no update if the last visit date is today
                    echo "Attendance already recorded for today!";
                } elseif (date("Y-m-d", strtotime("-1 day")) == $last_visit_date) {
                    $update_query = "UPDATE Progress_Report SET Attendance = 1, Streak = Streak + 1, last_visit_date = '$date' WHERE received_username = '$username'"; //streak will be updated if last visit date is yesterday
                    if ($conn->query($update_query) === TRUE) {
                        echo "Attendance recorded successfully! <br>";
                    } else {
                        echo "Error updating record: " . $conn->error;
                    }
                } else {
                    $update_query = "UPDATE Progress_Report SET Attendance = 1, Streak = 1, last_visit_date = '$date' WHERE received_username = '$username'"; //the streak is reset to 1
                    if ($conn->query($update_query) === TRUE) {
                        echo "Attendance recorded successfully!<br>";
                    } else {
                        echo "Error updating record: " . $conn->error;
                    }
                } 
            } else {
                // if user doesn't exist in Progress_Report, insert new record
                $insert_query = "INSERT INTO Progress_Report (last_visit_date, Attendance, Streak, received_username) VALUES ('$date', 1, 1, '$username')";
                if ($conn->query($insert_query) === TRUE) {
                    echo "Attendance recorded successfully!";
                    
                } else {
                    echo "Error inserting record: " . $conn->error;
                }
            }
        } else {
            // if the username does not exist in member_details_1 table
            echo "Invalid username! Please enter a valid username.";
        }
    }
}
}

// Showing a leaderboard of users with the streaks in descending order
$leaderboard_data = array();
$leaderboard_query = "SELECT received_username, Streak FROM Progress_Report ORDER BY Streak DESC";
$leaderboard_result = $conn->query($leaderboard_query);

if ($leaderboard_result->num_rows > 0) {
    // Fetch leaderboard data
    while ($row = $leaderboard_result->fetch_assoc()) {
        $leaderboard_data[] = $row;
    }
} else {
    echo "0 results";
}

$conn->close(); //closing database connection
?>

<!DOCTYPE html>
<html>
<head>
    <title>Attendance Form</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Domine:wght@400..700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap');

*{  
    box-sizing: border-box;
    font-family: "Domine", serif;
}

body{
    background-color: #d5effa;
    min-height: 100vh;
    align-items: center;
    justify-content: center;
    
    margin-left: 20px;
    margin: 10px;
    
}
.nav-bar {
    background-color:#98e0ff;
    padding: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
    .nav-bar a {
    background-color: #d5effa;
    border-radius: 5px;
    box-shadow: 0 0 5px #d1c5e1;
    color: black;
    border: 2px solid #ddd;
    padding: 10px;
    text-align: center;
    text-decoration: none;
    font-weight: bold;
    }
    .nav-bar a:hover {
        background-color: #d5effa;
        text-decoration: underline;
        color: white;
    }

    .time{
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 1.5rem;
        font-weight: 600;
        color: #333;
        padding: 20px;
        
    }

.attendance-form{
    padding: 120px 40px;
    justify-content: center;
    
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    width: 400px;
    margin: auto;
    
}

.leaderboard{
    text-align: center;
    padding: 20px;

}
.leaderboard-table{
    display:flex;
    justify-content: center;
    align-items: center;
    font-size: 1.5rem;
    font-weight: 600;
    color: #333;
    padding: 10px;
}
    </style>
</head>
<body>
    <div class="nav-bar">
        <div></div>
        <div> 
            <a href="dashboard.php">Home</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>
    <div class=time>
        <?php
        echo "Localtime is:  " . date("Y-m-d, H:i:s")."<br>" ; //current date and time
        ?>
    </div>
    <div class= "attendance-form">
    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" placeholder="Enter your username" required>
        <button type="submit">Record Attendance</button>
    </form>
    </div>
    

    <div class="leaderboard">
        <h2>Leaderboard</h2>
        <div class="leaderboard-table">
        <table style="width:60%; border: 1px solid black; text-align: center; border-collapse: collapse;">
        <tr>
            <th style="width:60%; border: 1px solid black;">Username</th>
            <th style="border: 1px solid black;">Streak</th>
        </tr>
        <?php
        // Output leaderboard data from the array
        foreach ($leaderboard_data as $row) {
         echo "<tr><td style='border: 1px solid black;'>" . $row["received_username"] . "</td><td style='border: 1px solid black;'>" . $row["Streak"] . "</td></tr>";
        }
        ?>
    </table>
        </div>
    </div>
</body>
</html>



