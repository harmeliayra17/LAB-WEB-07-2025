
const colors = ['red','yellow','green','blue'];
const actions = ['skip','reverse','draw2'];
const root = {
  deckEl: document.getElementById('deck'),
  discardEl: document.getElementById('discard'),
  playerHandEl: document.getElementById('playerHand'),
  botHandEl: document.getElementById('botHand'),
  logEl: document.getElementById('gameLog'),
  saldoEl: document.getElementById('saldoDisplay'),
  betInput: document.getElementById('betInput'),
  startBtn: document.getElementById('startBtn'),
  drawBtn: document.getElementById('drawBtn'),
  unoBtn: document.getElementById('unoBtn'),
  unoTimer: document.getElementById('unoTimer'),
  playerStatus: document.getElementById('playerStatus'),
  botStatus: document.getElementById('botStatus'),
};

let deck = [], discard = [];
let player = [], bot = [];
let turn = 'player';
let saldo = 5000;
let currentBet = 100;
let unoTimeId = null;
let unoPressed = false;
let roundActive = false;

// UTIL
function log(text){ root.logEl.textContent = text; }
function randInt(n){ return Math.floor(Math.random()*n); }

// Bangun deck UNO
function buildDeck(){
  const d = [];
  colors.forEach(c=>{
    d.push({type:'number',value:0,color:c,id:cryptoId()});
    for(let v=1; v<=9; v++){
      d.push({type:'number',value:v,color:c,id:cryptoId()});
      d.push({type:'number',value:v,color:c,id:cryptoId()});
    }
    actions.forEach(act=>{
      d.push({type:'action',action:act,color:c,id:cryptoId()});
      d.push({type:'action',action:act,color:c,id:cryptoId()});
    });
  });
  for(let i=0;i<4;i++){
    d.push({type:'wild',action:'wild',id:cryptoId()});
    d.push({type:'wild',action:'wild4',id:cryptoId()});
  }
  return d;
}

function cryptoId(){ return Math.random().toString(36).slice(2,9); }
function shuffle(a){ for(let i=a.length-1;i>0;i--){ const j=Math.floor(Math.random()*(i+1)); [a[i],a[j]]=[a[j],a[i]]; } return a; }

// MULAI RONDE
function startRound(){
  if(roundActive) return;
  currentBet = Math.max(100, Number(root.betInput.value) || 100);
  if(currentBet>saldo){ alert('Taruhan melebihi saldo!'); return; }
  deck = shuffle(buildDeck());
  discard = [];
  player = []; bot = [];
  for(let i=0;i<7;i++){ player.push(deck.pop()); bot.push(deck.pop()); }

  let top = deck.pop();
  while(top.type === 'wild4'){ deck.unshift(top); top = deck.pop(); }
  discard.push(top);

  roundActive = true;
  turn = 'player';
  unoPressed = false;
  updateUI();
  log(`Ronde dimulai. Giliran: pemain. Kartu teratas: ${cardLabel(top)}`);
  root.playerStatus.textContent = 'Giliranmu';
  root.botStatus.textContent = 'Bot menunggu';
}

function updateUI(){
  root.deckEl.textContent = deck.length;
  root.discardEl.innerHTML = '';
  if(discard.length){ root.discardEl.appendChild(renderCard(discard[discard.length-1])); }
  else root.discardEl.textContent = '—';

  root.playerHandEl.innerHTML = '';
  player.forEach((c, idx)=>{
    const el = renderCard(c);
    el.classList.add('player-card');
    el.onclick = ()=> {
      if(!roundActive) return;
      if(turn !== 'player'){ log('Bukan giliranmu'); return; }
      attemptPlay(player, idx, 'player');
    };
    root.playerHandEl.appendChild(el);
  });

  root.botHandEl.innerHTML = '';
  bot.forEach((_c, idx)=>{
    const back = document.createElement('div');
    back.className = 'card-back';
    back.textContent = 'UNO';
    back.style.transform = `translateX(${idx* -6}px)`;
    root.botHandEl.appendChild(back);
  });

  root.saldoEl.textContent = saldo;
  root.unoBtn.disabled = !roundActive;
}

