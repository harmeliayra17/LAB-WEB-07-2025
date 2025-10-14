// ====== UTIL ======
// Fungsi utilitas untuk mempermudah manipulasi DOM dan format data
const $ = (s, p = document) => p.querySelector(s); // Selektor elemen tunggal
const $$ = (s, p = document) => Array.from(p.querySelectorAll(s)); // Selektor multiple elemen
const fmt = n => Number(n).toLocaleString('id-ID'); // Format angka ke format Indonesia
// Konversi string ke number, menghilangkan karakter non-digit
const toNum = (t) => {
  const str = String(t ?? '').trim();
  const clean = str.replace(/[^\d.,-]/g, '').replace(/\./g, '').replace(',', '.');
  const n = parseFloat(clean);
  return Number.isFinite(n) ? Math.floor(n) : 0;
};

// ---- TIMERS & CONTROL GUARD ----
const timers = []; // Array untuk menyimpan semua timer aktif
const schedule = (fn, ms) => { const id = setTimeout(fn, ms); timers.push(id); return id; }; // Fungsi untuk menjadwalkan eksekusi fungsi
const clearAllTimers = () => { while (timers.length) clearTimeout(timers.pop()); }; // Membersihkan semua timer
function disableControls(disabled) {
  // Fungsi untuk menonaktifkan/mengaktifkan kontrol game berdasarkan giliran
  const controls = [drawBtn, skipBtn, unoBtn, callUnoBtn].filter(Boolean);
  controls.forEach(b => b.disabled = disabled);
}

// ====== ELEMENTS ======
// Mendefinisikan semua elemen DOM yang akan digunakan dalam game
const bettingScreen = $('#bettingScreen'); // Layar taruhan awal
const gameBoard = $('#gameBoard'); // Papan game utama
const initialBalanceEl = $('#initial-balance'); // Elemen saldo awal
const initialBetAmount = $('#initialBetAmount'); // Input jumlah taruhan
const startGameBtn = $('#startGame'); // Tombol mulai game
const exitGameBtn = $('#exitGame'); // Tombol keluar game

const botRow = $('#botRow'); // Area untuk menampilkan kartu bot
const playerRow = $('#playerRow'); // Area untuk menampilkan kartu player
const botCountEl = $('#botCount'); // Counter jumlah kartu bot
const playerCountEl = $('#playerCount'); // Counter jumlah kartu player

const topCardImg = $('#topCard'); // Gambar kartu teratas di discard pile
const deckCountEl = $('#deckCount'); // Counter sisa kartu di deck
const deckInfoText = $('#deckInfoText'); // Teks informasi deck
const drawBtn = $('#drawBtn'); // Tombol ambil kartu
const infoText = $('#infoText'); // Area untuk menampilkan informasi game

// Panel kanan (saldo & bet)
const balanceEl = $('#player-balance'); // Elemen saldo player
const betEl = $('#player-bet'); // Elemen taruhan player
const botBetEl = $('#bot-bet'); // Elemen taruhan bot
const totalBetEl = $('#total-bet'); // Elemen total taruhan

// Aksi kanan
const skipBtn = $('#skipBtn'); // Tombol skip giliran
const unoBtn = $('#unoBtn'); // Tombol deklarasi UNO
const callUnoBtn = $('#callUnoBtn'); // Tombol panggil UNO pada bot

// Wild modal
const wildModal = $('#wildModal'); // Modal untuk memilih warna wild card
const wildCancel = $('#wildCancel'); // Tombol batal di modal wild
const wildChips = wildModal ? wildModal.querySelectorAll('.color-chip') : []; // Chip pilihan warna

// ====== STATE ======
// Variabel state game yang menyimpan kondisi permainan saat ini
const CARD_PATH = 'assets/'; // Path folder gambar kartu
const FULL_DECK_SIZE = 108; // Total kartu dalam deck UNO lengkap

let turn = 'idle'; // State giliran: 'idle', 'player', 'bot', 'ended'
let deckCount = FULL_DECK_SIZE; // Jumlah kartu tersisa di deck
let botHand = []; // Array untuk menyimpan kartu di tangan bot
let pendingWild = null; // Menyimpan kartu wild yang sedang menunggu pemilihan warna
let pendingWildIsDrawFour = false;  // Flag menandakan apakah wild card adalah +4
let skipOpponentOnce = false; // Flag untuk melewatkan giliran lawan
let drawTwoNext = false;   // Flag untuk efek +2 (player → bot)
let drawFourNext = false;  // Flag untuk efek +4 (player → bot)
let reverseDirection = false; // Flag untuk reverse (belum diimplementasi penuh)
let lockedBet = false; // Flag menandakan taruhan sudah terkunci
let botBet = 0; // Jumlah taruhan bot
let activeColor = null; // Warna aktif saat ini di discard pile

