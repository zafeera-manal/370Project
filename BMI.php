<?php
// calculate BMI and weight status
function calculateBMI($weight, $height) {
    $bmi = $weight / ($height * $height);

    if ($bmi < 18.5) {
        return 'Underweight';
    } elseif ($bmi < 25) {
        return 'Healthy Weight';
    } elseif ($bmi < 30) {
        return 'Overweight';
    } else {
        return 'Obesity';
    }
}

// Connect to database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fitstudio";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$username = $height = $weight = $bmiResult = '';
$showButton = true;


// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input
    $username = isset($_POST['username']) ? $_POST['username'] : "";
    $height = isset($_POST['height']) ? $_POST['height'] : "";
    $weight = isset($_POST['weight']) ? $_POST['weight'] : "";

    // Check if user exists
    $query = $conn->prepare("SELECT * FROM member_details_1 WHERE username=?");
    $query->bind_param("s", $username);
    $query->execute();
    $result = $query->get_result()->fetch_assoc();

    if ($result) {
        // Calculate BMI
        $bmi = $weight / ($height * $height);
        $bmi = number_format($bmi, 2); // Format BMI to 2 decimal places

        // Determine weight status
        $weight_status = calculateBMI($weight, $height);

        // Store height and weight in interacts_with table
        $query = $conn->prepare("INSERT INTO BMI_calculator (mem_username, height, weight) VALUES (?, ?, ?)");
        $query->bind_param("sdd", $username, $height, $weight);
        $query->execute();

        // Set BMI result
        $bmiResult = "<h1>Your BMI Result</h1>";
        $bmiResult .= "<p>Your BMI is: $bmi</p>";
        $bmiResult .= "<p>Your Weight Status is: $weight_status</p>";
    } else {
        $bmiResult = "<h1>Error</h1><p>Username does not exist in the table</p>";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BMI Calculator</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Domine:wght@400..700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap');

        *{  
            box-sizing: border-box;
            font-family: "Domine", serif;
        }
        body {
            background-color: #ffe6e8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 10px;

        }
        .nav-bar {
            background-color:#ffeee3;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed; 
            top: 5px; 
            width: 100%; 
            z-index: 1000; 
        }
        .nav-bar a {
            background-color: #ffe6e8;
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
                background-color: #ffe6e8;
                text-decoration: underline;
                color: white;
            }

        .container {
            padding: 20px;
            text-align: center;
            margin-top: 80px;
        }
        
        form {
            margin-bottom: 20px;
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
    <div class="container">
        <h1>BMI Calculator</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required><br><br>
            <label for="height">Height (m):</label>
            <input type="number" id="height" name="height" min="0" step="0.01" value="<?php echo htmlspecialchars($height); ?>" required><br><br>
            <label for="weight">Weight (kg):</label>
            <input type="number" id="weight" name="weight" min="0" step="0.01" value="<?php echo htmlspecialchars($weight); ?>" required><br><br>
            <?php if ($showButton) { ?>
                <input type="submit" value="Calculate BMI">
            <?php } ?>
        </form>
        
        <?php echo $bmiResult; ?> 
    </div>
</body>
</html>


