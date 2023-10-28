<?php
// Check if the queryId parameter is set
if (isset($_GET['id'])) {
    // Get the queryId from the URL parameter
    $queryId = $_GET['id'];

    // Establish a database connection
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'query';

    $conn = mysqli_connect($servername, $username, $password, $database);
    if (!$conn) {
        die("Sorry, we failed to connect: " . mysqli_connect_error());
    }

    // Prepare and execute a DELETE SQL query
    $sql = "DELETE FROM querys WHERE no = $queryId";
    if (mysqli_query($conn, $sql)) {
        // Query deleted successfully
        header("Location: query.php");
    } else {
        // Error occurred while deleting
        echo "Error: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    // Redirect to an error page if the queryId parameter is not set
    header("Location: query.php");
    exit(); // Stop script execution
}
?>
