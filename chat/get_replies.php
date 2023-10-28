<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'query';

// Create a connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check if the connection was successful
if (!$conn) {
    die("Failed to connect to the database: " . mysqli_connect_error());
}

if (isset($_GET['query_id'])) {
    // Sanitize and validate the query_id
    $queryId = intval($_GET['query_id']);
    
    if ($queryId <= 0) {
        die("Invalid query_id provided.");
    }

    // Use prepared statements to prevent SQL injection
    $sql = "SELECT reply_text FROM replies WHERE query_id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $queryId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        if (!$result) {
            die("SQL Error: " . $conn->error);
        }

        $replies = array();
        while ($row = $result->fetch_assoc()) {
            $replies[] = $row;
        }

        // Check if there are replies
        if (count($replies) > 0) {
            echo json_encode($replies);
        } else {
            echo "No replies found for query_id $queryId.";
        }
    } else {
        die("Prepared statement error: " . $conn->error);
    }
} else {
    echo "No query_id provided.";
}

// Close the database connection
$conn->close();
?>