function renderCard(c){
  const el = document.createElement('div');
  el.className = 'card';
  if(c.color) el.classList.add(c.color);
  if(c.type === 'number'){
    el.textContent = c.value;
    const sub=document.createElement('span'); sub.className='sub'; sub.textContent=c.color.toUpperCase(); el.appendChild(sub);
  } else if(c.type === 'action'){
    el.textContent = actionLabel(c.action);
    el.classList.add('action');
    const sub=document.createElement('span'); sub.className='sub'; sub.textContent=c.color.toUpperCase(); el.appendChild(sub);
  } else if(c.type === 'wild'){
    el.textContent = c.action === 'wild4' ? '+4' : '★';
    el.style.background='linear-gradient(90deg,#222,#111)';
    const sub=document.createElement('span'); sub.className='sub'; sub.textContent='WILD'; el.appendChild(sub);
  }
  return el;
}

function cardLabel(c){
  if(!c) return '—';
  if(c.type === 'number') return `${c.color} ${c.value}`;
  if(c.type === 'action') return `${c.color} ${c.action}`;
  return c.action.toUpperCase();
}
function actionLabel(a){ return a==='skip'?'⏭':a==='reverse'?'🔁':a==='draw2'?'+2':a; }
function topCard(){ return discard[discard.length-1]; }

function isPlayable(card, top){
  if(!card) return false;
  if(card.type === 'wild') return true;
  const topColor = top.chosenColor || top.color;
  if(card.color === topColor) return true;
  if(card.type==='number' && top.type==='number' && card.value===top.value) return true;
  if(card.type==='action' && top.type==='action' && card.action===top.action) return true;
  return false;
}

function attemptPlay(handArr, idx, who){
  const card = handArr[idx];
  const top = topCard();
  if(!isPlayable(card, top)){ log('Kartu tidak cocok!'); return; }
  const played = handArr.splice(idx,1)[0];

  if(played.type==='wild'){
    chooseColor(played).then(chosen=>{
      if(chosen){
        played.chosenColor=chosen;
        discard.push(played);
        log(`${who==='player'?'Kamu':'Bot'} memainkan ${cardLabel(played)} (warna ${chosen})`);
        afterPlay(played, who);
      } else {
        handArr.push(played);
        updateUI();
      }
    });
  } else {
    discard.push(played);
    log(`${who==='player'?'Kamu':'Bot'} memainkan ${cardLabel(played)}`);
    afterPlay(played, who);
  }
  updateUI();
}

function chooseColor(card){
  return new Promise(resolve=>{
    const c = prompt('Pilih warna (red, yellow, green, blue):');
    if(c && colors.includes(c.toLowerCase())) resolve(c.toLowerCase()); else resolve(null);
  });
}

/* ✅ Fixed afterPlay (logic update for Wild, Draw2, Skip, Reverse) */
function afterPlay(card, who){
  // ACTION CARDS
  if(card.type === 'action'){
    if(card.action === 'skip' || card.action === 'reverse'){
      if(who === 'player'){
        log('Bot dilewati ('+card.action+'). Giliran tetap pemain.');
        updateUI(); checkUNO(); checkWin(); return;
      } else {
        log('Kamu dilewati oleh bot ('+card.action+'). Bot main lagi.');
        updateUI(); checkUNO(); checkWin();
        setTimeout(botTurn, 900); return;
      }
    }
    if(card.action === 'draw2'){
      if(who === 'player'){
        for(let i=0;i<2;i++) bot.push(drawFromDeck());
        log('Bot mengambil +2 kartu.');
        updateUI(); checkUNO(); checkWin(); return;
      } else {
        for(let i=0;i<2;i++) player.push(drawFromDeck());
        log('Kamu menerima +2 kartu.');
        updateUI(); checkUNO(); checkWin();
        setTimeout(botTurn,900); return;
      }
    }
  }

  // WILD CARDS
  if(card.type === 'wild'){
    if(card.action === 'wild4'){
      if(who === 'player'){
        for(let i=0;i<4;i++) bot.push(drawFromDeck());
        log('Bot menerima +4 kartu.');
        updateUI(); checkUNO(); checkWin(); return;
      } else {
        for(let i=0;i<4;i++) player.push(drawFromDeck());
        log('Kamu menerima +4 kartu.');
        updateUI(); checkUNO(); checkWin();
        setTimeout(botTurn,900); return;
      }
    }
    // plain wild hanya ganti warna — lanjut normal
  }

  // Ganti giliran normal
  if(who === 'player'){
    turn='bot';
    root.playerStatus.textContent='Menunggu';
    root.botStatus.textContent='Giliran bot';
    setTimeout(botTurn,900);
  } else {
    turn='player';
    root.playerStatus.textContent='Giliranmu';
    root.botStatus.textContent='Menunggu';
  }

  updateUI(); checkUNO(); checkWin();
}

