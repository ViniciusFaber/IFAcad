<?php
//fazendo conexão com o banco de dados e a classe CourseDAO
require_once '../DataBase/conexao.php';
require_once '../DAO/academicDAO.php';

if (isset($_GET['ac_id'])) {
    $idAcademic = $_GET['ac_id'];

    // Verifica se o parâmetro de exclusão foi fornecido e é igual a "cancelada"
    if (isset($_GET['exclusao']) && $_GET['exclusao'] === "cancelada") {
        // Redireciona de volta para a página de lista de cursos
        header("Location: ../View/academic-list.php");
        exit();
    }

    // Cria uma instância da classe Conexao
    $conexao = new Conexao();
    $conn = $conexao->conectar();

    // Cria uma instância da classe CourseDAO
    $academicDAO = new AcademicDAO($conn);

    // Executa a exclusão do curso
    if ($academicDAO->deleteAcademic($idAcademic)) {
        // Exclusão bem-sucedida
        header("Location: ../View/academic-list.php?excluir-sucesso=sucesso");
        exit();
    } else {
        // Não foi possível excluir o curso
        header("Location: ../View/academic-list.php?excluir-erro=erro");
        exit();
    }

    // Fecha a conexão com o banco de dados
    $conexao->fecharConexao();
} else {
    // Se o ID do curso não for fornecido, redirecione de volta para a página de lista de cursos
    header("Location: ../View/academic-list.php");
    exit();
}
?>
