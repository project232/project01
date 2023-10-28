<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'query';

$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn){
    die("Sorry we failed to connect: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $queryId = $_POST["query_id"];
    $newQuery = $_POST["new_query"];

    $sql = "UPDATE querys SET query = '$newQuery' WHERE no = $queryId";
    if (mysqli_query($conn, $sql)) {
        header("location: query.php");
    } else {
        echo "Error updating query: " . mysqli_error($conn);
    }
} else {
    $queryId = $_GET["id"];

    $sql = "SELECT * FROM querys WHERE no = $queryId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $currentQuery = $row["query"];
    } else {
        echo "Query not found.";
        exit();
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Query</title>
</head>
<style>/* styles.css */
/* styles.css */
body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
}

h2 {
    color: #007bff;
    font-weight: bold;
    text-align: center;
    font-size: 24px;
    text-transform: uppercase;
}

form {
    max-width: 400px;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
}

textarea {
    width: 100%;
    height: 150px;
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 10px;
    background-color: #f9f9f9;
}

input[type="submit"] {
    background-color: #ff5733;
    color: #fff;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s;
}

input[type="submit"]:hover {
    background-color: #ff3300;
}
textarea {
    width: 100%;
    height: 100px;
    resize: none;
}
 
</style>
<body>
    <h2>Edit Query</h2>
    <form method="POST">
        <input type="hidden" name="query_id" value="<?php echo $queryId; ?>">
        <textarea name="new_query"><?php echo $currentQuery; ?></textarea>
        <input type="submit" value="Save">
    </form>
</body>
</html>
