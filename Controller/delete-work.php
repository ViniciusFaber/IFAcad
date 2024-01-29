<?php
//fazendo conexão com o banco de dados e a classe CourseDAO
require_once '../DataBase/conexao.php';
require_once '../DAO/workDAO.php';

if (isset($_GET['t_id'])) {
    $idWork = $_GET['t_id'];

    // Verifica se o parâmetro de exclusão foi fornecido e é igual a "cancelada"
    if (isset($_GET['exclusao']) && $_GET['exclusao'] === "cancelada") {
        // Redireciona de volta para a página de lista de cursos
        header("Location: ../View/work-list.php");
        exit();
    }

    // Cria uma instância da classe Conexao
    $conexao = new Conexao();
    $conn = $conexao->conectar();

    // Cria uma instância da classe WorkeDAO
    $workDAO = new WorkDAO($conn);

    // Executa a exclusão do work
    if ($workDAO->deleteWork($idWork)) {
        // Exclusão bem-sucedida
        header("Location: ../View/work-list.php?excluir-sucesso=sucesso");
        exit();
    } else {
        // Não foi possível excluir o work
        header("Location: ../View/work-list.php?excluir-erro=erro");
        exit();
    }

    // Fecha a conexão com o banco de dados
    $conexao->fecharConexao();
} else {
    // Se o ID do curso não for fornecido, redirecione de volta para a página de lista de cursos
    header("Location: ../View/work-list.php");
    exit();
}
?>
