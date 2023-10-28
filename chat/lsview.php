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
    <title>View Lost and Found Data</title>
    <!-- Link to your external CSS file or include inline styles here -->
    <link rel="stylesheet" type="text/css" href="lsview.css">
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
        <h1>Lost and Found Data</h1>
    </header>

    <section class="lost-section">
        <h2>Lost Items</h2>
        <div id="lost-items-list">
            <!-- Lost item data will be displayed here -->
            <?php
            // PHP code to fetch and display lost item data
            // Include your database connection code
            
            $servername = 'localhost';
            $username = 'root';
            $password = '';
            $database = 'lost_and_found_db';
            
            $conn = mysqli_connect($servername, $username, $password, $database);
            if (!$conn){
                die("Sorry we failed to connect: ". mysqli_connect_error());
            }

            $sql = "SELECT * FROM lost_items";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $imageWidth = 200; // Set your desired width in pixels
                    $imageHeight = 150;
                    echo '
                        <div class="item">
                            <h3>' . $row["item_name"] . '</h3>
                            <p>' . $row["item_description"] . '</p>
                            <img src="' . $row["image_path"] . '" alt="' . $row["item_name"] . '" width="' . $imageWidth . '" height="' . $imageHeight . '">
                            <button onclick="deleteItem(' . $row["id"] . ')">Delete</button>
                        </div>
                    ';
                }
            } else {
                echo "No lost items found.";
            }

            $conn->close(); // Close the database connection
            ?>
        </div>
    </section>

    <section class="found-section">
        <h2>Found Items</h2>
        <div id="found-items-list">
            <!-- Found item data will be displayed here -->
            <?php
            // PHP code to fetch and display found item data
             // Include your database connection code
             $servername = 'localhost';
             $username = 'root';
             $password = '';
             $database = 'lost_and_found_db';
             
             $conn = mysqli_connect($servername, $username, $password, $database);
             if (!$conn){
                 die("Sorry we failed to connect: ". mysqli_connect_error());
             }

            $sql = "SELECT * FROM found_items";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $imageWidth = 200; // Set your desired width in pixels
                    $imageHeight = 150;
                    echo '
                        <div class="item">
                            <h3>' . $row["item_name"] . '</h3>
                            <p>' . $row["item_description"] . '</p>
                            <img src="' . $row["image_path"] . '" alt="' . $row["item_name"] .'" width="' . $imageWidth . '" height="' . $imageHeight . '">
                            <button onclick="deleteItem(' . $row["id"] . ')">Delete</button>
                        </div>
                    ';
                }
            } else {
                echo "No found items found.";
            }

            $conn->close(); // Close the database connection
            ?>
        </div>
    </section>

    <footer>
        <!-- Add footer content if needed -->
    </footer>

    <script>
        function deleteItem(itemId) {
            // Use JavaScript to confirm the deletion
            if (confirm("Are you sure you want to delete this item?")) {
                // Redirect to the PHP script that handles deletion
                window.location.href = "delete_item.php?id=" + itemId;
            }
        }
    </script>
</body>
</html>
