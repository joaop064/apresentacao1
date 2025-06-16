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
      --light-green-accent: #e8f5e9;
      --card-bg: #ffffff;
      --text-dark: #2c3e50;
      --text-light: #ffffff;
      --border-color: #e2e8f0;
      --shadow-soft: 0 4px 12px rgba(0, 0, 0, 0.06);
      --shadow-medium: 0 6px 20px rgba(0, 0, 0, 0.08);
      --default-border-radius: 8px;
      --large-border-radius: 12px;
      --font-family-main: 'Poppins', sans-serif;
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      font-family: var(--font-family-main);
      background: linear-gradient(135deg, #f7fafc 0%, #e9edf0 100%);
      color: var(--text-dark);
      display: flex;
      flex-direction: column;
      align-items: center;
      min-height: 100vh;
    }

    .game-page-header-container {
      width: 100%; max-width: 800px; padding: 20px;
    }

    .game-top-bar {
      display: flex; justify-content: space-between; align-items: center;
    }

    .btn-voltar-game {
      display: inline-flex; align-items: center; padding: 8px 15px;
      background-color: var(--card-bg); color: var(--text-dark);
      border: 1px solid var(--border-color); border-radius: var(--default-border-radius);
      font-weight: 500; text-decoration: none;
    }

    .btn-voltar-game:hover {
      background-color: #f0f0f0; color: var(--primary-green-dark);
    }

    .btn-voltar-game svg {
      margin-right: 6px; width: 18px; height: 18px; fill: currentColor;
    }

    .game-page-header-container h1 {
      text-align: center; flex-grow: 1; font-size: 2rem; color: var(--primary-green-dark);
    }

    #curiosidade-card {
      display: none;
      background-color: var(--card-bg);
      border-left: 6px solid var(--primary-green);
      padding: 16px;
      margin: 20px auto;
      max-width: 700px;
      border-radius: 12px;
      box-shadow: var(--shadow-medium);
      display: flex;
      align-items: center;
      gap: 16px;
      animation: fadeIn 0.5s ease;
    }

    #curiosidade-card img {
      width: 80px;
      height: 80px;
      object-fit: cover;
      border-radius: 8px;
    }

    #curiosidade-card .curiosidade-text {
      font-size: 1rem;
      color: var(--text-dark);
      line-height: 1.4;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .game-stats-container {
      display: flex; justify-content: space-around;
      background-color: var(--light-green-accent);
      padding: 10px; border-radius: var(--default-border-radius);
      box-shadow: var(--shadow-soft); margin-top: 10px;
    }

    .game-stat { font-weight: 500; }

    .memory-game-app-container {
      width: 100%; max-width: 800px; padding: 20px;
    }

    .memory-game-board-container {
      background: var(--card-bg); padding: 20px;
      border-radius: var(--large-border-radius);
      box-shadow: var(--shadow-medium);
      text-align: center;
    }

    #memory-game-board {
      display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px;
      max-width: 480px; margin: 0 auto; perspective: 1000px;
    }

    .memory-card {
      width: 100%; height: 100px;
      position: relative;
      transform-style: preserve-3d;
      transition: transform 0.6s;
      border-radius: var(--default-border-radius);
      box-shadow: var(--shadow-soft);
      cursor: pointer;
    }

    .memory-card.flipped,
    .memory-card.matched {
      transform: rotateY(180deg);
      cursor: default;
    }

    .card-face {
      position: absolute; width: 100%; height: 100%;
      backface-visibility: hidden;
      display: flex; align-items: center; justify-content: center;
      font-size: 2.2rem; border-radius: var(--default-border-radius);
    }

    .card-front {
      background-color: var(--light-green-accent);
      color: var(--text-dark);
      transform: rotateY(180deg);
    }

    .card-back {
      background: linear-gradient(135deg, var(--primary-green), var(--primary-green-dark));
      color: var(--text-light);
      transform: rotateY(0deg);
    }

    .card-back::before {
      content: "";
    }

    .btn-recomecar-memory {
      margin-top: 20px;
      padding: 12px 25px;
      background-color: var(--primary-green);
      color: white; border: none;
      border-radius: var(--default-border-radius);
      font-weight: 600; cursor: pointer;
    }

    .btn-recomecar-memory:hover {
      background-color: var(--primary-green-dark);
    }

    .game-feedback-message {
      font-weight: bold; color: var(--primary-green-dark); margin-top: 10px;
    }
  </style>
</head>
<body>

<div class="game-page-header-container">
  <div class="game-top-bar">
    <a href="ecogame.php" class="btn-voltar-game">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
        <path d="M10.8284 12.0007L15.7782 16.9504L14.364 18.3646L8 12.0007L14.364 5.63672L15.7782 7.05093L10.8284 12.0007Z"/>
      </svg>
      Voltar
    </a>
    <h1>Jogo da Memória Eco</h1>
    <div style="width:40px;"></div>
  </div>

  <div id="curiosidade-card"></div>

  <div class="game-stats-container">
    <div class="game-stat">Tentativas: <span id="tentativas-count">0</span></div>
    <div class="game-stat">Pares: <span id="pares-count">0</span> / <span id="total-pares">8</span></div>
  </div>
