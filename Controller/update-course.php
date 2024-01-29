<?php
require_once '../DataBase/conexao.php';
require_once '../DAO/courseDAO.php';

if (isset($_POST['btn-editar'])) {
    $c_id = $_POST['c_id'];
    $c_nome = $_POST['c_nome'];

    $conexao = new Conexao();
    $conn = $conexao->conectar();
    $courseDAO = new CourseDAO($conn);

    $success = $courseDAO->updateCourse($c_id, $c_nome);

    if ($success) {
        // Redirecionar para uma página de sucesso ou fazer algo apropriado
        header("Location: ../View/course-list.php?update"); 
        exit();
    } else {
        // Exibir uma mensagem de erro
        header("Location: ../View/course-list.php?update-erro");
        exit();
    }
}
?>
