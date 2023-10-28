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
<html lang="en">
<head>
    <!-- Your head content goes here -->
    <title>Your Website</title>
    <link rel="stylesheet" type="text/css" href="main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>
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

    <main>
        <!-- Your main content goes here -->
    </main>

    <script>
        function toggleMenu() {
            const nav = document.getElementById("nav");
            nav.classList.toggle("expanded");
        }
    </script>
</body>
</html>
