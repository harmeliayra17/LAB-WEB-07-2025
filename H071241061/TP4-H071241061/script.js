// === GAME STATE ===
let deck = [], playerHand = [], botHand = [], discardPile = []; 
let balance = 5000, currentBet = 0, currentColor = null, currentValue = null;
let currentPlayer = "player", gameActive = false, waitingForColor = false;
let unoTimer = null, unoInterval = null, unoPressed = false, botUnoPressed = false;

// === DOM ELEMENTS ===
const balanceEl = document.getElementById("balance");
const betEl = document.getElementById("current-bet");
const statusEl = document.getElementById("status-text");
const unoBtn = document.getElementById("uno-btn");
const deckEl = document.getElementById("deck");
const startBtn = document.getElementById("start-btn");
const betModal = document.getElementById("bet-modal");
const gameoverModal = document.getElementById("gameover-modal");
const colorModal = document.getElementById("color-modal");
const modalBalanceEl = document.getElementById("modal-balance");
const betInputEl = document.getElementById("bet-input");
const betErrorEl = document.getElementById("bet-error");
const confirmBetBtn = document.getElementById("confirm-bet-btn");
const cancelBetBtn = document.getElementById("cancel-bet-btn");
const restartBtn = document.getElementById("restart-btn");
const unoTimerEl = document.getElementById("uno-timer");
const playerHandEl = document.getElementById("player-hand");
const botHandEl = document.getElementById("bot-hand");
const discardPileEl = document.getElementById("discard-pile");
const playerCountEl = document.getElementById("player-count");
const botCountEl = document.getElementById("bot-count");
const deckCountEl = document.getElementById("deck-count");
const currentColorEl = document.getElementById("current-color");

// === EVENT LISTENERS ===
startBtn.onclick = () => {
  if (balance <= 0) return gameoverModal.classList.add("active");
  modalBalanceEl.textContent = balance; 
  betInputEl.value = ""; 
  betInputEl.max = balance; 
  betErrorEl.textContent = "";
  betModal.classList.add("active"); 
};

confirmBetBtn.onclick = () => {
  const bet = parseInt(betInputEl.value);
  if (isNaN(bet) || bet < 100) return betErrorEl.textContent = "Minimal $100!";
  if (bet > balance) return betErrorEl.textContent = "Saldo tidak cukup!";
  currentBet = bet; 
  betEl.textContent = bet; 
  betModal.classList.remove("active"); 
  startGame();
};

cancelBetBtn.onclick = () => betModal.classList.remove("active");

restartBtn.onclick = () => {
  balance = 5000;
  balanceEl.textContent = balance;
  currentBet = 0;
  betEl.textContent = "0";
  gameoverModal.classList.remove("active"); 
  startBtn.disabled = false; 
  statusEl.textContent = "Game direset! Tekan Mulai Game.";
};

unoBtn.onclick = () => {
  unoPressed = true;
  unoBtn.disabled = true;
  clearTimeout(unoTimer);
  clearInterval(unoInterval);
  unoTimerEl.textContent = ""; 
  statusEl.textContent = "UNO! Tepat waktu!";
};

deckEl.onclick = () => {
  if (!gameActive || currentPlayer !== "player" || waitingForColor) return;
  drawCard("player"); 
  render(); 
  const drawn = playerHand[playerHand.length - 1]; 
  if (canPlay(drawn)) {
    statusEl.textContent = "Kartu bisa dimainkan!";
  } else {
    statusEl.textContent = "Kartu tidak bisa dimainkan. Giliran Bot.";
    setTimeout(() => { 
      currentPlayer = "bot"; 
      botTurn();
    }, 1000);
  }
};

document.querySelectorAll(".color-btn").forEach(btn => { // tombol warna untuk kartu wild
  btn.onclick = () => {
    colorModal.classList.remove("active"); 
    waitingForColor = false;
    currentColor = btn.dataset.color; //untuk ubah currentColor 
    statusEl.textContent = `Kamu pilih warna ${currentColor.toUpperCase()}!`;
    render();
    if (playerHand.length === 1) startUnoTimer("player");
    if (checkWin("player")) return; 
    setTimeout(() => {
      currentPlayer = "bot";
      botTurn();
    }, 1000);
  };
});

// === DECK FUNCTIONS ===
function createDeck() { 
  deck = []; 
  const colors = ["red", "green", "blue", "yellow"];
  const values = ["0","1","2","3","4","5","6","7","8","9","skip","reverse","plus2"];
  
  colors.forEach(color => { 
    values.forEach(value => { 
      deck.push({ color, value, img: `assets/${color}_${value}.png` }); 
    });
  });
  
  for (let i = 0; i < 4; i++) { 
    deck.push({ color: "wild", value: "wild", img: "assets/wild.png" });
    deck.push({ color: "wild", value: "plus4", img: "assets/wild.png" });
  }
  
  deck.sort(() => Math.random() - 0.5); //mengacak urutan kartyu
}

