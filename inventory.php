<!DOCTYPE html>
<html>
<head>
    <title>Inventory</title>
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
        .item {
            margin-bottom: 20px;
        }
        table {
            width: 50%;
            margin: auto;
            margin-top: 150px;
            
        }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 8px;
        }
        .buy-button {
            font-weight: bold;
        }
        .navbar {
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
            color: white;
        }
    </style>
</head>
<body>

<div class="navbar">
<div></div>
<div>
    <a href="admin_reg2.php">Register new admin</a>
    <a href="snd.php">Send Notifications to Members</a>
    <a href="logout.php">Logout</a>
</div>
</div>

<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fitstudio";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT * FROM Inventory";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<div class='item'>";
    echo "<table>";
    echo "<tr><th>Equipment Name</th><th>Quantity</th></tr>";
    
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["equipment_name"] . "</td>";
        echo "<td>" . $row["quantity"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";

    echo "<form action='manages.php' method='post'>";
    
    $result->data_seek(0); 
    while($row = $result->fetch_assoc()) {
        echo "<input type='hidden' name='equipment_name[]' value='" . $row["equipment_name"] . "'>";
    }
    echo "<input type='submit' value='Buy From Supplier' class='buy-button'>";
    echo "</form>";
} else {
    echo "0 results";
}
$conn->close();
?>

</body>
</html>


