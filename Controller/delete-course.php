<?php
//fazendo conexão com o banco de dados e a classe CourseDAO
require_once '../DataBase/conexao.php';
require_once '../DAO/courseDAO.php';

if (isset($_GET['c_id'])) {
    $idCourse = $_GET['c_id'];

    // Verifica se o parâmetro de exclusão foi fornecido e é igual a "cancelada"
    if (isset($_GET['exclusao']) && $_GET['exclusao'] === "cancelada") {
        // Redireciona de volta para a página de lista de cursos
        header("Location: ../View/course-list.php");
        exit();
    }

    // Cria uma instância da classe Conexao
    $conexao = new Conexao();
    $conn = $conexao->conectar();

    // Cria uma instância da classe CourseDAO
    $courseDAO = new CourseDAO($conn);

    // Executa a exclusão do curso
    if ($courseDAO->deleteCourse($idCourse)) {
        // Exclusão bem-sucedida
        header("Location: ../View/course-list.php?excluir-sucesso=sucesso");
        exit();
    } else {
        // Não foi possível excluir o curso
        header("Location: ../View/course-list.php?excluir-erro=erro");
        exit();
    }

    // Fecha a conexão com o banco de dados
    $conexao->fecharConexao();
} else {
    // Se o ID do curso não for fornecido, redirecione de volta para a página de lista de cursos
    header("Location: ../View/course-list.php");
    exit();
}
?>
