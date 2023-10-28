<?php
// Include your database connection code here
$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'lost_and_found_db';

$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn){
    die("Sorry we failed to connect: ". mysqli_connect_error());
}

if (isset($_GET['id'])) {
    $itemId = $_GET['id'];

    // Prepare and execute the SQL query to delete the item
    $sql = "DELETE FROM lost_items WHERE id = $itemId";
     // Modify table name if needed
    if (mysqli_query($conn, $sql)) {
        header("Location: lsview.php");
    } else {
        echo "Error deleting item: " . mysqli_error($conn);
    }
}

$conn->close(); // Close the database connection
?>
<?php
// Include your database connection code here
$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'lost_and_found_db';

$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn){
    die("Sorry we failed to connect: ". mysqli_connect_error());
}

if (isset($_GET['id'])) {
    $itemId = $_GET['id'];

    // Prepare and execute the SQL query to delete the item
    $sql = "DELETE FROM found_items WHERE id = $itemId"; // Modify table name if needed
    if (mysqli_query($conn, $sql)) {
        header("Location: lsview.php");
    } else {
        echo "Error deleting item: " . mysqli_error($conn);
    }
}

$conn->close(); // Close the database connection
?>

