<?php
require_once 'conexao.php';
session_start();

// Função de validação e salvamento
function salvarPagamento($conexao, $idUsuario) {
    $erros = [];

    // Verifica se todos os campos obrigatórios foram enviados
    if (!isset($_POST['nome_instituicao'], $_POST['cnpj'], $_POST['endereco'], $_POST['responsavel'], $_POST['pagamento'])) {
        $erros[] = "Todos os campos obrigatórios devem ser preenchidos.";
        return $erros;
    }

    $nomeInstituicao = trim($_POST['nome_instituicao']);
    $cnpj = preg_replace('/[^0-9]/', '', trim($_POST['cnpj']));
    $endereco = trim($_POST['endereco']);
    $responsavel = trim($_POST['responsavel']);
    $pagamento = $_POST['pagamento'];

    // Validações
    if (preg_match('/\d/', $nomeInstituicao)) {
        $erros[] = "O nome da instituição não pode conter números.";
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

    // Inserir pagamento
    $stmt = $conexao->prepare("INSERT INTO pagamento (cnpj, nomeinst, endereco, nomeresp, formpag) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $cnpj, $nomeInstituicao, $endereco, $responsavel, $pagamento);

    if ($stmt->execute()) {
        // Atualizar aluno
        $stmt_upd = $conexao->prepare("UPDATE aluno SET comprou_jogos = 1 WHERE id = ?");
        $stmt_upd->bind_param("i", $idUsuario);
        $stmt_upd->execute();

        header("Location: ecogame.php");
        exit;
    } else {
        return ["Erro ao salvar pagamento: " . $stmt->error];
    }
}

// Executa somente se for POST
$idUsuario = $_SESSION['id'] ?? null;
$mensagem = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $idUsuario) {
    $mensagem = salvarPagamento($conexao, $idUsuario);
}

// Dados de exemplo para exibição
$linkQrCodePix = 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=chavepix%40ecogame.com';
$codigoBoleto = '34191.79001 01043.510047 91020.150008 2 85770000002000';
?>
