<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Challenges</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Domine:wght@400..700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap');

        *{  
        box-sizing: border-box;
        font-family: "Domine", serif;
        font-size: 16px;
        }   
        body {
            background-color: #d5effa;
            min-height: 100vh;
        align-items: center;
        justify-content: center;
        margin-left: 20px;
            margin: 10px;
        }
        .nav-bar {
        background-color: #98e0ff;
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
        table {
            width: 50%;
            margin: auto;
            margin-top: 20px;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #d5effa;
        }
        input[type='radio'] {
            
            transform: scale(1.5);
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
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];

    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $dbname = "fitstudio";

    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if username exists in Member_details_1 table
    $sql = "SELECT * FROM Member_details_1 WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Username exists, display daily challenges
        echo "<h1>Welcome, $username!</h1>";
        echo "<div style='text-align: center;'>";
        echo "<h2>Daily Challenges</h2>";
        echo "<form method='post' action=''>";
        echo "<input type='hidden' name='username' value='$username'>";
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Challenge Name</th><th>Challenge URL</th><th>Done</th></tr>";
        
        // Fetching data from the database
        $sql_challenges = "SELECT dc_id, challenge_name, dc_links FROM Daily_Challenges";
        $result_challenges = $conn->query($sql_challenges);

        if ($result_challenges->num_rows > 0) {
            while ($row = $result_challenges->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["dc_id"] . "</td>";
                echo "<td>" . $row["challenge_name"] . "</td>";
                echo "<td><a href='" . $row["dc_links"] . "'>Link</a></td>";
                echo "<td><input type='radio' name='done' value='" . $row["dc_id"] . "'></td>";
                echo "</tr>";
            }
        } else {
            echo "0 results";
        }
        
        echo "</table>";
        echo "<input type='submit' name='submit' value='Submit'>";
        echo "</form>";
        echo "</div>";

        // Process form submission for challenge completion
        if (isset($_POST['submit']) && isset($_POST['done'])) {
            $completed_challenge_id = $_POST['done'];

            $check_sql = "SELECT * FROM Follows WHERE fmem_username = '$username' AND fdc_id = $completed_challenge_id";
            $check_result = $conn->query($check_sql);

            if ($check_result->num_rows == 0) {
        // Entry does not exist, insert into Follows table

                $insert_sql = "INSERT INTO Follows (fmem_username, fdc_id) VALUES ('$username', $completed_challenge_id)";
                if ($conn->query($insert_sql) === TRUE) {
                header("Location: attendance.php"); // Redirect here
                exit();
            } else {
                echo "Error: " . $insert_sql . "<br>" . $conn->error;}
            }else {
                // Entry already exists, show an error message
                echo "<h3>You have already completed this challenge.</h3>";
            }
    
        }}
        else {
        echo "<h1>Invalid username. Please try again.</h1>";
    }

    $conn->close();
} else {
    // Display username form
    echo "<h1>Please enter your username</h1>";
    echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";
    echo "<label for='username'>Username:</label>";
    echo "<input type='text' id='username' name='username'>";
    echo "<input type='submit' value='Submit'>";
    echo "</form>";
}
?>
</body>
</html>

