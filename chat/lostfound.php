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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lost and Found</title>
    <link rel="stylesheet" type="text/css" href="lostfound.css">
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
    <header>
        <h1>Lost and Found</h1>
    </header>

    <section class="lost-section">
        <h2>Report a Lost Item</h2>
        <form id="lost-form" enctype="multipart/form-data" method="post" action="lostfound.php">
            <div>
                <label for="lost-item-name">Item Name:</label>
                <input type="text" id="lost-item-name" name="lost-item-name" required>
            </div>
            <div>
                <label for="lost-item-description">Description:</label>
                <textarea id="lost-item-description" name="lost-item-description" required></textarea>
            </div>
            <div>
                <label for="lost-item-image">Upload an Image:</label>
                <input type="file" id="lost-item-image" name="lost-item-image" accept="image/*" required>
            </div>
            <div>
                <button type="submit">Report Lost Item</button>
            </div>
        </form>
    </section>

    <section class="found-section">
        <h2>Report a Found Item</h2>
        <form id="found-form" enctype="multipart/form-data" method="post" action="lostfound.php">
            <div>
                <label for="found-item-name">Item Name:</label>
                <input type="text" id="found-item-name" name="found-item-name" required>
            </div>
            <div>
                <label for="found-item-description">Description:</label>
                <textarea id="found-item-description" name="found-item-description" required></textarea>
            </div>
            <div>
                <label for="found-item-image">Upload an Image:</label>
                <input type="file" id="found-item-image" name="found-item-image" accept="image/*" required>
            </div>
            <div>
                <button type="submit">Report Found Item</button>
            </div>
        </form>
    </section>
</body>
<?php
// Include your database connection code
$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'lost_and_found_db';
$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn){
    die("Sorry, we failed to connect: " . mysqli_connect_error());
}

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $itemName =  $_POST['lost-item-name'];
    $itemDescription = $_POST['lost-item-description'];


    // File upload handling
    $filename = $_FILES["lost-item-image"]["name"];
    $tempname = $_FILES["lost-item-image"]["tmp_name"];
    $folder = "lost/" . $filename;

    if (move_uploaded_file($tempname, $folder)) {
        // File uploaded successfully, insert data into the database
        $sql = "INSERT INTO lost_items (`item_name`, `item_description`, `image_path`) VALUES ('$itemName', '$itemDescription', '$folder')";
        $data = mysqli_query($conn, $sql);
        if ($data) {
            // Data inserted successfully
            header("Location: lsview.php"); // Redirect to the view page
            exit();
        } else {
            echo "Error inserting data into the database: " . mysqli_error($conn);
        }
    } else {
        echo "Error uploading the file.";
    }
}
  if  ($_SERVER["REQUEST_METHOD"] == "POST"){
    $itemName = $_POST['found-item-name'];
    $itemDescription = $_POST['found-item-description'];

    // File upload handling
    $filename = $_FILES["found-item-image"]["name"];
    $tempname = $_FILES["found-item-image"]["tmp_name"];
    $folder = "found/" . $filename;

    if (move_uploaded_file($tempname, $folder)) {
        // File uploaded successfully, insert data into the database
        $sql = "INSERT INTO `found_items` (`item_name`, `item_description`, `image_path`) VALUES ('$itemName', '$itemDescription', '$folder')";
        $data = mysqli_query($conn, $sql);
        
        if ($data) {
            // Data inserted successfully
            header("Location: lsview.php"); // Redirect to the view page
            exit();
        } else {
            echo "Error inserting data into the database: " . mysqli_error($conn);
        }
    } else {
        echo "Error uploading the file.";
    }
}
$conn->close();
?>

</html>
