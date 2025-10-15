let gameState = {   
    balance: 5000,
    currentBet: 0,
    deck: [],       
    discardPile: [],
    playerHand: [],
    botHand: [],
    currentPlayer: 'player',
    currentColor: '',
    topCard: null,
    unoTimer: null,
    unoCalled: {player: false, bot: false},
    pendingWildCard: null
};

const colors = ['red', 'blue', 'green', 'yellow'];
const values = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'skip', 'reverse', 'draw2'];

function getCardImagePath(card) {
    if (card.value === 'wild') {
        return 'assets/wild.png';
    } else if (card.value === 'draw4') {
        return 'assets/plus_4.png';
    } else if (card.value === 'skip') {
        return `assets/${card.color}_skip.png`;
    } else if (card.value === 'reverse') {
        return `assets/${card.color}_reverse.png`;
    } else if (card.value === 'draw2') {
        return `assets/${card.color}_plus2.png`;
    } else {
        return `assets/${card.color}_${card.value}.png`;
    }
}

function initDeck() {
    const deck = [];
    
    colors.forEach(color => {
        for (let i = 0; i <= 9; i++) {
            deck.push({color, value: i.toString(), type: 'number'});
        }
        
        ['skip', 'reverse', 'draw2'].forEach(action => {
            deck.push({color, value: action, type: 'action'});
        });
    });

    for (let i = 0; i < 4; i++) {
        deck.push({color: 'wild', value: 'wild', type: 'wild'});
        deck.push({color: 'wild', value: 'draw4', type: 'wild'});
    }

    return shuffleDeck(deck);
}

function shuffleDeck(deck) {
    for (let i = deck.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));      
        [deck[i], deck[j]] = [deck[j], deck[i]];
    }
    
    return deck;
}

function startGame() {
    const betInput = document.getElementById('betAmount');     
    const bet = parseInt(betInput.value);  
    if (bet < 100 || bet > gameState.balance) {
        showMessage('Taruhan tidak valid! Min: $100, Max: $' + gameState.balance);
        return;
    }

    gameState.currentBet = bet;
    gameState.deck = initDeck();
    gameState.playerHand = [];
    gameState.botHand = []; 
    gameState.discardPile = [];   
    gameState.currentPlayer = 'player';    
    gameState.unoCalled = {player: false, bot: false};

    for (let i = 0; i < 7; i++) {
        gameState.playerHand.push(gameState.deck.pop());
        gameState.botHand.push(gameState.deck.pop());  
    }

    let firstCard;
    do {
        firstCard = gameState.deck.pop();
        if (firstCard.type !== 'number') {
            gameState.deck.unshift(firstCard);
            gameState.deck = shuffleDeck(gameState.deck);
        }
    } while (firstCard.type !== 'number');   
    gameState.topCard = firstCard;
    gameState.currentColor = firstCard.color;
    gameState.discardPile.push(firstCard);

    document.getElementById('startScreen').style.display = 'none';
    document.getElementById('gameScreen').style.display = 'block'; 
    
    updateUI();
}

function updateUI() {
    document.getElementById('playerCardCount').textContent = gameState.playerHand.length;
    document.getElementById('botCardCount').textContent = gameState.botHand.length;
    
    document.getElementById('turnIndicator').textContent = gameState.currentPlayer === 'player' ? 'Your Turn' : "Rival's Turn";

    const botCardsDiv = document.getElementById('botCards');   
    botCardsDiv.innerHTML = '';       
    for (let i = 0; i < gameState.botHand.length; i++) {
        const cardBack = document.createElement('div'); 
        cardBack.className = 'card-back';  
        cardBack.style.backgroundImage = 'url(assets/card_back.png)';
        botCardsDiv.appendChild(cardBack);
    }

    document.getElementById('topCard').innerHTML = '';  
    document.getElementById('topCard').appendChild(createCardElement(gameState.topCard));

    renderPlayerCards();

    checkUnoCondition();
}

function createCardElement(card, isPlayer = false) {
    const cardDiv = document.createElement('div');
    cardDiv.className = `card ${card.color}`;
    
    cardDiv.style.backgroundImage = `url(${getCardImagePath(card)})`;
    
    if (isPlayer) {
        if (canPlayCard(card)) {
            cardDiv.classList.add('playable');  
            cardDiv.onclick = () => playCard(card); 
        }
    }

    return cardDiv;
}

