<?php
// Start a new session or resume the existing session
session_start();

// Check if the user is logged in (you can use a more secure method for authentication)
if (!isset($_SESSION['user'])) {
    // Redirect the user to the login page if not logged in
    header("Location: login.php"); // Replace 'login.php' with your actual login page
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ask Query</title>
    <link rel="stylesheet" type="text/css" href="aa.css">
    <link rel="stylesheet" type="text/css" href="main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>
<ul>
        <header class="head">
            <div class="navbar">
                <h1>DSEU STUDENTS</h1>
                <div class="menu-icon" onclick="toggleMenu()">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
                <ul class="nav" id="nav">
                    <li><a  href="main.php"><i class="fa-solid fa-house-laptop"></i></a></li>
                    <li><a href="chat.php">Chat</a></li>
                    <li><a href="lostfound.php">Report Lost and Found</a></li>
                    <li><a href="lsview.php">View Lost and Found</a></li>
                    <li><a href="askadmin.php">Ask Question</a></li>
                    <li><a href="query.php">Querys</a></li>
                    <li><a href="lgout.php">Logout</a></li>
                </ul>
            </div>
        </header>
    <div class="container">
        <h2>Query Panel</h2>
        <form action="askadmin.php" method="post">
            <label for="query">Ask a Query:</label>
            <textarea id="query" name="query" required></textarea>
            <button type="submit">Submit</button>
        </form>
    </div>
    <?php
        $servername = 'localhost';
        $username = 'root';
        $password = '';
        $database = 'query';
        
        $conn = mysqli_connect($servername, $username, $password, $database);
        if (!$conn){
            die("Sorry we failed to connect: ". mysqli_connect_error());
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $query = $_POST["query"];

            $sql = "INSERT INTO querys (query) VALUES ('$query')";
             $result = mysqli_query($conn, $sql);
             $userID = $_SESSION['user'];
           

        if($result) {
            header("location: query.php");
        
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
        ?>   
</body>
</html>