
// ----- Variabel Global -----
const colors = ["red", "yellow", "green", "blue"];
const numbers = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
const actions = ["skip", "reverse", "plus2"];
const wilds = ["wild", "plus_4"];

let deck = [];
let discardPile = [];
let playerHand = [];
let botHand = [];
let currentColor = null;
let currentValue = null;
let playerTurn = true;
let playerBalance = 5000;
let betAmount = 100;
let unoPressed = false;
let unoTimer = null;
let botUnoTimer = null;
let botUnoCalled = false;
let gameOver = false;
let pendingWildPlay = null;

const playerHandDiv = document.getElementById("playerHand");
const botHandDiv = document.getElementById("botHand");
const discardPileDiv = document.getElementById("discardPile");
const deckDiv = document.getElementById("deck");
const logDiv = document.getElementById("statusLog");
const colorChoiceDiv = document.getElementById("colorChoice");
const gameOverModal = document.getElementById("gameOverModal");
const betInput = document.getElementById("betInput");
const accuseBotUnoButton = document.getElementById("accuseBotUno");
const balanceDiv = document.getElementById("balance");
const passButton = document.getElementById("passButton");

// ----- Fungsi Utilitas -----
function log(msg) {
    const p = document.createElement("p");
    p.textContent = msg;
    logDiv.appendChild(p);
    logDiv.scrollTop = logDiv.scrollHeight;
}

function updateBalance() {
    balanceDiv.textContent = `$${playerBalance}`;
}

function shuffle(array) {
    for (let i = array.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [array[i], array[j]] = [array[j], array[i]];
    }
}

function createDeck() {
    deck = [];
    for (const color of colors) {
        deck.push({ color, value: "0" });
        for (let i = 1; i <= 9; i++) {
            deck.push({ color, value: i.toString() });
        }
        for (const act of actions) {
            deck.push({ color, value: act });
        }
    }
    for (let i = 0; i < 4; i++) {
        deck.push({ color: "wild", value: "wild" });
        deck.push({ color: "wild", value: "plus_4" });
    }
    shuffle(deck);
}

function drawCard() {
    if (deck.length === 0) reshuffle();
    return deck.pop();
}

function reshuffle() {
    const topCard = discardPile.pop();
    deck = discardPile;
    discardPile = [topCard];
    shuffle(deck);
}

function startGame() {
    betAmount = parseInt(betInput.value) || 100;
    if (betAmount < 100 || betAmount > playerBalance) {
        log("Taruhan tidak valid! Min $100, max $" + playerBalance);
        return;
    }
    playerBalance -= betAmount;
    updateBalance();
    logDiv.innerHTML = "";
    playerHand = [];
    botHand = [];
    discardPile = [];
    createDeck();

    for (let i = 0; i < 7; i++) {
        playerHand.push(drawCard());
        botHand.push(drawCard());
    }

    let initialCard = drawCard();
    while (initialCard.color === "wild") {
        deck.push(initialCard);
        shuffle(deck);
        initialCard = drawCard();
    }
    discardPile.push(initialCard);
    currentColor = discardPile[0].color;
    currentValue = discardPile[0].value;
    playerTurn = true;
    gameOver = false;
    passButton.style.display = "none";
    accuseBotUnoButton.style.display = "none";
    render();
    log("Ronde dimulai! Taruhan: $" + betAmount);
}

// ----- Rendering -----
function render() {
    playerHandDiv.innerHTML = "";
    botHandDiv.innerHTML = "";
    discardPileDiv.innerHTML = "";
    deckDiv.innerHTML = "";

    playerHand.forEach((card, index) => {
        const img = document.createElement("img");
        img.src = `assets/${card.color === "wild" ? card.value : `${card.color}_${card.value}`}.png`;
        img.addEventListener("click", () => playCard(index));
        playerHandDiv.appendChild(img);
    });

    for (let i = 0; i < botHand.length; i++) {
        const img = document.createElement("img");
        img.src = "assets/card_back.png";
        botHandDiv.appendChild(img);
    }

    const top = discardPile[discardPile.length - 1];
    const discardImg = document.createElement("img");
    discardImg.src = `assets/${top.color === "wild" ? top.value : `${top.color}_${top.value}`}.png`;
    discardPileDiv.appendChild(discardImg);

    const deckImg = document.createElement("img");
    deckImg.src = "assets/card_back.png";
    deckImg.addEventListener("click", drawForPlayer);
    deckDiv.appendChild(deckImg);
}

