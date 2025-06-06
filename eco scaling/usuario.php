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

    // Buscar nome da escola
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
<style>
  body {
  font-family: 'Poppins', sans-serif;
  background-color: #e9f7ec;
  margin: 0;
  padding: 0;
}

.user-container {
  max-width: 800px;
  margin: 50px auto;
  background-color: #ffffff;
  padding: 30px;
  border-radius: 10px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.user-header {
  text-align: center;
  color: #2e7d32;
  font-size: 2em;
  margin-bottom: 20px;
}

.user-info {
  display: flex;
  flex-direction: column;
  gap: 15px;
  margin-top: 30px;
}

.info-label {
  font-weight: bold;
  color: #388e3c;
  width: 100px;
  flex-shrink: 0;
}

.info-row {
  display: flex;
  align-items: center;
}

.info-content {
  background-color: #f1f8f4;
  padding: 10px 15px;
  border-radius: 5px;
  color: #333;
  flex-grow: 1;
}

.edit-button {
  display: inline-block;
  background-color: #4caf50;
  color: #fff;
  padding: 10px 20px;
  text-align: center;
  border: none;
  border-radius: 5px;
  text-decoration: none;
  font-size: 16px;
  margin-top: 20px;
  transition: background-color 0.3s;
}

.edit-button:not(:last-child) {
  margin-right: 10px;
}

.edit-button:hover {
  background-color: #388e3c;
}


.button-group {
  text-align: right;
  margin-top: 20px;
}
</style>
</head>
<body>
 

<div class="user-container">
  <div class="user-header">
    Bem-vindo, <?= htmlspecialchars($usuario['nome']); ?>!
  </div>

  <div class="user-info">
    <div class="info-row">
      <div class="info-label">Email:</div>
      <div class="info-content"><?= htmlspecialchars($usuario['email']); ?></div>
    </div>
    <div class="info-row">
      <div class="info-label">Escola:</div>
      <div class="info-content"><?= htmlspecialchars($nome_escola); ?></div>
    </div>
  </div>

  <div class="button-group">
    <a href="logout.php" class="edit-button" onclick="return confirm('Deseja realmente sair da conta?')">Sair</a>
    <a href="inicio.php" class="edit-button">Voltar</a>
  </div>
</div>

</body>
</html>