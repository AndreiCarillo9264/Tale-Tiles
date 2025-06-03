<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit();
}

require "../config/connection.php";

// Get raw POST data
$raw_post = file_get_contents('php://input');
$post_data = [];

// Log content type for debugging
$content_type = $_SERVER['CONTENT_TYPE'] ?? 'unknown';
error_log("Content-Type: $content_type");
error_log("Raw POST Data: $raw_post");

// Try parsing based on Content-Type
if (strpos($content_type, 'application/json') !== false) {
    $json_data = json_decode($raw_post, true);
    if (is_array($json_data)) {
        $post_data = $json_data;
    } else {
        error_log("JSON decode failed or not an object");
    }
} elseif (strpos($content_type, 'application/x-www-form-urlencoded') !== false) {
    parse_str($raw_post, $post_data);
} else {
    // Fallback: try both methods
    parse_str($raw_post, $post_data);
    if (empty($post_data)) {
        $json_data = json_decode($raw_post, true);
        if (is_array($json_data)) {
            $post_data = $json_data;
        }
    }
}

// Debug parsed data
error_log("Parsed POST Data: " . print_r($post_data, true));

// Validate score
if (!isset($post_data['score']) || !is_numeric($post_data['score'])) {
    error_log("Invalid or missing score: " . print_r($post_data, true));
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Score not provided or invalid']);
    exit();
}

$score = intval($post_data['score']);
$user_id = $_SESSION['user_id'];

// Insert into database
$stmt = $connection->prepare("INSERT INTO user_scores (user_id, score) VALUES (?, ?)");
if (!$stmt) {
    error_log("Database prepare error: " . $connection->error);
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Internal server error']);
    exit();
}

$stmt->bind_param("ii", $user_id, $score);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    error_log("Failed to submit score for user $user_id: " . $stmt->error);
    echo json_encode(['status' => 'error', 'message' => 'Failed to save score']);
}

$stmt->close();
$connection->close();
?>