function drawCard(who) {
  if (deck.length === 0) { 
    const top = discardPile.pop(); 
    deck = [...discardPile]; 
    discardPile = [top]; 
    deck.sort(() => Math.random() - 0.5);
    statusEl.textContent = "Deck dikocok ulang!";
  }
  const card = deck.pop(); 
  who === "player" ? playerHand.push(card) : botHand.push(card); 
}

// === GAME FUNCTIONS ===
function startGame() { 
  gameActive = true;
  createDeck();
  playerHand = deck.splice(0, 7); 
  botHand = deck.splice(0, 7);
  
  let first; 
  do {
    first = deck.splice(Math.floor(Math.random() * deck.length), 1)[0]; //math.random untuk ambil kartu acak dari deck math.floor untuk pembulatan kebawah ambil 1 kartu dan simpan di variabel first
  } while (first.color === "wild"); 
  
  discardPile = [first]; 
  currentColor = first.color;
  currentValue = first.value;
  currentPlayer = "player";
  
  render();
  statusEl.textContent = "Giliranmu! Mainkan kartu atau ambil dari deck.";
  startBtn.disabled = true;
  unoBtn.disabled = true;
}

function render() {
  playerHandEl.innerHTML = ""; 
  botHandEl.innerHTML = "";
  
  playerHand.forEach((card, i) => { 
    const img = document.createElement("img"); //buat elemen img baru untuk menampilkan gambar kartu
    img.src = card.img;
    img.className = "card";
    
    if (canPlay(card) && gameActive && currentPlayer === "player" && !waitingForColor) {
      img.onclick = () => playCard(i); 
    } else {
      img.classList.add("disabled"); 
    }
    playerHandEl.appendChild(img); 
  });
  
  botHand.forEach(() => {
    const img = document.createElement("img");
    img.src = "assets/card_back.png";
    img.className = "card";
    botHandEl.appendChild(img);
  });
  
  const top = discardPile[discardPile.length - 1]; //ambil kartu paling atas dari discard pile
  discardPileEl.innerHTML = `<img src="${top.img}" class="card">`; //tampilkan kartu paling atas di discard pile
  
  playerCountEl.textContent = playerHand.length; 
  botCountEl.textContent = botHand.length;
  deckCountEl.textContent = deck.length;
  
  currentColorEl.textContent = currentColor.toUpperCase();
  const colors = {
    red: "#e74c3c",
    green: "#2ecc71",
    blue: "#3498db",
    yellow: "#f1c40f"
  };
  currentColorEl.style.background = colors[currentColor] || "#fff";
}

function canPlay(card) { 
  if (card.color === "wild") {
    if (card.value === "plus4") {
      return !playerHand.some(c => c.color === currentColor || c.value === currentValue);
    }
    return true; 
  }
  return card.color === currentColor || card.value === currentValue;
}

function playCard(i) {
  if (!gameActive || currentPlayer !== "player" || waitingForColor) return;
  
  const card = playerHand[i]; 
  if (!canPlay(card)) return statusEl.textContent = "Kartu tidak bisa dimainkan!";
  
  playerHand.splice(i, 1); 
  discardPile.push(card); 
  
  if (card.color === "wild") {
    waitingForColor = true;
    colorModal.classList.add("active");
    statusEl.textContent = "Pilih warna untuk kartu Wild!";
    render();
    return;
  }
  
  currentColor = card.color; 
  currentValue = card.value;
  render();
  statusEl.textContent = `Kamu mainkan ${card.color.toUpperCase()} ${card.value.toUpperCase()}!`;
  
  if (playerHand.length === 1) startUnoTimer("player");
  if (checkWin("player")) return;
  
  applyEffect(card, "player"); 
}

