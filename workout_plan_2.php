<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workout Plan</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Domine:wght@400..700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap');

        *{  
        margin: 10px 0;
        
        box-sizing: border-box;
        font-family: "Domine", serif;
        font-size: 16px;
        }   

        body{
        background-color: #d1c5e1;
        min-height: 100vh;
        align-items: center;
        justify-content: center;
        margin-left: 20px;
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
        font-weight: bold;
        }
        .nav-bar a:hover {
            background-color: #d1c5e1;
            text-decoration: underline;
            color: white;
        }

        .plan-id-form{
            background-color: #ECD5E3;
            padding: 120px 40px;
            justify-content: center;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            box-align: center;
            width: 400px;
            margin: 20px 550px;
            margin-top: 40px;
            text-align: center;
        }
        .article {
            background: #ECD5E3;
            margin-top: 50px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        .article a {
            font-size: 20px;
            font-weight: bold;
            text-decoration: none; 
        }
        .article a:hover {
            text-decoration: underline; /*underline on hover */
        }
        .article-preview {
            font-size: 16px;
            overflow: hidden;
            text-wrap: wrap;
            
        }
        .diet-chart {
            font-size: 30px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
            
        }
        .diet-title {
            font-size: 30px;
            margin-bottom: 20px;
            text-align: center;
        }
        .meal {
            font-size: 20px;
            display: flex;
            justify-content: center;
        }
    </style>
</head>
<body>

<div class="nav-bar">
    <div></div> 
    <div>
        <a href="dashboard.php">Home</a>
        <a href="workout_plan_2.php">Diet Plan</a>
        <a href="logout.php">Logout</a>
        
    </div>
</div>

<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php"); //session not set
    exit;
}
$loggedin_username = $_SESSION["username"];
require_once('dbconnect.php');

$showForm = true; //flag to hide form when not needed

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $plan_id = $_POST["plan_id"];
    $member_name = $_POST["member_name"];
    if ($loggedin_username !== $member_name) {
        echo "Invalid username! Please enter your own username.";
        //exit; // To stop further processing
    }
    else{

    // Checking if the member username exists in the purchases table
    $check_username_sql = "SELECT COUNT(*) AS count FROM Purchases WHERE customer_username = '$member_name'";
    $username_result = $conn->query($check_username_sql);
    $username_row = $username_result->fetch_assoc();
    $username_count = $username_row["count"];

    if ($username_count > 0) {
        
        $check_purchase_sql = "SELECT COUNT(*) AS count FROM Purchases WHERE wplan_id = $plan_id AND customer_username = '$member_name'";
        $purchase_result = $conn->query($check_purchase_sql); // Checking if the member has purchased the specified plan

        $purchase_row = $purchase_result->fetch_assoc();
        $purchase_count = $purchase_row["count"];

        if ($purchase_count > 0) {
    
            if ($plan_id == 1 || $plan_id == 2) {
                
                $article_sql = "SELECT article_links FROM Workout_plan_2 WHERE plan_id = $plan_id";  // Fetching article from the database based on plan ID
                $article_result = $conn->query($article_sql);

                if ($article_result->num_rows > 0) {
        
                    while ($article_row = $article_result->fetch_assoc()) {
                        $article_link = $article_row["article_links"]; // Output articles of each row
                        
                        if ($article_link !== NULL) { //if article link is not NULL
                            $article_preview = getArticlePreview($article_link);
                            $article_title = getArticleTitle($article_link);
                            echo "<div class='article'>";
                            echo "<a href='$article_link' target='_blank'>$article_title</a>";
                            echo "<p class='article-preview'>$article_preview</p>";
                            echo "</div>";
                        } else {
                            //echo "<p>No article link found</p>";
                        }
                    }
                } else {
                    echo "<p>No articles found for Plan ID $plan_id</p>";
                }
                
                //diet chart from the database based on plan ID
                $diet_sql = "SELECT meal_plan FROM Workout_plan_2 WHERE plan_id= $plan_id";
                $diet_result = $conn->query($diet_sql);

                if ($diet_result->num_rows > 0) {
                    echo "<div class='diet-chart'>";
                    echo "<h2 class='diet-title'>"."Diet Chart" . "</h2>";
                    while ($diet_row = $diet_result->fetch_assoc()) {
                        echo "<p class='meal'>" . nl2br($diet_row["meal_plan"]) . "</p>";
                    }echo "</div>";
                } else {
                    echo "<p>No diet chart found for Plan ID $plan_id</p>";
                }

                
                $showForm = false; //hiding the form
            } else {
                echo "<p>Invalid Plan ID</p>";
            }
        } else {
            echo "<p>You haven't purchased Plan ID $plan_id. Please purchase the plan to access its workout and diet information.</p>";
        }
    } else {
        echo "<p>Wrong username! '$member_name' has not purchased any plans.</p>";
    }
}
}
// Display the form if necessary
if ($showForm) {
?>
<div class=plan-id-form>
<form method="post">
    <label for="plan_id">Select Plan ID:</label>
    <select name="plan_id" id="plan_id" required>
        <option value="" selected>Select your plan id</option>
        <option value="1">Plan 1</option>
        <option value="2">Plan 2</option>
    </select>
    <br>
    <label for="member_name">Enter Member Name: </label>
    <input type="text" name="member_name" id="member_name" placeholder="Enter your name" required>
    <br>
    <input type="submit" value="Submit">
</form>
</div>
<?php }  ?>

<?php
$conn->close();

function getArticlePreview($url)
{
    $html = file_get_contents($url);
    if ($html === false) {
        return "Error fetching article";
    }
    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML($html);
    $previewText = "";
    $paragraphs = $dom->getElementsByTagName('p');
    $word_count = 0;
    foreach ($paragraphs as $paragraph) {
        $words = str_word_count($paragraph->textContent);
        if ($word_count + $words > 200) { // Adjusting the word count limit for preview
            break;
        }
        $previewText .= $paragraph->textContent . " ";
        $word_count += $words;
    }
    return strlen($previewText) > 0 ? $previewText : "Preview not available";
}

function getArticleTitle($url)
{
    $html = file_get_contents($url);
    if ($html === false) {
        return "Error fetching title";
    }
    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML($html);
    $title = $dom->getElementsByTagName('title')->item(0)->textContent;
    return $title;
}
?>
</body>
</html>

