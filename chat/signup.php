<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Page</title>
    <link rel="stylesheet" type="text/css" href="signup.css">
</head>
<body>
    <?php
    $showalert = false;
    $showError= false;
    include '_dbconnect.php';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email=$_POST["email"];
        $username = $_POST["username"];
        $password = $_POST["password"];

        //for checking password 
        $existSql = "SELECT * FROM `users` WHERE username = '$username' OR email = '$email'"; 
        $result = mysqli_query($conn, $existSql);
        $numExistRows = mysqli_num_rows($result);
        if($numExistRows > 0){
            // $exists = true;
            $showError = "Username or Email Already Exists";
        }
       else{
        // You should hash the password before storing it in the database for security.
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO `users` (`username`,  `email`,`password`) VALUES ('$username', '$email','$password' )";
        $result = mysqli_query($conn, $sql);

        if($result) {
            $showalert = true;
        
        } else {
            echo "Error: " . mysqli_error($conn);
        }
            }

    }
    ?>
      <?php
     if($showalert){
    echo'<div class="alert" role="alert">
    <strong>Success!</strong> Your account is now created and you can login
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>';
    }
    if($showError){
        echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> '. $showError.'
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div> ';
        }
     ?>
    <div class="container">
        <h2>SIGNUP</h2>
        <form action="signup.php" method="post">
        <div class="input-container">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required
                pattern="[a-zA-Z0-9._%+-]+@desu\.ac\.in$"
                title="Please enter a valid email address ending with @desu.ac.in">
            </div>
            <div class="input-container">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-container">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Sign Up</button>
        </form>
        <a class="login" href="login.php"><button style="margin-top: 10px;"  type="link">Login</button></a>
        <div class="reset-password">
            <a href="reset_password.php">Forgot your password?</a>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  
</body>
</html>
