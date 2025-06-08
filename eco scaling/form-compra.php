<?php
session_start();
require_once 'conexao.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$id = $_SESSION['id'];

// Verifica se o usuário já comprou
$sql = "SELECT nome, email, comprou_jogos FROM aluno WHERE id = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 1) {
    $usuario = $resultado->fetch_assoc();
    $comprouJogos = $usuario['comprou_jogos'] == 1;
}

// Função para salvar o pagamento e atualizar a compra do aluno
function salvarPagamento($conexao, $idUsuario) {
    $cnpj = $_POST['cnpj'];
    $nomeinst = $_POST['nome_instituicao'];
    $endereco = $_POST['endereco'];
    $responsavel = $_POST['responsavel'];
    $formpag = $_POST['pagamento'];

    $sql_pag = "INSERT INTO pagamento (cnpj, nomeinst, endereco, nomeresp, formpag) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conexao->prepare($sql_pag);
    $stmt->bind_param("sssss", $cnpj, $nomeinst, $endereco, $responsavel, $formpag);

    if ($stmt->execute()) {
        $sql_upd = "UPDATE aluno SET comprou_jogos = 1 WHERE id = ?";
        $stmt = $conexao->prepare($sql_upd);
        $stmt->bind_param("i", $idUsuario);
        $stmt->execute();

        header("Location: ecogame.php");
        exit;
    } else {
        echo "<script>alert('Erro ao inserir: " . $stmt->error . "');</script>";
    }
}

// Somente chama se for POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    salvarPagamento($conexao, $id);
}
?>
