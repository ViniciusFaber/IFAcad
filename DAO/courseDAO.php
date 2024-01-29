<?php
//fazendo conexão com o banco de dados
require_once '../DataBase/conexao.php';

class CourseDAO {
    private $conn;

    public function __construct()
    {
        // Fazer a conexão com o banco de dados
        $conexao = new Conexao();
        $this->conn = $conexao->conectar();
    }
    
        // Função para inserir um novo curso no banco de dados
            public function insertCourse($c_nome) {
                    try {
                        // Insere o novo curso no banco de dados
                        $query = "INSERT INTO tb_cursos (c_nome) VALUES (:c_nome)";
                        $stmt = $this->conn->prepare($query);
                        $stmt->bindParam(':c_nome', $c_nome);
                                
                        if ($stmt->execute()) {
                            return true; // Inserção bem-sucedida
                        } else {
                            return false; // Não foi possível inserir o curso
                        }
                    } catch (PDOException $e) {
                        // Tratar erros de execução da query
                        echo 'Erro na inserção do curso: ' . $e->getMessage();
                        exit();
                    }
                }

            //função para listar um curso de acordo com o id passado
            public function getCourseById($c_id) {
                $sql = "SELECT * FROM tb_cursos WHERE c_id = :c_id";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':c_id', $c_id, PDO::PARAM_INT);
                $stmt->execute();
        
                // Verifica se o curso foi encontrado
                if ($stmt->rowCount() > 0) {
                    // Retorna os dados do curso como um array associativo
                    return $stmt->fetch(PDO::FETCH_ASSOC);
                } else {
                    // Retorna null se o curso não for encontrado
                    return null;
                }
            }

        
            //função para atualizar um curso no banco de dados
            public function updateCourse($c_id, $c_nome) {
                try {
                    // Execute a atualização do curso
                    $query = "UPDATE tb_cursos SET  c_nome = :c_nome WHERE c_id = :c_id";
                    $stmt = $this->conn->prepare($query);
                    $stmt->bindParam(':c_nome', $c_nome);
                    $stmt->bindParam(':c_id', $c_id);
        
                    if ($stmt->execute()) {
                        // Atualização bem-sucedida
                        return true;
                    } else {
                        // Ocorreu um erro na atualização
                        return false;
                    }
                } catch (PDOException $e) {
                    // Tratar erros de execução da query
                    echo 'Erro na atualização do curso: ' . $e->getMessage();
                    exit();
                }
            }

            //função para excluir um curso no banco de dados
            public function deleteCourse($c_id) {
                try {
                    $query = "DELETE FROM tb_cursos WHERE c_id = :c_id";
                    $stmt = $this->conn->prepare($query);
                    $stmt->bindParam(':c_id', $c_id, PDO::PARAM_INT);

                    if ($stmt->execute()) {
                        return true; // Exclusão bem-sucedida
                    } else {
                        return false; // Não foi possível excluir o curso
                    }
                } catch (PDOException $e) {
                    // Tratar erros de execução da query
                    echo 'Erro na exclusão do dado: ' . $e->getMessage();
                    exit();
                }
            }

            //função para listar os cursos cadastrados
            public function listCourse() {
                try {
                    $sql = "SELECT c_id, c_nome FROM tb_cursos";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->execute();
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    return $result;
                } catch (PDOException $e) {
                    // Tratar erros de execução da query
                    echo 'Erro na listagem de cursos: ' . $e->getMessage();
                    exit();
                }
            }

            //função para listar os curso na página de cadastro de acadêmico
            public function getAllCourses()
                {
                    $sql = "SELECT c_id, c_nome FROM tb_cursos"; 
                    $stmt = $this->conn->prepare($sql);
                    $stmt->execute();

                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
}

?>