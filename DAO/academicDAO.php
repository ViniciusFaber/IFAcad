<?php
//fazendo conexão com o banco de dados
require_once '../DataBase/conexao.php';

class AcademicDAO {
    private $conn;

    public function __construct()
    {
        // Fazer a conexão com o banco de dados
        $conexao = new Conexao();
        $this->conn = $conexao->conectar();
    }
    
    //função para inclusão de um novo registro de acadêmico no banco de dados
    public function insertAcademic($ac_nome, $ac_ra, $ac_curso) {
        try {
            // Verifique se o curso (ac_curso) já está cadastrado na tabela de cursos (tb_cursos)
            $query = "SELECT c_id FROM tb_cursos WHERE c_id = :ac_curso";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':ac_curso', $ac_curso);
            $stmt->execute();
    
            // Use fetchColumn para verificar se o curso existe
            $cursoExists = $stmt->fetchColumn();
    
            if (!$cursoExists) {
                return false; // O curso não existe, portanto, não é possível inserir o acadêmico
            }
    
            // Insira o novo acadêmico no banco de dados
            $query = "INSERT INTO tb_academicos (ac_nome, ac_ra, ac_curso) VALUES (:ac_nome, :ac_ra, :ac_curso)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':ac_nome', $ac_nome);
            $stmt->bindParam(':ac_ra', $ac_ra);
            $stmt->bindParam(':ac_curso', $ac_curso);
    
            if ($stmt->execute()) {
                return true; // Inserção bem-sucedida
            } else {
                return false; // Não foi possível inserir o acadêmico
            }
        } catch (PDOException $e) {
            // Tratar erros de execução da query
            echo 'Erro na inserção do acadêmico: ' . $e->getMessage();
            exit();
        }
    }
    
        //função para listar os acadêmicos cadastrados
        public function listAcademic() {
            try {
                $sql = "SELECT tb_academicos.ac_id, tb_academicos.ac_nome, tb_academicos.ac_ra, tb_cursos.c_nome
                FROM tb_academicos 
                INNER JOIN tb_cursos ON tb_academicos.ac_curso = tb_cursos.c_id";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $result;
            } catch (PDOException $e) {
                // Tratar erros de execução da query
                echo 'Erro na listagem de professores: ' . $e->getMessage();
                exit();
            }
        }

        //função para excluir um acadêmico no banco de dados
        public function deleteAcademic($ac_id) {
            try {
                $query = "DELETE FROM tb_academicos WHERE ac_id = :ac_id";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':ac_id', $ac_id, PDO::PARAM_INT);

                if ($stmt->execute()) {
                    return true; // Exclusão bem-sucedida
                } else {
                    return false; // Não foi possível excluir o academico
                }
            } catch (PDOException $e) {
                // Tratar erros de execução da query
                echo 'Erro na exclusão do dado: ' . $e->getMessage();
                exit();
            }
        }

        //função para atualizar o registro de um acadêmico no banco de dados
        public function updateAcademic($ac_id, $ac_nome, $ac_ra, $ac_curso) {
            try {
                // Certifique-se de que a tabela de cursos exista e tenha a coluna c_id
                $query = "UPDATE tb_academicos SET ac_nome = :ac_nome, ac_ra = :ac_ra, ac_curso = :ac_curso WHERE ac_id = :ac_id";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':ac_nome', $ac_nome); 
                $stmt->bindParam(':ac_ra', $ac_ra);
                $stmt->bindParam(':ac_curso', $ac_curso);
                $stmt->bindParam(':ac_id', $ac_id);
        
                if ($stmt->execute()) {
                    // Atualização bem-sucedida
                    return true;
                } else {
                    // Ocorreu um erro na atualização
                    return false;
                }
            } catch (PDOException $e) {
                // Tratar erros de execução da query
                echo 'Erro na atualização do acadêmico: ' . $e->getMessage();
                exit();
            }
        }
        

        //função para listar um acadêmico de acordo o id passado
        public function getAcademicById($ac_id) {
            $sql = "SELECT * FROM tb_academicos WHERE ac_id = :ac_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':ac_id', $ac_id, PDO::PARAM_INT);
            $stmt->execute();
    
            // Verifica se o academico foi encontrado
            if ($stmt->rowCount() > 0) {
                // Retorna os dados do academico como um array associativo
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                // Retorna null se o academico não for encontrado
                return null;
            }
        }

        //função para listar os acadêmicos na tela de cadastro de trabalho
        public function getAllAcademics()
        {
            $sql = "SELECT tb_academicos.ac_id, tb_academicos.ac_nome, tb_cursos.c_nome FROM tb_academicos
            INNER JOIN 
                tb_cursos ON tb_academicos.ac_curso = tb_cursos.c_id"; 
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        //função para verificar se o RA já está registrado
        public function isRaRegistered($ac_ra)
        {
            // Consulta o banco de dados para verificar se o RA já está cadastrado
            $query = "SELECT COUNT(*) FROM tb_academicos WHERE ac_ra = :ac_ra";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':ac_ra', $ac_ra);
            $stmt->execute();
    
            $count = $stmt->fetchColumn();
    
            return $count > 0;
        }

}


?>