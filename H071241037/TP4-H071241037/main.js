document.addEventListener("DOMContentLoaded", () => { // Memastikan seluruh kode JavaScript dijalankan HANYA setelah semua elemen HTML selesai dimuat.
  // ===================================================================================
  // REFERENSI DOM & VARIABEL GLOBAL
  // ===================================================================================
  const playerHandDiv = document.getElementById("player-hand");
  const cpuHandDiv = document.getElementById("cpu-hand");
  const discardPileDiv = document.getElementById("discard-pile");
  const drawPileImg = document.getElementById("draw-pile");
  const statusText = document.getElementById("status-text");
  const unoButton = document.getElementById("uno-button");
  const playerBalanceSpan = document.getElementById("player-balance");
  const betAmountInput = document.getElementById("bet-amount");
  const startRoundButton = document.getElementById("start-round-button");
  const playerHandTitle = document.getElementById("player-hand-title");
  const cpuHandTitle = document.getElementById("cpu-hand-title");
  const activeColorText = document.getElementById("active-color-text");
  const challengeUnoButton = document.getElementById("challenge-uno-button");

  let deck = [];
  let playerHand = [];
  let cpuHand = [];
  let discardPile = [];
  let currentPlayer = "player";
  let playerBalance = 5000;
  let unoTimer = null;
  let unoCalled = false;
  let playerHasDrawnThisTurn = false;
  let challengeTimer = null;
  let cpuUnoCalled = false;
  const colorMap = {
    Merah: "text-red-400",
    Hijau: "text-green-400",
    Biru: "text-blue-400",
    Kuning: "text-yellow-300",
  };

  // ===================================================================================
  // FUNGSI-FUNGSI UTAMA PERSIAPAN
  // ===================================================================================

  // Fungsi untuk membuat satu set dek UNO lengkap (108 kartu).
  function createDeck() {
    deck = [];
    let cardIdCounter = 0; // Membuat penghitung untuk memberikan ID unik pada setiap kartu.
    const colors = [
      { js: "Merah", file: "red" },
      { js: "Hijau", file: "green" },
      { js: "Biru", file: "blue" },
      { js: "Kuning", file: "yellow" },
    ];
    const values = [
      "0", "1", "2", "3", "4", "5", "6", "7", "8", "9",
      "Skip", "Reverse", "Draw2",
    ];
    for (let color of colors) {
      for (let value of values) {
        let fileValue = value;
        if (value === "Skip") fileValue = "10";
        if (value === "Reverse") fileValue = "11";
        if (value === "Draw2") fileValue = "12";
        
        // PERBAIKAN: Menambahkan objek kartu pertama (selalu baru).
        deck.push({
          id: cardIdCounter++, // Memberikan ID unik (0, 1, 2, ...).
          color: color.js,
          value,
          image: `asset/${color.file}${fileValue}.png`,
        });

        // PERBAIKAN: Menambahkan kartu kedua sebagai OBJEK BARU jika nilainya bukan "0".
        if (value !== "0") {
          deck.push({
            id: cardIdCounter++, // Memberikan ID unik yang berbeda dari kartu pertamanya.
            color: color.js,
            value,
            image: `asset/${color.file}${fileValue}.png`,
          });
        }
      }
    }
    // PERBAIKAN: Menambahkan kartu Wild sebagai objek baru setiap kali.
    for (let i = 0; i < 4; i++) {
        deck.push({ id: cardIdCounter++, color: "Liar", value: "Wild", image: "asset/wild13.png" });
        deck.push({ id: cardIdCounter++, color: "Liar", value: "Wild4", image: "asset/wild14.png" });
    }
  }

  // Fungsi untuk mengacak urutan kartu di dalam dek.
  function shuffleDeck() {
    for (let i = deck.length - 1; i > 0; i--) {
      const j = Math.floor(Math.random() * (i + 1));
      [deck[i], deck[j]] = [deck[j], deck[i]];
    } 
  }

  // Fungsi utama yang dijalankan saat ronde baru dimulai.
  function startNewRound() {
    const bet = parseInt(betAmountInput.value);
    if (isNaN(bet) || bet < 100 || bet > playerBalance) {
      updateStatus("Taruhan tidak valid! (Min. $100)");
      return;
    }

    playerBalance -= bet;
    updateBalanceDisplay();
    startRoundButton.disabled = true;
    betAmountInput.disabled = true;

    clearTimeout(unoTimer);
    unoButton.classList.add("hidden");
    clearTimeout(challengeTimer);
    challengeUnoButton.classList.add("hidden");
    unoCalled = false;
    cpuUnoCalled = false;

    createDeck();
    shuffleDeck();
    playerHand = deck.splice(0, 7);
    cpuHand = deck.splice(0, 7);
    let startCard = deck.pop();
    while (startCard.value === "Wild4") {
      deck.push(startCard);
      shuffleDeck();
      startCard = deck.pop();
    }
    discardPile = [startCard];
    if (startCard.color === "Liar") {
      startCard.color = ["Merah", "Hijau", "Biru", "Kuning"][Math.floor(Math.random() * 4)];
    }
    currentPlayer = "player";
    renderAll();
    updateStatus("Ronde dimulai. Giliran Anda!");
  }

  // ===================================================================================
  // FUNGSI-FUNGSI TAMPILAN (RENDER)
  // ===================================================================================

  function renderAll() {
    renderHand(playerHand, playerHandDiv, "player");
    renderHand(cpuHand, cpuHandDiv, "cpu");
    renderDiscardPile();
    updateHandTitles();
  }

  function renderHand(hand, element, owner) {
    element.innerHTML = "";
    hand.forEach((card) => {
      const cardImg = document.createElement("img");
      cardImg.src = owner === "player" ? card.image : "asset/back.png";
      cardImg.className = "w-24 h-36";
      
      if (owner === "player") {
        cardImg.classList.add("player-card", "cursor-pointer");
        cardImg.addEventListener("click", () => playerPlayCard(card));
      }

      element.appendChild(cardImg);
    });
  }
  
  function renderDiscardPile() {
    const topCard = discardPile[discardPile.length - 1];
    discardPileDiv.innerHTML = `<img src="${topCard.image}" alt="${topCard.color} ${topCard.value}" class="w-full h-full rounded-lg shadow-lg">`;
    activeColorText.textContent = `Warna: ${topCard.color}`;
    activeColorText.className = "text-center mt-2 font-bold";
    if (colorMap[topCard.color]) {
      activeColorText.classList.add(colorMap[topCard.color]);
    }
    if (topCard.color === "Liar") {
      activeColorText.textContent = "Pilih warna!";
    }
  }

  function updateHandTitles() {
    playerHandTitle.textContent = `Kartu Anda (${playerHand.length} kartu)`;
    cpuHandTitle.textContent = `Bot (${cpuHand.length} kartu)`;
  }

  function updateStatus(message) {
    statusText.textContent = message;
  }
  
  function updateBalanceDisplay() {
    playerBalanceSpan.textContent = `$${playerBalance}`;
  }

  // ===================================================================================
  // FUNGSI LOGIKA PERMAINAN
  // ===================================================================================
  
  function isMoveValid(card, hand) {
    const topCard = discardPile[discardPile.length - 1];
    if (card.color === "Liar") {
      if (card.value === "Wild4") {
        const hasPlayableCard = hand.some(
          (c) => c.color !== "Liar" && (c.color === topCard.color || c.value === topCard.value)
        );
        return !hasPlayableCard;
      }
      return true;
    }
    return card.color === topCard.color || card.value === topCard.value;
  }
  
  function playerPlayCard(card) {
    if (currentPlayer !== "player") return;

    if (!isMoveValid(card, playerHand)) {
      updateStatus("Kartu tidak valid!");
      return;
    }

    // PERBAIKAN: Menggunakan ID unik untuk memfilter kartu, bukan referensi objek.
    playerHand = playerHand.filter((c) => c.id !== card.id);
    discardPile.push(card);
    playerHasDrawnThisTurn = false;

    clearTimeout(unoTimer);
    unoButton.classList.add("hidden");

    renderAll();

    if (playerHand.length === 0) {
      endRound("player");
      return;
    }

    if (playerHand.length === 1) {
      startUnoTimer("player");
    }

    handleCardEffect(card, "player");
  }
  
  function cpuTurn() {
    updateStatus("Giliran Bot...");
    setTimeout(() => {
      let cardToPlay = cpuHand.find((card) => isMoveValid(card, cpuHand));
      if (cardToPlay) {
        // PERBAIKAN: CPU juga menggunakan ID unik untuk memfilter kartunya.
        cpuHand = cpuHand.filter((c) => c.id !== cardToPlay.id);
        discardPile.push(cardToPlay);

        clearTimeout(challengeTimer);
        challengeUnoButton.classList.add("hidden");
        cpuUnoCalled = false; 

        if (cpuHand.length === 1) {
          challengeUnoButton.classList.remove("hidden");
          challengeTimer = setTimeout(() => {
            cpuUnoCalled = true; 
            updateStatus("Bot berhasil UNO!");
            challengeUnoButton.classList.add("hidden");
          }, 3000);
        }

        if (cpuHand.length === 0) {
          renderAll();
          endRound("cpu");
          return;
        }
        handleCardEffect(cardToPlay, "cpu");
      } else {
        if (deck.length > 0) cpuHand.push(deck.pop());
        updateStatus("Bot mengambil kartu dan melewati giliran.");
        switchTurn();
      }
      renderAll();
    }, 1500);
  }

  function handleCardEffect(card, playedBy) {
    const opponent = playedBy === "player" ? "cpu" : "player";

    switch (card.value) {
      case "Draw2":
      case "Skip":
      case "Reverse":
        if(card.value === "Draw2") drawCards(opponent, 2);
        updateStatus(`${playedBy.toUpperCase()} main ${card.value}. Giliran ${playedBy} lagi!`);
        if (playedBy === "cpu") setTimeout(cpuTurn, 1000);
        return;

      case "Wild":
      case "Wild4":
        if (card.value === "Wild4") drawCards(opponent, 4);
        if (playedBy === "player") {
          setTimeout(chooseColorPrompt, 100);
        } else {
          const colorsInHand = cpuHand.map((c) => c.color).filter((c) => c !== "Liar");
          const colorCounts = colorsInHand.reduce((acc, color) => { acc[color] = (acc[color] || 0) + 1; return acc; }, {});
          const chosenColor = Object.keys(colorCounts).sort((a, b) => colorCounts[b] - colorCounts[a])[0] || ["Merah", "Hijau", "Biru", "Kuning"][Math.floor(Math.random() * 4)];
          
          discardPile[discardPile.length - 1].color = chosenColor;
          updateStatus(`Bot memilih warna ${chosenColor}.`);
          renderDiscardPile();
          switchTurn();
        }
        return;
    }
    switchTurn();
  }

  function chooseColorPrompt() {
    const overlay = document.createElement("div");
    overlay.style.cssText = "position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.7); z-index:99; display:flex; justify-content:center; align-items:center;";

    const colorPickerDiv = document.createElement("div");
    colorPickerDiv.style.cssText = "background-color:#1F2937; padding:2rem; border-radius:10px; z-index:100; color:white;";
    colorPickerDiv.innerHTML = `<h3 class="text-center mb-4 text-xl font-bold">Pilih Warna:</h3>`;

    const buttonContainer = document.createElement("div");
    buttonContainer.className = "flex gap-4";
    colorPickerDiv.appendChild(buttonContainer);

    function selectColor(color) {
      discardPile[discardPile.length - 1].color = color;
      updateStatus(`Anda memilih warna ${color}.`);
      renderDiscardPile();
      switchTurn();
      document.body.removeChild(overlay);
    }
    
    const colorChoices = ["Merah", "Hijau", "Biru", "Kuning"];
    colorChoices.forEach((color) => {
      const button = document.createElement("button");
      button.textContent = color;
      button.className = `font-bold py-2 px-4 rounded transition-colors bg-${color.toLowerCase()}-600 hover:bg-${color.toLowerCase()}-700`;
      button.onclick = () => selectColor(color);
      buttonContainer.appendChild(button);
    });
    
    overlay.appendChild(colorPickerDiv);
    document.body.appendChild(overlay);
  }

  function drawCards(player, amount) {
    for (let i = 0; i < amount; i++) {
      if (deck.length > 0) {
        if (player === "player") playerHand.push(deck.pop());
        else cpuHand.push(deck.pop());
      }
    }
  }

  function switchTurn() {
    currentPlayer = currentPlayer === "player" ? "cpu" : "player";
    playerHasDrawnThisTurn = false;
    if (currentPlayer === "cpu") {
      cpuTurn();
    } else {
      updateStatus("Giliran Anda!");
    }
  }

  function endRound(winner) {
    const bet = parseInt(betAmountInput.value);
    let message = "";
    if (winner === "player") {
      playerBalance += bet * 2;
      message = `Anda MENANG dan mendapat $${bet * 2}!`;
    } else {
      message = `Anda KALAH taruhan $${bet}.`;
    }
    
    clearTimeout(challengeTimer);
    challengeUnoButton.classList.add("hidden");
    clearTimeout(unoTimer);
    unoButton.classList.add("hidden");
    
    alert(message);

    if (playerBalance <= 0) {
      alert("Game Over! Saldo Anda habis. Saldo direset ke $5000.");
      playerBalance = 5000;
    }
    resetForNewRound();
  }

  function resetForNewRound() {
    updateBalanceDisplay();
    startRoundButton.disabled = false;
    betAmountInput.disabled = false;
    updateStatus("Masukkan taruhan dan mulai ronde baru.");
    playerHandDiv.innerHTML = "";
    cpuHandDiv.innerHTML = "";
    discardPileDiv.innerHTML = "";
    activeColorText.textContent = "";
  }
  
  function startUnoTimer(player) {
    unoButton.classList.remove("hidden");
    unoCalled = false;
    unoTimer = setTimeout(() => {
      if (!unoCalled) {
        updateStatus(`${player.toUpperCase()} lupa UNO! Penalti +2 kartu.`);
        drawCards(player, 2);
        renderAll();
      }
      unoButton.classList.add("hidden");
    }, 5000);
  }

  // EVENT LISTENERS & INISIALISASI
  startRoundButton.addEventListener("click", startNewRound);
  drawPileImg.addEventListener("click", () => {
    if (currentPlayer !== "player") return;

    if (playerHasDrawnThisTurn) {
      updateStatus("Anda melewati giliran.");
      switchTurn();
    } else {
      if (deck.length > 0) {
        playerHand.push(deck.pop());
        playerHasDrawnThisTurn = true;
        renderAll();
        updateStatus("Anda mengambil kartu. Mainkan kartu atau klik tumpukan lagi untuk lewat.");
      } else {
        updateStatus("Tumpukan kartu ambil telah habis!");
      }
    }
  });

  unoButton.addEventListener("click", () => {
    unoCalled = true;
    clearTimeout(unoTimer);
    updateStatus("UNO!");
    unoButton.classList.add("hidden");
  });

  challengeUnoButton.addEventListener("click", () => {
    if (cpuHand.length !== 1 || cpuUnoCalled) return;

    clearTimeout(challengeTimer);
    updateStatus("Anda berhasil memanggil UNO pada Bot! Bot mengambil 2 kartu.");
    drawCards("cpu", 2);
    renderAll();
    challengeUnoButton.classList.add("hidden");
  });
  
  updateBalanceDisplay();
});f