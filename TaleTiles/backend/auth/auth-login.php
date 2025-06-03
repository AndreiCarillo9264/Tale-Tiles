<?php
session_start([
    'cookie_secure' => true,
    'cookie_httponly' => true,
    'use_strict_mode' => true,
]);

require "../config/connection.php";

$errors = [];

if (isset($_POST['loginButton'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email)) {
        $errors['email'] = "Email is required!";
    }
    if (empty($password)) {
        $errors['password'] = "Password is required!";
    }

    if (empty($errors)) {
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $connection->prepare($query);

        if ($stmt === false) {
            $errors['database'] = "Database error: " . $connection->error;
        } else {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();

                if (password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['email'] = $user['email'];

                    header("Location: ../../pages/home.php");
                    exit();
                } else {
                    $errors['password'] = "Incorrect password!";
                }
            } else {
                $errors['email'] = "No account found with that email.";
            }
        }
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: ../../index.php");
        exit();
    }
}
?>