// ==========================
// script.js — versi saldo sinkron
// ==========================
const colors = ["red", "blue", "green", "yellow"];
let deck = [];
let playerHand = [];
let botHand = [];
let discardPile = [];
let turn = "player";
let saldo = 5000;
let bet = 0;
let unoPressed = false;
let unoTimer = null;
let lastPlayedBy = null;

// ---------- Utils ----------
function createDeck() {
  deck = [];
  colors.forEach(color => {
    for (let i = 0; i <= 9; i++) deck.push({ color, value: i, img: `asset/${color}_${i}.png` });
    ["skip", "reverse", "plus2"].forEach(action =>
      deck.push({ color, value: action, img: `asset/${color}_${action}.png` })
    );
  });
  for (let i = 0; i < 4; i++) {
    deck.push({ color: "wild", value: "wild", img: `asset/wild.png` });
    deck.push({ color: "wild", value: "wild4", img: `asset/plus_4.png` });
  }
}

function shuffle(arr) {
  for (let i = arr.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [arr[i], arr[j]] = [arr[j], arr[i]];
  }
  return arr;
}

function reshuffleDeck() {
  if (discardPile.length <= 1) return;
  const top = discardPile.pop();
  const rest = discardPile.splice(0);
  deck = shuffle(rest);
  discardPile = [top];
}

function ensureDeck() {
  if (deck.length === 0) reshuffleDeck();
}

// ---------- Start Round ----------
function startRound() {
  bet = parseInt(document.getElementById("bet-amount").value);
  if (isNaN(bet) || bet < 100 || bet > saldo) {
    alert("Taruhan tidak valid!");
    return;
  }
  saldo -= bet;

  // update tampilan saldo & taruhan
  document.getElementById("saldo").textContent = saldo;
  document.getElementById("saldo-info").textContent = saldo;
  document.getElementById("taruhan-info").textContent = bet;

  // reset semua data ronde
  playerHand = [];
  botHand = [];
  discardPile = [];
  createDeck();
  shuffle(deck);

  // bagi 7 kartu ke masing-masing
  for (let i = 0; i < 7; i++) {
    ensureDeck(); playerHand.push(deck.pop());
    ensureDeck(); botHand.push(deck.pop());
  }

  // ambil kartu pertama untuk discard (tidak boleh wild/wild4)
  let firstCard;
  do {
    ensureDeck();
    firstCard = deck.pop();
    if (firstCard.color === "wild") {
      // masukkan kembali ke deck dan acak ulang
      deck.unshift(firstCard);
      shuffle(deck);
      firstCard = null;
    }
  } while (!firstCard);

  // masukkan kartu pertama yang valid ke discard
  discardPile.push(firstCard);

  // tampilkan game board
  document.getElementById("bet-section").style.display = "none";
  document.getElementById("game").style.display = "grid";
  document.getElementById("status").textContent = "Giliran Player";

  // reset state
  turn = "player";
  lastPlayedBy = null;
  unoPressed = false;
  if (unoTimer) { clearTimeout(unoTimer); unoTimer = null; }

  updateUI();
}


// ---------- UI Update ----------
function updateUI() {
  const playerCardsDiv = document.getElementById("player-cards");
  const botCardsDiv = document.getElementById("bot-cards");
  const discardImg = document.getElementById("discard");

  playerCardsDiv.innerHTML = "";
  botCardsDiv.innerHTML = "";

  playerHand.forEach((card, index) => {
    const img = document.createElement("img");
    img.src = card.img;
    img.addEventListener("click", () => playCard(index));
    playerCardsDiv.appendChild(img);
  });

  botHand.forEach(() => {
    const img = document.createElement("img");
    img.src = "asset/card_back.png";
    botCardsDiv.appendChild(img);
  });

  if (discardPile.length > 0) {
    const top = discardPile[discardPile.length - 1];
    discardImg.src = top.img;
    updateDiscardColorIndicator(top);
  } else {
    discardImg.src = "asset/card_back.png";
    updateDiscardColorIndicator(null);
  }

  if (playerHand.length !== 1) {
    document.getElementById("uno-btn").style.display = "none";
  }

  // pastikan saldo & taruhan sidebar selalu sinkron
  document.getElementById("saldo-info").textContent = saldo;
  document.getElementById("taruhan-info").textContent = bet;
}

