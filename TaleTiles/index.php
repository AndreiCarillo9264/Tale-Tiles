<?php
    session_start();
    $errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
    unset($_SESSION['errors']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tale Tiles</title>
    <link rel="stylesheet" href="assets/css/auth-style.css">
</head>
<body>
    <div class="login-page starting-page">
        <div class="contents">
            <div class="login-container">
                <h1>TALE TILES</h1>
                <?php if (!empty($errors)): ?>
                    <div class="error-message">
                        <?php foreach ($errors as $error): ?>
                            <p><?php echo htmlspecialchars($error); ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <div class="form-toggle">
                    <button type="button" id="loginButton" class="active">Login</button>
                    <button type="button" id="registerButton">Sign Up</button>
                </div>
                <form action="backend/auth/auth-login.php" method="post" id="loginForm" class="auth-form active">
                    <div class="input-box input-email">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter your Email">
                    </div>
                    <div class="input-box input-password">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter your Password">
                    </div>
                    <button type="submit" name="loginButton">Login</button>
                </form>
            </div>
            <div class="sound-option">
                <img src="assets/images/icon_music_unmute.png" alt="Sound Toggle" id="toggleSound" />
            </div>
        </div>
        <audio id="backgroundMusic" loop>
            <source src="assets/musics/snd_bg.mp3" type="audio/mpeg">
            Your browser does not support the audio element.
        </audio>
    </div>
    <script src="assets/js/music-index.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const registerButton = document.getElementById("registerButton");
            registerButton.addEventListener("click", function () {
                window.location.href = "pages/register.php";
            });
        });
    </script>
</body>
</html>