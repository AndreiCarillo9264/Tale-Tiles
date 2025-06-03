function loadLeaderboard() {
    fetch('../backend/api/get-leaderboard.php')
        .then(res => res.json())
        .then(scores => {
            const list = document.getElementById('leaderboardList');
            list.innerHTML = '';

            if (scores.length === 0) {
                list.innerHTML = '<li>No scores yet!</li>';
                return;
            }

            scores.forEach((entry, index) => {
                const li = document.createElement('li');
                li.textContent = `${index + 1}. ${entry.username} — ${entry.score} pts`;
                list.appendChild(li);
            });
        })
        .catch(err => {
            console.error('Error fetching leaderboard:', err);
        });
}

// Load immediately on page load
loadLeaderboard();

// Refresh every 15 seconds
setInterval(loadLeaderboard, 15000);