// ----- Logika Permainan -----
function canPlay(card, hand = playerHand) {
    if (card.color === "wild" && card.value === "plus_4") {
        const hasOtherPlayable = hand.some(c => c !== card && (c.color === currentColor || c.value === currentValue || c.color === "wild"));
        return !hasOtherPlayable;
    }
    return (
        card.color === currentColor ||
        card.value === currentValue ||
        card.color === "wild"
    );
}

function playCard(index) {
    if (!playerTurn || gameOver) return;
    const card = playerHand[index];
    if (!canPlay(card)) {
        log("Kartu tidak cocok!");
        return;
    }

    playerHand.splice(index, 1);
    discardPile.push(card);
    currentValue = card.value;
    if (card.color !== "wild") currentColor = card.color;

    if (card.color === "wild") {
        pendingWildPlay = card;
        colorChoiceDiv.style.display = "block";
        passButton.style.display = "none";
        return;
    }

    handleAction(card, "player");
    render();

    checkUno("player");

    if (botHand.length !== 1) {
        accuseBotUnoButton.style.display = "none";
        clearTimeout(botUnoTimer);
        botUnoCalled = false;
    }

    if (playerHand.length === 0) {
        endRound(true);
    } else if (card.value === "skip" || card.value === "reverse" || card.value === "plus2" || card.value === "plus_4") {
        playerTurn = true;
        log("Giliran kamu lagi!");
    } else {
        playerTurn = false;
        log("Giliran bot!");
        passButton.style.display = "none";
        setTimeout(botPlay, 1500);
    }
}

function continueAfterColorChoice(chosenColor) {
    if (gameOver) return;
    currentColor = chosenColor;
    colorChoiceDiv.style.display = "none";
    const card = pendingWildPlay;
    pendingWildPlay = null;
    log(`Warna berubah jadi ${currentColor}`);
    handleAction(card, "player");
    render();
    checkUno("player");

    if (botHand.length !== 1) {
        accuseBotUnoButton.style.display = "none";
        clearTimeout(botUnoTimer);
        botUnoCalled = false;
    }

    if (playerHand.length === 0) {
        endRound(true);
    } else if (card.value === "plus_4") {
        playerTurn = true;
        log("Giliran kamu lagi!");
    } else {
        playerTurn = false;
        log("Giliran bot!");
        passButton.style.display = "none";
        setTimeout(botPlay, 1500);
    }
}

function drawForPlayer() {
    if (!playerTurn || gameOver) return;
    const card = drawCard();
    playerHand.push(card);
    render();
    if (canPlay(card)) {
        log("Kartu bisa dimainkan! Mainkan kartu atau tekan Pass.");
        passButton.style.display = "inline";
    } else {
        log("Kartu tidak bisa dimainkan.");
        playerTurn = false;
        log("Giliran bot!");
        passButton.style.display = "none";
        setTimeout(botPlay, 1500);
    }
}

function botPlay() {
    if (gameOver) return;
    let playableIndex = botHand.findIndex(card => canPlay(card, botHand));
    let card;
    if (playableIndex === -1) {
        card = drawCard();
        botHand.push(card);
        log("Bot mengambil kartu.");
        if (canPlay(card, botHand)) {
            botHand.splice(botHand.length - 1, 1);
            discardPile.push(card);
            currentValue = card.value;
            if (card.color !== "wild") currentColor = card.color;
            else currentColor = colors[Math.floor(Math.random() * 4)];
            log(`Bot memainkan ${card.color} ${card.value}`);
            if (card.color === "wild") log(`Warna berubah jadi ${currentColor}`);
            handleAction(card, "bot");
        } else {
            log("Bot tidak bisa memainkan kartu.");
        }
    } else {
        card = botHand.splice(playableIndex, 1)[0];
        discardPile.push(card);
        currentValue = card.value;
        if (card.color !== "wild") currentColor = card.color;
        else currentColor = colors[Math.floor(Math.random() * 4)];
        log(`Bot memainkan ${card.color} ${card.value}`);
        if (card.color === "wild") log(`Warna berubah jadi ${currentColor}`);
        handleAction(card, "bot");
    }

    render();
    checkUno("bot");

    if (botHand.length !== 1) {
        accuseBotUnoButton.style.display = "none";
        clearTimeout(botUnoTimer);
        botUnoCalled = false;
    }

    if (botHand.length === 0) {
        endRound(false);
    } else if (card && (card.value === "skip" || card.value === "reverse" || card.value === "plus2" || card.value === "plus_4")) {
        playerTurn = false;
        log("Giliran bot lagi!");
        setTimeout(botPlay, 1500);
    } else {
        playerTurn = true;
        log("Giliran kamu!");
    }
}

