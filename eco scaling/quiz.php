
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
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quiz EcoScaling - Revisão Detalhada</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary-color: #4CAF50; /* Green for eco-theme */
      --primary-light: #66BB6A;
      --primary-dark: #388E3C;
      
      /* Light Theme Palette */
      --background-color: #f4f7f9; 
      --surface-color: #ffffff;   
      --text-color: #212121;     
      --text-color-muted: #5f6368;
      --border-color: #d1d9de;   
      --shadow-color: rgba(0,0,0,0.1);
      --danger-color: #dc3545; /* Red for incorrect answers */
      --light-green-accent: #e8f5e9; /* For correct answer highlights or celebration bg */
      --warning-bg-color: #fff3cd; /* Light yellow for encouragement messages */
      --warning-text-color: #856404;


      --transition-speed: 0.4s;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, var(--background-color) 0%, #e9edf0 100%);
      color: var(--text-color);
      margin: 0;
      padding: 20px;
      display: flex;
      flex-direction: column;
      align-items: center;
      /* justify-content: center; /* Can be removed if content grows too tall */
      min-height: 100vh;
      box-sizing: border-box;
      overflow-x: hidden; 
    }

    .quiz-app-container {
      width: 100%;
      max-width: 700px; /* Adjusted for potentially longer result screen */
      margin: 20px auto;
    }

    .navigation-area {
      width: 100%;
      margin-bottom: 20px; 
      text-align: left; 
    }

    .btn-voltar {
      display: inline-flex; 
      align-items: center;
      padding: 8px 15px;
      background-color: var(--surface-color); 
      color: var(--text-color-muted);
      border: 1px solid var(--border-color);
      border-radius: 8px;
      font-size: 0.9rem;
      font-weight: 500;
      text-decoration: none;
      transition: background-color var(--transition-speed) ease, color var(--transition-speed) ease, box-shadow 0.2s ease, border-color 0.2s ease;
    }

    .btn-voltar:hover {
      background-color: #f0f0f0; 
      color: var(--primary-dark);
      border-color: #c0c8cd;
      box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    .btn-voltar svg {
      margin-right: 6px; 
      fill: currentColor; 
      width: 18px;
      height: 18px;
    }

    .quiz-header {
      text-align: center;
      margin-bottom: 30px;
    }

    .quiz-header h1 {
      font-size: 2.5rem;
      font-weight: 700;
      color: var(--primary-dark); 
      margin-bottom: 10px;
    }

    .progress-container {
      width: 100%;
      background-color: var(--border-color); 
      border-radius: 5px;
      height: 10px;
      margin-top: 15px;
      overflow: hidden;
    }

    .progress-bar {
      width: 0%;
      height: 100%;
      background-color: var(--primary-color);
      border-radius: 5px;
      transition: width var(--transition-speed) ease-in-out;
    }

    .quiz-container {
      background: var(--surface-color);
      padding: 30px 40px;
      border-radius: 15px;
      box-shadow: 0 10px 30px var(--shadow-color);
      text-align: center;
      opacity: 0;
      transform: translateY(20px);
      animation: fadeIn var(--transition-speed) forwards;
      margin-bottom: 20px; 
    }

    @keyframes fadeIn {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .question-area { /* Mantido para a área de perguntas */
      opacity: 1;
      transition: opacity var(--transition-speed) ease-out, transform var(--transition-speed) ease-out;
    }
    .question-area.fade-out {
      opacity: 0;
      transform: translateX(-20px);
    }
     .question-area.fade-in { /* Não mais usado diretamente se resultadoDiv controla tudo */
      opacity: 1;
      transform: translateX(0px);
    }

    .pergunta {
      font-size: 1.5rem;
      margin-bottom: 30px;
      color: var(--text-color);
      font-weight: 600;
      line-height: 1.6;
      min-height: 50px; /* Para evitar saltos de layout */
    }

    .opcoes-container {
      display: flex;
      flex-direction: column;
      gap: 15px;
      min-height: 200px; /* Para evitar saltos de layout */
    }

    .opcao {
      display: block;
      width: 100%;
      padding: 15px 20px;
      border: 2px solid var(--border-color);
      border-radius: 10px;
      background-color: var(--surface-color); 
      color: var(--text-color-muted);
      cursor: pointer;
      transition: background-color var(--transition-speed) ease,
                  transform var(--transition-speed) ease,
                  border-color var(--transition-speed) ease,
                  color var(--transition-speed) ease,
                  box-shadow 0.2s ease;
      font-size: 1rem;
      font-weight: 400;
      text-align: left;
    }

    .opcao:hover {
      background-color: #f0f0f0; 
      border-color: var(--primary-light);
      color: var(--primary-dark); 
      transform: scale(1.02);
      box-shadow: 0 5px 15px rgba(0,0,0,0.07);
    }

    .opcao:active {
      transform: scale(0.98);
      background-color: #e9e9e9; 
    }

    /* Estilos para a área de resultado detalhado */
    .resultado-final { /* Container principal dos resultados */
      margin-top: 20px;
      text-align: left; /* Alinha o conteúdo do resultado à esquerda */
      opacity: 0; 
      transform: translateY(20px);
       /* min-height não é mais necessário aqui, o conteúdo definirá a altura */
    }
    .resultado-final.show {
        opacity: 1;
        transform: translateY(0);
        transition: opacity 0.5s ease-out var(--transition-speed), transform 0.5s ease-out var(--transition-speed);
    }

    .score-summary {
        font-size: 1.8rem;
        color: var(--primary-dark);
        margin-bottom: 10px;
        text-align: center;
    }
    .quiz-feedback {
        font-size: 1.1rem;
        margin-bottom: 25px;
        padding: 12px;
        border-radius: var(--default-border-radius);
        text-align: center;
    }
    .quiz-feedback.celebration {
        background-color: var(--light-green-accent);
        color: var(--primary-dark);
    }
    .quiz-feedback.encouragement {
        background-color: var(--warning-bg-color);
        color: var(--warning-text-color);
    }

    .resultados-detalhados-titulo {
        font-size: 1.5rem;
        color: var(--text-color);
        margin-top: 30px;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid var(--border-color);
    }
    .question-review-item {
        background-color: var(--surface-color);
        border: 1px solid var(--border-color);
        border-radius: var(--default-border-radius);
        padding: 15px 20px;
        margin-bottom: 20px;
        box-shadow: var(--shadow-soft);
    }
    .question-review-item.review-correct {
        border-left: 5px solid var(--primary-color);
    }
    .question-review-item.review-incorrect {
        border-left: 5px solid var(--danger-color);
    }
    .review-question-text {
        font-weight: 600;
        color: var(--text-color);
        margin-bottom: 10px;
        font-size: 1.1em;
    }
    .review-user-answer, .review-correct-answer {
        margin-bottom: 8px;
        font-size: 1em;
    }
    .answer-correct {
        color: var(--primary-dark);
        font-weight: bold;
    }
    .answer-incorrect {
        color: var(--danger-color);
        font-weight: bold;
        text-decoration: line-through;
    }
    .answer-correct-highlight {
        color: var(--primary-dark);
        font-weight: bold;
        background-color: var(--light-green-accent);
        padding: 2px 5px;
        border-radius: 3px;
    }
    .review-explanation {
        margin-top: 12px;
        font-size: 0.95em;
        color: var(--text-color-muted);
        background-color: #f8f9fa; 
        padding: 12px;
        border-radius: var(--default-border-radius);
        border-top: 2px dashed var(--border-color);
    }
    .review-explanation strong {
        color: var(--text-color);
    }

    .btn-recomecar {
      display: block; 
      margin: 30px auto 10px; /* Ajustada margem */
      padding: 12px 25px;
      background-color: var(--primary-color);
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      transition: background-color var(--transition-speed) ease, transform 0.2s ease;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      opacity: 0; 
      transform: translateY(10px); 
      pointer-events: none; 
    }

    .btn-recomecar.show {
        opacity: 1;
        transform: translateY(0);
        pointer-events: auto; 
        transition: opacity 0.3s ease var(--transition-speed), transform 0.3s ease var(--transition-speed); 
    }


    /* Responsive adjustments */
    @media (max-width: 768px) {
      .btn-voltar { font-size: 0.85rem; padding: 7px 12px; }
      .btn-voltar svg { width: 16px; height: 16px; }
      .quiz-header h1 { font-size: 2rem; }
      .pergunta { font-size: 1.3rem; }
      .opcao { padding: 12px 15px; font-size: 0.95rem; }
      .quiz-container { padding: 25px 20px; }
      .score-summary { font-size: 1.6rem; }
      .resultados-detalhados-titulo { font-size: 1.3rem; }
      .btn-recomecar { font-size: 0.95rem; padding: 10px 20px;}
    }

    @media (max-width: 480px) {
      .btn-voltar { font-size: 0.8rem; padding: 6px 10px; }
      .btn-voltar svg { width: 14px; height: 14px; margin-right: 4px; }
      .navigation-area { margin-bottom: 15px; }
      body { padding: 10px; }
      .quiz-header h1 { font-size: 1.8rem; }
      .pergunta { font-size: 1.1rem; margin-bottom: 20px; }
      .opcoes-container { gap: 10px; }
      .opcao { padding: 10px; font-size: 0.9rem; }
      .quiz-container { padding: 20px 15px; }
      .score-summary { font-size: 1.4rem;}
      .resultados-detalhados-titulo { font-size: 1.2rem; }
      .btn-recomecar { font-size: 0.9rem; padding: 10px 18px;}
    }

  </style>
</head>
<body>
  <div class="quiz-app-container">

    <div class="navigation-area">
      <a href="ecogame.php" class="btn-voltar">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
          <path d="M10.8284 12.0007L15.7782 16.9504L14.364 18.3646L8 12.0007L14.364 5.63672L15.7782 7.05093L10.8284 12.0007Z"></path>
        </svg>
        Voltar
      </a>
    </div>

    <header class="quiz-header">
      <h1>Quiz EcoScaling</h1>
      <div class="progress-container">
        <div class="progress-bar" id="progressBar"></div>
      </div>
    </header>

    <main>
      <div class="quiz-container">
        <div id="question-area" class="question-area">
          <div id="pergunta" class="pergunta"></div>
          <div id="opcoes" class="opcoes-container"></div>
        </div>
        <div id="resultado" class="resultado-final"></div> </div>
      <button id="reiniciarBtn" class="btn-recomecar">Recomeçar Quiz</button>
    </main>
  </div>

  <script>
    const perguntas = [
      {
        texto: "Por que é importante pensar no futuro ao consumir recursos naturais?",
        opcoes: [
          "Porque os recursos são infinitos e sempre existirão",
          "Para garantir que as próximas gerações também tenham acesso a eles",
          "Porque isso ajuda a gastar mais energia"
        ],
        resposta: "Para garantir que as próximas gerações também tenham acesso a eles",
        explicacao: "Os recursos naturais, mesmo os renováveis, podem se esgotar ou degradar se consumidos de forma insustentável. Pensar no futuro (sustentabilidade) é garantir que nossos filhos e netos também possam usufruir desses recursos. As outras opções são incorretas porque os recursos não são infinitos e consumir de forma consciente geralmente leva a economizar energia."
      },
      {
        texto: "Qual das ações abaixo mais contribui para o consumo consciente?",
        opcoes: [
          "Comprar produtos descartáveis por serem baratos",
          "Reutilizar materiais e evitar desperdício",
          "Consumir produtos de grandes marcas apenas"
        ],
        resposta: "Reutilizar materiais e evitar desperdício",
        explicacao: "Consumo consciente envolve reduzir o impacto de nossas escolhas. Reutilizar e evitar desperdício diminuem a necessidade de nova produção, economizando recursos e energia. Comprar produtos descartáveis aumenta o lixo, e focar apenas em grandes marcas não garante sustentabilidade."
      },
      {
        texto: "Sobre energias renováveis, assinale a alternativa correta:",
        opcoes: [
          "Elas são finitas e causam poluição intensa",
          "Vêm de fontes naturais que se renovam constantemente",
          "São obtidas apenas por meio do petróleo"
        ],
        resposta: "Vêm de fontes naturais que se renovam constantemente",
        explicacao: "Energias renováveis (solar, eólica, hidrelétrica, etc.) são chamadas assim porque suas fontes são naturalmente reabastecidas. Elas são chave para reduzir a poluição e o impacto das mudanças climáticas, ao contrário dos combustíveis fósseis como o petróleo, que são finitos e mais poluentes."
      },
      {
        texto: "A reciclagem é importante porque:",
        opcoes: [
          "Diminui a necessidade de extrair novos recursos",
          "Aumenta a produção de lixo nas cidades",
          "É uma forma de gastar mais energia elétrica"
        ],
        resposta: "Diminui a necessidade de extrair novos recursos",
        explicacao: "Reciclar transforma materiais usados em novos produtos, reduzindo a extração de matéria-prima da natureza, o consumo de energia na produção e o volume de lixo em aterros. Isso conserva recursos naturais e protege o meio ambiente."
      },
      {
        texto: "O turismo sustentável busca:",
        opcoes: [
          "Reduzir o número de turistas nos lugares famosos",
          "Promover viagens de luxo sem se preocupar com o ambiente",
          "Valorizar o meio ambiente e a cultura local ao viajar"
        ],
        resposta: "Valorizar o meio ambiente e a cultura local ao viajar",
        explicacao: "Turismo sustentável visa minimizar os impactos negativos no ambiente e na cultura local, ao mesmo tempo que gera renda e conservação. Não se trata de proibir viagens ou focar apenas no luxo, mas sim em viajar com responsabilidade e respeito."
      },
      {
        texto: "Uma construção sustentável deve:",
        opcoes: [
          "Utilizar materiais recicláveis e priorizar eficiência energética",
          "Ser feita rapidamente com qualquer material",
          "Ignorar o impacto ambiental desde que seja moderna"
        ],
        resposta: "Utilizar materiais recicláveis e priorizar eficiência energética",
        explicacao: "Construções sustentáveis buscam reduzir o impacto ambiental em todo o seu ciclo de vida. Isso inclui o uso de materiais de baixo impacto (reciclados, locais, renováveis), design que maximize a eficiência energética (luz natural, ventilação, isolamento) e o uso consciente da água."
      },
      {
        texto: "Qual a relação entre alimentação e sustentabilidade?",
        opcoes: [
          "Nenhuma, comer não afeta o planeta",
          "Escolher alimentos locais e da estação reduz impactos ambientais",
          "Quanto mais industrializado o alimento, mais sustentável ele é"
        ],
        resposta: "Escolher alimentos locais e da estação reduz impactos ambientais",
        explicacao: "Nossa alimentação tem grande impacto ambiental. Produzir, processar e transportar alimentos consome recursos e gera emissões. Optar por alimentos locais e da estação reduz a pegada de carbono do transporte, apoia a economia local e geralmente significa alimentos mais frescos e menos processados. Alimentos altamente industrializados costumam ter uma pegada ambiental maior."
      },
      {
        texto: "Economizar água é importante porque:",
        opcoes: [
          "A água é um recurso renovável ilimitado",
          "Ajuda a evitar o racionamento e preservar os mananciais",
          "A água potável pode ser facilmente fabricada"
        ],
        resposta: "Ajuda a evitar o racionamento e preservar os mananciais",
        explicacao: "Embora a água seja um recurso renovável, a água potável e acessível é finita e sua disponibilidade é ameaçada pela poluição, desperdício e mudanças climáticas. Economizar água ajuda a garantir o abastecimento para todos, preserva ecossistemas aquáticos e reduz a energia gasta no tratamento e distribuição."
      }
    ];

    let indicePerguntaAtual = 0;
    let acertos = 0;
    const totalPerguntas = perguntas.length;
    let respostasUsuario = new Array(totalPerguntas).fill(null); // Para armazenar as respostas do usuário

    const perguntaDiv = document.getElementById("pergunta");
    const opcoesDiv = document.getElementById("opcoes");
    const resultadoDiv = document.getElementById("resultado");
    const progressBar = document.getElementById("progressBar");
    const questionArea = document.getElementById("question-area"); // Container da pergunta e opções
    const reiniciarBtn = document.getElementById("reiniciarBtn");

    const transitionDelay = 400; 

    function atualizarBarraProgresso() {
      if (!progressBar) return;
      const progressoPercentual = ((indicePerguntaAtual + 1) / totalPerguntas) * 100;
      progressBar.style.width = `${progressoPercentual}%`;
    }
     function atualizarBarraProgressoFinal() {
        if (!progressBar) return;
        progressBar.style.width = `100%`;
    }

    function carregarPergunta() {
      if (!questionArea || !perguntaDiv || !opcoesDiv) return;

      questionArea.classList.remove('fade-in'); // Garante que está pronto para fade-out
      questionArea.classList.add('fade-out');

      setTimeout(() => {
        const p = perguntas[indicePerguntaAtual];
        perguntaDiv.textContent = p.texto;
        opcoesDiv.innerHTML = '';

        const shuffledOpcoes = [...p.opcoes].sort(() => Math.random() - 0.5);

        shuffledOpcoes.forEach(op => {
          const btn = document.createElement("button");
          btn.className = "opcao";
          btn.textContent = op;
          btn.onclick = () => {
            respostasUsuario[indicePerguntaAtual] = op; // Armazena a resposta do usuário
            if (op === p.resposta) acertos++;
            
            indicePerguntaAtual++;
            if (indicePerguntaAtual < totalPerguntas) {
              carregarPergunta();
            } else {
              mostrarResultado();
            }
          };
          opcoesDiv.appendChild(btn);
        });
        
        if (indicePerguntaAtual < totalPerguntas) { 
            atualizarBarraProgresso();
        }
        questionArea.style.display = 'block'; // Garante que está visível antes de animar entrada
        questionArea.classList.remove('fade-out');
        questionArea.classList.add('fade-in');
        // A classe fade-in será removida pelo CSS após a animação ou pode ser removida via JS se necessário
        // Não vamos remover via JS aqui para simplificar e deixar a animação CSS controlar.

      }, transitionDelay);
    }

    function mostrarResultado() {
      if(!questionArea || !resultadoDiv || !reiniciarBtn) return;

      atualizarBarraProgressoFinal(); 
      questionArea.classList.add('fade-out');

      setTimeout(() => {
        questionArea.style.display = 'none'; 
        resultadoDiv.innerHTML = ''; // Limpa conteúdo anterior

        let detalheResultadoHTML = `<h3 class="score-summary">Você acertou ${acertos} de ${totalPerguntas} perguntas!</h3>`;
        
        // Mensagens de feedback baseadas na pontuação
        if (acertos / totalPerguntas >= 0.7) {
            detalheResultadoHTML += `<p class="quiz-feedback celebration">🎉 Excelente! Você está no caminho certo para a sustentabilidade!</p>`;
        } else if (acertos / totalPerguntas >= 0.4) {
            detalheResultadoHTML += `<p class="quiz-feedback encouragement">👍 Bom trabalho! Continue aprendendo e fazendo a diferença!</p>`;
        } else {
            detalheResultadoHTML += `<p class="quiz-feedback encouragement">🌱 Todo conhecimento é valioso. Continue explorando a sustentabilidade!</p>`;
        }

        detalheResultadoHTML += `<div class="resultados-detalhados-titulo">Revisão das Perguntas:</div>`;

        perguntas.forEach((pergunta, index) => {
            const userAnswer = respostasUsuario[index];
            const isCorrect = userAnswer === pergunta.resposta;
            detalheResultadoHTML += `
            <div class="question-review-item ${isCorrect ? 'review-correct' : 'review-incorrect'}">
                <p class="review-question-text"><strong>Questão ${index + 1}:</strong> ${pergunta.texto}</p>
                <p class="review-user-answer">Sua resposta: <span class="${isCorrect ? 'answer-correct' : 'answer-incorrect'}">${userAnswer || "Não respondida"}</span> ${isCorrect ? '✔️' : '❌'}</p>
                ${!isCorrect ? `<p class="review-correct-answer">Resposta correta: <span class="answer-correct-highlight">${pergunta.resposta}</span></p>` : ''}
                <p class="review-explanation"><strong>Explicação:</strong> ${pergunta.explicacao}</p>
            </div>
            `;
        });

        resultadoDiv.innerHTML = detalheResultadoHTML;
        resultadoDiv.classList.add('show'); 
        reiniciarBtn.classList.add('show'); 
      }, transitionDelay);
    }

    function reiniciarQuiz() {
        if(!questionArea || !resultadoDiv || !reiniciarBtn || !progressBar || !perguntaDiv || !opcoesDiv) return;

        indicePerguntaAtual = 0;
        acertos = 0;
        respostasUsuario = new Array(totalPerguntas).fill(null); // Limpa respostas anteriores

        resultadoDiv.classList.remove('show');
        // Delay para a animação de saída do resultado antes de limpar o conteúdo
        setTimeout(() => {
            resultadoDiv.innerHTML = ''; 
        }, transitionDelay + 100); // Um pouco mais que a transitionDelay para garantir


        reiniciarBtn.classList.remove('show');

        questionArea.style.display = 'block'; // Garante que a area de questão está visível
        questionArea.classList.remove('fade-out', 'fade-in'); // Limpa classes de animação
        
        progressBar.style.width = '0%'; 
        
        // Pequeno delay para garantir que a UI de resultado sumiu antes de carregar a primeira pergunta
        setTimeout(() => {
             opcoesDiv.innerHTML = ''; // Limpa opções antigas
             perguntaDiv.textContent = ''; // Limpa texto da pergunta antiga
             carregarPergunta();
        }, 100); 
    }

    if (reiniciarBtn) {
        reiniciarBtn.addEventListener('click', reiniciarQuiz);
    }

    // Iniciar o quiz
    if (perguntaDiv && opcoesDiv) { // Garante que os elementos existem antes de iniciar
        carregarPergunta();
    }
  </script>
</body>
</html>