// --- UNO state ---
let playerUnoPending = false; // Flag menandakan player perlu tekan UNO
let playerUnoTimer = null; // Timer untuk window UNO player
let botUnoPending = false; // Flag menandakan bot perlu tekan UNO
let botUnoTimer = null; // Timer untuk window UNO bot

// ====== DECK MANAGEMENT ======
let deck = []; // Array untuk deck kartu aktif
let discardPile = []; // Array untuk discard pile

// Fungsi untuk menginisialisasi deck UNO dengan komposisi yang benar
function initializeDeck() {
  deck = [];
  const colors = ['red', 'blue', 'green', 'yellow'];
  
  colors.forEach(color => {
    // Angka 0 - hanya satu per warna
    deck.push(`${color}_0`);
    
    // Angka 1-9 - dua setiap angka per warna
    for (let num = 1; num <= 9; num++) {
      deck.push(`${color}_${num}`);
      deck.push(`${color}_${num}`);
    }
    
    // Action cards - dua setiap jenis per warna
    deck.push(`${color}_skip`);
    deck.push(`${color}_skip`);
    deck.push(`${color}_reverse`);
    deck.push(`${color}_reverse`);
    deck.push(`${color}_plus2`);
    deck.push(`${color}_plus2`);
  });
  
  // Wild cards - empat setiap jenis
  for (let i = 0; i < 4; i++) {
    deck.push('wild');
    deck.push('plus4');
  }
  
  // Total harus 108 kartu
  console.log('Deck initialized with', deck.length, 'cards');
}

// Fungsi untuk mengacak deck menggunakan algoritma Fisher-Yates
function shuffleDeck() {
  for (let i = deck.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [deck[i], deck[j]] = [deck[j], deck[i]];
  }
}

// Fungsi untuk mengambil kartu dari deck
function drawCard() {
  if (deck.length === 0) {
    // Jika deck habis, reset dari discard pile (kecuali kartu teratas)
    if (discardPile.length > 1) {
      const topCard = discardPile.pop(); // Simpan kartu teratas
      deck = [...discardPile];
      discardPile = [topCard];
      shuffleDeck();
      setInfo('Deck habis! Mengacak ulang dari kartu buangan...');
    } else {
      setInfo('Tidak ada kartu lagi!');
      return null;
    }
  }
  
  const card = deck.pop();
  deckCount = deck.length;
  updateDeckInfo();
  return `${CARD_PATH}${card}.png`;
}

// Fungsi untuk menambahkan kartu ke discard pile
function addToDiscardPile(cardSrc) {
  const cardName = cardSrc.replace(CARD_PATH, '').replace('.png', '');
  discardPile.push(cardName);
}

// ====== INFO ======
// Fungsi untuk menampilkan informasi game kepada player
const setInfo = (msg) => {
  if (!infoText) {
    console.warn('infoText element not found');
    return;
  }
  infoText.textContent = msg;
  infoText.parentElement?.classList.add('pulse');
  setTimeout(() => infoText.parentElement?.classList.remove('pulse'), 500);
};

// Fungsi untuk mengatur giliran dan menampilkan informasi yang sesuai
function setTurn(who, reason='') {
  turn = who;
  const msg = who === 'player' ? 'Giliran kamu' : 'Giliran bot';
  setInfo(reason ? `${msg} — ${reason}` : msg);
  // player hanya bisa klik tombol saat gilirannya
  disableControls(who !== 'player');
  if (who === 'player') updatePlayableHints();
}

// Fungsi untuk memperbarui informasi deck di UI
function updateDeckInfo() {
  if (deckCountEl) deckCountEl.textContent = String(deckCount);
  if (deckInfoText) {
    const pretty = activeColor ? activeColor[0].toUpperCase() + activeColor.slice(1) : '-';
    deckInfoText.textContent = `Sisa Kartu: ${deckCount}${activeColor ? ` • Warna Aktif: ${pretty}` : ''}`;
  }
}

// Fungsi untuk mengatur warna aktif
function setActiveColor(key) { activeColor = key; updateDeckInfo(); }

// Fungsi untuk mendapatkan warna aktif saat ini
function getActiveColor() {
  const guess = detectColorFromSrc(topCardImg.src);
  return activeColor || guess || 'wild';
}

// Fungsi untuk membersihkan timer UNO
function clearUnoTimers() {
  if (playerUnoTimer) { clearTimeout(playerUnoTimer); playerUnoTimer = null; }
  if (botUnoTimer) { clearTimeout(botUnoTimer); botUnoTimer = null; }
}

