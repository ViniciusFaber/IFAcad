<?php
require_once '../DataBase/conexao.php';
require_once '../DAO/academicDAO.php';

if (isset($_POST['bnt-editar'])) {
    $ac_id = $_POST['ac_id'];
    $ac_nome = $_POST['ac_nome'];
    $ac_ra = $_POST['ac_ra'];
    $ac_curso = $_POST['ac_curso']; 

    $conexao = new Conexao();
    $conn = $conexao->conectar();
    $academicDAO = new AcademicDAO($conn);

    $success = $academicDAO->updateAcademic($ac_id, $ac_nome, $ac_ra, $ac_curso); 
    if ($success) {
        // Redirecionar para uma página de sucesso ou fazer algo apropriado
        header("Location: ../View/academic-list.php?update"); 
        exit();
    } else {
        // Exibir uma mensagem de erro
        header("Location: ../View/academic-list.php?update-erro");
        exit();
    }
}
?>
