<?php      
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customerUsername = $_POST["customer_username"];

    // Check if the customer exists in the Member_details_1 table
    $query = "SELECT * FROM Member_details_1 WHERE username = '$customerUsername'";
    
    // Execute the query and check if any rows are returned. If no rows are returned, it means the customer does not exist
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "fitstudio";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        // Get the selected plan ID and payment type from the form
        $selectedPlanId = $_POST["plan_id"];
        $paymentType = $_POST["payment_type"];

        // Check if the combination of plan ID and customer username already exists in the Purchases table
        $checkQuery = "SELECT * FROM Purchases WHERE wplan_id = '$selectedPlanId' AND customer_username = '$customerUsername'";
        $checkResult = $conn->query($checkQuery);

        if ($checkResult->num_rows > 0) {
            // If the combination already exists, print an error message
            echo "Member is already subscribed to the plan.";
            header("Location:workout_plan_1.php?plan_id='$selectedPlanId'");
                exit();
        } else {
            // Insert the purchase details in the Purchases table
            $insertQuery = "INSERT INTO Purchases (wplan_id, customer_username, payment_type) 
                            VALUES ('$selectedPlanId', '$customerUsername', '$paymentType')";
            // Execute the insert query
            $conn->query($insertQuery);

            // Redirect to appropriate video page based on the selected plan ID
            if ($selectedPlanId == 1) {
                header("Location:workout_plan_1.php?plan_id=1");
                exit();
            } elseif ($selectedPlanId == 2) {
                header("Location:workout_plan_1.php?plan_id=2");
                exit();
            }
        }
    } else {
        // Show error message or redirect to another page
        echo "Customer does not exist!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>FitStudio Purchase Form</title>
    <style>
         @import url('https://fonts.googleapis.com/css2?family=Domine:wght@400..700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap');

        *{  
            
            box-sizing: border-box;
            font-family: "Domine", serif;
            
            }   

            body{
            background-color: #d1c5e1;
            min-height: 100vh;
            align-items: center;
            justify-content: center;
            margin-left: 20px;
            margin-bottom: 20px;
            padding: 10px;
            }
            .nav-bar {
            background-color: #ECD5E3;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 14px;
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
        .purchase-form {
            margin: 20px 10px;
            padding: 20px;
            font-size: 20px;
        }
        label {
            font-weight: bold;
            }
    </style>
</head>
<body>
<div class="nav-bar">
    <div></div> <!-- This empty div creates space on the left side -->
    <div>
        <a href="dashboard.php">Home</a>
        <a href="logout.php">Logout</a>    
    </div>
</div> 

</div>
<div class="purchase-form">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="customer_username">Customer Username:</label>
        <input type="text" name="customer_username" id="customer_username" placeholder="Enter your username" required><br><br>

        <label for="plan_id">Select Plan ID:</label><br>
        <input type="radio" name="plan_id" value="1" id="plan1" required>
        <label for="plan1">Plan 1 - Weight Loss ($3.00)</label><br>
        <input type="radio" name="plan_id" value="2" id="plan2">
        <label for="plan2($5.00)">Plan 2 - Weight Gain ($5.00)</label><br><br>

        <label for="payment_type">Select Payment Type:</label><br>
        <input type="radio" name="payment_type" value="Credit Card" id="credit_card" required>
        <label for="credit_card">Credit Card</label><br>
        <input type="radio" name="payment_type" value="Mobile Wallet" id="mobile_wallet">
        <label for="mobile_wallet">Mobile Wallet</label><br><br>

        <input type="submit" value="Submit">
    </form>
</div>
</body>
</html>