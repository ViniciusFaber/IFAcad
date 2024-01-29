<?php
require_once '../DataBase/conexao.php';
require_once '../DAO/teacherDAO.php';

if (isset($_POST['btn-editar'])) {
    $p_id = $_POST['p_id']; // Recupera o p_id do formulário
    $u_nome = $_POST['u_nome'];
    $u_email = $_POST['u_email'];
    $u_senha = $_POST['u_senha'];
    $p_ciap = $_POST['p_ciap'];
    $p_block = $_POST['p_block'];

    $conexao = new Conexao();
    $conn = $conexao->conectar();
    $teacherDAO = new TeacherDAO($conn);

    $u_id = $teacherDAO->getUserIdByTeacherId($p_id);


    // Começar a transação
    $conn->beginTransaction();

    // Atualizar o usuário
    $userUpdateSuccess = $teacherDAO->updateUser($u_id, $u_nome, $u_email, $u_senha);

    // Atualizar o professor
    $professorUpdateSuccess = $teacherDAO->updateProfessor($p_id, $p_ciap, $p_block);

    // Verificar se ambas as atualizações foram bem-sucedidas
    if ($userUpdateSuccess && $professorUpdateSuccess) {
        // Confirmar a transação
        $conn->commit();

        // Redirecionar para uma página de sucesso ou fazer algo apropriado
        header("Location: ../View/teacher-list.php?update"); 
        exit();
    } else {
        // Reverter a transação em caso de erro
        $conn->rollback();

        // Exibir uma mensagem de erro
        header("Location: ../View/teacher-list.php?update-erro");
        exit();
    }
}
?>
