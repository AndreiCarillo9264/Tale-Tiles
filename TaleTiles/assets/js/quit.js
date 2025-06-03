document.addEventListener("DOMContentLoaded", () => {
    const quitButton = document.getElementById("quitButton");
    const quitModal = document.getElementById("quitModal");
    const closeModalBtn = document.getElementById("closeModal");
    const confirmLogoutBtn = document.getElementById("confirmLogout");

    if (quitButton) {
        quitButton.addEventListener("click", () => {
            quitModal.style.display = "flex";
        });
    }

    if (closeModalBtn) {
        closeModalBtn.addEventListener("click", (event) => {
            event.preventDefault();
            quitModal.style.display = "none";
        });
    }

    window.addEventListener("click", (event) => {
        if (event.target === quitModal) {
            quitModal.style.display = "none";
        }
    });

    if (confirmLogoutBtn) {
        confirmLogoutBtn.addEventListener("click", () => {
            fetch("../backend/api/logout.php")
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = "../index.php";
                    } else {
                        alert("Logout failed: " + data.error);
                        quitModal.style.display = "none";
                    }
                })
                .catch(error => {
                    console.error("Logout error:", error);
                    alert("An error occurred during logout.");
                    quitModal.style.display = "none";
                });
        });
    }
});