<?php
session_start();
require_once 'conexao.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

// Verifica se o usuário comprou
$id = $_SESSION['id'];
$sql = "SELECT comprou_jogos FROM aluno WHERE id = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1 || !$result->fetch_assoc()['comprou_jogos']) {
    echo "<h2 style='text-align:center;color:red;'>⚠️ Acesso negado. Compre os jogos para jogar.</h2>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Jogo da Memória Eco - Sustentabilidade</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
 <style>
    :root {
      --primary-green: #4CAF50;
      --primary-green-dark: #388E3C;
      --dark-green-nav: #2e7d32; 
      --light-green-accent: #e8f5e9; 
      --page-bg: #f7fafc; 
      --card-bg: #ffffff;   
      --text-dark: #2c3e50; 
      --text-light: #ffffff; 
      --text-muted: #555e68; 
      --border-color: #e2e8f0; 
      --danger-color: #dc3545;
      --warning-bg-color: #fff3cd;
      --warning-text-color: #856404;

      --default-border-radius: 8px;
      --large-border-radius: 12px;
      
      --shadow-soft: 0 4px 12px rgba(0, 0, 0, 0.06);
      --shadow-medium: 0 6px 20px rgba(0, 0, 0, 0.08);
      --shadow-strong: 0 8px 25px rgba(0,0,0,0.12);

      --font-family-main: 'Poppins', sans-serif;
      
      --transition-main: all 0.3s ease-in-out;
      --transition-fast: all 0.2s ease-in-out;
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }
    html { scroll-behavior: smooth; }

    body {
      font-family: var(--font-family-main);
      background: linear-gradient(135deg, var(--page-bg) 0%, #e9edf0 100%);
      color: var(--text-dark);
      margin: 0;
      padding: 0; 
      display: flex;
      flex-direction: column;
      align-items: center;
      min-height: 100vh;
      overflow-x: hidden; 
    }

    
    .game-page-header-container {
        width: 100%; max-width: 800px; /* Pode ser um pouco maior para o jogo */
        padding: 20px 20px 0 20px; margin: 20px auto 0 auto; box-sizing: border-box;
    }
    .game-top-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; }
    .game-page-header-container h1 {
        font-size: 2.2rem; font-weight: 700; color: var(--primary-green-dark);
        text-align: center; margin: 0 10px; flex-grow: 1; line-height: 1.2;
    }
    .btn-voltar-game { /* Botão Voltar genérico para jogos */
      display: inline-flex; align-items: center; padding: 8px 15px;
      background-color: var(--card-bg); color: var(--text-muted);
      border: 1px solid var(--border-color); border-radius: var(--default-border-radius);
      font-size: 0.9rem; font-weight: 500; text-decoration: none;
      transition: background-color var(--transition-main), color var(--transition-main), box-shadow var(--transition-fast), border-color var(--transition-fast);
      flex-shrink: 0;
    }
    .btn-voltar-game:hover {
      background-color: #f0f0f0; color: var(--primary-green-dark);
      border-color: #c0c8cd; box-shadow: var(--shadow-soft);
    }
    .btn-voltar-game svg { margin-right: 6px; fill: currentColor; width: 18px; height: 18px; }
    .game-header-placeholder { /* Para balancear o botão voltar */
        min-width: calc(18px + 6px + (15px * 2) + 40px); /* Ajuste conforme texto do botão voltar */
        visibility: hidden; flex-shrink: 0;
    }
    .game-stats-container {
        display: flex;
        justify-content: space-around;
        align-items: center;
        background-color: var(--light-green-accent);
        padding: 10px;
        border-radius: var(--default-border-radius);
        margin-bottom: 20px;
        box-shadow: var(--shadow-soft);
    }
    .game-stat {
        font-size: 1rem;
        font-weight: 500;
        color: var(--primary-green-dark);
    }
    .game-stat span { font-weight: 700; }
    /* --- Fim do Cabeçalho Específico da Página Jogo da Memória --- */

    .memory-game-app-container-wrapper { /* Wrapper para padding */
        width: 100%; padding: 0 20px 20px 20px; box-sizing: border-box;
        display: flex; flex-direction: column; align-items: center;
    }
    .memory-game-app-container { /* Container principal do jogo */
      width: 100%; max-width: 800px; margin: 0 auto;
    }

    .memory-game-board-container { /* Card principal do jogo */
      background: var(--card-bg); padding: 20px;
      border-radius: var(--large-border-radius); box-shadow: var(--shadow-medium);
      text-align: center; margin-bottom: 20px; 
    }

    #memory-game-board {
        display: grid;
        grid-template-columns: repeat(4, 1fr); /* Tabuleiro 4x4 */
        gap: 10px;
        max-width: 480px; /* Ajuste conforme tamanho das cartas */
        margin: 20px auto;
        perspective: 1000px; /* Para efeito 3D do flip */
    }

    .memory-card {
        background-color: var(--primary-green);
        height: 100px; /* Ajuste conforme necessário */
        border-radius: var(--default-border-radius);
        cursor: pointer;
        position: relative;
        transform-style: preserve-3d;
        transition: transform 0.6s;
        box-shadow: var(--shadow-soft);
    }
    .memory-card:hover {
        box-shadow: var(--shadow-medium);
        transform: scale(1.03) translateY(-2px); /* Leve elevação no hover */
    }
    .memory-card.flipped, .memory-card.matched {
        transform: rotateY(180deg);
        cursor: default;
    }
    .memory-card.matched {
        box-shadow: 0 0 0 3px var(--primary-green-dark) inset, var(--shadow-soft); /* Destaque para pares encontrados */
        opacity: 0.7; /* Levemente transparente quando encontrado */
    }

    .card-face {
        position: absolute; width: 100%; height: 100%;
        backface-visibility: hidden; /* Esconde o lado de trás da face */
        display: flex; justify-content: center; align-items: center;
        font-size: 2.5rem; /* Tamanho do emoji/ícone */
        border-radius: var(--default-border-radius);
    }
    .card-front {
        background-color: var(--light-green-accent);
        color: var(--text-dark);
        transform: rotateY(180deg); /* Oculta a frente inicialmente */
    }
    .card-back {
        background: linear-gradient(135deg, var(--primary-green), var(--primary-green-dark));
        color: var(--text-light);
        /* Pode adicionar um ícone genérico para a parte de trás, ex: '?' ou um logo */
    }
     .card-back::before { /* Exemplo de conteúdo para o verso da carta */
        content: "🌿";
        font-size: 2rem;
        opacity: 0.8;
    }

    .game-feedback-message {
        min-height: 30px; /* Para evitar que o layout salte */
        margin-top: 15px;
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--primary-green-dark);
    }

    .btn-recomecar-memory {
      display: block; margin: 20px auto 10px; padding: 12px 25px;
      background-color: var(--primary-green); color: white; border: none;
      border-radius: var(--default-border-radius); font-size: 1rem; font-weight: 600;
      cursor: pointer; transition: background-color var(--transition-main), transform var(--transition-fast);
      box-shadow: var(--shadow-soft);
    }
    .btn-recomecar-memory:hover {
      background-color: var(--primary-green-dark); transform: translateY(-2px);
    }


    /* Media Queries */
    @media (max-width: 999px) { /* Para menu mobile */
      .logo { font-size: 1.5rem; }
      .nav-list {
        position: fixed; top: 0; right: 0; width: 60vw; max-width: 300px; height: 100vh;
        background: var(--dark-green-nav); box-shadow: -5px 0 15px rgba(0,0,0,0.2);
        flex-direction: column; align-items: center; justify-content: center;
        transform: translateX(100%); transition: transform 0.4s ease-in-out;
        z-index: 1000; padding-top: 60px;
      }
      .nav-list li { margin: 20px 0; }
      .nav-list.active { transform: translateX(0); }
      .mobile-menu { display: block; z-index: 1001; }
      .mobile-menu.active .line1 { transform: rotate(-45deg) translate(-7px, 7px); }
      .mobile-menu.active .line2 { opacity: 0; }
      .mobile-menu.active .line3 { transform: rotate(45deg) translate(-7px, -7px); }
    }
    @media (max-width: 768px) {
      .btn-voltar-game { font-size: 0.85rem; padding: 7px 12px; }
      .btn-voltar-game svg { width: 16px; height: 16px; }
      .game-header-placeholder { min-width: calc(16px + 6px + (12px*2) + 30px); }
      .game-page-header-container h1 { font-size: 1.8rem; }
      #memory-game-board { grid-template-columns: repeat(4, 1fr); gap: 8px; max-width: 400px; }
      .memory-card { height: 80px; }
      .card-face { font-size: 2rem; }
      .game-stat { font-size: 0.9rem; }
    }
    @media (max-width: 480px) {
      nav { padding: 10px 15px; }
      .logo { font-size: 1.3rem; }
      .btn-voltar-game { font-size: 0.8rem; padding: 6px 10px; }
      .btn-voltar-game svg { width: 14px; height: 14px; margin-right: 4px; }
      .game-header-placeholder { min-width: calc(14px + 4px + (10px*2) + 25px); }
      .game-page-header-container { padding: 15px 10px 0 10px; }
      .game-page-header-container h1 { font-size: 1.5rem; }
      #memory-game-board { grid-template-columns: repeat(4, 1fr); gap: 6px; max-width: 100%; } /* Ajuste para telas pequenas */
      .memory-card { height: 70px; } /* Cartas menores */
      .card-face { font-size: 1.8rem; }
      .game-stat { font-size: 0.8rem; }
      .game-stats-container { flex-direction: column; gap: 5px; padding: 8px;}
      .btn-recomecar-memory { font-size: 0.9rem; padding: 10px 18px; }
      .nav-login-btn {padding: 6px 12px; font-size: 0.85rem;}
    }
    #curiosidade {
  background-color: var(--light-green-accent);
  color: var(--primary-green-dark);
  font-style: italic;
  font-size: 1.1rem;
  padding: 12px 18px;
  border-left: 4px solid var(--primary-green);
  border-radius: var(--default-border-radius);
  margin-top: 10px;
  text-align: center;
  box-shadow: var(--shadow-soft);
  max-width: 700px;
  margin-left: auto;
  margin-right: auto;
  transition: opacity 0.3s ease;
}

  </style>
