<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eco-Coleta: Jogo Sustentável</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #e0ffe0; /* Fundo verde claro */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            overflow: hidden;
            color: #333;
        }

        /* Estilo para todas as páginas/containers principais */
        .page-container {
            background-color: #ffffff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
            padding: 40px; /* Mais padding para a página inicial */
            text-align: center;
            width: 90%;
            max-width: 900px; /* Mais largo para a página inicial */
            position: relative;
            overflow: hidden;
            min-height: 600px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border: 3px solid #66bb6a;
            transition: opacity 0.5s ease-in-out, transform 0.5s ease-in-out; /* Transição suave */
        }

        /* Estilo específico para a página inicial */
        #main-page {
            justify-content: space-around;
            padding: 60px 40px; /* Mais padding vertical */
        }

        #main-page header h1 {
            font-size: 4em; /* Título maior */
            color: #2e7d32;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }

        #main-page .tagline {
            font-size: 1.8em;
            color: #4CAF50;
            margin-bottom: 40px;
            font-weight: 500;
        }

        #main-page .intro-section {
            font-size: 1.2em;
            line-height: 1.8;
            max-width: 700px;
            margin: 0 auto 50px auto;
            color: #444;
        }

        #main-page .intro-section p {
            margin-bottom: 15px;
        }

        .main-footer {
            margin-top: 50px;
            font-size: 0.9em;
            color: #888;
        }

        /* Esconde elementos */
        .hidden {
            display: none !important;
            opacity: 0;
            transform: scale(0.95);
        }

        /* Estilos do jogo (mantidos e ajustados da versão anterior) */
        .game-wrapper { /* Este é o container interno do jogo, dentro de #game-container-wrapper */
            background-color: #ffffff; /* Fundo interno do jogo */
            border-radius: 15px; /* Ajuste para o container interno */
            box-shadow: none; /* Remove a sombra duplicada */
            padding: 20px;
            width: 100%;
            min-height: 520px; /* Ajusta altura para caber dentro do wrapper externo */
            border: none; /* Remove borda duplicada */
        }

        h1 {
            color: #2e7d32;
            margin-bottom: 25px;
            font-size: 3em;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }

        .game-screen {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            position: absolute; /* Para sobrepor a área de jogo */
            top: 0;
            left: 0;
            padding: 30px;
            box-sizing: border-box;
            background-color: rgba(255, 255, 255, 0.98);
            border-radius: 15px;
            z-index: 5; /* Garante que as telas fiquem por cima */
        }

        #game-play-screen { /* A tela de jogo não precisa ser absoluta ou ter fundo semi-transparente */
            position: static; /* Volta para o fluxo normal */
            background-color: transparent;
            padding: 0;
            justify-content: flex-start; /* Alinha o conteúdo ao topo */
            height: auto; /* Permite que a altura se ajuste ao conteúdo */
        }


        #game-start-screen h2,
        #game-end-screen h2,
        #game-pause-screen h2 {
            color: #2e7d32;
            font-size: 2.8em;
            margin-bottom: 20px;
            text-shadow: 0.5px 0.5px 1px rgba(0,0,0,0.05);
        }

        #game-start-screen p,
        #game-end-screen p,
        #game-pause-screen p {
            font-size: 1.4em;
            color: #555;
            margin-bottom: 35px;
            line-height: 1.5;
        }

        .game-info {
            display: flex;
            justify-content: space-around;
            align-items: center;
            width: 100%;
            margin-bottom: 25px;
            font-size: 1.5em;
            color: #4CAF50;
            font-weight: bold;
            padding: 10px 0;
            background-color: #f0fff0;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        #game-area {
            background-color: #e8f5e9;
            border: 3px dashed #81c784;
            border-radius: 10px;
            height: 400px;
            width: 100%;
            position: relative;
            overflow: hidden;
            margin-top: 20px;
        }

        .item {
            position: absolute;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 2.5em;
            cursor: pointer;
            transition: transform 0.1s ease-out, background-color 0.2s ease;
            user-select: none;
            line-height: 1;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .item:active {
            transform: scale(0.85);
        }

        .item.collectible {
            background-color: #b9f6ca;
            border: 2px solid #00c853;
        }

        .item.non-collectible {
            background-color: #ffcdd2;
            border: 2px solid #d32f2f;
        }

        /* Estilo para todos os botões principais */
        button {
            background-color: #4CAF50;
            color: white;
            padding: 15px 35px;
            border: none;
            border-radius: 50px;
            font-size: 1.5em;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.2s ease;
            margin-top: 20px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
            letter-spacing: 0.5px;
        }

        button:hover {
            background-color: #43a047;
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0,0,0,0.3);
        }

        button:active {
            transform: translateY(0);
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        /* Estilo específico para o botão de pausa */
        .control-btn {
            background-color: #ffc107;
            padding: 10px 20px;
            font-size: 1.1em;
            border-radius: 30px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .control-btn:hover {
            background-color: #e0a800;
            transform: translateY(-2px);
            box-shadow: 0 3px 8px rgba(0,0,0,0.15);
        }

        /* Novo estilo para botões secundários, como o de voltar ao início na pausa */
        .secondary-btn {
            background-color: #6c757d; /* Cinza para secundário */
            color: white;
            padding: 12px 25px; /* Um pouco menor que o principal */
            font-size: 1.2em;
            margin-top: 15px; /* Ajuste a margem para separar do botão principal */
        }

        .secondary-btn:hover {
            background-color: #5a6268;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        @keyframes pop-in {
            from { transform: scale(0.2) rotate(15deg); opacity: 0; }
            to { transform: scale(1) rotate(0deg); opacity: 1; }
        }

        .item {
            animation: pop-in 0.3s cubic-bezier(0.68, -0.55, 0.27, 1.55);
        }
    </style>
</head>
<body>
    <div id="main-page" class="page-container">
        <header>
            <h1>Eco-Coleta</h1>
            <p class="tagline">Seja um herói da reciclagem e salve o planeta!</p>
        </header>
        <section class="intro-section">
            <p>Em "Eco-Coleta", sua missão é simples: clique rapidamente nos **itens recicláveis** que aparecem na tela para coletá-los e ganhar pontos. Mas cuidado! Se clicar no **lixo comum**, você perde pontos valiosos.</p>
            <p>Junte o máximo de pontos antes que o tempo acabe e ajude o meio ambiente!</p>
        </section>
        <button id="start-game-from-main">Começar a Jogar</button>
        <footer class="main-footer">
            <p>&copy; 2025 Eco-Coleta. Todos os direitos reservados.</p>
        </footer>
    </div>

    <div id="game-container-wrapper" class="page-container hidden">
        <div class="game-wrapper">
            <h1>Eco-Coleta</h1>

            <div id="game-start-screen" class="game-screen hidden">
                <h2>Bem-vindo ao Eco-Coleta!</h2>
                <p>Clique nos itens recicláveis para ganhar pontos. Evite o lixo comum!</p>
                <button id="start-game-btn">Iniciar Jogo</button>
            </div>

            <div id="game-play-screen" class="game-screen hidden">
                <div class="game-info">
                    <p>Pontuação: <span id="score-display">0</span></p>
                    <p>Tempo: <span id="time-display">30</span>s</p>
                    <button id="pause-game-btn" class="control-btn">Pausar</button>
                </div>
                <div id="game-area">
                    </div>
            </div>

            <div id="game-pause-screen" class="game-screen hidden">
                <h2>Jogo Pausado</h2>
                <p>Clique em continuar para voltar à coleta, ou voltar ao início.</p>
                <button id="resume-game-btn">Continuar Jogo</button>
                <button id="return-to-main-from-pause-btn" class="secondary-btn">Voltar ao Início</button>
                <button id="return-to-site-homepage-from-pause-btn" class="secondary-btn">Ir para Início do Site</button>
            </div>

            <div id="game-end-screen" class="game-screen hidden">
                <h2>Fim de Jogo!</h2>
                <p>Sua pontuação final foi: <span id="final-score-display">0</span></p>
                <button id="restart-game-btn">Jogar Novamente</button>
                <button id="return-to-game-start-btn" class="secondary-btn">Voltar para o Início do Jogo</button>
                <button id="return-to-site-homepage-from-end-btn" class="secondary-btn">Ir para Início do Site</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // --- Referências aos elementos do DOM ---
            const mainPage = document.getElementById('main-page');
            const gameContainerWrapper = document.getElementById('game-container-wrapper');

            const gameStartScreen = document.getElementById('game-start-screen');
            const gamePlayScreen = document.getElementById('game-play-screen');
            const gamePauseScreen = document.getElementById('game-pause-screen');
            const gameEndScreen = document.getElementById('game-end-screen');

            const startGameFromMainBtn = document.getElementById('start-game-from-main');
            const startGameBtn = document.getElementById('start-game-btn');
            const pauseGameBtn = document.getElementById('pause-game-btn');
            const resumeGameBtn = document.getElementById('resume-game-btn');
            const returnToMainFromPauseBtn = document.getElementById('return-to-main-from-pause-btn');
            const restartGameBtn = document.getElementById('restart-game-btn');

            const returnToGameStartBtn = document.getElementById('return-to-game-start-btn');
            const returnToSiteHomepageFromPauseBtn = document.getElementById('return-to-site-homepage-from-pause-btn');
            const returnToSiteHomepageFromEndBtn = document.getElementById('return-to-site-homepage-from-end-btn');


            const scoreDisplay = document.getElementById('score-display');
            const timeDisplay = document.getElementById('time-display');
            const finalScoreDisplay = document.getElementById('final-score-display');
            const gameArea = document.getElementById('game-area');

            // --- Variáveis de estado do jogo ---
            let score = 0;
            let timeLeft = 0;
            let gameInterval;
            let itemGenerationInterval;
            let gameActive = false;
            let gamePaused = false;

            // --- Configurações do jogo ---
            const COLLECTIBLE_ITEMS = ['♻️', '🥫', '📰', '🍾', '📦', '🔋'];
            const NON_COLLECTIBLE_ITEMS = ['🍎', '🍌', '🦴', '💩', '🍂', '🗑️'];
            const GAME_DURATION = 30;
            const ITEM_LIFESPAN = 2500;
            const ITEM_SPAWN_RATE = 500;

            // --- Funções de controle de tela ---

            /**
             * Mostra uma tela específica dentro do container do jogo e esconde as outras.
             * @param {HTMLElement} screenToShow - O elemento da tela a ser mostrada (dentro do jogo).
             */
            function showGameScreen(screenToShow) {
                [gameStartScreen, gamePlayScreen, gamePauseScreen, gameEndScreen].forEach(screen => {
                    screen.classList.add('hidden');
                });
                screenToShow.classList.remove('hidden');
            }

            /**
             * Alterna entre a página principal e o container do jogo.
             * @param {HTMLElement} containerToShow - O container (mainPage ou gameContainerWrapper) a ser mostrado.
             */
            function showMainContainer(containerToShow) {
                if (containerToShow === mainPage) {
                    mainPage.classList.remove('hidden');
                    gameContainerWrapper.classList.add('hidden');
                } else {
                    mainPage.classList.add('hidden');
                    gameContainerWrapper.classList.remove('hidden');
                }
            }

            // --- Funções de lógica do jogo ---

            /**
             * Inicia uma nova partida.
             */
            function startGame() {
                score = 0;
                timeLeft = GAME_DURATION;
                gameActive = true;
                gamePaused = false;

                scoreDisplay.textContent = score;
                timeDisplay.textContent = timeLeft;
                gameArea.innerHTML = ''; // Limpa a área de jogo de itens anteriores

                clearInterval(gameInterval);
                clearInterval(itemGenerationInterval);

                showMainContainer(gameContainerWrapper); // Garante que o container do jogo esteja visível
                showGameScreen(gamePlayScreen); // Mostra a tela de jogo

                gameInterval = setInterval(updateTimer, 1000);
                itemGenerationInterval = setInterval(generateItem, ITEM_SPAWN_RATE);
            }

            /**
             * Pausa o jogo.
             */
            function pauseGame() {
                if (!gameActive || gamePaused) return;

                gamePaused = true;
                clearInterval(gameInterval);
                clearInterval(itemGenerationInterval);

                showGameScreen(gamePauseScreen); // Mostra a tela de pausa
            }

            /**
             * Continua o jogo após ser pausado.
             */
            function resumeGame() {
                if (!gameActive || !gamePaused) return;

                gamePaused = false;
                showGameScreen(gamePlayScreen); // Volta para a tela de jogo

                gameInterval = setInterval(updateTimer, 1000);
                itemGenerationInterval = setInterval(generateItem, ITEM_SPAWN_RATE);
            }

            /**
             * Volta para a página inicial do site (reinicia o estado do jogo e vai para inicio.php).
             */
            function returnToSiteHomepage() {
                // Primeiro, garante que o jogo está parado e limpo
                gameActive = false;
                gamePaused = false;
                clearInterval(gameInterval);
                clearInterval(itemGenerationInterval);
                gameArea.innerHTML = ''; // Limpa quaisquer itens restantes

                // Então, redireciona para a página inicial do site
                window.location.href = 'index.php'; // Altere para a URL real da sua página inicial se for diferente
            }

            /**
             * Volta para a tela de início do jogo (mantém dentro do contêiner do jogo).
             */
            function returnToGameStartScreen() {
                // Primeiro, garante que o jogo está parado e limpo
                gameActive = false;
                gamePaused = false;
                clearInterval(gameInterval);
                clearInterval(itemGenerationInterval);
                gameArea.innerHTML = ''; // Limpa quaisquer itens restantes

                // Então, mostra a tela de início do jogo
                showGameScreen(gameStartScreen);
            }

            /**
             * Volta para o menu principal da página inicial (o container fora do jogo).
             */
            function returnToMainMenu() {
                gameActive = false;
                gamePaused = false;
                clearInterval(gameInterval);
                clearInterval(itemGenerationInterval);
                gameArea.innerHTML = ''; // Limpa a área de jogo

                showMainContainer(mainPage); // Mostra a página principal
            }

            /**
             * Atualiza o timer do jogo a cada segundo.
             */
            function updateTimer() {
                if (!gameActive || gamePaused) return;

                timeLeft--;
                timeDisplay.textContent = timeLeft;

                if (timeLeft <= 0) {
                    endGame();
                }
            }

            /**
             * Gera um novo item (reciclável ou não) na área de jogo.
             */
            function generateItem() {
                if (!gameActive || gamePaused) return;

                const item = document.createElement('div');
                item.classList.add('item');

                const isCollectible = Math.random() > 0.3; // 70% de chance de ser coletável
                let itemEmoji;

                if (isCollectible) {
                    itemEmoji = COLLECTIBLE_ITEMS[Math.floor(Math.random() * COLLECTIBLE_ITEMS.length)];
                    item.classList.add('collectible');
                    item.dataset.type = 'collectible';
                } else {
                    itemEmoji = NON_COLLECTIBLE_ITEMS[Math.floor(Math.random() * NON_COLLECTIBLE_ITEMS.length)];
                    item.classList.add('non-collectible');
                    item.dataset.type = 'non-collectible';
                }

                item.textContent = itemEmoji;

                const itemSize = 60;
                const maxX = gameArea.clientWidth - itemSize;
                const maxY = gameArea.clientHeight - itemSize;

                item.style.left = `${Math.max(0, Math.random() * maxX)}px`;
                item.style.top = `${Math.max(0, Math.random() * maxY)}px`;

                gameArea.appendChild(item);

                item.addEventListener('click', () => {
                    if (gameActive && !gamePaused) {
                        if (item.dataset.type === 'collectible') {
                            score += 10;
                            scoreDisplay.textContent = score;
                        } else {
                            score = Math.max(0, score - 5);
                            scoreDisplay.textContent = score;
                        }
                        item.remove();
                    }
                });

                setTimeout(() => {
                    if (item.parentNode === gameArea) {
                        item.remove();
                    }
                }, ITEM_LIFESPAN);
            }

            /**
             * Finaliza o jogo, para os timers e mostra a tela de fim de jogo.
             */
            function endGame() {
                gameActive = false;
                gamePaused = false;

                clearInterval(gameInterval);
                clearInterval(itemGenerationInterval);

                gameArea.innerHTML = '';

                finalScoreDisplay.textContent = score;
                showGameScreen(gameEndScreen);
            }

            // --- Inicialização e Event Listeners Globais ---

            // Define que a página principal seja a primeira a aparecer
            showMainContainer(mainPage);

            // Listener para o botão "Começar a Jogar" da página principal
            startGameFromMainBtn.addEventListener('click', () => {
                showMainContainer(gameContainerWrapper); // Alterna para o container do jogo
                showGameScreen(gameStartScreen); // Mostra a tela de início do jogo
            });

            // Listeners para os botões do jogo
            startGameBtn.addEventListener('click', startGame);
            pauseGameBtn.addEventListener('click', pauseGame);
            resumeGameBtn.addEventListener('click', resumeGame);
            restartGameBtn.addEventListener('click', startGame);

            // Novos Listeners para os botões de navegação adicionados
            returnToMainFromPauseBtn.addEventListener('click', returnToMainMenu);
            returnToGameStartBtn.addEventListener('click', returnToGameStartScreen);
            returnToSiteHomepageFromPauseBtn.addEventListener('click', returnToSiteHomepage);
            returnToSiteHomepageFromEndBtn.addEventListener('click', returnToSiteHomepage);
        });
    </script>
</body>
</html>
