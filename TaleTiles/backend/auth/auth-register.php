<?php
session_start([
    'cookie_secure' => true,
    'cookie_httponly' => true,
    'use_strict_mode' => true,
]);

require "../config/connection.php";

$errors = [];

if (isset($_POST['registerButton'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($username)) {
        $errors['username'] = "Username is required!";
    }

    if (empty($email)) {
        $errors['email'] = "Email is required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format!";
    }

    if (empty($password)) {
        $errors['password'] = "Password is required!";
    } elseif (strlen($password) < 8) {
        $errors['password'] = "Password must be at least 8 characters long!";
    }

    if (empty($errors)) {
        $checkEmailQuery = "SELECT id FROM users WHERE email = ?";
        $checkEmailStmt = $connection->prepare($checkEmailQuery);
        $checkEmailStmt->bind_param("s", $email);
        $checkEmailStmt->execute();
        $checkEmailStmt->store_result();

        if ($checkEmailStmt->num_rows > 0) {
            $errors['email'] = "This email is already in use.";
        }

        $checkUserQuery = "SELECT id FROM users WHERE username = ?";
        $checkUserStmt = $connection->prepare($checkUserQuery);
        $checkUserStmt->bind_param("s", $username);
        $checkUserStmt->execute();
        $checkUserStmt->store_result();

        if ($checkUserQuery && $checkUserStmt->num_rows > 0) {
            $errors['username'] = "This username is already taken.";
        }
    }

    if (empty($errors)) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $connection->prepare($query);

        if ($stmt) {
            $stmt->bind_param("sss", $username, $email, $passwordHash);

            if ($stmt->execute()) {
                header("Location: ../../index.php");
                exit();
            } else {
                $errors['database'] = "Database error: " . $stmt->error;
            }
        } else {
            $errors['database'] = "Database error: " . $connection->error;
        }
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: ../../pages/register.php");
        exit();
    }
}
?>