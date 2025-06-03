<?php
session_start([
    'cookie_secure' => true,
    'cookie_httponly' => true,
    'use_strict_mode' => true,
]);

if (session_id() === '' || !isset($_SESSION)) {
    echo json_encode(['success' => false, 'error' => 'No active session to destroy.']);
    exit;
}

try {
    session_unset();
    session_destroy();

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '', 
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }
    echo json_encode(['success' => true, 'message' => 'Logged out successfully.']);
} catch (Exception $e) {
    error_log('Logout Error: ' . $e->getMessage());
    echo json_encode(['success' => false, 'error' => 'An unexpected error occurred during logout.']);
}
?>