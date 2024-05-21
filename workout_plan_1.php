<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Workout Plan</title>
<style>
     @import url('https://fonts.googleapis.com/css2?family=Domine:wght@400..700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap');

    *{  
    box-sizing: border-box;
    font-family: "Domine", serif;
    font-size: 16px;
    }   
    body {
        background-color: #d1c5e1;
        margin: 10px;
    }
    .nav-bar {
        background-color: #ECD5E3;
        padding: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .nav-bar a {
        background-color: #d1c5e1;
        border-radius: 5px;
        box-shadow: 0 0 5px #d1c5e1;
        color: black;
        border: 2px solid #ddd;
        padding: 10px;
        text-align: center;
        text-decoration: none;
        margin-right: 20px;
        font-weight: bold;
    }
    .nav-bar a:hover {
        background-color: #d1c5e1;
        text-decoration: underline;
        color: white;
    }
    .container {
        width: 50%;
        margin: auto;
        margin-top: 20px;
    }
    .video-link {
        display: block;
        margin-bottom: 10px;
    }
</style>
</head>
<body>

<div class="nav-bar">
    <div></div> <!-- creates space on the left side -->
    <div>
        <a href="dashboard.php">Home</a>
        <a href="workout_plan_2.php">Diet Plan</a>
        <a href="logout.php">Logout</a>
        
    </div>
</div>

<div class="container">
    <?php
    // Check if plan ID is provided in the url
    if (isset($_GET['plan_id'])) {
        $planId = $_GET['plan_id'];

        
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "fitstudio";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Query to fetch videos based on plan ID
        $query = "SELECT * FROM Workout_plan_1 WHERE plan_id = $planId";

        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            // Output videos
            echo "<h2>Plan ID $planId videos:</h2>";
            while ($row = $result->fetch_assoc()) {
                echo "<p>{$row['video_name']} - <a class='video-link' href='" . $row["wp_videos"] . "' target='_blank'>Link</a></p>";
            }
        } else {
            echo "No videos found for this plan.";
        }

        $conn->close();
    } else {
        echo "Plan ID is missing in the URL.";
    }
    ?>
</div>

</body>
</html>



