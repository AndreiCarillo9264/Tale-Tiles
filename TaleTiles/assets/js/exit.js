document.addEventListener("DOMContentLoaded", () => {
    const quitButton = document.getElementById("exitButton");
    const quitModal = document.getElementById("exitModal");
    const closeModalBtn = document.getElementById("closeModal");

    quitButton.addEventListener("click", () => {
        quitModal.style.display = "flex";
        
        if (currentLevel < levels.length - 1) {
            quitModal.style.display = "flex";
        } else {
            alert("Please complete this level and save your score before exiting.");
        }
    });

    closeModalBtn.addEventListener("click", (event) => {
        event.preventDefault();
        quitModal.style.display = "none";
    });

    window.addEventListener("click", (event) => {
        if (event.target === quitModal) {
            quitModal.style.display = "none";
        }
    });
});