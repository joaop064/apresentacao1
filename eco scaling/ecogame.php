<?php
session_start();
require_once 'conexao.php';

$comprouJogos = false;
$nomeUsuario = '';

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];

    $sql = "SELECT nome, comprou_jogos FROM aluno WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $usuario = $result->fetch_assoc();
        $nomeUsuario = $usuario['nome'];
        $comprouJogos = $usuario['comprou_jogos'] == 1;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Jogos Educativos - Sustentabilidade</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f0f8f5;
      color: #333;
      line-height: 1.6;
    }

    nav {
      display: flex;
      align-items: center;
      justify-content: space-between;
      background: #2e7d32;
      height: 8vh;
      padding: 0 20px;
      position: relative;
    }

    .logo {
      font-size: 25px;
      text-transform: uppercase;
      letter-spacing: 4px;
      font-weight: bold;
      color: white;
    }

    .nav-menu-right {
      display: flex;
      align-items: center;
      gap: 20px;
    }

    .nav-list {
      display: flex;
      list-style: none;
      gap: 25px;
    }

    .nav-list li a {
      color: white;
      text-decoration: none;
      font-weight: 500;
    }

    .nav-right {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .perfil-link {
      display: flex;
      align-items: center;
      color: white;
      text-decoration: none;
      font-weight: 500;
    }

    .perfil-link img {
      width: 40px;
      height: 40px;
      margin-right: 8px;
    }

    .mobile-menu {
      display: none;
      cursor: pointer;
    }

    .mobile-menu div {
      width: 32px;
      height: 2px;
      background: #fff;
      margin: 8px;
      transition: 0.3s;
    }

    @media (max-width: 999px) {
      .nav-list {
        position: absolute;
        top: 8vh;
        right: 0;
        width: 50vw;
        height: 92vh;
        background: #2e7d32;
        flex-direction: column;
        align-items: center;
        justify-content: space-around;
        transform: translateX(100%);
        transition: transform 0.3s ease-in;
        z-index: 999;
      }

      .nav-list.active {
        transform: translateX(0);
      }

      .mobile-menu {
        display: block;
      }

      .mobile-menu.active .line1 {
        transform: rotate(-45deg) translate(-8px, 8px);
      }

      .mobile-menu.active .line2 {
        opacity: 0;
      }

      .mobile-menu.active .line3 {
        transform: rotate(45deg) translate(-5px, -7px);
      }
    }

    header {
      background-color: #4CAF50;
      color: white;
      padding: 30px;
      text-align: center;
      border-radius: 10px;
      margin: 20px;
    }

    section {
      background-color: white;
      padding: 20px;
      border-radius: 10px;
      margin: 20px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    section h2 {
      margin-bottom: 10px;
      color: #4CAF50;
    }

    section ul {
      margin-top: 10px;
      padding-left: 20px;
    }

    blockquote {
      margin: 15px 0;
      padding: 10px 20px;
      background-color: #e0f7e9;
      border-left: 5px solid #4CAF50;
      border-radius: 5px;
      font-style: italic;
    }

    .benefits ul {
      list-style-type: "✅ ";
    }

    footer {
      text-align: center;
      margin-top: 30px;
      padding: 10px;
      font-size: 0.9em;
      color: #555;
    }

    .btn-comprar {
      display: inline-block;
      margin: 20px auto;
      padding: 12px 24px;
      background-color: #4CAF50;
      color: white;
      text-decoration: none;
      border-radius: 8px;
      font-weight: bold;
      transition: background-color 0.3s ease;
      text-align: center;
      font-size: 16px;
    }

    .btn-comprar:hover {
      background-color: #388e3c;
    }

    .btn-comprar span.preco {
      margin-left: 12px;
      font-size: 0.9rem;
      font-weight: 500;
      background: rgba(255, 255, 255, 0.2);
      padding: 4px 8px;
      border-radius: 8px;
    }

    @media (max-width: 600px) {
      body {
        padding: 10px;
      }
      header h1 {
        font-size: 1.5em;
      }
    }

    html {
      scroll-behavior: smooth;
    }
  </style>
</head>
<body>

  <nav>
    <a class="logo">EcoScaling</a>
    <div class="nav-menu-right">
      <ul class="nav-list">
        <li><a href="index.php">Início</a></li>
        <li><a href="cards.php">Cards</a></li>
        <li><a href="sobre.php">Sobre</a></li>
       <?php if ($comprouJogos): ?>
       <li><a href="#meus-jogos">Jogos</a></li>
       <?php endif; ?>
      </ul>
      <div class="nav-right">
        <?php if (isset($_SESSION['id'])): ?>
          <a href="usuario.php" class="perfil-link">
            <img src="logo.png" alt="Logo" class="logo1">
            <span>Perfil</span>
          </a>
        <?php else: ?>
          <a href="login.php" class="btn-comprar">Login/Cadastro</a>
        <?php endif; ?>
      </div>
    </div>
    <div class="mobile-menu">
      <div class="line1"></div>
      <div class="line2"></div>
      <div class="line3"></div>
    </div>
  </nav>

  <header>
    <h1>Jogos Educativos sobre Sustentabilidade</h1>
    <p>Diversão e aprendizado para crianças do Ensino Fundamental!</p>
  </header>

  

  <section class="game">
    <h2>🖼️ Jogo das Imagens Iguais</h2>
    <p>As crianças devem encontrar pares de imagens relacionadas à sustentabilidade, como:</p>
    <ul>
      <li>Duas imagens de árvores.</li>
      <li>Duas imagens de reciclagem.</li>
    </ul>
    <blockquote>"Você sabia que uma árvore adulta pode absorver até 150 kg de CO₂ por ano?"</blockquote>
  </section>
  <section class="benefits">
  <h2>🧠 Por que o Jogo das Imagens Iguais é importante?</h2>
  <ul>
    <li>Desenvolve a memória visual e a concentração.</li>
    <li>Estimula o reconhecimento de elementos relacionados à sustentabilidade.</li>
    <li>Ajuda no aprendizado de conceitos ecológicos por meio da associação de imagens.</li>
    <li>Promove o raciocínio lógico de maneira lúdica e divertida.</li>
  </ul>
  <blockquote>"Aprender brincando é uma forma poderosa de fixar conhecimentos essenciais para o futuro do planeta."</blockquote>
</section>

  <section class="game" id="ecocoleta">
    <h2>♻️ O que é o jogo Eco-Coleta?</h2>
    <p>No Eco-Coleta, as crianças aprendem sobre a separação do lixo de forma divertida e interativa! O objetivo é arrastar corretamente cada tipo de resíduo para a lixeira correspondente:</p>
    <ul>
      <li>Plástico na lixeira vermelha</li>
      <li>Papel na lixeira azul</li>
      <li>Metal na lixeira amarela</li>
      <li>Vidro na lixeira verde</li>
      <li>Orgânico na lixeira marrom</li>
    </ul>
    <p>A cada acerto, o jogador ganha pontos e aprende mais sobre os materiais recicláveis!</p>
  </section>
   <section class="benefits">
    <h2>🌱 Por que o Eco-Coleta é importante?</h2>
    <ul>
      <li>Ensina a importância da coleta seletiva.</li>
      <li>Promove hábitos sustentáveis desde a infância.</li>
      <li>Trabalha coordenação motora e raciocínio rápido.</li>
    </ul>
    <blockquote>"Separar o lixo corretamente é um pequeno gesto que faz uma grande diferença no planeta!"</blockquote>
  </section>

  <section class="info" id="sobre">
    <h2>ℹ️ Sobre o projeto</h2>
    <p>O Eco-Coleta é um jogo educativo pensado para alunos do Ensino Fundamental. Com ele, as crianças aprendem de forma lúdica a importância de cuidar do planeta e como realizar a separação correta dos resíduos.</p>
  </section>

  <section class="benefits">
    <h2>🎯 Por que esses jogos são importantes?</h2>
    <ul>
      <li>Estimula o raciocínio lógico e a memória.</li>
      <li>Ensina sustentabilidade de forma lúdica.</li>
      <li>Desperta interesse pela preservação ambiental.</li>
    </ul>
  </section>

  <section class="info" id="sobre">
    <h2>ℹ️ Mais informações</h2>
    <p>Os jogos são ideais para o Ensino Fundamental, promovendo respeito à natureza e cidadania.</p>
  </section>

  <?php if (!$comprouJogos): ?>
  <div style="text-align:center;">
    <a href="formulario-compra.php" class="btn-comprar">
      Comprar acesso <span class="preco">R$ 20,00</span>
    </a>
  </div>
  <?php endif; ?>

  <?php if ($comprouJogos): ?>
  <section class="games-links" id="meus-jogos" style="text-align:center;">
    <h2>🎮 Acesse seus jogos!</h2>
    <a href="ecocoleta.php" class="btn-comprar">Eco-coleta</a>
    <a href="memoria.php" class="btn-comprar">Jogo da Memória</a>
  </section>
  <?php endif; ?>

  <footer id="contato">
    <p>Desenvolvido com ❤️ para a educação ambiental.</p>
  </footer>

  <script>
    const mobileMenu = document.querySelector('.mobile-menu');
    const navList = document.querySelector('.nav-list');

    mobileMenu.addEventListener('click', () => {
      navList.classList.toggle('active');
      mobileMenu.classList.toggle('active');
    });
  </script>
</body>
</html>
