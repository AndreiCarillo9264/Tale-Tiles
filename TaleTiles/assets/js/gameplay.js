const levels = [
    // 🟢 Easy (Short to Long)
    { clues: ["../assets/puzzles/haiku/clue1.png", "../assets/puzzles/haiku/clue2.png", "../assets/puzzles/haiku/clue3.png", "../assets/puzzles/haiku/clue4.png"], answer: "HAIKU" },
    { clues: ["../assets/puzzles/sonnet/clue1.png", "../assets/puzzles/sonnet/clue2.png", "../assets/puzzles/sonnet/clue3.png", "../assets/puzzles/sonnet/clue4.png"], answer: "SONNET" },
    { clues: ["../assets/puzzles/tragedy/clue1.png", "../assets/puzzles/tragedy/clue2.png", "../assets/puzzles/tragedy/clue3.png", "../assets/puzzles/tragedy/clue4.png"], answer: "TRAGEDY" },
    { clues: ["../assets/puzzles/novel/clue1.png", "../assets/puzzles/novel/clue2.png", "../assets/puzzles/novel/clue3.png", "../assets/puzzles/novel/clue4.png"], answer: "NOVEL" },
    { clues: ["../assets/puzzles/aristotle/clue1.png", "../assets/puzzles/aristotle/clue2.png", "../assets/puzzles/aristotle/clue3.png", "../assets/puzzles/aristotle/clue4.png"], answer: "ARISTOTLE" },
    { clues: ["../assets/puzzles/feminism/clue1.png", "../assets/puzzles/feminism/clue2.png", "../assets/puzzles/feminism/clue3.png", "../assets/puzzles/feminism/clue4.png"], answer: "FEMINISM" },

    { clues: ["../assets/puzzles/iliad/clue1.png", "../assets/puzzles/iliad/clue2.png", "../assets/puzzles/iliad/clue3.png", "../assets/puzzles/iliad/clue4.png"], answer: "ILIAD" },
    { clues: ["../assets/puzzles/epic/clue1.png", "../assets/puzzles/epic/clue2.png", "../assets/puzzles/epic/clue3.png", "../assets/puzzles/epic/clue4.png"], answer: "EPIC" },
    { clues: ["../assets/puzzles/drama/clue1.png", "../assets/puzzles/drama/clue2.png", "../assets/puzzles/drama/clue3.png", "../assets/puzzles/drama/clue4.png"], answer: "DRAMA" },
    { clues: ["../assets/puzzles/renaissance/clue1.png", "../assets/puzzles/renaissance/clue2.png", "../assets/puzzles/renaissance/clue3.png", "../assets/puzzles/renaissance/clue4.png"], answer: "RENAISSANCE" },
    { clues: ["../assets/puzzles/odyssey/clue1.png", "../assets/puzzles/odyssey/clue2.png", "../assets/puzzles/odyssey/clue3.png", "../assets/puzzles/odyssey/clue4.png"], answer: "ODYSSEY" },

    { clues: ["../assets/puzzles/allegory/clue1.png", "../assets/puzzles/allegory/clue2.png", "../assets/puzzles/allegory/clue3.png", "../assets/puzzles/allegory/clue4.png"], answer: "ALLEGORY" },
    { clues: ["../assets/puzzles/beowulf/clue1.png", "../assets/puzzles/beowulf/clue2.png", "../assets/puzzles/beowulf/clue3.png", "../assets/puzzles/beowulf/clue4.png"], answer: "BEOWULF" },
    { clues: ["../assets/puzzles/ramayana/clue1.png", "../assets/puzzles/ramayana/clue2.png", "../assets/puzzles/ramayana/clue3.png", "../assets/puzzles/ramayana/clue4.png"], answer: "RAMAYANA" },
    { clues: ["../assets/puzzles/symbolism/clue1.png", "../assets/puzzles/symbolism/clue2.png", "../assets/puzzles/symbolism/clue3.png", "../assets/puzzles/symbolism/clue4.png"], answer: "SYMBOLISM" },
    { clues: ["../assets/puzzles/structuralism/clue1.png", "../assets/puzzles/structuralism/clue2.png", "../assets/puzzles/structuralism/clue3.png", "../assets/puzzles/structuralism/clue4.png"], answer: "STRUCTURALISM" },
    { clues: ["../assets/puzzles/postcolonialism/clue1.png", "../assets/puzzles/postcolonialism/clue2.png", "../assets/puzzles/postcolonialism/clue3.png", "../assets/puzzles/postcolonialism/clue4.png"], answer: "POSTCOLONIALISM" }
];

let currentLevel = 0;
let totalScore = 0;
let levelScore = 100;

const letterBoxesContainer = document.querySelector('.letter-boxes');
const letterBankContainer = document.querySelector('.letter-bank');
const scoreDisplayTop = document.querySelector('#score');