function getCardDisplay(card) {
    if (card.value === 'skip') return '⊘';
    if (card.value === 'reverse') return '⇄';
    if (card.value === 'draw2') return '+2';
    if (card.value === 'wild') return '🌈';
    if (card.value === 'draw4') return '+4';
    return card.value;
}

function renderPlayerCards() {
    const playerCardsDiv = document.getElementById('playerCards');
    playerCardsDiv.innerHTML = '';      
    
    const numCards = gameState.playerHand.length;
    
    const maxRotation = 60; 
    const minRotation = -30;

    gameState.playerHand.forEach((card, index) => {
        const cardElement = createCardElement(card, true); 
        let rotation = 0;
        if (numCards > 1) {
            const normalizedIndex = index / (numCards - 1); 
            rotation = minRotation + normalizedIndex * maxRotation;
        }

        cardElement.style.position = 'absolute';
        cardElement.style.transformOrigin = 'bottom center';
        cardElement.style.transform = `rotate(${rotation}deg)`;
        
        cardElement.style.zIndex = index;   
        const horizontalOffset = 30;        
        const centerOffset = (numCards - 1) * horizontalOffset / 2;
        cardElement.style.left = `calc(50% - 60px + ${(index * horizontalOffset) - centerOffset}px)`;
        cardElement.style.bottom = '0'; 

        cardElement.onmouseover = () => {
            const yOffset = cardElement.classList.contains('playable') ? -25 : -15;
            cardElement.style.transform = `translateY(${yOffset}px) rotate(${rotation}deg)`;
        };
        cardElement.onmouseout = () => {
            cardElement.style.transform = `rotate(${rotation}deg)`;
        };

        playerCardsDiv.appendChild(cardElement);    
    });
}

function canPlayCard(card) {
    if (gameState.currentPlayer !== 'player') 
        return false;
    if (card.type === 'wild') {
        if (card.value === 'draw4') {
            return !gameState.playerHand.some(c => 
                c.type !== 'wild' && (c.color === gameState.currentColor || c.value === gameState.topCard.value)
            );
        }
        return true;
    }
    return card.color === gameState.currentColor || card.value === gameState.topCard.value;
}

function playCard(card) {
    if (!canPlayCard(card)) return; 

    const index = gameState.playerHand.indexOf(card); 
    gameState.playerHand.splice(index, 1);   
    if (card.type === 'wild') {
        gameState.pendingWildCard = card;
        document.getElementById('colorModal').style.display = 'flex';
        return;
    }

    executeCardPlay(card);
}

function chooseColor(color) {
    document.getElementById('colorModal').style.display = 'none';   
    const card = gameState.pendingWildCard;
    card.chosenColor = color;       
    gameState.currentColor = color;    
    executeCardPlay(card); 
}

function executeCardPlay(card) {
    gameState.unoCalled[gameState.currentPlayer] = false;   

    gameState.discardPile.push(card);   
    gameState.topCard = card;   
    
    if (card.type !== 'wild') {
        gameState.currentColor = card.color;
    }

    
    if (card.value === 'skip' || card.value === 'reverse') {
        if (gameState.currentPlayer === 'player') showMessage('Rival skipped!');
        else showMessage('You skipped!');
    } else if (card.value === 'draw2') {
        if (gameState.currentPlayer === 'player') {
            drawCardsForPlayer('bot', 2);
            showMessage('Rival draws 2 cards!');
        } else {
            drawCardsForPlayer('player', 2);
            showMessage('You draw 2 cards!');
        }
    } else if (card.value === 'draw4') {
        if (gameState.currentPlayer === 'player') {
            drawCardsForPlayer('bot', 4);
            showMessage('Rival draws 4 cards!');
        } else {
            drawCardsForPlayer('player', 4);
            showMessage('You draw 4 cards!');
        }
    } else {
        gameState.currentPlayer = gameState.currentPlayer === 'player' ? 'bot' : 'player';  
    }
    
    checkWinCondition(); 

    updateUI();

    if (gameState.currentPlayer === 'bot') {
        setTimeout(botTurn, 1500);      
    }
}