function drawFromDeck(){
  if(deck.length===0){
    const top = discard.pop();
    deck = shuffle(discard.splice(0));
    discard = [top];
  }
  return deck.pop();
}

// PLAYER draw
root.drawBtn.addEventListener('click', ()=>{
  if(!roundActive || turn!=='player'){ log('Bukan giliranmu.'); return; }
  const card = drawFromDeck();
  if(!card){ log('Deck kosong'); return; }
  player.push(card);
  log('Kamu mengambil 1 kartu.');
  updateUI();
  turn='bot'; root.playerStatus.textContent='Menunggu';
  root.botStatus.textContent='Giliran bot';
  setTimeout(botTurn,900);
});

// UNO button
root.unoBtn.addEventListener('click', ()=>{
  if(!roundActive) return;
  if(player.length===1){
    unoPressed=true; clearTimeout(unoTimeId);
    root.unoTimer.textContent='UNO ✅'; log('UNO!');
  } else log('Tekan UNO hanya jika 1 kartu tersisa.');
});

// Timer cek UNO
function checkUNO(){
  if(player.length===1){
    root.unoTimer.textContent='5s'; unoPressed=false;
    let t=5;
    unoTimeId=setInterval(()=>{
      t--; root.unoTimer.textContent=t+'s';
      if(t<=0){
        clearInterval(unoTimeId);
        if(!unoPressed){
          player.push(drawFromDeck(),drawFromDeck());
          log('Lupa tekan UNO! +2 kartu.');
          updateUI();
        }
        root.unoTimer.textContent='';
      }
    },1000);
  } else {
    root.unoTimer.textContent='';
    if(unoTimeId){ clearInterval(unoTimeId); unoTimeId=null; }
  }
}

function botTurn(){
  if(!roundActive) return;
  const top = topCard();
  let playableIndex=-1;
  for(let i=0;i<bot.length;i++){ if(isPlayable(bot[i],top)){ playableIndex=i; break; } }

  if(playableIndex>=0){
    const c=bot.splice(playableIndex,1)[0];
    if(c.type==='wild'){
      const chosen=botChooseColor();
      c.chosenColor=chosen;
      discard.push(c);
      log(`Bot memainkan ${cardLabel(c)} (warna ${chosen}).`);
      updateUI();
      afterPlay(c,'bot');
    } else {
      discard.push(c);
      log(`Bot memainkan ${cardLabel(c)}.`);
      updateUI();
      afterPlay(c,'bot');
    }
  } else {
    const d=drawFromDeck();
    if(d){
      bot.push(d);
      log('Bot mengambil 1 kartu.');
      updateUI();
      if(isPlayable(d,top)&&Math.random()>0.4){
        setTimeout(()=>attemptPlay(bot,bot.length-1,'bot'),700);
        return;
      }
    }
    turn='player';
    root.playerStatus.textContent='Giliranmu';
    root.botStatus.textContent='Menunggu';
    checkUNO(); checkWin();
  }
}

function botChooseColor(){
  const counts={red:0,green:0,blue:0,yellow:0};
  bot.forEach(c=>{ if(c.color) counts[c.color]++; });
  const arr=Object.entries(counts).sort((a,b)=>b[1]-a[1]);
  return arr[0][0]||colors[randInt(4)];
}

function checkWin(){
  if(player.length===0){
    log('Kamu menang!');
    saldo+=currentBet; roundActive=false; updateUI();
    alert(`Menang! +${currentBet}$`);
  } else if(bot.length===0){
    log('Bot menang!');
    saldo-=currentBet; roundActive=false; updateUI();
    alert(`Kalah. -${currentBet}$`);
  }
  if(saldo<=0){ alert('Saldo habis! Reset ke 5000$'); saldo=5000; }
}

root.startBtn.addEventListener('click', startRound);
root.deckEl.addEventListener('click', ()=>{
  if(!roundActive||turn!=='player'){ log('Bukan giliranmu.'); return; }
  const card=drawFromDeck();
  if(!card){ log('Deck kosong'); return; }
  player.push(card);
  log('Kamu mengambil 1 kartu.');
  updateUI();
  turn='bot'; root.playerStatus.textContent='Menunggu';
  root.botStatus.textContent='Giliran bot';
  setTimeout(botTurn,900);
});

updateUI();
log('Siap! Tekan "Mulai Ronde" untuk mulai bermain.');
