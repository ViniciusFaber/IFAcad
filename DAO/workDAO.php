<?php
//fazendo conexão com o banco de dados
require_once __DIR__ . '/../DataBase/conexao.php';
// importando a biblioteca do cliente, instalando dependencia dentro do arquivo
use Google\Cloud\Storage\StorageClient;

class WorkDAO {
    private $conn;

    public function __construct()
    {
        // Fazer a conexão com o banco de dados
        $conexao = new Conexao();
        $this->conn = $conexao->conectar();
    }
    
        // Função para inserir um novo acadêmico no banco de dados
        public function insertWork($t_titulo, $t_data_def, $t_palavra_c, $t_banca, $t_resumo, $t_citar, $t_idioma, $t_doc, $t_tipo, $t_acad, $t_acad2, $t_prof) {
            try {
                // Insere o novo acadêmico no banco de dados
                $query = "INSERT INTO tb_trabalhos (t_titulo, t_data_def, t_palavra_c, t_banca, t_resumo, t_citar, t_idioma, t_doc, t_tipo, t_acad, t_acad2, t_prof) VALUES (:t_titulo, :t_data_def, :t_palavra_c, :t_banca, :t_resumo, :t_citar, :t_idioma, :t_doc, :t_tipo, :t_acad, :t_acad2, :t_prof)";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':t_titulo', $t_titulo);
                $stmt->bindParam(':t_data_def', $t_data_def); 
                $stmt->bindParam(':t_palavra_c', $t_palavra_c); 
                $stmt->bindParam(':t_banca', $t_banca); 
                $stmt->bindParam(':t_resumo', $t_resumo); 
                $stmt->bindParam(':t_citar', $t_citar); 
                $stmt->bindParam(':t_idioma', $t_idioma); 
                $stmt->bindParam(':t_doc', $t_doc); 
                $stmt->bindParam(':t_tipo', $t_tipo); 
                $stmt->bindParam(':t_acad', $t_acad); 
                $stmt->bindParam(':t_acad2', $t_acad2); 
                $stmt->bindParam(':t_prof', $t_prof); 
                
                if ($stmt->execute()) {
                    return true; // Inserção bem-sucedida
                } else {
                    return false; // Não foi possível inserir o acadêmico
                }
            } catch (PDOException $e) {
                // Tratar erros de execução da query
                echo 'Erro na inserção do dado: ' . $e->getMessage();
                exit();
            }
        }

        //função para listar os trabalhos adicionados recentemente na tabela da página inicial
        public function listRecent() {
            try {
                $sql = "SELECT tb_trabalhos.t_id, tb_trabalhos.t_titulo, tb_academicos.ac_nome, tb_trabalhos.t_data_def, tb_cursos.c_nome as nome_curso, tb_trabalhos.t_doc
                FROM tb_trabalhos 
                INNER JOIN tb_academicos ON tb_trabalhos.t_acad = tb_academicos.ac_id
                INNER JOIN tb_cursos ON tb_academicos.ac_curso = tb_cursos.c_id
                ORDER BY tb_trabalhos.t_id DESC
                LIMIT 3";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $result;
            } catch (PDOException $e) {
                // Tratar erros de execução da query
                echo 'Erro na listagem de trabalhos: ' . $e->getMessage();
                exit();
            }
        }

        //função para listar as principais informações do trabalho apresentadas na tabela de listagem
        public function listWork() {
            try {
                $sql = "SELECT 
                tb_trabalhos.t_id,
                tb_trabalhos.t_titulo,
                tb_academicos.ac_nome,
                tb_cursos.c_nome as nome_curso,
                tb_trabalhos.t_data_def,
                tb_trabalhos.t_doc
            FROM 
                tb_trabalhos
            INNER JOIN 
                tb_academicos ON tb_trabalhos.t_acad = tb_academicos.ac_id
            INNER JOIN 
                tb_professores ON tb_trabalhos.t_prof = tb_professores.p_id
            INNER JOIN 
                tb_cursos ON tb_academicos.ac_curso = tb_cursos.c_id";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $result;
            } catch (PDOException $e) {
                // Tratar erros de execução da query
                echo 'Erro na listagem de trabalhos: ' . $e->getMessage();
                exit();
            }
        }

        public function listWorkInit() {
            try {
                $sql = "SELECT tb_trabalhos.t_titulo, tb_trabalhos.t_acad, tb_trabalhos.t_data_def, tb_trabalhos.t_doc
                FROM tb_trabalhos 
                INNER JOIN tb_academicos ON tb_trabalhos.t_acad = tb_academicos.ac_id
                INNER JOIN tb_professores ON tb_trabalhos.t_prof = tb_professores.p_id";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $result;
            } catch (PDOException $e) {
                // Tratar erros de execução da query
                echo 'Erro na listagem de trabalhos: ' . $e->getMessage();
                exit();
            }
        }

        //função para listar os dados do trabalho para edição na tela de upload
        public function getById($t_id) {
            $sql = "SELECT 
            tb_trabalhos.t_id,
            tb_trabalhos.t_titulo,
            tb_trabalhos.t_tipo,
            tb_trabalhos.t_acad,
            tb_trabalhos.t_acad2,
            tb_trabalhos.t_palavra_c,
            tb_trabalhos.t_data_def,            
            tb_trabalhos.t_prof,
            tb_trabalhos.t_banca,
            tb_trabalhos.t_doc,
            tb_trabalhos.t_resumo,
            tb_trabalhos.t_idioma,
            tb_trabalhos.t_citar
        FROM 
            tb_trabalhos
        INNER JOIN 
            tb_academicos ON tb_trabalhos.t_acad = tb_academicos.ac_id
        INNER JOIN 
            tb_professores ON tb_trabalhos.t_prof = tb_professores.p_id       
        WHERE 
            tb_trabalhos.t_id = :t_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':t_id', $t_id, PDO::PARAM_INT);
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

        //função para listar todas as informações do trabalho na página de detalhes
        public function getWorkDetailsById($t_id) {
            try {
                $sql = "SELECT 
                            tb_trabalhos.t_titulo,
                            tb_trabalhos.t_tipo,
                            tb_academicos.ac_nome as t_acad,
                            tb_trabalhos.t_acad2,
                            tb_trabalhos.t_palavra_c,
                            tb_trabalhos.t_data_def,
                            tb_user.u_nome as t_prof_nome,
                            tb_trabalhos.t_banca,
                            tb_cursos.c_nome as nome_curso,
                            tb_trabalhos.t_doc,
                            tb_trabalhos.t_resumo,
                            tb_trabalhos.t_idioma,
                            tb_trabalhos.t_citar
                        FROM 
                            tb_trabalhos
                        INNER JOIN 
                            tb_academicos ON tb_trabalhos.t_acad = tb_academicos.ac_id
                        INNER JOIN 
                            tb_professores ON tb_trabalhos.t_prof = tb_professores.p_id
                        INNER JOIN 
                            tb_user ON tb_professores.u_id = tb_user.u_id
                        INNER JOIN 
                            tb_cursos ON tb_academicos.ac_curso = tb_cursos.c_id
                        WHERE 
                            tb_trabalhos.t_id = :t_id";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':t_id', $t_id, PDO::PARAM_INT);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $result;
            } catch (PDOException $e) {
                // Tratar erros de execução da query
                echo 'Erro ao obter detalhes do trabalho: ' . $e->getMessage();
                exit();
            }
        }
        

        //função para excluir um curso no banco de dados
        public function deleteWork($t_id) {
            try {
                $query = "DELETE FROM tb_trabalhos WHERE t_id = :t_id";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':t_id', $t_id, PDO::PARAM_INT);

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

        //função para atualizar um trabalho no banco de dados
        public function updateWork($t_id, $t_titulo, $t_data_def, $t_palavra_c, $t_banca, $t_resumo, $t_citar, $t_idioma, $t_doc, $t_tipo, $t_acad, $t_acad2, $t_prof) {
            try {
                // Execute a atualização do usuário
                $query = "UPDATE tb_trabalhos SET t_titulo = :t_titulo, t_data_def = :t_data_def, t_palavra_c = :t_palavra_c, t_banca = :t_banca, t_resumo = :t_resumo, t_citar = :t_citar, t_idioma = :t_idioma, t_doc = :t_doc, t_tipo = :t_tipo, t_acad = :t_acad, t_acad2 = :t_acad2, t_prof = :t_prof WHERE t_id = :t_id";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':t_titulo', $t_titulo);
                $stmt->bindParam(':t_data_def', $t_data_def); 
                $stmt->bindParam(':t_palavra_c', $t_palavra_c); 
                $stmt->bindParam(':t_banca', $t_banca); 
                $stmt->bindParam(':t_resumo', $t_resumo); 
                $stmt->bindParam(':t_citar', $t_citar); 
                $stmt->bindParam(':t_idioma', $t_idioma); 
                $stmt->bindParam(':t_doc', $t_doc); 
                $stmt->bindParam(':t_tipo', $t_tipo); 
                $stmt->bindParam(':t_acad', $t_acad);
                $stmt->bindParam(':t_acad2', $t_acad2);  
                $stmt->bindParam(':t_prof', $t_prof);
                $stmt->bindParam(':t_id', $t_id);
    
                if ($stmt->execute()) {
                    // Atualização bem-sucedida
                    return true;
                } else {
                    // Ocorreu um erro na atualização
                    return false;
                }
            } catch (PDOException $e) {
                // Tratar erros de execução da query
                echo 'Erro na atualização do trabalho: ' . $e->getMessage();
                
                exit();
            }
        }

        //função para listar o id do trabalho
        public function getWorkById($t_id) {
            $sql = "SELECT * FROM tb_trabalhos WHERE t_id = :t_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':t_id', $t_id, PDO::PARAM_INT);
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
    }        
?>