



<?php
require_once 'conexao.php';
session_start();

function salvarPagamento($conexao, $idUsuario) {
    $erros = [];

    if (!isset($_POST['nome_instituicao'], $_POST['cnpj'], $_POST['endereco'], $_POST['responsavel'], $_POST['pagamento'])) {
        $erros[] = "Todos os campos obrigatórios devem ser preenchidos.";
        return $erros;
    }

    $nomeInstituicao = trim($_POST['nome_instituicao']);
    $cnpj = preg_replace('/[^0-9]/', '', trim($_POST['cnpj']));
    $endereco = trim($_POST['endereco']);
    $responsavel = trim($_POST['responsavel']);
    $pagamento = $_POST['pagamento'];

    if (preg_match('/^\d+$/', $nomeInstituicao)) {
        $erros[] = "O nome da instituição não pode conter apenas números.";
    }

    if (preg_match('/\d/', $responsavel)) {
        $erros[] = "O nome do responsável não pode conter números.";
    }

    if (!preg_match('/^[0-9]{14}$/', $cnpj)) {
        $erros[] = "CNPJ inválido. Ele deve conter exatamente 14 números (somente números).";
    }

    if (strlen($endereco) < 5) {
        $erros[] = "O endereço informado é muito curto ou inválido.";
    }

    if (!empty($erros)) {
        return $erros;
    }

    // Inserir no banco
    $stmt = $conexao->prepare("INSERT INTO pagamento (cnpj, nomeinst, endereco, nomeresp, formpag) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $cnpj, $nomeInstituicao, $endereco, $responsavel, $pagamento);

    if ($stmt->execute()) {
        // Atualizar status de compra
        $stmt_upd = $conexao->prepare("UPDATE aluno SET comprou_jogos = 1 WHERE id = ?");
        $stmt_upd->bind_param("i", $idUsuario);
        $stmt_upd->execute();

        return ["Pagamento registrado com sucesso!"];
    } else {
        return ["Erro ao salvar pagamento: " . $stmt->error];
    }
}

$idUsuario = $_SESSION['id'] ?? null;
$mensagem = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $idUsuario) {
    $mensagem = salvarPagamento($conexao, $idUsuario);
}

$linkQrCodePix = 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=chavepix%40ecogame.com';
$codigoBoleto = '34191.79001 01043.510047 91020.150008 2 85770000002000';
?>




<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <title>Formulário de Compra</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />
  <style>
    /* ... [SEU CSS AQUI - MESMO QUE O ORIGINAL, sem alterações] ... */

    .form-group {
      margin-bottom: 20px;
    }

    /* Reforço para campos do cartão */
    #dados-cartao {
      margin-top: 10px;
    }
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
<a href="ecogame.php" class="seta-voltar-topo">← Voltar</a>

<div class="form-container">
  <h2>Formulário de Compra</h2>

 <?php if (!empty($mensagem)): ?>
  <ul style="color: <?= str_contains(implode('', $mensagem), 'sucesso') ? 'green' : 'red' ?>;">
    <?php foreach ($mensagem as $msg): ?>
      <li><?= htmlspecialchars($msg) ?></li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>



  <form method="POST" action="formulario-compra.php">
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

    <div class="form-group">
      <label>Forma de pagamento:</label>
      <div class="payment-options">
        <label>
          <input type="radio" name="pagamento" value="pix" required checked />
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

    <div id="info-pix" class="pagamento-info" style="display:block;">
      <p><strong>QR Code PIX:</strong></p>
     <img src="<?= $linkQrCodePix ?>" alt="QR Code PIX" style="width:200px;" />
      <p>Chave PIX: <strong>pix@ecogame.com</strong></p>
    </div>

    <div id="info-boleto" class="pagamento-info" style="display:none;">
      <p><strong>Boleto Bancário:</strong></p>
      <p style="background:#fff;padding:10px;border-radius:8px;font-family:monospace;">
        <?= $codigoBoleto ?>
      </p>
    </div>

    <div id="info-cartao" class="pagamento-info" style="display:none;">
      <p><strong>Pagamento com cartão:</strong></p>
      <div id="dados-cartao">
        <div class="form-group">
          <label for="numero_cartao">Número do cartão:</label>
          <input type="text" id="numero_cartao" name="numero_cartao" placeholder="0000 0000 0000 0000" />
        </div>
        <div class="form-group">
          <label for="nome_cartao">Nome no cartão:</label>
          <input type="text" id="nome_cartao" name="nome_cartao" />
        </div>
        <div class="form-group">
          <label for="validade_cartao">Validade:</label>
          <input type="text" id="validade_cartao" name="validade_cartao" placeholder="MM/AA" />
        </div>
        <div class="form-group">
          <label for="cvv_cartao">CVV:</label>
          <input type="text" id="cvv_cartao" name="cvv_cartao" placeholder="123" />
        </div>
      </div>
    </div>

    <button type="submit">Enviar</button>
  </form>
</div>

<script>
  const radios = document.querySelectorAll('input[name="pagamento"]');
  const pixInfo = document.getElementById('info-pix');
  const boletoInfo = document.getElementById('info-boleto');
  const cartaoInfo = document.getElementById('info-cartao');

  function esconderTodos() {
    pixInfo.style.display = 'none';
    boletoInfo.style.display = 'none';
    cartaoInfo.style.display = 'none';
  }

  radios.forEach(radio => {
    radio.addEventListener('change', () => {
      esconderTodos();

      if (radio.checked) {
        if (radio.value === 'pix') {
          pixInfo.style.display = 'block';
        } else if (radio.value === 'boleto') {
          boletoInfo.style.display = 'block';
        } else if (radio.value === 'visa' || radio.value === 'mastercard') {
          cartaoInfo.style.display = 'block';
        }
      }
    });
  });

  // Exibir a opção selecionada no carregamento da página (PIX por padrão)
  window.addEventListener('DOMContentLoaded', () => {
    const selecionado = document.querySelector('input[name="pagamento"]:checked');
    if (selecionado) {
      selecionado.dispatchEvent(new Event('change'));
    }
  });
</script>

</body>
</html>