</head>
<body>

<div class="game-page-header-container">
  <div class="game-top-bar">
    <a href="ecogame.php" class="btn-voltar-game">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
        <path d="M10.8284 12.0007L15.7782 16.9504L14.364 18.3646L8 12.0007L14.364 5.63672L15.7782 7.05093L10.8284 12.0007Z"></path>
      </svg>
      Voltar para Jogos
    </a>
    <h1>Jogo da Memória Eco</h1>
    <div class="game-header-placeholder"></div>
  </div>
  <p id="curiosidade" style="text-align:center; font-style: italic; color: var(--primary-green-dark); margin-top: 5px;"></p>
  <div class="game-stats-container">
    <div class="game-stat">Tentativas: <span id="tentativas-count">0</span></div>
    <div class="game-stat">Pares Encontrados: <span id="pares-count">0</span> / <span id="total-pares">8</span></div>
  </div>
</div>

<div class="memory-game-app-container-wrapper">
  <div class="memory-game-app-container">
    <main>
      <div class="memory-game-board-container">
        <div id="memory-game-board"></div>
        <div id="game-feedback-message" class="game-feedback-message"></div>
      </div>
      <button id="restartMemoryGameBtn" class="btn-recomecar-memory">Recomeçar Jogo</button>
    </main>
  </div>