// Fungsi untuk memulai window UNO untuk player (5 detik)
function startPlayerUnoWindow() {
  playerUnoPending = true;
  clearTimeout(playerUnoTimer);
  setInfo('Kamu tinggal 1 kartu! Tekan tombol UNO dalam 5 detik!');
  playerUnoTimer = setTimeout(() => {
    if (playerUnoPending) {
      // Penalti +2 kartu jika lupa tekan UNO
      for (let i = 0; i < 2; i++) {
        const newCard = drawCard();
        if (newCard) {
          playerRow.appendChild(createCard(newCard, 'lg'));
        }
      }
      updateDeckInfo(); refreshCounts(); updatePlayableHints();
      setInfo('Lupa menekan UNO → penalti +2 kartu.');
    }
    playerUnoPending = false; playerUnoTimer = null;
  }, 5000);
}

// Fungsi untuk memulai window UNO untuk bot (5 detik)
function startBotUnoWindow() {
  botUnoPending = true;
  clearTimeout(botUnoTimer);
  setInfo('Bot tinggal 1 kartu! Panggil UNO dalam 5 detik kalau bot lupa!');
  botUnoTimer = setTimeout(() => { botUnoPending = false; botUnoTimer = null; }, 5000);
}

// ====== KARTU / LOGIKA ======
// Fungsi untuk membuat elemen kartu dari sumber gambar
function createCard(src, size = 'lg') {
  const img = document.createElement('img');
  img.src = src;
  img.alt = 'card';
  img.className = `card-img card-${size}`;
  img.draggable = false;
  img.onerror = function () {
    console.error('Gambar tidak ditemukan:', src);
    this.src = `${CARD_PATH}card_back.png`;
  };
  return img;
}

// Fungsi helper untuk memaksa player mengambil kartu (digunakan untuk efek +2/+4)
function forceDrawForPlayer(n) {
  for (let i = 0; i < n; i++) {
    const newCard = drawCard();
    if (newCard) {
      playerRow.appendChild(createCard(newCard, 'lg'));
    }
  }
  updateDeckInfo();
  refreshCounts();
  updatePlayableHints();
}

// Fungsi helper untuk memaksa bot mengambil kartu (digunakan untuk efek +2/+4)
function forceDrawForBot(n) {
  for (let i = 0; i < n; i++) {
    const newCard = drawCard();
    if (newCard) {
      botHand.push(newCard);
    }
  }
  updateDeckInfo();
  renderBot();
  refreshCounts();
}

// Fungsi untuk memparse informasi kartu dari sumber gambar
function parseCard(src) {
  const f = src.split('/').pop().replace('.png', '').toLowerCase();
  if (f === 'plus4') return { color: 'wild', value: 'plus4', type: 'wild' };
  if (f === 'wild') return { color: 'wild', value: 'wild', type: 'wild' };
  const [color, rest] = f.split('_');
  if (rest === 'reverse' || rest === 'skip' || rest === 'plus2') {
    return { color, value: rest, type: 'action' };
  }
  return { color, value: rest, type: /^\d+$/.test(rest) ? 'number' : 'action' };
}

// Fungsi untuk mendeteksi warna dari sumber gambar kartu
function detectColorFromSrc(src) {
  const f = src.split('/').pop().toLowerCase();
  if (f.startsWith('red')) return 'red';
  if (f.startsWith('blue')) return 'blue';
  if (f.startsWith('green')) return 'green';
  if (f.startsWith('yellow')) return 'yellow';
  if (f.startsWith('wild') || f.startsWith('plus4')) return 'wild';
  return null;
}

// Fungsi untuk mengecek apakah kartu bisa dimainkan di atas kartu saat ini
function canPlay(topSrc, candSrc) {
  const top = parseCard(topSrc);
  const cand = parseCard(candSrc);
  const active = getActiveColor();
  if (cand.type === 'wild') return true; // Wild card selalu bisa dimainkan
  if (cand.color === active) return true; // Warna cocok dengan warna aktif
  if (cand.value === top.value) return true; // Nilai cocok dengan kartu teratas
  return false;
}

// ==== CEK LEGALITAS +4 (UNO resmi, tanpa challenge) ====
// Fungsi untuk mengecek apakah player memiliki kartu dengan warna tertentu
function playerHasColor(color) {
  if (!color || color === 'wild') return false;
  return $$('.card-img', playerRow).some(img => {
    const c = parseCard(img.src);
    return c.type !== 'wild' && c.color === color;
  });
}

// Fungsi untuk mengecek apakah bot memiliki kartu dengan warna tertentu
function botHasColor(color) {
  if (!color || color === 'wild') return false;
  return botHand.some(src => {
    const c = parseCard(src);
    return c.type !== 'wild' && c.color === color;
  });
}

// ====== RENDER / UI ======
// Fungsi untuk merender kartu bot (ditampilkan sebagai kartu tertutup)
function renderBot() {
  if (!botRow) return;
  botRow.innerHTML = '';
  for (let i = 0; i < botHand.length; i++) botRow.appendChild(createCard(`${CARD_PATH}card_back.png`, 'sm'));
}

