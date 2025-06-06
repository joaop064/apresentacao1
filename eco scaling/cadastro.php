<?php
include('codC.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <title>Cadastro</title>
  <link rel="stylesheet" href="style.css">
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family:'Poppins', sans-serif;;
    }

    body {
      
      background: #e9f2e7;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background-image: url('https://img.freepik.com/vetores-gratis/ilustracao-do-dia-do-meio-ambiente-no-mundo-plano_23-2148928197.jpg?t=st=1745606927~exp=1745610527~hmac=87544bca5b9e32c5d47d33b711c30ef81dfac9a1acae5f14b50335bdfd95a1eb&w=740'); /* Caminho da imagem */
      
      background-repeat: no-repeat; /* não repete a imagem */
      background-position: center; /* centraliza a imagem */
    }

    .container {
      font-family:'Poppins', sans-serif;;
      background-color: transparent;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 400px;
    }

    .container h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #333;
    }

    label {
      display: block;
      margin: 15px 0 5px;
      color: #000000;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    button {
      
      width: 100%;
      padding: 12px;
      background-color: #3c803e;
      color: white;
      border: none;
      border-radius: 10px;
      margin-top: 20px;
      font-size: 16px;
      cursor: pointer;
    }

    button:hover {
      background-color: #45a049;
    }

    .login-link {
      text-align: center;
      margin-top: 15px;
      font-size: 14px;
    }

    .login-link a {
      color: #4CAF50;
      text-decoration: none;
    }

    .login-link a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Cadastro</h2>
    <form method="POST" action="cadastro.php">
      <label for="nome">Nome completo</label>
      <input type="text" id="nome" name="nome" required>

      <label for="email">E-mail</label>
      <input type="email" id="email" name="email" required>

      <label for="senha">Senha</label>
      <input type="password" id="senha" name="senha" required>

      <label for="escola_id">Escola</label>
     <select id="escola_id" name="escola_id" required>
    <option value="">Selecione a escola</option>
    <option value="1">Escola EEEP Walter Ramos de Araújo</option>
    <option value="2">Escola EEMTI Adelino Cunha Alcântra</option>
    <option value="3">Escola EEM Waldemar Alcântra</option>
    </select>


      <button type="submit">Cadastrar</button>
      <a href="cards.php"> </a>
    </form>

    
  </div>
</body>
</html>