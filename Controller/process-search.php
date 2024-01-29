<?php
// Verificar se uma sessão já está ativa
if (session_status() == PHP_SESSION_NONE) {
    // Se não estiver ativa, iniciar a sessão
    session_start();
}

// Verificar se o parâmetro de pesquisa está presente na URL
if (!isset($_GET['query'])) {
    // Redirecionar de volta para a página de pesquisa se o parâmetro estiver ausente
    header("Location: index.php");
    exit();
}

// Recuperar o termo de pesquisa da URL
$termo_pesquisa = '%' . $_GET['query'] . '%';

// Execute a consulta novamente aqui e exiba os resultados na tabela
require_once '../DataBase/conexao.php';

$conexao = new Conexao();
$conn = $conexao->conectar();

$query = "SELECT tb_trabalhos.*, tb_academicos.ac_nome, tb_cursos.c_nome
          FROM tb_trabalhos 
          LEFT JOIN tb_academicos ON tb_trabalhos.t_acad = tb_academicos.ac_id
          LEFT JOIN tb_cursos ON tb_academicos.ac_curso = tb_cursos.c_id
          WHERE tb_trabalhos.t_titulo LIKE :termo_pesquisa
             OR tb_academicos.ac_nome LIKE :termo_pesquisa
             OR tb_trabalhos.t_data_def LIKE :termo_pesquisa
             OR tb_cursos.c_nome LIKE :termo_pesquisa";

$stmt = $conn->prepare($query);
$stmt->bindParam(':termo_pesquisa', $termo_pesquisa);

if ($stmt->execute()) {
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Redirecionar para a página de resultados com os resultados na URL
    header("Location: ../View/search-result.php?query=" . urlencode($_GET['query']) . "&resultados=" . urlencode(json_encode($resultados)));
    exit();
} else {
    // Trate erros na execução da consulta
    echo 'Erro na execução da consulta: ' . implode(' ', $stmt->errorInfo());
    exit();
}
?>