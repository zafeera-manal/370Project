<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Emails</title>
    <style>
        /* Your CSS styles here */
        @import url('https://fonts.googleapis.com/css2?family=Domine:wght@400..700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap');

        * {  
            box-sizing: border-box;
            font-family: "Domine", serif;
        }
        body {
            background-color: #c1e6a4;
            margin: 0;
            padding: 0;
        }

        .container {
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .btn-bold {
            font-weight: bold;
            margin-bottom: 20px;
        }

        .status-message {
            margin-top: 20px;
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
            color: white;
        }
    </style>
</head>
<body style="background-color: #c1e6a4;"> <!-- Add inline style to set background color -->
    <div class="navbar">
        <div></div>
        <div>
            <a href="inventory.php">Inventory</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>
    <div class="container">
        <?php
        // PHP code here
        require 'vendor/autoload.php'; // DOING THIS TO Include Guzzle library

        use GuzzleHttp\Client;

        // Function to send email using Mailjet
        function sendEmail($to, $subject, $message) {
            $mjApiKey = 'dca2eb42ac0d16902609d3c433b96533';
            $mjApiSecret = '39c8a9edeb4be9af079549073fca0787';

            $client = new Client([
                'base_uri' => 'https://api.mailjet.com/v3.1/',
                'auth' => [$mjApiKey, $mjApiSecret],
                'headers' => [
                    'Content-Type' => 'application/json',
                ]
            ]);

            $response = $client->post('send', [
                'json' => [
                    'Messages' => [
                        [
                            'From' => [
                                'Email' => 'fitstudio34@gmail.com',
                                'Name' => 'FitStudio',
                            ],
                            'To' => [
                                [
                                    'Email' => $to,
                                    'Name' => 'Recipient',
                                ],
                            ],
                            'Subject' => $subject,
                            'TextPart' => $message,
                        ],
                    ],
                ],
            ]);

            return $response->getStatusCode();
        }

        //Check if emails have already been sent today
        function emailsAlreadySentToday() {
            $lastSubmission = isset($_COOKIE['last_submission']) ? $_COOKIE['last_submission'] : null;
            return $lastSubmission === date('Y-m-d');
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            if (emailsAlreadySentToday()) {
                echo "<p class='status-message'>Emails have already been sent today.</p>";
            } else {
                
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "fitstudio";

                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Query to select admin email SECOND ONE
                $sql_admin = "SELECT a_email FROM Admin LIMIT 1,1";
                $result_admin = $conn->query($sql_admin);

                if ($result_admin->num_rows > 0) {
                    $row_admin = $result_admin->fetch_assoc();
                    $admin_email = $row_admin["a_email"];
                } else {
                    echo "<p class='status-message'>Admin email not found!</p>";
                    exit;
                }

                // Query to select member emails
                $sql_members = "SELECT email FROM member_details_2";
                $result_members = $conn->query($sql_members);

                if ($result_members->num_rows > 0) {
                    while ($row_member = $result_members->fetch_assoc()) {
                        $member_email = $row_member["email"];

                        // Subject and message
                        $subject = "NotifyMe: Your Personal Alert System for FitStudio!";
                        $message = trim("Hey! Don't forget your workout session today.
It's time to sweat it out and make progress towards your fitness goals.
Whether it's lifting weights, going for a run, or doing some yoga, remember: every little effort counts!
You got this 💪 #FitnessGoals");

                        // Sending email to each member
                        sendEmail($member_email, $subject, $message);

                        
                        $sql_notify = "INSERT INTO notifies (supervisor_ad_email, mem_email, message, sent_time) VALUES ('$admin_email', '$member_email', '$subject', NOW())";

                        if ($conn->query($sql_notify) === FALSE) {
                            echo "<p class='status-message'>Error: " . $sql_notify . "<br>" . $conn->error . "</p>";
                        }
                    }
                    echo "<p class='status-message'>Emails sent successfully!</p>";

                    //COOKIE to indicate that emails have been sent today
                    setcookie('last_submission', date('Y-m-d'), strtotime('tomorrow'));
                } else {
                    echo "<p class='status-message'>No member emails found!</p>";
                }

                $conn->close();
            }
        }
        ?>
        <form method="post">
            <input class="btn-bold" type="submit" value="Send Emails">
        </form>
    </div>
</body>
</html>