function drawCard() {   
    if (gameState.currentPlayer !== 'player') return;
    
    if (gameState.deck.length === 0) {
        reshuffleDeck();
    }

    const card = gameState.deck.pop();
    gameState.playerHand.push(card);
    showMessage('You draw 1 card');

    if (canPlayCard(card)) {
        updateUI();
    } else {
        gameState.currentPlayer = 'bot';
        updateUI();
        setTimeout(botTurn, 1500);
    }
}

function drawCardsForPlayer(player, count) {
    for (let i = 0; i < count; i++) {
        if (gameState.deck.length === 0) {
            reshuffleDeck();
        }
        const card = gameState.deck.pop();
        if (player === 'player') {
            gameState.playerHand.push(card);
        } else {
            gameState.botHand.push(card);
        }
    }
}

function reshuffleDeck() {
    if (gameState.discardPile.length <= 1) return;
    const topCard = gameState.discardPile.pop();    
    gameState.deck = shuffleDeck(gameState.discardPile);
    gameState.discardPile = [topCard];
    showMessage('Deck shuffled!');
}

function botTurn() {
    if (gameState.currentPlayer !== 'bot') return;

    const playableCards = gameState.botHand.filter(card => {
        if (card.type === 'wild') {
            if (card.value === 'draw4') {
                return !gameState.botHand.some(c => 
                    c.type !== 'wild' && (c.color === gameState.currentColor || c.value === gameState.topCard.value)
                );
            }
            return true;
        }
        return card.color === gameState.currentColor || card.value === gameState.topCard.value;
    });

    if (playableCards.length > 0) {
        const card = playableCards[Math.floor(Math.random() * playableCards.length)];   
        const index = gameState.botHand.indexOf(card);
        gameState.botHand.splice(index, 1);
        
        if (card.type === 'wild') {
            const colorCounts = {red: 0, blue: 0, green: 0, yellow: 0};
            gameState.botHand.forEach(c => {
                if (c.color !== 'wild') colorCounts[c.color]++;
            });
            const mostCommonColor = Object.keys(colorCounts).reduce((a, b) => 
                colorCounts[a] > colorCounts[b] ? a : b
            );
            card.chosenColor = mostCommonColor;
            gameState.currentColor = mostCommonColor;
        }
        
        gameState.unoCalled.bot = false; 

        gameState.discardPile.push(card);
        gameState.topCard = card;
        
        if (card.type !== 'wild') {
            gameState.currentColor = card.color;
        }

        showMessage(`Rival plays card ${getCardDisplay(card)}`);



        let nextPlayerIsBot = false;
        if (card.value === 'skip' || card.value === 'reverse') {
            nextPlayerIsBot = true; 
        } else if (card.value === 'draw2') {
            drawCardsForPlayer('player', 2);
            showMessage('You draw 2 cards!');
            nextPlayerIsBot = true; 
        } else if (card.value === 'draw4') {
            drawCardsForPlayer('player', 4);
            showMessage('You draw 4 cards!');
            nextPlayerIsBot = true; 
        } else {
            gameState.currentPlayer = 'player';
        }

        checkWinCondition(); 
        updateUI(); 

        if (nextPlayerIsBot) {
            setTimeout(botTurn, 1500);
        }

    } else {    
        if (gameState.deck.length === 0) {
            reshuffleDeck();
        }
        const card = gameState.deck.pop();
        gameState.botHand.push(card);
        showMessage('Rival draws 1 card');
        gameState.currentPlayer = 'player';
        updateUI();
    }
}

function checkUnoCondition() {
    const playerHasOneCard = gameState.playerHand.length === 1; 
    const botHasOneCard = gameState.botHand.length === 1;

    const shouldShowUnoButton = (playerHasOneCard && !gameState.unoCalled.player) || 
                               (botHasOneCard && !gameState.unoCalled.bot);

    if (shouldShowUnoButton) {
        document.getElementById('unoButton').classList.add('active'); 

        if (playerHasOneCard && !gameState.unoCalled.player) {
            startUnoTimer('player');
        } else {
            if (gameState.unoTimer) { 
                clearTimeout(gameState.unoTimer);
                document.getElementById('unoTimer').style.display = 'none';
            }
        }
        
    } else {
        document.getElementById('unoButton').classList.remove('active');
        if (gameState.unoTimer) { 
            clearTimeout(gameState.unoTimer);
            document.getElementById('unoTimer').style.display = 'none';
        }
    }
    
    if (botHasOneCard && !gameState.unoCalled.bot) {
        if (Math.random() < 0.8) {
            setTimeout(() => {
                if (gameState.botHand.length === 1) { 
                    gameState.unoCalled.bot = true;
                    showMessage("Rival calls UNO!");
                    updateUI();
                }
            }, 3000);
        } else {
            setTimeout(() => {
                if (!gameState.unoCalled.bot && gameState.botHand.length === 1) {
                    showMessage("Rival forgot UNO! Press button for penalty.");
                }
            }, 5000);
        }
    }
}

