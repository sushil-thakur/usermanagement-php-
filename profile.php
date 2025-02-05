<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    // Delete user profile logic
    $sql = "DELETE FROM users WHERE id='$user_id'";
    
    if ($conn->query($sql) === TRUE) {
        // Optionally, you can also delete the profile image from the server
        $sql_select = "SELECT profile_image FROM users WHERE id='$user_id'";
        $result = $conn->query($sql_select);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (!empty($row['profile_image'])) {
                unlink($row['profile_image']); // Delete image from server
            }
        }
        session_destroy(); // Destroy session after deletion
        header("Location: index.php"); // Redirect to homepage after deletion
        exit();
    } else {
        echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Profile image handling
    $profile_image = $_FILES['profile_image']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($profile_image);
    $uploadOk = 1;

    // Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["profile_image"]["tmp_name"]);
        if ($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "<div class='alert alert-danger'>File is not an image.</div>";
            $uploadOk = 0;
        }
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "<div class='alert alert-danger'>Sorry, file already exists.</div>";
        $uploadOk = 0;
    }

    // Check file size (limit to 2MB)
    if ($_FILES["profile_image"]["size"] > 2000000) {
        echo "<div class='alert alert-danger'>Sorry, your file is too large.</div>";
        $uploadOk = 0;
    }

    // Allow certain file formats
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "<div class='alert alert-danger'>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</div>";
        $uploadOk = 0;
    }

    // Check if everything is ok and upload file
    if ($uploadOk == 1) {
        // If a new file is uploaded, move it to the uploads directory
        if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
            // Update user information in the database including profile image path
            $sql = "UPDATE users SET first_name='$first_name', last_name='$last_name', email='$email', phone='$phone', profile_image='$target_file' WHERE id='$user_id'";
            
            if ($conn->query($sql) === TRUE) {
                echo "<div class='alert alert-success'>Profile updated successfully!</div>";
            } else {
                echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Sorry, there was an error uploading your file.</div>";
        }
    }
}
// Fetch user data from database
$sql = "SELECT * FROM users WHERE id='$user_id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang='en'>
<head> 
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Your Profile</title>
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
   <style>
       .profile-image-nav {
           width: 40px;
           height: 40px;
           border-radius: 50%;
           object-fit: cover;
           margin-left: 15px;
       }
       .profile-image-dropdown {
           cursor: pointer;
       }
       .image-preview {
           max-width: 150px;
           height: auto;
           border-radius: 50%;
           margin: 10px 0;
       }
   </style>
</head>

<body>

<header class='bg-dark text-white p-3'>
      <nav class="navbar navbar-expand-lg navbar-dark">
          <a class="navbar-brand" href="#">Simple Website</a>
          <div class="collapse navbar-collapse">
              <ul class="navbar-nav mr-auto">
                  <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                  <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                  <li class="nav-item"><a class="nav-link" href="register.php">Signup</a></li>
                  <li class="nav-item"><a class="nav-link" href="profile.php">Profile</a></li>
              </ul>
              <div class="dropdown">
                  <img src="<?php echo !empty($user['profile_image']) ? htmlspecialchars($user['profile_image']) : 'uploads/default-avatar.png'; ?>" 
                       alt="Profile" 
                       class="profile-image-nav profile-image-dropdown"
                       data-toggle="dropdown">
                  <div class="dropdown-menu dropdown-menu-right">
                      <a class="dropdown-item" href="update_image.php">Update Profile Picture</a>
                      <a class="dropdown-item" href="profile.php">Edit Profile</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="logout.php">Logout</a>
                  </div>
              </div>
          </div>
      </nav>
</header>

<main class='container mt-5'>
<div class="row">
    <div class="col-md-8">
        <form action='' method='POST' enctype='multipart/form-data'>
            <h2>Your Profile</h2>

            <div class='form-group'>
                <label for='first_name'>First Name:</label>
                <input type='text' id='first_name' name='first_name' value='<?php echo htmlspecialchars($user['first_name']); ?>' class='form-control' required/>
            </div>

            <div class='form-group'>
                <label for='last_name'>Last Name:</label>
                <input type='text' id='last_name' name='last_name' value='<?php echo htmlspecialchars($user['last_name']); ?>' class='form-control' required/>
            </div>

            <div class='form-group'>
                <label for='email'>Email:</label>
                <input type='email' id='email' name='email' value='<?php echo htmlspecialchars($user['email']); ?>' class='form-control' required/>
            </div>

            <div class='form-group'>
                <label for='phone'>Phone Number:</label>
                <input type='text' id='phone' name='phone' value='<?php echo htmlspecialchars($user['phone']); ?>' class='form-control'/>
            </div>

            <button type='submit' name="update" class='btn btn-primary'>Update Profile</button>
            <button type='submit' name="delete" onclick="return confirm('Are you sure you want to delete your profile? This action cannot be undone.');" class='btn btn-danger'>Delete Profile</button>
        </form>
    </div>
    
    <div class="col-md-4 text-center">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Profile Picture</h5>
                <img src="<?php echo !empty($user['profile_image']) ? htmlspecialchars($user['profile_image']) : 'uploads/default-avatar.png'; ?>" 
                     alt="Profile Picture" 
                     class="img-fluid rounded-circle mb-3"
                     style="width: 200px; height: 200px; object-fit: cover;">
                <a href="update_image.php" class="btn btn-primary">Update Profile Picture</a>
            </div>
        </div>
    </div>
</div>
</main>

<footer class='text-center mt-5 p-3 bg-dark text-white'>
    <p>&copy; 2025 Simple Website</p>
</footer>

<script src='https://code.jquery.com/jquery-3.5.1.slim.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js'></script>
<script src='https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js'></script>

</body>
</html>