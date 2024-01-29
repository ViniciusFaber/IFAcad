<?php
require_once '../Model/teacher-model.php';
require_once '../DAO/teacherDAO.php';
require_once '../DataBase/conexao.php';

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bnt-cadastrar'])) {
    $u_nome = $_POST['u_nome'];
    $u_email = $_POST['u_email'];
    $u_senha = $_POST['u_senha'];
    $p_ciap = $_POST['p_ciap'];
    $p_block = $_POST['p_block'];

    // Cria uma instância do TeacherModel
    $teacherModel = new TeacherModel();
   
    // Verifica se o email já está cadastrado
    if ($teacherModel->isEmailRegistered($u_email)) {
        header("Location: ../View/teacher-register.php?existe");
        exit();
    }

    // Validação CIAP
    if (!is_numeric($p_ciap) || strlen($p_ciap) < 4 || strlen($p_ciap) > 10) {
        // CIAP não é um número válido ou não atende aos requisitos
        header("Location: ../View/teacher-register.php?ciap_erro1");
        exit();
    }

    // Verificar unicidade do CIAP
    if ($teacherModel->isCiapRegistered($p_ciap)) {
        // Este CIAP já está cadastrado
        header("Location: ../View/teacher-register.php?ciap_erro2");
        exit();
    }

    // Define a variável $u_user_adm diretamente como false (para professores)
    $u_user_adm_value = false;
    $u_user_adm = $u_user_adm_value ? 1 : 0;
     
    $result = $teacherModel->insertTeacher($u_nome, $u_email, $u_senha, $u_user_adm, $p_ciap, $p_block);

    if ($result) {
        header("Location: ../View/teacher-list.php?sucesso");
        exit();
    } else {
        header("Location: ../View/teacher-list.php?erro");
        exit();
    }
}
?>
