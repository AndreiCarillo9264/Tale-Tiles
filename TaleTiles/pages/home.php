<?php
    session_start();

    if (!isset($_SESSION['user_id'])) {
        header("Location: ../index.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tale Tiles</title>
    <link rel="stylesheet" href="../assets/css/home.css">
</head>
<body>
    <div class="home-page">
        <div class="contents">
            <div class="left-container">
                <h1 class="game-title">TALE TILES</h1>
                <div class="button-container">
                    <a href="gameplay.html"><h2 id="playButton">Play</h2></a>
                    <a href="about.html"><h2 id="aboutButton">About</h2></a>
                    <h2 id="quitButton">Quit</h2>
                </div>
            </div>
            <div class="quit-modal" id="quitModal">
                <div class="modal-contents">
                    <div class="modal-text">
                        <h3>ARE YOU SURE <br>YOU WANT TO QUIT?</h3>
                    </div>
                    <div class="modal-button">
                        <button id="confirmLogout">YES</button>
                        <button id="closeModal">NO</button>
                    </div>
                </div>
            </div>
            <div class="right-container">
                <div class="sound-option">
                    <img src="../assets/images/icon_music_unmute.png" alt="Sound Toggle" id="toggleSound" />
                </div>
                <div class="leaderboard-container">
                    <h1>Leaderboard</h1>
                    <ul id="leaderboardList"></ul>
                </div>
            </div>
        </div>
        <audio id="backgroundMusic" loop>
            <source src="../assets/musics/snd_bg.mp3" type="audio/mpeg">
                Your browser does not support the audio element.
        </audio>
    </div>
    <script src="../assets/js/quit.js"></script>
    <script src="../assets/js/music.js"></script>
    <script src="../assets/js/leaderboard.js"></script>
</body>
</html>