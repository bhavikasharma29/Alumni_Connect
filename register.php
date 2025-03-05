<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $batch = $_POST['batch'];
    $company = !empty($_POST['company']) ? $_POST['company'] : NULL;
    $linkedin = !empty($_POST['linkedin']) ? $_POST['linkedin'] : NULL;
    $bio = !empty($_POST['bio']) ? $_POST['bio'] : NULL;
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = 'alumni'; // Default role for registration
    
    $sql = "INSERT INTO users (role, name, email, password_hash, batch, company, linkedin, bio) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $role, $name, $email, $password, $batch, $company, $linkedin, $bio);
    
    if ($stmt->execute()) {
        $_SESSION['message'] = "Registration successful! Please login.";
        header("Location: login.php");
        exit();
    } else {
        $_SESSION['error'] = "Error: Could not register user.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Alumni Connect</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #FFC3A0, #FFAFBD);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .form-container {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }
        h2 {
            color: #444;
            margin-bottom: 1rem;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }
        button {
            background: #FF758C;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            font-size: 1rem;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }
        button:hover {
            background: #FF4B72;
        }
        p {
            margin-top: 1rem;
            font-size: 0.9rem;
        }
        a {
            color: #FF4B72;
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Register</h2>
        <?php if (isset($_SESSION['error'])) { echo "<p class='error'>" . $_SESSION['error'] . "</p>"; unset($_SESSION['error']); } ?>
        <form method="POST" action="">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="number" name="batch" placeholder="Graduation Year (e.g., 2020)" required>
            <input type="text" name="company" placeholder="Company Name (Optional)">
            <input type="url" name="linkedin" placeholder="LinkedIn Profile (Optional)">
            <textarea name="bio" placeholder="Tell us about yourself (Optional)"></textarea>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login</a></p>
    </div>
</body>
</html>
