<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <title>Sobre a EcoScaling</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
      width: 35px;
      height: 35px;
      margin-right: 6px;
    }

    .btn {
      padding: 6px 12px;
      background-color: #66bb6a;
      color: white;
      border: none;
      border-radius: 4px;
      text-decoration: none;
      font-weight: bold;
    }

    .btn:hover {
      background-color: #57a05a;
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
      padding: 40px 20px;
      text-align: center;
    }

    header h1 {
      font-size: 2.2em;
    }

    main {
      padding: 30px 20px;
      max-width: 1000px;
      margin: auto;
    }

    section {
      margin-bottom: 40px;
    }

    h2 {
      color: #2e7d32;
      margin-bottom: 10px;
    }

    p {
      margin-bottom: 15px;
    }

    ul {
      list-style: disc;
      padding-left: 20px;
    }

    footer {
      background-color: #2e7d32;
      color: white;
      padding: 20px;
      text-align: center;
      margin-top: 40px;
    }

    a {
      color: white;
    }
    html {
      scroll-behavior: smooth;
    }
  </style>
</head>
<body>

<!-- MENU RESPONSIVO -->
<nav>
  <a class="logo">EcoScaling</a>
  <div class="nav-menu-right">
    <ul class="nav-list">
      <li><a href="inicio.php">Início</a></li>
      <li><a href="ecogame.php">Ecogame</a></li>
      <li><a href="cards.php">Cards</a></li>
      <li><a href="#contato">Contato</a></li>
    </ul>
    <div class="nav-right">
      <?php if (isset($_SESSION['id'])): ?>
        <a href="usuario.php" class="perfil-link">
          <img src="logo.png" alt="Logo" class="logo1">
          <span>Perfil</span>
        </a>
      <?php else: ?>
        <a href="login.php" class="btn">Login/Cadastro</a>
      <?php endif; ?>
    </div>
  </div>

  <div class="mobile-menu">
    <div class="line1"></div>
    <div class="line2"></div>
    <div class="line3"></div>
  </div>
</nav>

<!-- CONTEÚDO PRINCIPAL -->
<header>
  <h1>Sobre a EcoScaling</h1>
  <p>Educar, conscientizar e transformar o mundo com sustentabilidade.</p>
</header>

<main>
  <section>
    <h2>🌱 Quem Somos</h2>
    <p>A <strong>EcoScaling</strong> é uma iniciativa voltada para promover a educação ambiental através de jogos, conteúdos e experiências interativas. Acreditamos que a transformação começa na infância e que o conhecimento é a chave para um futuro sustentável.</p>
  </section>

  <section>
    <h2>🎯 Nossa Missão</h2>
    <p>Incentivar práticas sustentáveis desde cedo, por meio de jogos educativos e recursos visuais que despertem a consciência ecológica de forma lúdica e envolvente.</p>
  </section>

  <section>
    <h2>🌍 Nossa Visão</h2>
    <p>Ser referência em educação ambiental digital, inspirando escolas, famílias e comunidades a adotarem atitudes sustentáveis no dia a dia.</p>
  </section>

  <section>
    <h2>💚 Nossos Valores</h2>
    <ul>
      <li>Consumo consciente</li>
      <li>Preservação ambiental</li>
      <li>Educação acessível e de qualidade</li>
      <li>Inovação com responsabilidade</li>
      <li>Inclusão social e respeito à diversidade</li>
    </ul>
  </section>

  <section>
    <h2>📘 O que oferecemos?</h2>
    <ul>
      <li><strong>Cards educativos:</strong> temas como reciclagem, energia renovável, uso consciente da água e biodiversidade.</li>
      <li><strong>Jogos interativos:</strong> como quizzes, desafios e jogos de memória com conteúdo sustentável.</li>
      <li><strong>Materiais para professores e pais:</strong> apoio didático para o ensino da sustentabilidade.</li>
    </ul>
  </section>
</main>

<!-- RODAPÉ -->
<footer id="contato">
  <p>Contato: <a href="mailto:EcoScaling@gmail.com">EcoScaling@gmail.com</a> | Tel: (00) 0000-0000</p>
  <p>Siga-nos nas redes sociais: Instagram | Facebook | LinkedIn</p>
  <p>&copy; 2025 - EcoScaling. Todos os direitos reservados.</p>
</footer>

<!-- JavaScript do menu -->
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
