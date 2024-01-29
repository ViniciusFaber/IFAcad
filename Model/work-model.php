<?php
require_once '../DataBase/conexao.php';
require_once '../DAO/workDAO.php';

class WorkModel
{
    private $workDAO;

    public function __construct()
    {
        $conexao = new Conexao();
        $conn = $conexao->conectar();
        $this->workDAO = new WorkDAO($conn);
    }

    public function insertWork($t_titulo, $t_data_def, $t_chave_c, $t_banca, $t_resumo, $t_citar, $t_idioma, $fileUrl, $t_tipo, $t_acad, $t_acad2, $t_prof)
    {
        return $this->workDAO->insertWork($t_titulo, $t_data_def, $t_chave_c, $t_banca, $t_resumo, $t_citar, $t_idioma, $fileUrl, $t_tipo, $t_acad, $t_acad2, $t_prof);
    }

    public function getAllWorks()
    {
        return $this->workDAO->getAllWorks();
    }

}
?>