const typewriterSound = new Audio('../assets/musics/snd_typewriter.wav');
const buttonSound = new Audio('../assets/musics/snd_button.wav');

function shuffleArray(array) {
    for (let i = array.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [array[i], array[j]] = [array[j], array[i]];
    }
}

function renderClues() {
    const clueGrid = document.querySelector('.clue-grid');
    clueGrid.innerHTML = '';

    levels[currentLevel].clues.forEach((clueSrc, idx) => {
        const clueCard = document.createElement('div');
        clueCard.classList.add('clue-card');
        clueCard.innerHTML = `<span><img src="${clueSrc}" alt="Clue ${idx + 1}"></span>`;
        clueGrid.appendChild(clueCard);
    });
}

function createLetterBoxes(answer) {
    letterBoxesContainer.innerHTML = '';
    for (let i = 0; i < answer.length; i++) {
        const box = document.createElement('div');
        box.classList.add('letter-box');
        box.dataset.index = i;
        letterBoxesContainer.appendChild(box);
    }
}

function createLetterBank(answer) {
    letterBankContainer.innerHTML = '';

    let letterOptions = [...answer.toUpperCase()];
    const alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    while (letterOptions.length < 15) {
        const randChar = alphabet.charAt(Math.floor(Math.random() * alphabet.length));
        if (!letterOptions.includes(randChar)) {
            letterOptions.push(randChar);
        }
    }

    shuffleArray(letterOptions);

    letterOptions.forEach(letter => {
        const letterDiv = document.createElement('div');
        letterDiv.classList.add('letter');
        letterDiv.dataset.letter = letter;

        const img = document.createElement('img');
        img.src = `../assets/images/icon_key_${letter.toLowerCase()}.png`;
        img.alt = letter;

        letterDiv.appendChild(img);
        letterBankContainer.appendChild(letterDiv);

        letterDiv.addEventListener('click', () => {
            const emptyBox = [...letterBoxesContainer.children].find(box => !box.hasChildNodes());
            if (emptyBox) {
                const clone = img.cloneNode(true);

                clone.addEventListener('click', () => {
                    emptyBox.innerHTML = '';
                    letterDiv.style.visibility = 'visible';
                    buttonSound.currentTime = 0;
                    buttonSound.play();

                    if(levelScore > 0) {
                        levelScore -= 10;
                        updateScoreDisplay();
                    }
                });

                emptyBox.appendChild(clone);
                letterDiv.style.visibility = 'hidden';
                typewriterSound.currentTime = 0;
                typewriterSound.play();

                checkAnswer();
            }
        });
    });
}

function checkAnswer() {
    const guessed = [...letterBoxesContainer.children].map(box =>
        box.firstChild ? box.firstChild.alt : ''
    ).join('');

    const answer = levels[currentLevel].answer.toUpperCase();

    if (guessed.length === answer.length) {
        if (guessed === answer) {
            totalScore += levelScore;
            showNextLevelModal();
        } else {
            alert("Incorrect! Try again.");
        }
    }
}

function showNextLevelModal() {
    const nextModal = document.getElementById('nextModal');
    nextModal.style.display = 'block';

    const scoreDisplay = nextModal.querySelector('#score');
    scoreDisplay.textContent = `${levelScore}`;

    updateScoreDisplay();

    setTimeout(() => {
        nextModal.style.display = 'none';
        currentLevel++;
        if (currentLevel < levels.length) {
            initLevel();
        } else {
            // Show final modal
            const finalModal = document.getElementById('finalModal');
            const finalScoreDisplay = document.getElementById('finalScoreDisplay');
            finalScoreDisplay.textContent = totalScore;
            finalModal.style.display = 'block';

            // Attach click handler to submit score and go home
            document.getElementById('submitAndHomeBtn').onclick = () => {
                const btn = document.getElementById('submitAndHomeBtn');
                btn.textContent = 'Saving...';
                btn.disabled = true;

                console.log("Submitting score:", totalScore);

                fetch('../backend/api/submit-scores.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ score: totalScore })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        console.log('Score saved successfully!');
                        window.location.href = 'home.php';
                    } else {
                        alert('Failed to save score.');
                        window.location.href = 'home.php';
                    }
                })
                .catch(err => {
                    console.error('🚨 Error submitting score:', err);
                    alert('Unable to connect to server. Redirecting...');
                    window.location.href = 'home.php';
                });
            };
        }
    }, 3000);
}

function updateScoreDisplay() {
    const scoreDisplayTop = document.querySelector('.stats-container #score');
    scoreDisplayTop.textContent = `${totalScore}`;
}

function initLevel() {
    updateScoreDisplay();
    levelScore = 100;
    const answer = levels[currentLevel].answer;
    renderClues();
    createLetterBoxes(answer);
    createLetterBank(answer);
}

window.onload = () => {
    updateScoreDisplay();
    initLevel();
};