<?php
require_once '../Model/academic-model.php';
require_once '../DAO/academicDAO.php';
require_once '../DataBase/conexao.php';

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bnt-cadastrar'])) {
    $ac_nome = $_POST['ac_nome'];
    $ac_ra = $_POST['ac_ra'];
    $ac_curso = $_POST['ac_curso'];
   
 // Cria uma instância do UsuarioModel
    $academicModel = new AcademicModel();

    // Validação do RA
if (!is_numeric($ac_ra) || strlen($ac_ra) < 7 || strlen($ac_ra) > 10) {
    // RA não é um número válido ou não atende aos requisitos
    header("Location: ../View/academic-register.php?ra_erro1");
    exit();
}

// Verifique se o RA já está cadastrado no banco de dados
if ($academicModel->isRaRegistered($ac_ra)) {
    // Este RA já está cadastrado
    header("Location: ../View/academic-list.php?existe");
    exit();
}
   
    $result = $academicModel->insertAcademic($ac_nome, $ac_ra, $ac_curso);

    if ($result) {
        header("Location: ../View/academic-list.php?sucesso");
        exit();
    } else {
        header("Location: ../View/academic-list.php?erro");
        exit();
    }
}
?>