// Fungsi untuk memperbarui counter jumlah kartu
function refreshCounts() {
  if (botCountEl) botCountEl.textContent = `(${botHand.length} Kartu)`;
  if (playerCountEl) playerCountEl.textContent = `(${$$('.card-img', playerRow).length} Kartu)`;
}

// Fungsi untuk memperbarui hint kartu yang bisa dimainkan (warna hijau/merah)
function updatePlayableHints() {
  const imgs = $$('.card-img', playerRow);
  imgs.forEach(img => {
    const ok = canPlay(topCardImg.src, img.src);
    img.classList.toggle('playable', ok);
    img.classList.toggle('unplayable', !ok);
  });
}

// Fungsi untuk menghentikan game (clear semua timer dan disable kontrol)
function stopGame() {
  turn = 'ended';
  clearAllTimers();
  clearUnoTimers();
  disableControls(true);
}

// ====== RESET GAME ======
// Fungsi untuk mereset state game ke kondisi awal
function resetGame() {
  turn = 'idle';
  
  // Reset deck management
  initializeDeck();
  shuffleDeck();
  discardPile = [];
  
  deckCount = deck.length;
  botHand = [];
  pendingWild = null;
  pendingWildIsDrawFour = false;
  skipOpponentOnce = false;
  drawTwoNext = false;
  drawFourNext = false;
  reverseDirection = false;
  lockedBet = false;
  botBet = 0;
  activeColor = null;
  playerUnoPending = false; botUnoPending = false; clearUnoTimers();

  if (botRow) botRow.innerHTML = '';
  if (playerRow) playerRow.innerHTML = '';

  // Deal kartu awal akan dilakukan di dealHands()
  
  if (topCardImg) topCardImg.src = `${CARD_PATH}blue_0.png`;
  setActiveColor('blue');
  updateDeckInfo();

  setInfo('Permainan dimulai.');
  refreshCounts();
  disableControls(true);

  if (betEl) betEl.textContent = '0';
  if (botBetEl) botBetEl.textContent = '0';
  if (totalBetEl) totalBetEl.textContent = '0';
}

// ====== GAME OVER ======
// Fungsi untuk menangani akhir game dan menampilkan hasil
function gameOver(winner) {
  stopGame();

  const playerBet = toNum(betEl?.textContent || '0');
  if (winner === 'player') {
    const currentBalance = toNum(balanceEl?.textContent || '0');
    const newBalance = currentBalance + (playerBet * 2); // Player menang dapat 2x taruhan
    if (balanceEl) balanceEl.textContent = fmt(newBalance);
    setTimeout(() => {
      const playAgain = confirm('🎉 Selamat! Anda menang!\n\nSaldo Anda: ' + fmt(newBalance) + '\n\nMain lagi?');
      if (playAgain) {
        resetGame(); 
        if (gameBoard) gameBoard.classList.add('hidden'); 
        if (bettingScreen) bettingScreen.classList.remove('hidden');
        if (initialBalanceEl) initialBalanceEl.textContent = balanceEl?.textContent || '$5000'; 
        if (initialBetAmount) initialBetAmount.value = '';
      } else {
        if (gameBoard) gameBoard.classList.add('hidden'); 
        if (bettingScreen) bettingScreen.classList.remove('hidden');
        if (initialBalanceEl) initialBalanceEl.textContent = balanceEl?.textContent || '$5000'; 
        if (initialBetAmount) initialBetAmount.value = '';
      }
    }, 500);
  } else {
    setTimeout(() => {
      // Game Over jika saldo habis/negatif
      const currentBalance = toNum(balanceEl?.textContent || '0');
      if (currentBalance <= 0) {
        alert('💀 Game Over! Saldo habis.\nSaldo direset ke awal.');
        if (gameBoard) gameBoard.classList.add('hidden');
        if (bettingScreen) bettingScreen.classList.remove('hidden');
        resetGame();
        // Sinkron dengan UI taruhan kamu ($5000)
        if (initialBalanceEl) initialBalanceEl.textContent = '$5000';
        if (initialBetAmount) initialBetAmount.value = '';
        if (balanceEl) balanceEl.textContent = fmt(5000);
        return;
      }
      const playAgain = confirm('😞 Bot menang!\n\nMain lagi?');
      if (playAgain) {
        resetGame(); 
        if (gameBoard) gameBoard.classList.add('hidden'); 
        if (bettingScreen) bettingScreen.classList.remove('hidden');
        if (initialBalanceEl) initialBalanceEl.textContent = balanceEl?.textContent || '$5000'; 
        if (initialBetAmount) initialBetAmount.value = '';
      } else {
        if (gameBoard) gameBoard.classList.add('hidden'); 
        if (bettingScreen) bettingScreen.classList.remove('hidden');
        if (initialBalanceEl) initialBalanceEl.textContent = balanceEl?.textContent || '$5000'; 
        if (initialBetAmount) initialBetAmount.value = '';
      }
    }, 500);
  }
}

