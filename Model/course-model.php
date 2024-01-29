<?php
require_once '../DataBase/conexao.php';
require_once '../DAO/courseDAO.php';

class CourseModel
{
    private $courseDAO;

    public function __construct()
    {
        $conexao = new Conexao();
        $conn = $conexao->conectar();
        $this->courseDAO = new CourseDAO($conn);
    }

    public function insertCourse($nomeCourse)
    {
        return $this->courseDAO->insertCourse($nomeCourse);
    }

    public function getAllCourses()
    {
        return $this->courseDAO->getAllCourses();
    }
}
?>