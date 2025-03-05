<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include 'db.php';

$user_id = $_SESSION['user_id'];
$sql = "SELECT name, role, batch, company, linkedin, bio FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Alumni Connect</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #FFDEE9, #B5FFFC);
            margin: 0;
            padding: 0;
        }
        .navbar {
            background: #17B978;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
        }
        .profile-card {
            text-align: center;
            padding: 20px;
        }
        h2 {
            color: #444;
        }
        .bio {
            font-style: italic;
            color: #666;
        }
        .buttons {
            margin-top: 20px;
        }
        .btn {
            background: #FF9A8B;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 5px;
            transition: 0.3s;
        }
        .btn:hover {
            background: #D76D77;
        }
    </style>
</head>
<body>
    <div class="navbar">Alumni Connect Dashboard</div>
    <div class="container">
        <div class="profile-card">
            <h2>Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h2>
            <p><strong>Role:</strong> <?php echo htmlspecialchars($user['role']); ?></p>
            <p><strong>Batch:</strong> <?php echo htmlspecialchars($user['batch']); ?></p>
            <p><strong>Company:</strong> <?php echo htmlspecialchars($user['company']); ?></p>
            <p><strong>LinkedIn:</strong> <a href="<?php echo htmlspecialchars($user['linkedin']); ?>" target="_blank">Profile</a></p>
            <p class="bio">"<?php echo htmlspecialchars($user['bio']); ?>"</p>
            <div class="buttons">
                <button class="btn" onclick="location.href='profile.php'">Edit Profile</button>
                <button class="btn" onclick="location.href='logout.php'">Logout</button>
            </div>
        </div>
    </div>
</body>
</html>