function botTurn() {
  if (!gameActive) return;
  
  statusEl.textContent = "Giliran Bot...";
  
  setTimeout(() => { 
    let idx = botHand.findIndex(c => c.color === currentColor || c.value === currentValue); 
    
    if (idx === -1) { 
      const wildIdx = botHand.findIndex(c => c.color === "wild" && c.value === "plus4");
      if (wildIdx >= 0 && !botHand.some(c => c.color === currentColor || c.value === currentValue)) {
        idx = wildIdx;
      } else {
        const regularWildIdx = botHand.findIndex(c => c.color === "wild" && c.value === "wild");
        if (regularWildIdx >= 0) idx = regularWildIdx;
      }
    }
    
    if (idx >= 0) {
      const card = botHand.splice(idx, 1)[0]; 
      discardPile.push(card); 
      
      if (card.color === "wild") {
        const count = {red: 0, green: 0, blue: 0, yellow: 0};
        botHand.forEach(c => c.color !== "wild" && count[c.color]++); 
        currentColor = Object.keys(count).reduce((a, b) => count[a] > count[b] ? a : b); 
        currentValue = card.value;
        statusEl.textContent = `Bot mainkan ${card.value.toUpperCase()} dan pilih ${currentColor.toUpperCase()}!`;
      } else {
        currentColor = card.color;
        currentValue = card.value;
        statusEl.textContent = `Bot mainkan ${card.color.toUpperCase()} ${card.value.toUpperCase()}!`;
      }
      
      render();
      
      if (botHand.length === 1) startBotUno();
      if (checkWin("bot")) return;
      
      applyEffect(card, "bot");
    } else {
      drawCard("bot"); 
      render();
      statusEl.textContent = "Bot mengambil kartu.";
      setTimeout(() => {
        currentPlayer = "player";
        statusEl.textContent = "Giliranmu!";
        render();
      }, 1000);
    }
  }, 1200);
}

function applyEffect(card, who) {
  const next = who === "player" ? "bot" : "player";

  if (card.value === "skip" || card.value === "reverse") {
    statusEl.textContent = `${next === "bot" ? "Bot" : "Kamu"} dilewati!`; 
    currentPlayer = who; 
    
    setTimeout(() => {
      if (who === "player") { 
        statusEl.textContent = "Giliranmu lagi!";
        render();
      } else {
        botTurn();
      }
    }, 1500);
    
  } else if (card.value === "plus2") {
    for (let i = 0; i < 2; i++) drawCard(next);
    statusEl.textContent = `${next === "bot" ? "Bot" : "Kamu"} ambil 2 kartu!`;
    render();
    currentPlayer = who;
    
    setTimeout(() => {
      if (who === "player") {
        statusEl.textContent = "Giliranmu lagi!";
        render();
      } else {
        botTurn();
      }
    }, 1500);
    
  } else if (card.value === "plus4") {
    for (let i = 0; i < 4; i++) drawCard(next);
    statusEl.textContent = `${next === "bot" ? "Bot" : "Kamu"} ambil 4 kartu!`;
    render();
    currentPlayer = who;
    
    setTimeout(() => {
      if (who === "player") {
        statusEl.textContent = "Giliranmu lagi!";
        render();
      } else {
        botTurn();
      }
    }, 1500);
    
  } else {
    setTimeout(() => {
      currentPlayer = next;
      if (next === "bot") {
        botTurn();
      } else {
        statusEl.textContent = "Giliranmu!";
        render();
      }
    }, 800);
  }
}

// === UNO SYSTEM ===
function startUnoTimer(who) {
  unoPressed = false;
  unoBtn.disabled = false;
  let time = 5;
  unoTimerEl.textContent = `${time}s`;
  
  unoInterval = setInterval(() => {
    time--;
    unoTimerEl.textContent = `${time}s`;
  }, 1000);
  
  unoTimer = setTimeout(() => { 
    clearInterval(unoInterval);
    if (!unoPressed) {
      drawCard("player");
      drawCard("player");
      statusEl.textContent = "Lupa tekan UNO! +2 kartu!";
      render();
    }
    unoBtn.disabled = true;
    unoTimerEl.textContent = "";
  }, 5000);
}

function startBotUno() {
  botUnoPressed = false;
  const willPress = Math.random() < 0.8; //80% kemungkinan bot akan tekan UNO 20% lupa
  
  if (willPress) {
    setTimeout(() => {
      botUnoPressed = true;
      statusEl.textContent = "Bot tekan UNO!";
    }, Math.random() * 3000); 
  } else {
    setTimeout(() => {
      if (!botUnoPressed) {
        drawCard("bot");
        drawCard("bot");
        statusEl.textContent = "Bot lupa tekan UNO! +2 kartu!";
        render();
      }
    }, 5000);
  }
}

// === WIN CONDITIONS ===
function checkWin(who) {
  if (who === "player" && playerHand.length === 0) {
    gameActive = false;
    balance += currentBet;
    balanceEl.textContent = balance;
    statusEl.textContent = `Kamu menang! +${currentBet}`;
    startBtn.disabled = false;
    currentBet = 0;
    betEl.textContent = "0";
    return true; 
  } else if (who === "bot" && botHand.length === 0) {
    gameActive = false;
    balance -= currentBet;
    balanceEl.textContent = balance;
    statusEl.textContent = `Bot menang! -${currentBet}`;
    
    if (balance <= 0) {
      setTimeout(() => gameoverModal.classList.add("active"), 1500);
    } else {
      startBtn.disabled = false;
    }
    
    currentBet = 0;
    betEl.textContent = "0";
    return true;
  }
  return false;
}