</div>

<script>
const gameBoard = document.getElementById('memory-game-board');
const tentativasCountEl = document.getElementById('tentativas-count');
const paresCountEl = document.getElementById('pares-count');
const totalParesEl = document.getElementById('total-pares');
const restartBtn = document.getElementById('restartMemoryGameBtn');
const feedbackMessageEl = document.getElementById('game-feedback-message');
const curiosidadeEl = document.getElementById('curiosidade');

const cardValues = ['♻️', '🌳', '💧', '☀️', '💨', '🚲', '🥕', '🌍'];
let cards = [];
let flippedCards = [];
let matchedPairs = 0;
let attempts = 0;
let lockBoard = false;
const totalPairs = cardValues.length;
totalParesEl.textContent = totalPairs;

const curiosidades = {
  '♻️': 'A reciclagem ajuda a preservar recursos naturais e economizar energia.',
  '🌳': 'As árvores produzem oxigênio e ajudam a combater as mudanças climáticas.',
  '💧': 'Água é essencial para a vida e deve ser usada de forma consciente.',
  '☀️': 'A energia solar é limpa e renovável, reduzindo a emissão de gases poluentes.',
  '💨': 'O vento é uma fonte de energia renovável que não polui o meio ambiente.',
  '🚲': 'Andar de bicicleta ajuda a reduzir a poluição e melhora a saúde.',
  '🥕': 'Consumir alimentos orgânicos é melhor para o solo e para a saúde.',
  '🌍': 'Preservar o planeta é essencial para garantir um futuro sustentável para todos.',
};

