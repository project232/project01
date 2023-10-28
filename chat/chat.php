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
    <link rel="stylesheet" type="text/css" href="main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>CHATBOT</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }
        
        .chat-container {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
            overflow: hidden;
            margin-top: 200px;
        }
        
        .chat-header {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            text-align: center;
        }
        
        .chat-body {
            padding: 20px;
            max-height: 300px;
            overflow-y: auto;
        }
        
        .chat-input {
            display: flex;
            padding: 10px;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #ccc;
        }
        
        input[type="text"] {
            flex: 1;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 3px;
            outline: none;
        }
        
        button {
            padding: 8px 16px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        
    </style>

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
     
    <div class="chat-container">
        <div class="chat-header">
            <h1>Collage Chatbot</h1>
        </div>
        <div class="chat-body" id="chat-body">
            <!-- Chat messages will be displayed here -->
        </div>
        <div class="chat-input">
            <input type="text" id="user-input" placeholder="Type a message...">
            <button onclick="sendMessage()">Send</button>
        </div>
    </div>
</body>
<script>
    function sendMessage() {
        const userMessage = document.getElementById('user-input').value;
        const chatBody = document.getElementById('chat-body');
    
        // Display user message in the chat
        appendMessage('You', userMessage);
    
        // Send user message to the PHP backend for processing
        fetch('chatbot.php', {
            method: 'POST',
            body: JSON.stringify({ message: userMessage }),
            headers: {
                'Content-Type': 'application/json',
            },
        })
            .then(response => response.json())
            .then(data => {
                // Display chatbot response in the chat
                appendMessage('Chatbot', data.message);
            })
            .catch(error => {
                console.error('Error:', error);
            });
    
        // Clear user input
        document.getElementById('user-input').value = '';
    }
    
    function appendMessage(sender, message) {
        const chatBody = document.getElementById('chat-body');
        const messageElement = document.createElement('div');
        messageElement.className = `message ${sender.toLowerCase()}`;
        messageElement.innerHTML = `<strong>${sender}:</strong> ${message}`;
        chatBody.appendChild(messageElement);
        chatBody.scrollTop = chatBody.scrollHeight;
    }
    
    
</script>
</html>