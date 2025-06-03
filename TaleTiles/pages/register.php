<?php
    session_start();
    $errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
    unset($_SESSION['errors']);

    if (isset($_SESSION['user_id'])) {
        header("Location: home.html");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tale Tiles</title>
    <link rel="stylesheet" href="../assets/css/auth-style.css">
</head>
<body>
    <div class="register-page starting-page">
        <div class="contents">
            <div class="register-container">
                <h1>TALE TILES</h1>
                <?php if (!empty($errors)): ?>
                    <div class="error-message">
                        <?php foreach ($errors as $error): ?>
                            <p><?php echo htmlspecialchars($error); ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <div class="form-toggle">
                    <button type="button" id="loginButton">Login</button>
                    <button type="button" id="registerButton" class="active">Sign Up</button>
                </div>
                <form action="../backend/auth/auth-register.php" method="post" id="registerForm" class="auth-form active">
                    <div class="input-box input-username">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" placeholder="Enter your Username">
                    </div>
                    <div class="input-box input-email">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter your Email">
                    </div>
                    <div class="input-box input-password">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter your Password">
                    </div>
                    <button type="submit" name="registerButton">Register</button>
                </form>
            </div>
            <div class="sound-option">
                <img src="../assets/images/icon_music_unmute.png" alt="Sound Toggle" id="toggleSound" />
            </div>
        </div>
        <audio id="backgroundMusic" loop>
            <source src="../assets/musics/snd_bg.mp3" type="audio/mpeg">
            Your browser does not support the audio element.
        </audio>
    </div>
    <script src="../assets/js/music.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const registerButton = document.getElementById("loginButton");
            registerButton.addEventListener("click", function () {
                window.location.href = "../index.php";
            });
        });
    </script>
</body>
</html>