function shuffle(array) {
  for (let i = array.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [array[i], array[j]] = [array[j], array[i]];
  }
  return array;
}

function createBoard() {
  gameBoard.innerHTML = '';
  feedbackMessageEl.textContent = '';
  curiosidadeEl.textContent = '';
  flippedCards = [];
  matchedPairs = 0;
  attempts = 0;
  tentativasCountEl.textContent = '0';
  paresCountEl.textContent = '0';
  lockBoard = false;
  
  const gameCardsData = shuffle([...cardValues, ...cardValues]);

  gameCardsData.forEach(value => {
    const cardElement = document.createElement('div');
    cardElement.classList.add('memory-card');
    cardElement.dataset.value = value;

    const cardFaceFront = document.createElement('div');
    cardFaceFront.classList.add('card-face', 'card-front');
    cardFaceFront.textContent = value;

    const cardFaceBack = document.createElement('div');
    cardFaceBack.classList.add('card-face', 'card-back');

    cardElement.appendChild(cardFaceFront);
    cardElement.appendChild(cardFaceBack);
    
    cardElement.addEventListener('click', handleCardClick);
    cards.push(cardElement);
    gameBoard.appendChild(cardElement);
  });
}

function handleCardClick(event) {
  if (lockBoard) return;
  const clickedCard = event.currentTarget;
  if (clickedCard === flippedCards[0] || clickedCard.classList.contains('matched')) return;

  clickedCard.classList.add('flipped');
  flippedCards.push(clickedCard);

  if (flippedCards.length === 2) {
    lockBoard = true;
    attempts++;
    tentativasCountEl.textContent = attempts;
    checkForMatch();
  }
}

function checkForMatch() {
  const [card1, card2] = flippedCards;
  if (card1.dataset.value === card2.dataset.value) {
    matchedPairs++;
    paresCountEl.textContent = matchedPairs;
    card1.classList.add('matched');
    card2.classList.add('matched');
    card1.removeEventListener('click', handleCardClick);
    card2.removeEventListener('click', handleCardClick);

    // Exibe a curiosidade relacionada
    curiosidadeEl.textContent = curiosidades[card1.dataset.value] || '';

    flippedCards = [];
    lockBoard = false;
  } else {
    setTimeout(() => {
      card1.classList.remove('flipped');
      card2.classList.remove('flipped');
      flippedCards = [];
      lockBoard = false;
    }, 1000);
  }
}

restartBtn.addEventListener('click', () => {
  createBoard();
});

createBoard();
</script>
</body>
</html>