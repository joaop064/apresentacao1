<?php
session_start(); // importante para usar $_SESSION

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('conexao.php');

    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
    $email = trim(mysqli_real_escape_string($conexao, $_POST['email']));
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $escola_id = isset($_POST['escola_id']) ? (int) $_POST['escola_id'] : null;

    if ($escola_id === null) {
        die("Por favor, selecione uma escola.");
    }

    // Verificar se o e-mail já está cadastrado
    $check = $conexao->prepare("SELECT id FROM aluno WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "Erro: Este e-mail já está cadastrado. Por favor, use outro.";
        exit();
    }

    // Inserir o novo aluno
    $stmt = $conexao->prepare("INSERT INTO aluno (nome, email, senha, escola_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $nome, $email, $senha, $escola_id);
    $stmt->execute();

    // Obter o ID do novo usuário
    $novo_id = $conexao->insert_id;

    // Armazenar os dados na sessão para login automático
    $_SESSION['id'] = $novo_id;
    $_SESSION['nome'] = $nome;

    // Redirecionar para a página inicial
    header("Location: inicio.php");
    exit();
}
?>
