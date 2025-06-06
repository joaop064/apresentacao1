<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Página Inicial Sustentabilidade</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="stylecards.css">
</head>
<body>

  
  <header>
    
   <nav>
  <a class="logo">EcoScaling</a>
  <div class="nav-menu-right">
    <ul class="nav-list">
      <li><a href="inicio.php">Início</a></li>
      <li><a href="ecogame.php">Ecogame</a></li>
      <li><a href="sobre.php">Sobre</a></li>
      <li><a href="#contato">Contato</a></li>
    </ul>
    <div class="nav-right">
      <?php session_start(); ?>
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



    
  </header>

  <!-- Cards -->
  <section class="cards-section" id="cards">
    <h2>Cards</h2>
    <div class="cards-container">
      <!-- 10 cards exatamente como você forneceu -->
      <a href="card1.html" id="link1">
        <div class="card">
          <img src="img1.png" alt="">
          <h3>Sustentabilidade</h3>
          <p>Sustentabilidade é cuidar do hoje pensando no amanhã.</p>
        </div>
      </a>
      <a href="card2.html">
        <div class="card">
          <img src="img2.png" alt="">
          <h3>Impactos da falta de Sustentabilidade</h3>
          <p>Ignorar o meio ambiente traz problemas no futuro.</p>
        </div>
      </a>
      <a href="card3.html">
        <div class="card">
          <img src="img3.png" alt="">
          <h3>Consumo Consciente</h3>
          <p>O consumo consciente é escolher com responsabilidade e respeito ao meio ambiente.</p>
        </div>
      </a>
      <a href="card4.html">
        <div class="card">
          <img src="img4.png" alt="">
          <h3>Reciclagem e Reuso</h3>
          <p>Reciclar e reutilizar ajudam a reduzir o impacto no planeta.</p>
        </div>
      </a>
      <a href="card5.html">
        <div class="card">
          <img src="img5.png" alt="">
          <h3>Alimentação Sustentável</h3>
          <p>Alimentação sustentável é cuidar do planeta e de você a cada refeição.</p>
        </div>
      </a>
      <a href="card6.html">
        <div class="card">
          <img src="img6.png" alt="">
          <h3>Energia Renovável</h3>
          <p>Energia renovável é a força do futuro, gerada de forma limpa e sustentável.</p>
        </div>
      </a>
      <a href="card7.html">
        <div class="card">
          <img src="img7.png" alt="">
          <h3>Construção Sustentável</h3>
          <p>Construção sustentável é criar espaços que respeitam o meio ambiente e garantem o futuro.</p>
        </div>
      </a>
      <a href="card8.html">
        <div class="card">
          <img src="img8.png" alt="">
          <h3>Educação Ambiental</h3>
          <p>Educação ambiental é plantar consciência para colher um futuro melhor.</p>
        </div>
      </a>
      <a href="card9.html">
        <div class="card">
          <img src="https://img.freepik.com/vetores-gratis/fundo-de-guia-e-excursao-com-ilustracao-vetorial-plana-de-simbolos-turisticos_1284-82172.jpg?t=st=1745853747~exp=1745857347~hmac=a1d9f09a6da3980aba46e0913cff0d0e8d3a41e881950e6a377691d497d5bf6f&w=826" alt="">
          <h3>Turismo sustentável</h3>
          <p>Viaje com propósito, preserve o que torna cada destino único.</p>
        </div>
      </a>
      <a href="card10.html">
        <div class="card">
          <img src="https://img.freepik.com/vetores-gratis/mulher-pequena-tirando-agua-da-torneira-com-paisagem-montanhosa_74855-11024.jpg?t=st=1745853952~exp=1745857552~hmac=178d47346a0ffbf81673e2f69eba7353431232d92c6a2b4f97b315d8059f6a0d&w=826" alt="">
          <h3>Água: uso consciente</h3>
          <p>Cuidar da água hoje é garantir um amanhã possível.</p>
        </div>
      </a>
    
    <a href="card11.html">
      <div class="card">
        <img src="https://img.freepik.com/vetores-gratis/jardinagem-feminina_1284-62186.jpg?semt=ais_items_boosted&w=740" alt="Natureza Sustentável">
        <h3>Biodiversidade e preservação</h3>
        <p>Preservar a biodiversidade é garantir o equilíbrio da vida no planeta e o futuro das próximas gerações.</p>
      </div>
    </a>
    <a href="card12.html">
      <div class="card">
        <img src="https://img.freepik.com/vetores-gratis/conjunto-de-cartoes-de-familia-em-casa_1284-64641.jpg?semt=ais_items_boosted&w=740" alt="Natureza Sustentável">
        <h3>Sustentabilidade em casa</h3>
        <p>Sustentabilidade em casa começa com atitudes simples que protegem o planeta.</p>
      </div>
    </a>
  </section>

  <!-- Rodapé -->
  <footer id="contato">
    <div class="footer-container">
      <div class="footer-section">
        <h3>Contato</h3>
        <p>Email: EcoScaling@gmail.com</p>
        <p>Telefone:(00)0000-0000</p>
      </div>
      <div class="footer-section">
        <h3>Siga-nos</h3>
        <a href="#">Instagram</a><br>
        <a href="#">Facebook</a><br>
        <a href="#">LinkedIn</a>
      </div>
      <div class="footer-section" id="sobre">
        <h3>Sobre</h3>
        <p>Nosso site oferece soluções sustentáveis.</p>
      </div>
    </div>
    <div class="footer-bottom">
      <p>&copy; 2025 - Todos os direitos reservados</p>
    </div>
  </footer>

  <script src="mobile-navbar.js"></script>
  
</body>
</html>