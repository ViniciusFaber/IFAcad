<?php
session_start();
require_once '../DataBase/conexao.php'; // Inclua o arquivo de configuração do banco de dados
require_once '../DAO/teacherDAO.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u_email = $_POST['u_email'];
    $u_senha = $_POST['u_senha'];
    // Crie uma instância da classe de conexão com o banco de dados
    $conexao = new Conexao();
    $conn = $conexao->conectar();
    $teacherDAO = new TeacherDAO($conn);
    $user = $teacherDAO->checkLogin($u_email, $u_senha);

    if ($user) {
        $_SESSION['user_id'] = $user['u_id'];
        if ($user['u_user'] == 0) {
            $_SESSION['user_type'] = 'professor';
            
            header("Location: ../View/teacher-home.php");
            exit();
        } elseif ($user['u_user'] == 1) {
            $_SESSION['user_type'] = 'administrador';
            header("Location: ../View/administrator-home.php");
            exit();
        } else { // Trate outros casos aqui, se necessário           
        }
    } else {
        header("Location: ../View/login.php?erro");
        exit();
    }
}
?>
