<!DOCTYPE html>
<html>
<head>
    <title>Admin Verification</title>
    <style>
    
        @import url('https://fonts.googleapis.com/css2?family=Domine:wght@400..700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap');

        *{  
        box-sizing: border-box;
        font-family: "Domine", serif;
        }
        body {
            background: #c1e6a4;
            text-align: center;
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
        .container {width: 50%;
            margin: auto;
            margin-top: 150px;}
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
<h2>Admin Verification</h2>
<form action="" method="post">
    <label for="admin_email">Enter Admin Email:</label><br>
    <input type="email" id="admin_email" name="admin_email" required><br><br>
    <input type="submit" value="Verify">
</form>
</div>

</body>
</html>

<?php
// Proceed only if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['admin_email'])) {
    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "fitstudio";

    $conn = new mysqli($servername, $username, $password, $dbname);

    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve admin email from form
    $admin_email = $_POST['admin_email'];

    // Check if admin exists
    $sql_check_admin = "SELECT * FROM Admin WHERE a_email = '$admin_email'";
    $result_check_admin = $conn->query($sql_check_admin);

    if ($result_check_admin->num_rows > 0) {
        // Admin found ONLY  then proceed 
        echo "Admin email verified successfully!";
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Manage Inventory</title>
            <style>
                @import url('https://fonts.googleapis.com/css2?family=Domine:wght@400..700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap');

                *{  
                box-sizing: border-box;
                font-family: "Domine", serif;
                }
                body {
                    background: #c1e6a4;
                    text-align: center;
                }
                
            </style>
        </head>
        <body>


        <h2>Manage Inventory</h2>
        <form action="" method="post">
            <label for="equipment_name">Select Equipment Name:</label><br>
            <select id="equipment_name" name="equipment_name" required>
                <?php
                
                $sql_inventory = "SELECT equipment_name FROM Inventory";
                $result_inventory = $conn->query($sql_inventory);

                if ($result_inventory->num_rows > 0) {
                    while($row = $result_inventory->fetch_assoc()) {
                        echo "<option value='" . $row["equipment_name"] . "'>" . $row["equipment_name"] . "</option>";
                    }
                }
                ?>
            </select><br><br>
            <label for="quantity">Quantity:</label><br>
            <input type="number" id="quantity" name="quantity" value="1" min="1" required><br><br>
            <input type="hidden" name="admin_email" value="<?php echo $admin_email; ?>">
            <input type="submit" value="Submit">
        </form>

        </body>
        </html>
        <?php
    } else {
        
        echo "Admin email not found.";
    }

    // Proceed only if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['equipment_name'])) {
        // Retrieve form data
        $equipment_name = $_POST['equipment_name'];
        $quantity = $_POST['quantity'];

        // Check if admin exists (additional validation)
        $sql_check_admin = "SELECT * FROM Admin WHERE a_email = '$admin_email'";
        $result_check_admin = $conn->query($sql_check_admin);

        if ($result_check_admin->num_rows > 0) {
            
            $today_date = date("Y-m-d");
            $sql_check_managed = "SELECT * FROM Manages WHERE ad_email = '$admin_email' AND in_equipment_name = '$equipment_name' AND purchased_date = '$today_date'";
            $result_check_managed = $conn->query($sql_check_managed);

            if ($result_check_managed->num_rows == 0) {
                
                $sql_insert_managed = "INSERT INTO Manages (ad_email, in_equipment_name, purchased_date, purchased_quantity) VALUES ('$admin_email', '$equipment_name', '$today_date', '$quantity')";
                if ($conn->query($sql_insert_managed) === TRUE) {
                    
                    $sql_update_inventory = "UPDATE Inventory SET quantity = quantity + '$quantity' WHERE equipment_name = '$equipment_name'";
                    if ($conn->query($sql_update_inventory) === TRUE) {
                        echo "Inventory adjusted successfully.";
                    } else {
                        echo "Error updating inventory: " . $conn->error;
                    }
                } else {
                    echo "Error: " . $sql_insert_managed . "<br>" . $conn->error;
                }
            } else {
                echo "This type of equipment has already been managed today.";
            }
        } else {
            echo "Admin email not found.";
        }
    }

    $conn->close();
}
?>