function handleAction(card, owner) {
    if (gameOver) return;
    const isPlayer = owner === "player";
    const targetHand = isPlayer ? botHand : playerHand;

    if (card.value === "skip" || card.value === "reverse") {
        log(`${isPlayer ? "Bot" : "Pemain"} dilewati!`);
    } else if (card.value === "plus2") {
        targetHand.push(drawCard(), drawCard());
        log(`${isPlayer ? "Bot" : "Pemain"} ambil 2 kartu!`);
    } else if (card.value === "plus_4") {
        for (let i = 0; i < 4; i++) targetHand.push(drawCard());
        log(`${isPlayer ? "Bot" : "Pemain"} ambil 4 kartu!`);
    }
}

function checkUno(owner) {
    if (gameOver) return;
    const hand = owner === "player" ? playerHand : botHand;
    if (hand.length === 1) {
        if (owner === "player") {
            startPlayerUnoTimer();
        } else {
            startBotUnoTimer();
        }
    }
}

function startPlayerUnoTimer() {
    if (gameOver) return;
    unoPressed = false;
    log("UNO! Tekan tombol dalam 5 detik!");
    clearTimeout(unoTimer);
    unoTimer = setTimeout(() => {
        if (!unoPressed && !gameOver) {
            playerHand.push(drawCard(), drawCard());
            log("Lupa tekan UNO! Tambah 2 kartu!");
            render();
        }
    }, 5000);
}

function startBotUnoTimer() {
    if (gameOver) return;
    botUnoCalled = false;
    accuseBotUnoButton.style.display = "inline";
    log("Bot punya 1 kartu! Panggil UNO dalam 5 detik jika lupa!");
    const botForgets = Math.random() > 0.5;
    clearTimeout(botUnoTimer);
    botUnoTimer = setTimeout(() => {
        accuseBotUnoButton.style.display = "none";
        if (botForgets && !botUnoCalled && !gameOver) {
            botHand.push(drawCard(), drawCard());
            log("Bot lupa UNO! Tambah 2 kartu!");
            render();
        } else if (!botForgets) {
            log("Bot bilang UNO tepat waktu!");
        }
    }, 5000);
}

document.getElementById("unoButton").addEventListener("click", () => {
    if (gameOver) return;
    if (playerHand.length === 1) {
        unoPressed = true;
        clearTimeout(unoTimer);
        log("UNO ditekan tepat waktu!");
    }
});

document.getElementById("accuseBotUno").addEventListener("click", () => {
    if (gameOver) return;
    if (botHand.length === 1 && !botUnoCalled) {
        botUnoCalled = true;
        clearTimeout(botUnoTimer);
        botHand.push(drawCard(), drawCard());
        log("Kamu panggil UNO pada Bot! Bot tambah 2 kartu!");
        render();
        accuseBotUnoButton.style.display = "none";
    }
});

document.getElementById("startButton").addEventListener("click", startGame);

document.getElementById("restartButton").addEventListener("click", () => {
    gameOverModal.style.display = "none";
    playerBalance = 5000;
    updateBalance();
    startGame();
});

document.getElementById("passButton").addEventListener("click", () => {
    if (!playerTurn || gameOver) return;
    log("Kamu melewati giliran!");
    playerTurn = false;
    passButton.style.display = "none";
    log("Giliran bot!");
    setTimeout(botPlay, 1500);
});

function endRound(playerWon) {
    gameOver = true;
    clearTimeout(unoTimer);
    clearTimeout(botUnoTimer);
    accuseBotUnoButton.style.display = "none";
    passButton.style.display = "none";
    if (playerWon) {
        playerBalance += betAmount * 2;
        log(`Kamu menang ronde ini! Saldo: $${playerBalance}`);
    } else {
        log(`Bot menang ronde ini! Saldo: $${playerBalance}`);
    }
    updateBalance();

    if (playerBalance <= 0) {
        gameOver = true;
        gameOverModal.style.display = "block";
    } else {
        log("Klik 'Mulai Ronde' untuk bermain lagi.");
    }
}

colorChoiceDiv.querySelectorAll("button").forEach(btn => {
    btn.addEventListener("click", () => {
        continueAfterColorChoice(btn.dataset.color);
    });
});

window.onload = () => {
    updateBalance();
    log("Masukkan taruhan dan klik Mulai Ronde.");
};