// Fungsi untuk mengecek kondisi game over
function checkGameOver() {
  const p = $$('.card-img', playerRow).length;
  const b = botHand.length;
  if (p === 0) { gameOver('player'); return true; }
  if (b === 0) { gameOver('bot'); return true; }
  return false;
}

// ====== UPDATE TOTAL BET ======
// Fungsi untuk memperbarui total taruhan di UI
function updateTotalBet() {
  const playerBet = toNum(betEl?.textContent || '0');
  const totalBet = playerBet + botBet;
  if (totalBetEl) totalBetEl.textContent = fmt(totalBet);
}

// ====== DEAL / RESET RONDE ======
// Fungsi untuk membagikan kartu awal ke semua pemain
function dealHands() {
  botHand = [];
  if (playerRow) playerRow.innerHTML = '';

  // Deal 7 kartu untuk setiap pemain
  for (let i = 0; i < 7; i++) {
    const botCard = drawCard();
    if (botCard) botHand.push(botCard);
    
    const playerCard = drawCard();
    if (playerCard && playerRow) playerRow.appendChild(createCard(playerCard, 'lg'));
  }

  renderBot();
  refreshCounts();
  updatePlayableHints();

  // Top card bukan wild - cari kartu non-wild untuk mulai permainan
  let topCard;
  do { 
    topCard = drawCard();
  } while (topCard && parseCard(topCard).type === 'wild');

  if (topCard && topCardImg) {
    topCardImg.src = topCard;
    addToDiscardPile(topCard); // Tambah ke discard pile
    setActiveColor(parseCard(topCard).color);
  }

  updateDeckInfo();
}

// ====== INIT ======
// Inisialisasi game saat DOM sudah siap
window.addEventListener('DOMContentLoaded', () => {
  console.log('DOM loaded - initializing game...'); // Debug log
  
  // Pastikan elemen ada sebelum mengakses
  if (!bettingScreen || !gameBoard) {
    console.error('Critical elements not found!');
    return;
  }
  
  bettingScreen.classList.remove('hidden');
  gameBoard.classList.add('hidden');
  
  // Pastikan elemen ada sebelum set value
  if (initialBalanceEl) initialBalanceEl.textContent = '$5000';
  if (balanceEl) balanceEl.textContent = fmt(5000);
  
  resetGame();
  
  // Event listener untuk start game
  if (startGameBtn) {
    startGameBtn.addEventListener('click', startGameHandler);
  } else {
    console.error('Start button not found!');
  }
  
  // Event listener untuk exit game
  if (exitGameBtn) {
    exitGameBtn.addEventListener('click', exitGameHandler);
  }

  // Event listener untuk draw button
  if (drawBtn) {
    drawBtn.addEventListener('click', drawHandler);
  }

  // Event listener untuk player cards
  if (playerRow) {
    playerRow.addEventListener('click', playerCardClickHandler);
  }

  // Event listener untuk wild modal
  if (wildChips.length > 0) {
    wildChips.forEach(chip => {
      chip.addEventListener('click', wildChipClickHandler);
    });
  }

  if (wildCancel) {
    wildCancel.addEventListener('click', wildCancelHandler);
  }

  // Event listener untuk action buttons
  if (skipBtn) skipBtn.addEventListener('click', skipHandler);
  if (unoBtn) unoBtn.addEventListener('click', unoHandler);
  if (callUnoBtn) callUnoBtn.addEventListener('click', callUnoHandler);
});

