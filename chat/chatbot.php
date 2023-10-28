<?php
// Sample predefined responses
$responses = array(
    "Hi" => "Hello! How can I assist you today?",
    "What are the admission requirements?" => "To apply for admission, you need to...",
    "What are the courses offered?" => "We offer a wide range of courses, including...",
    "What is the contact information?" => "You can reach us at email@example.com or call +123456789.",
    "Default" => "I'm sorry, I don't understand. Please ask another question.",
);

// Get user's message from the frontend
$data = json_decode(file_get_contents('php://input'), true);
$userMessage = $data['message'];

// Process the user's message and generate a response
if (isset($responses[$userMessage])) {
    $botResponse = $responses[$userMessage];
} else {
    $botResponse = $responses["Default"];
}

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode(array('message' => $botResponse));
?>