// ---------- Indikator warna aktif ----------
function updateDiscardColorIndicator(topCard) {
  let indicator = document.getElementById("discard-color");
  if (!indicator) {
    const discardImg = document.getElementById("discard");
    indicator = document.createElement("div");
    indicator.id = "discard-color";
    indicator.style.marginTop = "8px";
    indicator.style.fontWeight = "bold";
    indicator.style.color = "#fff";
    discardImg.insertAdjacentElement("afterend", indicator);
  }

  if (!topCard) {
    indicator.textContent = "Warna aktif: -";
    indicator.style.background = "transparent";
    return;
  }

  let activeColor = topCard.color;
  if ((topCard.value === "wild" || topCard.value === "wild4") && topCard.chosenColor) {
    activeColor = topCard.chosenColor;
  }

  if (!activeColor || activeColor === "wild") {
    indicator.textContent = "Warna aktif: (belum dipilih)";
    indicator.style.background = "transparent";
  } else {
    indicator.textContent = "Warna aktif: " + activeColor;
    indicator.style.background = activeColor;
    indicator.style.padding = "6px 10px";
    indicator.style.borderRadius = "6px";
  }
}

// ---------- Validasi kartu ----------
function isValid(card, top) {
  if (card.color === "wild") return true;
  let topColor = top.color;
  if ((top.value === "wild" || top.value === "wild4") && top.chosenColor) {
    topColor = top.chosenColor;
  }
  return card.color === topColor || card.value === top.value;
}

// ---------- Player play ----------
function playCard(index) {
  if (turn !== "player") return;
  const card = playerHand[index];
  const top = discardPile[discardPile.length - 1];

  if (!isValid(card, top)) {
    alert("Kartu tidak valid!");
    return;
  }

  lastPlayedBy = "player";
  discardPile.push(card);
  playerHand.splice(index, 1);
  updateUI();

  if (checkWinner()) return;

  if (card.color === "wild") {
    document.getElementById("color-picker").style.display = "block";

    if (card.value === "wild4") {
      for (let i = 0; i < 4; i++) { ensureDeck(); botHand.push(deck.pop()); }
      document.getElementById("status").textContent = "Player main Wild +4! Bot +4 kartu.";
      updateUI();
      if (playerHand.length === 1) startUnoTimer("player");
      return;
    } else {
      if (playerHand.length === 1) startUnoTimer("player");
      return;
    }
  }

  if (card.value === "plus2") {
    for (let i = 0; i < 2; i++) { ensureDeck(); botHand.push(deck.pop()); }
    document.getElementById("status").textContent = "Player main +2! Bot +2 kartu.";
    updateUI();
    if (playerHand.length === 1) startUnoTimer("player");
    return;
  }

  if (card.value === "skip" || card.value === "reverse") {
    document.getElementById("status").textContent = "Bot dilewati!";
    updateUI();
    if (playerHand.length === 1) startUnoTimer("player");
    return;
  }

  if (playerHand.length === 1) startUnoTimer("player");
  turn = "bot";
  document.getElementById("status").textContent = "Giliran Bot";
  setTimeout(botTurn, 700);
}

// ---------- Player draw ----------
function drawCard() {
  if (turn !== "player") return;
  ensureDeck();
  if (deck.length === 0) {
    document.getElementById("status").textContent = "Tidak ada kartu tersisa.";
    return;
  }
  playerHand.push(deck.pop());
  document.getElementById("status").textContent = "Player mengambil kartu.";
  updateUI();
  turn = "bot";
  setTimeout(botTurn, 700);
}

