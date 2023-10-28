<?php
// Start a new session or resume the existing session
session_start();
// Check if the user is logged in (you can use a more secure method for authentication)
if (!isset($_SESSION['user'])) {
    // Redirect the user to the login page if not logged in
    header("Location: login.php"); // Replace 'login.php' with your actual login page
    exit();
}


// Retrieve the user's ID from the session

// Rest of your code...
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Query Page</title>
    <link rel="stylesheet" type="text/css" href="query.css">
    <link rel="stylesheet" type="text/css" href="main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body><ul>
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
        <h2>Queries</h2>
        <ul>
            <?php
            // Read and display queries from the database
            $servername = 'localhost';
            $username = 'root';
            $password = '';
            $database = 'query'; // Change this to your actual database name
            
            // Connect to the database
            $conn = mysqli_connect($servername, $username, $password, $database);
            if (!$conn) {
                die("Sorry, we failed to connect: " . mysqli_connect_error());
            }

            $sql = "SELECT * FROM querys";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $queryId = $row["no"];
                    $editScript = "editQuery(" . $queryId . ")"; // JavaScript edit script
                    echo '
                        <div class="query">
                         <h2>' . $queryId . '</h2>
                            <h3>' . $row["query"] . '</h3>';
                    
                        // User can edit and delete their own query
                        echo '
                            <button onclick="' . $editScript . '">Edit</button>
                            <button onclick="deleteQuery(' . $queryId . ')">Delete</button>';
                        echo '<button onclick="toggleReplyForm(' . $queryId . ')">Reply</button>';

                    echo '
                        <div id="replyForm-' . $queryId . '" style="display:none;">
                            <form id="form-' . $queryId . '" method="post">
                                <input type="text" name="reply" id="reply-' . $queryId . '" placeholder="Reply...">
                                <input type="hidden" name="query_id" value="' . $queryId . '">
                                <button type="submit">Submit</button>
                            </form>
                        </div>
                        <div id="replies-' . $queryId . '">';

                    // Fetch and display replies for this query
                    $sqlReplies = "SELECT * FROM replies WHERE query_id = $queryId";
                    $resultReplies = $conn->query($sqlReplies);
                    while ($rowReply = $resultReplies->fetch_assoc()) {
                        echo '<p>' . $rowReply["reply_text"] . '</p>';
                    }
            
                    echo '</div>
                        </div>';
                }
            } else {
                echo "No queries found.";
            }
            
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST['reply']) && isset($_POST['query_id'])) {
                    $replyText = $_POST['reply'];
                    $queryId = $_POST['query_id'];

                    // Insert the reply into the database
                    $sql = "INSERT INTO replies (query_id, reply_text) VALUES ($queryId, '$replyText')";
                    $result = $conn->query($sql);
                    if ($result) {
                        // Reply successfully inserted into the database
                    } else {
                        echo "Error inserting reply into the database: " . mysqli_error($conn);
                    }
                }
            }
            ?>
        </ul>
    </div>
        
    <script>
        function editQuery(queryId) {
            // Redirect to the edit_query.php page with the queryId parameter
            window.location.href = "edit_query.php?id=" + queryId;
        }

        function deleteQuery(queryId) {
            // Implement the delete functionality using JavaScript or make an AJAX request
            // You can also redirect to a delete_query.php script with the queryId as a parameter
            // and handle the delete operation on the server-side.
            const result = confirm("Do you really want to delete?");

            if (result == true) {
                window.location.href = "delete_query.php?id=" + queryId;
            } else {
                window.location.href = "query.php";
            }
        }

        function toggleReplyForm(queryId) {
            // Toggle the reply form visibility
            const replyForm = document.getElementById("replyForm-" + queryId);
            replyForm.style.display = replyForm.style.display === "none" ? "block" : "none";
        }

        function showReplies(queryId) {
            const repliesDiv = document.getElementById("replies-" + queryId);
            
            // Fetch replies from MySQL using an AJAX request
            const xhr = new XMLHttpRequest();
            xhr.open("GET", "get_replies.php?query_id=" + queryId, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const replies = JSON.parse(xhr.responseText);
                    if (replies.length > 0) {
                        repliesDiv.innerHTML = replies.map(reply => "<p>" + reply.reply_text + "</p>").join("");
                    } else {
                        repliesDiv.innerHTML = "No replies found.";
                    }
                }
            };
            xhr.send();
        }
    </script>
</body>
</html>
