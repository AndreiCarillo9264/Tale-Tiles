document.addEventListener("DOMContentLoaded", () => {
    const music = document.getElementById("backgroundMusic");
    const toggleButton = document.getElementById("toggleSound");

    music.volume = 0.3;
    music.muted = true;

    const playPromise = music.play();

    if (playPromise !== undefined) {
        playPromise.catch(error => {
            console.log("Autoplay prevented:", error);
        });
    }

    window.addEventListener("click", () => {
        if (music.muted) {
            music.muted = false;
            toggleButton.src = "../assets/images/icon_music_unmute.png";
        }
    }, { once: true });

    toggleButton.addEventListener("click", () => {
        if (music.muted) {
            music.muted = false;
            toggleButton.src = "../assets/images/icon_music_unmute.png";
        } else {
            music.muted = true;
            toggleButton.src = "../assets/images/icon_music_mute.png";
        }
    });
});