<?php
include('conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomeinst = $_POST['nome_instituicao'] ?? '';
    $cnpj = preg_replace('/\D/', '', $_POST['cnpj'] ?? '');
    $endereco = $_POST['endereco'] ?? '';
    $nomeresp = $_POST['responsavel'] ?? '';
    $formpag = $_POST['pagamento'] ?? '';

    if (empty($nomeinst) || empty($cnpj) || empty($endereco) || empty($nomeresp) || empty($formpag)) {
        echo "Por favor, preencha todos os campos.";
        echo '<br><a href="formulario-compra.html">Voltar</a>';
        exit;
    }

    $stmt = $conn->prepare("CALL inserir_pagamento(?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Erro na preparação da consulta: " . $conn->error);
    }

    $stmt->bind_param("sssss", $nomeinst, $cnpj, $endereco, $nomeresp, $formpag);

    if ($stmt->execute()) {
        echo "Pagamento inserido com sucesso!";
    } else {
        echo "Erro ao inserir pagamento: " . $stmt->error;
    }

    echo '<br><a href="formulario-compra.html">Voltar</a>';

    $stmt->close();
    $conn->close();
} else {
    header('Location: formulario-compra.html');
    exit;
}
?>
