<?php

require_once 'conexao.php';
require_once 'form-compra.php';

// ✅ Verificar se o usuário está logado
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$mensagem = "";

// ✅ Chamar a função de salvar compra apenas se for POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idUsuario = $_SESSION['id'];
    $mensagem = salvarPagamento($conexao, $idUsuario);  // Passa o ID do usuário
    header("Location: ecogame.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <title>Formulário de Compra</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />
  <style>
    /* ... (seu CSS continua igual) ... */
  </style>
</head>
<body>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f0f4f0;
      margin: 0;
      padding: 0;
      color: #333;
    }

    .form-container {
      max-width: 600px;
      background-color: #ffffff;
      margin: 60px auto;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    }

    .form-container h2 {
      color: #2e7d32;
      text-align: center;
      margin-bottom: 30px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    label {
      font-weight: 500;
      color: #2e7d32;
      display: block;
      margin-bottom: 8px;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"],
    input[type="number"],
    select,
    textarea {
      width: 100%;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 16px;
      font-family: 'Poppins', sans-serif;
      background-color: #f9f9f9;
      transition: border 0.3s ease;
    }

    input:focus,
    select:focus,
    textarea:focus {
      border-color: #2e7d32;
      outline: none;
    }

    .payment-options label {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 10px 15px;
      border: 1px solid #ccc;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      margin-bottom: 10px;
      font-size: 16px;
      color: #333;
      user-select: none;
    }

    .payment-options label:hover {
      background-color: #f0f0f0;
    }

    .payment-options input[type="radio"] {
      accent-color: #2e7d32;
      cursor: pointer;
      flex-shrink: 0;
    }

    .payment-options img {
      width: 30px;
      height: auto;
      flex-shrink: 0;
    }

    button {
      width: 100%;
      padding: 14px;
      background-color: #2e7d32;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 18px;
      font-weight: bold;
      cursor: pointer;
      transition: background-color 0.3s ease, transform 0.2s ease;
      margin-top: 20px;
    }

    button:hover {
      background-color: #1b5e20;
      transform: scale(1.03);
    }

    @media (max-width: 768px) {
      .form-container {
        margin: 20px;
        padding: 20px;
      }
    }
    .seta-voltar-topo {
    position: fixed;
    top: 15px;
    left: 15px;
    background-color: hsl(149, 50%, 49%);
    color: white;
    padding: 8px 14px;
    border-radius: 8px;
    font-weight: bold;
    font-family: 'Poppins', sans-serif;
    font-size: 16px;
    text-decoration: none;
    box-shadow: 0 2px 6px rgba(38, 214, 102, 0.3);
    z-index: 1000;
    transition: background-color 0.3s ease;
}

  </style>
  <a href="ecogame.php" class="seta-voltar-topo" aria-label="Voltar para a página principal">← Voltar</a>

  <div class="form-container">
    <h2>Formulário de Compra</h2>

    <?php if (!empty($mensagem)): ?>
      <p style="color: green;"><?= htmlspecialchars($mensagem) ?></p>
    <?php endif; ?>

    <form method="POST">
      <!-- 🔰 Informações da Escola -->
      <div class="form-group">
        <label for="nome_instituicao">Nome da instituição:</label>
        <input type="text" id="nome_instituicao" name="nome_instituicao" required />
      </div>

      <div class="form-group">
        <label for="cnpj">CNPJ:</label>
        <input type="text" id="cnpj" name="cnpj" placeholder="00.000.000/0000-00" required />
      </div>

      <div class="form-group">
        <label for="endereco">Endereço:</label>
        <input type="text" id="endereco" name="endereco" required />
      </div>

      <div class="form-group">
        <label for="responsavel">Nome do responsável:</label>
        <input type="text" id="responsavel" name="responsavel" required />
      </div>

      <!-- 💳 Forma de Pagamento -->
      <div class="form-group">
        <label>Forma de pagamento:</label>
        <div class="payment-options">
          <label>
            <input type="radio" name="pagamento" value="pix" required />
            <img src="pix.png" alt="PIX" />
            PIX
          </label>

          <label>
            <input type="radio" name="pagamento" value="boleto" />
            <img src="https://cdn-icons-png.flaticon.com/512/2089/2089678.png" alt="Boleto" />
            Boleto Bancário
          </label>

          <label>
            <input type="radio" name="pagamento" value="visa" />
            <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg" alt="Visa" />
            Cartão Visa
          </label>

          <label>
            <input type="radio" name="pagamento" value="mastercard" />
            <img src="https://upload.wikimedia.org/wikipedia/commons/0/04/Mastercard-logo.png" alt="Mastercard" />
            Cartão Mastercard
          </label>
        </div>
      </div>

      <button type="submit">Enviar</button>
    </form>
  </div>
</body>
</html>