// ====== ATURAN RESMI UNO - DRAW HANDLER ======
// Fungsi untuk menangani ketika player menekan tombol draw
function drawHandler() {
  if (turn !== 'player' || turn === 'ended') return;

  // Jika ada efek drawTwo atau drawFour, itu adalah penalti dan harus diambil sekaligus
  if (drawTwoNext) {
    drawTwoNext = false;
    forceDrawForPlayer(2);
    setInfo('Kamu mengambil 2 kartu (efek +2). Giliran berakhir.');
    schedule(() => { setTurn('bot', 'Selesai menarik penalti'); botTurn(); }, 1200);
    return;
  }

  if (drawFourNext) {
    drawFourNext = false;
    forceDrawForPlayer(4);
    setInfo('Kamu mengambil 4 kartu (efek +4). Giliran berakhir.');
    schedule(() => { setTurn('bot', 'Selesai menarik penalti'); botTurn(); }, 1200);
    return;
  }

  // ATURAN RESMI: Hanya ambil 1 kartu jika tidak punya kartu yang bisa dimainkan
  const newCard = drawCard();
  if (!newCard) {
    setInfo('Tidak ada kartu lagi!');
    return;
  }

  const img = createCard(newCard, 'lg');
  if (playerRow) playerRow.appendChild(img);

  // draw membatalkan kewajiban UNO jika ada
  playerUnoPending = false; 
  clearTimeout(playerUnoTimer); 
  playerUnoTimer = null;

  updateDeckInfo();
  refreshCounts();
  updatePlayableHints();

  const card = parseCard(newCard);
  setInfo(`Kamu menarik 1 kartu: ${card.type === 'wild' ? card.value.toUpperCase() : `${card.color.toUpperCase()} ${card.value}`}.`);

  // ATURAN RESMI: Jika kartu yang diambil BISA dimainkan, boleh langsung dimainkan
  if (canPlay(topCardImg.src, newCard)) {
    setInfo('Kartu yang kamu tarik bisa dimainkan! Kamu boleh memainkannya SEKARANG atau lewatkan giliran.');
    
    // Beri waktu 3 detik untuk player memutuskan apakah mau main kartu ini
    const autoPlayTimer = setTimeout(() => {
      // Jika tidak dimainkan dalam 3 detik, giliran berakhir
      if (playerRow.contains(img)) { // Kartu masih ada di tangan (belum dimainkan)
        setInfo('Kamu tidak memainkan kartu. Giliran berakhir.');
        schedule(() => { setTurn('bot', 'Tidak memainkan kartu'); botTurn(); }, 800);
      }
    }, 3000);

    // Simpan timer untuk dibersihkan nanti
    timers.push(autoPlayTimer);
    
  } else {
    // ATURAN RESMI: Jika kartu yang diambil TIDAK bisa dimainkan, giliran langsung berakhir
    setInfo('Kartu yang kamu tarik tidak bisa dimainkan. Giliran berakhir.');
    schedule(() => { setTurn('bot', 'Tidak bisa main'); botTurn(); }, 1200);
  }
}

// ====== ATURAN RESMI UNO - BOT TURN ======
// Fungsi untuk mengatur giliran bot
function botTurn() {
  if (turn !== 'bot' || turn === 'ended') return;

  // tampilkan info giliran bot kalau belum
  setInfo('Giliran bot');

  if (skipOpponentOnce) {
    skipOpponentOnce = false;
    setInfo('Bot ter-skip. Giliran kamu.');
    setTurn('player');
    return;
  }

  // konsumsi penalti untuk kasus PLAYER → BOT
  if (drawTwoNext) {
    drawTwoNext = false;
    forceDrawForBot(2);
    setInfo('Bot ambil 2 kartu (efek +2) dan dilewati.');
    setTurn('player'); 
    return;
  }

  if (drawFourNext) {
    drawFourNext = false;
    forceDrawForBot(4);
    setInfo('Bot ambil 4 kartu (efek +4) dan dilewati.');
    setTurn('player'); 
    return;
  }

  // Cari kartu yang bisa dimainkan
  const playableCards = botHand.filter(src => canPlay(topCardImg.src, src));
  
  if (playableCards.length > 0) {
    // Bot punya kartu yang bisa dimainkan - pilih secara acak
    const randomIndex = Math.floor(Math.random() * playableCards.length);
    const src = playableCards[randomIndex];
    const cardIndex = botHand.indexOf(src);
    
    playBotCard(cardIndex);
    
    if (checkGameOver()) return;

    if (botHand.length === 1) startBotUnoWindow(); 
    else { botUnoPending = false; clearTimeout(botUnoTimer); }

    if (skipOpponentOnce) {
      skipOpponentOnce = false;
      schedule(() => { 
        setInfo('Giliran kamu ter-skip. Bot main lagi.'); 
        schedule(botTurn, 1100); 
      }, 800);
      return;
    }

    setTurn('player');
    
  } else {
    // ATURAN RESMI: Bot tidak punya kartu yang bisa dimainkan, ambil 1 kartu saja
    const newCard = drawCard();
    if (newCard) {
      botHand.push(newCard);
      updateDeckInfo(); 
      renderBot(); 
      refreshCounts();

      // Cek apakah kartu yang baru diambil bisa dimainkan
      if (canPlay(topCardImg.src, newCard)) {
        // ATURAN RESMI: Jika kartu yang diambil BISA dimainkan, bot akan memainkannya
        const newCardIndex = botHand.length - 1;
        setInfo('Bot mengambil 1 kartu');
        
        schedule(() => {
          playBotCard(newCardIndex);
          
          if (checkGameOver()) return;

          if (botHand.length === 1) startBotUnoWindow(); 
          else { botUnoPending = false; clearTimeout(botUnoTimer); }

          if (skipOpponentOnce) {
            skipOpponentOnce = false;
            schedule(() => { 
              setInfo('Giliran kamu ter-skip. Bot main lagi.'); 
              schedule(botTurn, 1100); 
            }, 800);
            return;
          }

          setTurn('player');
        }, 1500);
        
      } else {
        // ATURAN RESMI: Jika kartu yang diambil TIDAK bisa dimainkan, giliran berakhir
        setInfo('Bot mengambil 1 kartu');
        schedule(() => { setTurn('player'); }, 1200);
      }
    } else {
      setInfo('Tidak ada kartu untuk di!');
      setTurn('player');
    }
  }
}

