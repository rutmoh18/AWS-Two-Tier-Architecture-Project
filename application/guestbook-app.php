<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "DB Server Private IP";   // DB Server Private IP
$username = "Ritik";            
$password = "Ritik@123";        
$dbname = "myDatabase";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $message = $_POST["message"];
    $sql = "INSERT INTO guestbook (name, message) VALUES ('$name', '$message')";
    $conn->query($sql);
}

$result = $conn->query("SELECT * FROM guestbook ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>AWS Cloud Guestbook</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        .container {
            width: 60%;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        label {
            font-weight: bold;
        }

        input, textarea {
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            margin-bottom: 15px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        input[type="submit"] {
            background: #667eea;
            color: white;
            border: none;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s ease;
        }

        input[type="submit"]:hover {
            background: #764ba2;
        }

        .message-box {
            background: #f4f4f4;
            padding: 15px;
            margin-top: 15px;
            border-radius: 10px;
            border-left: 5px solid #667eea;
        }

        .message-box strong {
            color: #764ba2;
        }

        footer {
            text-align: center;
            margin-top: 30px;
            color: #666;
            font-size: 13px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>🚀 AWS Cloud Guestbook</h2>

    <form method="POST">
        <label>Name</label>
        <input type="text" name="name" required>

        <label>Message</label>
        <textarea name="message" rows="4" required></textarea>

        <input type="submit" value="Submit Message">
    </form>

    <h3>🌟 Recent Messages</h3>

    <?php
    while($row = $result->fetch_assoc()) {
        echo "<div class='message-box'>";
        echo "<strong>" . htmlspecialchars($row["name"]) . "</strong><br>";
        echo htmlspecialchars($row["message"]);
        echo "</div>";
    }
    ?>

    <footer>
        Deployed on AWS EC2 | Two-Tier Architecture | DevOps Project
    </footer>
</div>

</body>
</html>
