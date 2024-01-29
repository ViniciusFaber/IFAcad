<?php
require_once '../DataBase/conexao.php';
require_once '../DAO/teacherDAO.php';

class TeacherModel
{
    private $teacherDAO;

    public function __construct()
    {
        $conexao = new Conexao();
        $conn = $conexao->conectar();
        $this->teacherDAO = new TeacherDAO($conn);
    }

    public function insertTeacher($u_nome, $u_email, $u_senha, $u_user, $p_ciap, $p_block)
    {
        return $this->teacherDAO->insertTeacher($u_nome, $u_email, $u_senha, $u_user, $p_ciap, $p_block);
    }

    public function getAllTeachers()
    {
        return $this->teacherDAO->getAllTeachers();
    }

    public function isEmailRegistered($u_email)
    {
        return $this->teacherDAO->isEmailRegistered($u_email);
    }

    public function isCiapRegistered($p_ciap)
    {
        return $this->teacherDAO->isCiapRegistered($p_ciap);
    }
}
?>