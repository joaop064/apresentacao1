<?php
session_start(); 

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

    // Função para gerar matrícula aleatória única
    function gerarMatriculaUnica($conexao) {
        do {
            
            $matricula = strval(random_int(1000000, 9999999));

            // Verifica se já existe essa matrícula no banco
            $stmt = $conexao->prepare("SELECT id FROM aluno WHERE matricula = ?");
            $stmt->bind_param("s", $matricula);
            $stmt->execute();
            $stmt->store_result();
        } while ($stmt->num_rows > 0); // repete se matrícula já existir

        return $matricula;
    }

    // Gerar matrícula única
    $matricula = gerarMatriculaUnica($conexao);

    // Inserir o novo aluno com a matrícula
    $stmt = $conexao->prepare("INSERT INTO aluno (nome, email, senha, escola_id, matricula) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssis", $nome, $email, $senha, $escola_id, $matricula);
    $stmt->execute();

    
    $novo_id = $conexao->insert_id;

    
    $_SESSION['id'] = $novo_id;
    $_SESSION['nome'] = $nome;
    $_SESSION['matricula'] = $matricula; // opcional, se quiser salvar na sessão

    
    header("Location: inicio.php");
    exit();
}
?>
