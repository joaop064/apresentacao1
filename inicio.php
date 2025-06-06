<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <title>EcoScaling - Início</title>
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
    }

    nav {
      background-color: #2e7d32;
      color: white;
      padding: 0;
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
  text-decoration: none;
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

.btn-comprar {
  background-color: #4CAF50;
  color: white;
  padding: 8px 14px;
  text-decoration: none;
  border-radius: 20px;
  transition: background-color 0.3s ease;
}

.btn-comprar:hover {
  background-color: #388e3c;
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

    
   .hero {
  background: url('https://www.teraambiental.com.br/hs-fs/hubfs/pilares-da-sustentabilidade.jpg?width=1280&height=853&name=pilares-da-sustentabilidade.jpg') no-repeat center center/cover;
  height: 90vh;
  color: white;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  text-align: center;
  padding: 0 20px;
}



    .hero h1 {
      font-size: 3em;
      text-shadow:
        2px 2px 6px rgba(0, 0, 0, 0.8),
        0 0 10px rgba(0, 0, 0, 0.6);
    }

    .hero p {
      font-size: 1.2em;
      margin: 10px 0 20px;
      text-shadow:
        1px 1px 4px rgba(0, 0, 0, 0.7),
        0 0 6px rgba(0, 0, 0, 0.5);
    }

    .hero a {
      padding: 12px 24px;
      background-color: rgba(34, 139, 34, 0.95);
      border-radius: 6px;
      text-decoration: none;
      font-weight: bold;
      color: white;
      transition: background-color 0.3s ease;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    }

    .hero a:hover {
      background-color: #1b5e20;
    }

    .features {
      display: flex;
      justify-content: space-around;
      padding: 40px 20px;
      background-color: #ffffff;
      text-align: center;
      flex-wrap: wrap;
    }

    .feature {
      width: 30%;
      min-width: 260px;
      margin-bottom: 20px;
    }

    .card-preview-section {
      padding: 40px 20px;
      text-align: center;
      background-color: #e6f2ec;
    }

    .cards-container {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 20px;
      margin-top: 20px;
    }

    .card {
      background: white;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      width: 250px;
      padding: 20px;
      text-align: center;
      transition: transform 0.3s;
    }

    .card img {
      width: 100%;
      height: auto;
      border-radius: 8px;
    }

    .card:hover {
      transform: translateY(-5px);
    }

    .card h3 {
      margin-top: 10px;
      font-size: 1.2em;
    }

    .card p {
      font-size: 0.95em;
      margin-top: 5px;
    }

    .explore,
    .card-preview-section a[href="cards.php"] {
      display: inline-block;
      margin: 20px auto 0;
      padding: 12px 24px;
      background: #2e7d32;
      color: white;
      text-decoration: none;
      border-radius: 6px;
      font-weight: bold;
      transition: background-color 0.3s ease;
    }

    .card-preview-section a[href="cards.php"]:hover {
      background: #1b5e20;
    }

    footer {
      background-color: #2e7d32;
      color: white;
      padding: 15px 20px;
      text-align: center;
    }

    footer a {
      color: white;
      text-decoration: none;
    }

    /* RESPONSIVO */
    @media (max-width: 768px) {
      nav .nav-container {
        padding: 15px 20px;
      }

      /* Menu mobile: esconde lista e mostra ao clicar no hamburguer */
      .nav-right > ul {
        display: none;
        flex-direction: column;
        gap: 10px;
        background-color: #2e7d32;
        position: absolute;
        top: 60px;
        right: 20px;
        padding: 10px;
        border-radius: 5px;
        z-index: 99;
      }

      .nav-right > ul.show {
        display: flex;
      }

      .mobile-menu {
        display: flex;
      }

      .features {
        flex-direction: column;
        align-items: center;
      }

      .feature {
        width: 90%;
      }
    }
  </style>
</head>
<body>

<!-- MENU -->
<nav>
  <a class="logo" href="inicio.php">EcoScaling</a>
  <div class="nav-menu-right">
    <ul class="nav-list">
      <li><a href="ecogame.php">Ecogame</a></li>
      <li><a href="cards.php">Cards</a></li>
      <li><a href="sobre.php">Sobre</a></li>
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



<section class="hero">
  <h1>Aprenda brincando, transforme o planeta</h1>
  <p>Jogos e conteúdos interativos sobre sustentabilidade para todas as idades.</p>
  <a href="ecogame.php">Começar Agora</a>
</section>

<!-- FEATURES -->
<section class="features">
  <div class="feature">
    <h2>🌿 Educação ecológica</h2>
    <p>Desperte a consciência ambiental desde cedo.</p>
  </div>
  <div class="feature">
    <h2>🎮 Jogos Interativos</h2>
    <p>Aprenda com diversão e desafios ecológicos.</p>
  </div>
  <div class="feature">
    <h2>👨‍🏫 Apoio Escolar</h2>
    <p>Recursos para pais e professores ensinarem sustentabilidade.</p>
  </div>
</section>

<!-- PREVIEW DE CARDS -->
<section class="card-preview-section">
  <h2>Conheça alguns de nossos cards</h2>
  <div class="cards-container">
    <div class="card">
      <img src="img1.png" alt="Sustentabilidade">
      <h3>Sustentabilidade</h3>
      <p>Sustentabilidade é cuidar do hoje pensando no amanhã.</p>
    </div>
    <div class="card">
      <img src="img3.png" alt="Consumo Consciente">
      <h3>Consumo Consciente</h3>
      <p>Escolhas responsáveis que respeitam o meio ambiente.</p>
    </div>
    <div class="card">
      <img src="img4.png" alt="Reciclagem e Reuso">
      <h3>Reciclagem e Reuso</h3>
      <p>Reciclar e reutilizar ajudam a reduzir o impacto no planeta.</p>
    </div>
  </div>
  <br>
  <a href="cards.php">Ver todos os cards</a>
</section>


<footer>
  <p>Contato: <a href="mailto:EcoScaling@gmail.com">EcoScaling@gmail.com</a> | Telefone: (00) 0000-0000</p>
  <p>&copy; 2025 - EcoScaling. Todos os direitos reservados.</p>
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
