<?php
require_once '../DataBase/conexao.php';
require_once '../DAO/academicDAO.php';

class AcademicModel
{
    private $academicDAO;

    public function __construct()
    {
        $conexao = new Conexao();
        $conn = $conexao->conectar();
        $this->academicDAO = new AcademicDAO($conn);
    }

    public function insertAcademic($ac_nome, $ac_ra, $ac_curso)
    {
        return $this->academicDAO->insertAcademic($ac_nome, $ac_ra, $ac_curso);
    }

    public function getAllAcademics()
    {
        return $this->academicDAO->getAllAcademics();
    }
    public function isRaRegistered($ac_ra)
    {
        return $this->academicDAO->isRaRegistered($ac_ra);
    }

}
?>