// ---------- Bot logic ----------
function botTurn() {
  ensureDeck();
  if (turn !== "bot") return;
  const top = discardPile[discardPile.length - 1];

  for (let i = 0; i < botHand.length; i++) {
    const c = botHand[i];
    if (isValid(c, top)) {
      lastPlayedBy = "bot";
      discardPile.push(c);
      botHand.splice(i, 1);
      updateUI();
      if (checkWinner()) return;

      if (c.color === "wild") {
        const chosen = colors[Math.floor(Math.random() * colors.length)];
        discardPile[discardPile.length - 1].chosenColor = chosen;
        document.getElementById("status").textContent = `Bot pilih warna ${chosen}.`;
        if (c.value === "wild4") {
          for (let k = 0; k < 4; k++) { ensureDeck(); playerHand.push(deck.pop()); }
          document.getElementById("status").textContent = "Bot main Wild +4! Player +4 kartu.";
          updateUI();
          setTimeout(botTurn, 700);
          return;
        } else {
          turn = "player";
          updateUI();
          return;
        }
      }

      if (c.value === "plus2") {
        for (let k = 0; k < 2; k++) { ensureDeck(); playerHand.push(deck.pop()); }
        document.getElementById("status").textContent = "Bot main +2! Player +2 kartu.";
        updateUI();
        setTimeout(botTurn, 700);
        return;
      }

      if (c.value === "skip" || c.value === "reverse") {
        document.getElementById("status").textContent = "Bot main Skip! Player dilewati.";
        updateUI();
        setTimeout(botTurn, 700);
        return;
      }

      turn = "player";
      document.getElementById("status").textContent = "Giliran Player";
      updateUI();
      return;
    }
  }

  ensureDeck();
  if (deck.length > 0) {
    botHand.push(deck.pop());
    document.getElementById("status").textContent = "Bot mengambil kartu.";
  }
  turn = "player";
  updateUI();
}

// ---------- Pilih warna ----------
function chooseColor(color) {
  const top = discardPile[discardPile.length - 1];
  top.chosenColor = color;
  document.getElementById("color-picker").style.display = "none";
  document.getElementById("status").textContent = `Player memilih warna ${color}.`;
  updateUI();

  if (top.value !== "wild4") {
    turn = "bot";
    setTimeout(botTurn, 700);
  }
}

// ---------- UNO ----------
function startUnoTimer(who) {
  if (who !== "player") return;
  unoPressed = false;
  document.getElementById("uno-btn").style.display = "inline-block";
  if (unoTimer) clearTimeout(unoTimer);
  unoTimer = setTimeout(() => {
    document.getElementById("uno-btn").style.display = "none";
    if (!unoPressed) {
      for (let i = 0; i < 2; i++) { ensureDeck(); playerHand.push(deck.pop()); }
      document.getElementById("status").textContent = "UNO lupa ditekan! +2 kartu.";
      updateUI();
    }
    unoPressed = false;
    unoTimer = null;
  }, 3000);
}

function pressUNO() {
  if (playerHand.length !== 1) return;
  unoPressed = true;
  document.getElementById("uno-btn").style.display = "none";
  document.getElementById("status").textContent = "UNO ditekan!";
}

// ---------- Winner ----------
function checkWinner() {
  if (playerHand.length === 0) {
    saldo += bet * 2;
    document.getElementById("status").textContent = `Player Menang! +${bet}, Saldo: $${saldo}`;
    updateSaldoDisplay();
    endRound();
    return true;
  } else if (botHand.length === 0) {
    document.getElementById("status").textContent = `Bot Menang! -${bet}, Saldo: $${saldo}`;
    updateSaldoDisplay();
    endRound();
    return true;
  }
  updateSaldoDisplay();
  return false;
}

function updateSaldoDisplay() {
  document.getElementById("saldo").textContent = saldo;
  document.getElementById("saldo-info").textContent = saldo;
  document.getElementById("taruhan-info").textContent = bet;
}

// ---------- End & Surrender ----------
function endRound() {
  document.getElementById("bet-section").style.display = "block";
  document.getElementById("game").style.display = "none";
  document.getElementById("color-picker").style.display = "none";
  bet = 0;
  updateSaldoDisplay();
  if (unoTimer) { clearTimeout(unoTimer); unoTimer = null; }
  unoPressed = false;
}

function surrender() {
  document.getElementById("status").textContent = `Kamu menyerah! -${bet}, Saldo: $${saldo}`;
  endRound();
}