// ====== FUNGSI BANTUAN BOT ======
// Fungsi untuk memainkan kartu bot
function playBotCard(index) {
  const src = botHand[index];
  const card = parseCard(src);

  if (card.type === 'wild') {
    const counts = { red: 0, blue: 0, green: 0, yellow: 0 };
    botHand.forEach(s => { 
      const c = parseCard(s);
      if (counts[c.color] != null) counts[c.color]++; 
    });
    const chosen = Object.entries(counts).sort((a, b) => b[1] - a[1])[0]?.[0] || 'red';
    // CEK LEGALITAS +4 untuk BOT (pakai warna aktif saat ini)
    const currentActive = getActiveColor();

    if (topCardImg) topCardImg.src = src;
    addToDiscardPile(src); // Tambah ke discard pile
    setActiveColor(chosen);

    if (card.value === 'plus4') {
      if (botHasColor(currentActive)) {
        // Bot tidak boleh +4: jadikan wild biasa
        setInfo(`Bot: WILD (bukan +4) → ${chosen.toUpperCase()}.`);
      } else {
        // Efek +4 sah
        forceDrawForPlayer(4);
        skipOpponentOnce = true;
        setInfo(`Bot: WILD +4 → ${chosen.toUpperCase()}. Kamu ambil 4 dan dilewati.`);
      }
    } else {
      setInfo(`Bot: WILD → ${chosen.toUpperCase()}.`);
    }
  } else {
    if (topCardImg) topCardImg.src = src;
    addToDiscardPile(src); // Tambah ke discard pile
    setActiveColor(card.color);

    if (card.type === 'action') {
      if (card.value === 'skip') {
        skipOpponentOnce = true; 
        setInfo(`Bot: ${card.color.toUpperCase()} SKIP → kamu dilewati.`);
      } else if (card.value === 'reverse') {
        skipOpponentOnce = true; 
        setInfo(`Bot: ${card.color.toUpperCase()} REVERSE → kamu dilewati.`);
      } else if (card.value === 'plus2') {
        // efek langsung ke PLAYER
        forceDrawForPlayer(2);
        skipOpponentOnce = true;
        setInfo(`Bot: ${card.color.toUpperCase()} +2 → kamu ambil 2 dan dilewati.`);
      } else {
        setInfo(`Bot: ${card.color.toUpperCase()} ${card.value}.`);
      }
    } else {
      setInfo(`Bot: ${card.color.toUpperCase()} ${card.value}.`);
    }
  }

  botHand.splice(index, 1);
  renderBot();
  refreshCounts();
}

// ====== EVENT HANDLERS ======
// Handler untuk tombol start game
function startGameHandler() {
  console.log('Start button clicked'); // Debug log
  
  const saldo = 5000;
  const t = toNum(initialBetAmount?.value || '0');

  if (t < 100) {
    alert('Minimal taruhan 100.');
    return;
  }
  if (t > saldo) {
    alert('Saldo tidak cukup.');
    return;
  }

  // Pastikan elemen ada sebelum update
  if (balanceEl) balanceEl.textContent = fmt(saldo - t);
  if (betEl) betEl.textContent = fmt(t);

  botBet = t;
  if (botBetEl) botBetEl.textContent = fmt(botBet);
  updateTotalBet();

  bettingScreen.classList.add('hidden');
  gameBoard.classList.remove('hidden');

  lockedBet = true;
  skipOpponentOnce = false;
  drawTwoNext = false;
  drawFourNext = false;
  reverseDirection = false;

  // Reset dan deal kartu baru
  initializeDeck();
  shuffleDeck();
  discardPile = [];
  dealHands();

  setTurn('player', 'Ronde dimulai');
  disableControls(false);
}

// Handler untuk tombol exit game
function exitGameHandler() {
  const confirmExit = confirm('Apakah Anda yakin ingin keluar dari permainan?');
  if (!confirmExit) return;
  
  gameBoard.classList.add('hidden');
  bettingScreen.classList.remove('hidden');
  resetGame();
  
  if (initialBalanceEl) initialBalanceEl.textContent = '$5000';
  if (initialBetAmount) initialBetAmount.value = '';
  if (balanceEl) balanceEl.textContent = fmt(5000);
}

// Handler untuk klik kartu player
function playerCardClickHandler(e) {
  if (turn !== 'player' || turn === 'ended') return;
  const img = e.target.closest('.card-img');
  if (!img) return;
  if (!img.complete || img.naturalHeight === 0) return;

  if (!canPlay(topCardImg.src, img.src)) {
    img.classList.add('shake');
    setInfo('Kartu tidak bisa dimainkan. Coba kartu lain atau ambil kartu.');
    schedule(() => img.classList.remove('shake'), 250);
    return;
  }

  playPlayerCard(img);
}

