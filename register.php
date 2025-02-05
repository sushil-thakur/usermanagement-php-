<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (first_name, last_name, email, phone, password) VALUES ('$first_name', '$last_name', '$email', '$phone', '$password')";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: login.php");
        exit();
    } else {
        echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<header class="bg-dark text-white p-3">
        <nav class="navbar navbar-expand-lg navbar-dark">
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
        </nav>
</header>

<main class="container mt-5">
<form action="" method="POST">
   <h2>Create an Account</h2>

   <div class="form-group">
       <label for="first_name">First Name:</label>
       <input type="text" id="first_name" name="first_name" class="form-control" required>
   </div>

   <div class="form-group">
       <label for="last_name">Last Name:</label>
       <input type="text" id="last_name" name="last_name" class="form-control" required>
   </div>

   <div class="form-group">
       <label for="email">Email:</label>
       <input type="email" id="email" name="email" class="form-control" required>
   </div>

   <div class="form-group">
       <label for="phone">Phone Number:</label>
       <input type="text" id="phone" name="phone" class="form-control">
   </div>

   <div class="form-group">
       <label for="password">Password:</label>
       <input type="password" id="password" name="password" class="form-control" required>
   </div>

   <button type="submit" class='btn btn-primary'>Register</button>
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
