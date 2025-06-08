<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['retornar']) && $_POST['retornar'] === 'retornar') {
        header("Location: inicio.php");
        exit;
    }
}

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

include('conexao.php');

$id = $_SESSION['id'];
$sql = "SELECT * FROM aluno WHERE id = '$id'";
$result = $conexao->query($sql);

if ($result->num_rows == 1) {
    $usuario = $result->fetch_assoc();

    $comprouJogos = $usuario['comprou_jogos'] == 1;

    $escola_id = $usuario['escola_id'];
    $sql_escola = "SELECT nome FROM escola WHERE id = '$escola_id'";
    $result_escola = $conexao->query($sql_escola);

    if ($result_escola->num_rows == 1) {
        $escola = $result_escola->fetch_assoc();
        $nome_escola = $escola['nome'];
    } else {
        $nome_escola = "Escola não encontrada";
    }

} else {
    echo "Usuário não encontrado.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Página do Usuário</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      padding: 0;
      font-family: 'Poppins', sans-serif;
      background-image: url('https://static.vecteezy.com/ti/vetor-gratis/p1/14703696-modelo-de-negocios-verde-e-plano-de-fundo-para-o-conceito-de-sustentabilidade-com-icones-planos-ambientais-vetor.jpg');
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
      background-attachment: fixed; /* Faz o fundo se manter fixo ao rolar */
    }

    .user-container {
      max-width: 800px;
      margin: 60px auto 30px auto;
      padding: 40px;
      border-radius: 20px;
      background: rgba(255, 255, 255, 0.25);
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
      backdrop-filter: blur(8px);
      -webkit-backdrop-filter: blur(8px);
      border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .user-header {
      text-align: center;
      color: #1b5e20;
      font-size: 2em;
      font-weight: 600;
      margin-bottom: 30px;
    }

    .user-info {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    .info-row {
      display: flex;
      align-items: center;
    }

    .info-label {
      font-weight: 600;
      color: #2e7d32;
      width: 120px;
      flex-shrink: 0;
    }

    .info-content {
      background: rgba(240, 255, 240, 0.6);
      border: 1px solid #c8e6c9;
      padding: 10px 15px;
      border-radius: 10px;
      color: #2e2e2e;
      flex-grow: 1;
    }

    .button-group {
      text-align: right;
      margin-top: 30px;
    }

    .edit-button {
      display: inline-block;
      background-color: #4caf50;
      color: #fff;
      padding: 10px 20px;
      text-align: center;
      border: none;
      border-radius: 10px;
      text-decoration: none;
      font-size: 16px;
      margin-left: 10px;
      transition: background-color 0.3s, transform 0.2s;
    }

    .edit-button:hover {
      background-color: #388e3c;
      transform: scale(1.05);
    }
  </style>
</head>
<body>

<div class="user-container">
  <div class="user-header">
    Bem-vindo, <?= htmlspecialchars($usuario['nome']); ?>!
  </div>
  
   <div class="info-row">
    <div class="info-label">Matrícula:</div>
    <div class="info-content"><?= htmlspecialchars($usuario['matricula']); ?></div>
  </div>
  <br>
  <div class="user-info">
    <div class="info-row">
      <div class="info-label">Email:</div>
      <div class="info-content"><?= htmlspecialchars($usuario['email']); ?></div>
    </div>
    <div class="info-row">
      <div class="info-label">Escola:</div>
      <div class="info-content"><?= htmlspecialchars($nome_escola); ?></div>
    </div>
    <div class="info-row">
      <div class="info-label">Jogos:</div>
      <div class="info-content">
        <?= $comprouJogos ? 'Você já possui acesso aos jogos!' : 'Você ainda não adquiriu os jogos.'; ?>
      </div>
    </div>
  </div>

  <div class="button-group">
    <a href="logout.php" class="edit-button" onclick="return confirm('Deseja realmente sair da conta?')">Sair</a>
    <a href="inicio.php" class="edit-button">Voltar</a>
  </div>
</div>

</body>
</html>