// Handler untuk klik chip warna di modal wild
function wildChipClickHandler(e) {
  if (!pendingWild) return;
  const chosen = this.getAttribute('data-color');

  // Ambil warna aktif sebelum berubah (penting untuk cek legal +4)
  const currentActive = getActiveColor();

  // Tampilkan wild di top (sesuai kartu yg dipilih)
  if (topCardImg) topCardImg.src = pendingWild.src;
  addToDiscardPile(pendingWild.src); // Tambah ke discard pile
  setActiveColor(chosen);

  if (pendingWildIsDrawFour) {
    // CEK LEGALITAS +4 untuk PEMAIN
    if (playerHasColor(currentActive)) {
      setInfo('Tidak boleh +4: kamu masih punya kartu dengan warna aktif. Diubah jadi WILD biasa.');
      // tidak set drawFourNext
    } else {
      drawFourNext = true; // penalti ke BOT
      setInfo(`WILD +4 → ${chosen.toUpperCase()}. Bot harus ambil 4 kartu.`);
    }
  } else {
    setInfo(`WILD → ${chosen.toUpperCase()}.`);
  }

  pendingWild.remove();
  pendingWild = null;
  pendingWildIsDrawFour = false;
  if (wildModal) wildModal.classList.add('hidden');

  refreshCounts();
  updatePlayableHints();
  if (checkGameOver()) return;

  schedule(() => { setTurn('bot'); botTurn(); }, 1200);
}

// Handler untuk tombol cancel di modal wild
function wildCancelHandler() {
  pendingWild = null;
  pendingWildIsDrawFour = false;
  if (wildModal) wildModal.classList.add('hidden');
  setInfo('Batal memilih warna.');
}

// Handler untuk tombol skip
function skipHandler() {
  if (turn !== 'player' || turn === 'ended') return;
  setInfo('Kamu melewatkan giliran.');
  schedule(() => { setTurn('bot', 'Kamu skip'); botTurn(); }, 800);
}

// Handler untuk tombol UNO
function unoHandler() {
  if (turn === 'ended') return;
  if (playerUnoPending) {
    playerUnoPending = false;
    if (playerUnoTimer) { clearTimeout(playerUnoTimer); playerUnoTimer = null; }
    setInfo('UNO diklaim. Kamu aman dari penalti.');
  } else {
    setInfo('Tidak perlu UNO sekarang.');
  }
}

// Handler untuk tombol call UNO (panggil UNO pada bot)
function callUnoHandler() {
  if (turn === 'ended') return;
  if (botUnoPending) {
    botUnoPending = false;
    if (botUnoTimer) { clearTimeout(botUnoTimer); botUnoTimer = null; }
    for (let i = 0; i < 2; i++) {
      const newCard = drawCard();
      if (newCard) {
        botHand.push(newCard);
      }
    }
    updateDeckInfo(); renderBot(); refreshCounts();
    setInfo('Kamu memanggil UNO pada bot → bot kena penalti +2.');
  } else {
    setInfo('Bot tidak sedang lupa UNO.');
  }
}

// ====== MAIN LOGIKA: MAINKAN KARTU PEMAIN ======
// Fungsi utama untuk memainkan kartu player
function playPlayerCard(img) {
  const card = parseCard(img.src);

  if (card.type === 'wild') {
    // Simpan state buat modal
    pendingWild = img;
    pendingWildIsDrawFour = (card.value === 'plus4');
    if (wildModal) wildModal.classList.remove('hidden');
    setInfo('Memilih warna untuk WILD...');
    return;
  }

  // non-wild
  if (topCardImg) topCardImg.src = img.src;
  addToDiscardPile(img.src); // Tambah ke discard pile
  setActiveColor(card.color);
  img.remove();

  // UNO window
  const remainPlayer = $$('.card-img', playerRow).length;
  if (remainPlayer === 1) startPlayerUnoWindow(); 
  else { playerUnoPending = false; clearTimeout(playerUnoTimer); }

  if (card.type === 'action') {
    if (card.value === 'skip') {
      skipOpponentOnce = true; 
      setInfo(`${card.color.toUpperCase()} SKIP → Bot dilewati.`);
    } else if (card.value === 'reverse') {
      skipOpponentOnce = true; 
      setInfo(`${card.color.toUpperCase()} REVERSE → Bot dilewati.`);
    } else if (card.value === 'plus2') {
      drawTwoNext = true; 
      setInfo(`${card.color.toUpperCase()} +2 → Bot ambil 2.`);
    }
  } else {
    setInfo(`${card.color.toUpperCase()} ${card.value}.`);
  }

  refreshCounts();
  updatePlayableHints();
  if (checkGameOver()) return;

  schedule(() => { setTurn('bot'); botTurn(); }, 1200);
}