<?php
include 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            header("Location: profile.php");
            exit();
        } else {
            echo "<div class='alert alert-danger'>Invalid password.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>No user found with that email.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang='en'>
<head> 
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>

<header class='bg-dark text-white p-3'>
<nav class="navbar navbar-expand-lg navbar-dark">
            <a class="navbar-brand" href="#">User Management</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="register.php">Signup</a></li>
                    <li class="nav-item"><a class="nav-link" href="profile.php">Profile</a></li>
                </ul>
            </div>
        </nav>
</header>

<main class='container mt-5'>
<form action='' method='POST'>
   <h2>Login to Your Account</h2>

   <div class='form-group'>
       <label for='email'>Email:</label><br/>
       <input type='email' id='email' name='email' class='form-control' required/>
   </div>

   <div class='form-group'>
       <label for='password'>Password:</label><br/>
       <input type='password' id='password' name='password' class='form-control' required/>
   </div>

   <button type='submit' class='btn btn-primary'>Login</button>
</form> 
</main> 

<footer class='text-center mt-5 p-3 bg-dark text-white'>
<footer class="text-center mt-5 p-3 bg-dark text-white">
        <p>&copy; 2025 User Management</p>
    </footer>
</footer> 

<script src='https://code.jquery.com/jquery-3.5.1.slim.min.js'></script> 
<script src='https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js'></script> 
<script src='https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js'></script> 

</body> 
</html> 
