<?php
require_once '../Model/course-model.php';
require_once '../DAO/courseDAO.php';
require_once '../DataBase/conexao.php';

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bnt-cadastrar'])) {
    $nome = $_POST['name_curso'];
   
 // Cria uma instância do UsuarioModel
    $courseModel = new CourseModel();
   
    $result = $courseModel->insertCourse($nome);

    if ($result) {
        header("Location: ../View/course-list.php?sucesso");
        exit();
    } else {
        header("Location: ../View/course-list.php?erro");
        exit();
    }
}
?>
