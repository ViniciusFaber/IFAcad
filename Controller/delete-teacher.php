<?php
//fazendo conexão com o banco de dados e a classe CourseDAO
require_once '../DataBase/conexao.php';
require_once '../DAO/teacherDAO.php';

if (isset($_GET['p_id'])) {
    $idTeacher = $_GET['p_id'];

    // Verifica se o parâmetro de exclusão foi fornecido e é igual a "cancelada"
    if (isset($_GET['exclusao']) && $_GET['exclusao'] === "cancelada") {
        // Redireciona de volta para a página de lista de cursos
        header("Location: ../View/teacher-list.php");
        exit();
    }

    // Cria uma instância da classe Conexao
    $conexao = new Conexao();
    $conn = $conexao->conectar();

    // Cria uma instância da classe DAO
    $teacherDAO = new TeacherDAO($conn);

    // Executa a exclusão
    if ($teacherDAO->deleteTeacherAndAdminRelations($idTeacher)) {
        // Exclusão bem-sucedida
        header("Location: ../View/teacher-list.php?excluir-sucesso=sucesso");
        exit();
    } else {
        // Não foi possível excluir
        header("Location: ../View/teacher-list.php?excluir-erro=erro");
        exit();
    }

    // Fecha a conexão com o banco de dados
    $conexao->fecharConexao();
} else {
    // Se o ID não for fornecido, redirecione de volta para a página de lista 
    header("Location: ../View/teacher-list.php");
    exit();
}
?>