function startUnoTimer(player) {
    if (gameState.unoTimer) clearTimeout(gameState.unoTimer);
    
    let timeLeft = 3; 
    const timerDiv = document.getElementById('unoTimer');
    timerDiv.style.display = 'flex';
    timerDiv.textContent = timeLeft;

    const countdown = setInterval(() => {
        timeLeft--;
        timerDiv.textContent = timeLeft;
        
        if (timeLeft <= 0) {
            clearInterval(countdown);
            timerDiv.style.display = 'none';
            
            if (!gameState.unoCalled[player] && gameState.playerHand.length === 1) {
                drawCardsForPlayer(player, 2);
                showMessage(`${player === 'player' ? 'You' : 'Rival'} forgot UNO! +2 cards`);
                gameState.unoCalled[player] = true; 
                updateUI();
            }
        }
    }, 1000);

    gameState.unoTimer = setTimeout(() => {
        clearInterval(countdown);
        timerDiv.style.display = 'none';
    }, 3000); 
}

function callUno() {
    if (gameState.playerHand.length === 1 && !gameState.unoCalled.player) {
        gameState.unoCalled.player = true;
        showMessage('UNO!');
        document.getElementById('unoButton').classList.remove('active');
        document.getElementById('unoTimer').style.display = 'none';
        if (gameState.unoTimer) clearTimeout(gameState.unoTimer);
        updateUI(); 
    } 
    else if (gameState.botHand.length === 1 && !gameState.unoCalled.bot) {
        drawCardsForPlayer('bot', 2);
        showMessage('Rival penalized +2 cards!');
        gameState.unoCalled.bot = true;
        document.getElementById('unoButton').classList.remove('active'); 
        updateUI();
    }
}

function checkWinCondition() {
    if (gameState.playerHand.length === 0) {
        endGame(true);
    } else if (gameState.botHand.length === 0) {
        endGame(false);
    }
}

function endGame(playerWon) {
    if (playerWon) {
        gameState.balance += gameState.currentBet;
        document.getElementById('gameOverTitle').textContent = 'YOU WON!';
        document.getElementById('gameOverMessage').textContent = `You won ${gameState.currentBet}! Balance: ${gameState.balance}`;
    } else {
        gameState.balance -= gameState.currentBet;
        document.getElementById('gameOverTitle').textContent = 'YOU LOST';
        document.getElementById('gameOverMessage').textContent = `You lost ${gameState.currentBet}. Balance: ${gameState.balance}`;
    }

    document.getElementById('gameScreen').style.display = 'none';
    
    if (gameState.balance <= 0) {
        document.getElementById('gameOverTitle').textContent = 'GAME OVER';
        document.getElementById('gameOverMessage').textContent = 'Your balance is zero! Game will be reset.';
        gameState.balance = 5000;
    } else {
        const currentTitle = document.getElementById('gameOverTitle').textContent;
        document.getElementById('gameOverTitle').textContent = `UNO GAME - ${currentTitle}`;
    }
    
    document.getElementById('gameOverScreen').style.display = 'block';
}

function resetGame() {
    document.getElementById('startBalance').textContent = gameState.balance;
    document.getElementById('gameOverScreen').style.display = 'none';
    document.getElementById('startScreen').style.display = 'block';
    
    document.getElementById('gameOverTitle').textContent = 'UNO GAME'; 

    const maxBet = Math.max(100, Math.min(gameState.balance, 100));
    document.getElementById('betAmount').value = maxBet;
    document.getElementById('betAmount').max = gameState.balance;
}

function showMessage(message) {
    const messageDiv = document.getElementById('statusMessage');
    messageDiv.textContent = message;
    messageDiv.style.display = 'block';
    
    setTimeout(() => {
        messageDiv.style.display = 'none';
    }, 2000);
}


document.getElementById('startBalance').textContent = gameState.balance;
document.getElementById('betAmount').max = gameState.balance;