</div>

<div class="memory-game-app-container">
  <div class="memory-game-board-container">
    <div id="memory-game-board"></div>
    <div id="game-feedback-message" class="game-feedback-message"></div>
    <button id="restartMemoryGameBtn" class="btn-recomecar-memory">Recomeçar Jogo</button>
  </div>
</div>

<script>
const gameBoard = document.getElementById('memory-game-board');
const tentativasCountEl = document.getElementById('tentativas-count');
const paresCountEl = document.getElementById('pares-count');
const totalParesEl = document.getElementById('total-pares');
const restartBtn = document.getElementById('restartMemoryGameBtn');
const feedbackMessageEl = document.getElementById('game-feedback-message');
const curiosidadeEl = document.getElementById('curiosidade-card');

const cardValues = ['\u267b\ufe0f', '\ud83c\udf33', '\ud83d\udca7', '\u2600\ufe0f', '\ud83d\udca8', '\ud83d\udeb2', '\ud83e\udd55', '\ud83c\udf0d'];
const curiosidades = {
  '\u267b\ufe0f': {
    texto: 'A reciclagem ajuda a preservar recursos naturais e economizar energia.',
    imagem: 'https://cdn-icons-png.flaticon.com/512/679/679922.png'
  },
  '\ud83c\udf33': {
    texto: 'As árvores produzem oxigênio e ajudam a combater as mudanças climáticas.',
    imagem: 'https://cdn-icons-png.flaticon.com/512/427/427735.png'
  },
  '\ud83d\udca7': {
    texto: 'Água é essencial para a vida e deve ser usada de forma consciente.',
    imagem: 'https://cdn-icons-png.flaticon.com/512/728/728093.png'
  },
  '\u2600\ufe0f': {
    texto: 'A energia solar é limpa e renovável.',
    imagem: 'https://cdn-icons-png.flaticon.com/512/869/869869.png'
  },
  '\ud83d\udca8': {
    texto: 'O vento é uma fonte de energia renovável.',
    imagem: 'https://cdn-icons-png.flaticon.com/512/1121/1121359.png'
  },
  '\ud83d\udeb2': {
    texto: 'Andar de bicicleta reduz a poluição e melhora a saúde.',
    imagem: 'https://cdn-icons-png.flaticon.com/512/44/44651.png'
  },
  '\ud83e\udd55': {
    texto: 'Alimentos orgânicos são melhores para o solo e a saúde.',
    imagem: 'https://cdn-icons-png.flaticon.com/512/415/415744.png'
  },
  '\ud83c\udf0d': {
    texto: 'Preservar o planeta é essencial para o futuro.',
    imagem: 'https://cdn-icons-png.flaticon.com/512/616/616408.png'
  }
};

let flippedCards = [];
let matchedPairs = 0;
let attempts = 0;
let lockBoard = false;

totalParesEl.textContent = cardValues.length;

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
  curiosidadeEl.innerHTML = '';
  curiosidadeEl.style.display = 'none';
  flippedCards = [];
  matchedPairs = 0;
  attempts = 0;
  tentativasCountEl.textContent = '0';
  paresCountEl.textContent = '0';
  lockBoard = false;

  const shuffled = shuffle([...cardValues, ...cardValues]);

  shuffled.forEach(value => {
    const card = document.createElement('div');
    card.classList.add('memory-card');
    card.dataset.value = value;

    const front = document.createElement('div');
    front.classList.add('card-face', 'card-front');
    front.textContent = value;

    const back = document.createElement('div');
    back.classList.add('card-face', 'card-back');

    card.appendChild(front);
    card.appendChild(back);

    card.addEventListener('click', handleCardClick);
    gameBoard.appendChild(card);
  });
}

function handleCardClick(e) {
  if (lockBoard) return;
  const card = e.currentTarget;
  if (card.classList.contains('flipped') || card.classList.contains('matched')) return;

  card.classList.add('flipped');
  flippedCards.push(card);

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
    card1.classList.add('matched');
    card2.classList.add('matched');
    card1.removeEventListener('click', handleCardClick);
    card2.removeEventListener('click', handleCardClick);

    matchedPairs++;
    paresCountEl.textContent = matchedPairs;

    const curiosidade = curiosidades[card1.dataset.value];
    if (curiosidade) {
      curiosidadeEl.innerHTML = `
        <img src="${curiosidade.imagem}" alt="Imagem da curiosidade">
        <div class="curiosidade-text">${curiosidade.texto}</div>
      `;
      curiosidadeEl.style.display = 'flex';
    }

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

restartBtn.addEventListener('click', createBoard);

createBoard();
</script>

</body>
</html>
