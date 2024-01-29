<?php
//incluindo o arquivo de conexão com o banco de dados
require_once '../DataBase/conexao.php';

class TeacherDAO {
    private $conn;

    public function __construct()
    {
        // Fazer a conexão com o banco de dados
        $conexao = new Conexao();
        $this->conn = $conexao->conectar();
    }
    
                // Função para inserir um novo professor no banco de dados, incluindo um registro em tb_user
                public function insertTeacher($u_nome, $u_email, $u_senha, $u_user, $p_ciap, $p_block) {
                    try {
                        // Iniciar uma transação
                        $this->conn->beginTransaction();

                        // Primeiro, insira um novo usuário em tb_user
                        $query = "INSERT INTO tb_user (u_nome, u_email, u_senha, u_user) VALUES (:u_nome, :u_email, :u_senha, :u_user)";
                        $stmt = $this->conn->prepare($query);
                        $stmt->bindParam(':u_nome', $u_nome);
                        $stmt->bindParam(':u_email', $u_email);
                        $stmt->bindParam(':u_senha', $u_senha);
                        $stmt->bindParam(':u_user', $u_user);

                        if ($stmt->execute()) {
                            // Recupere o ID do usuário recém-inserido
                            $u_id = $this->conn->lastInsertId();
                            
                            // Em seguida, insira o professor em tb_professores
                            $query = "INSERT INTO tb_professores (p_ciap, p_block, u_id) VALUES (:p_ciap, :p_block, :u_id)";
                            $stmt = $this->conn->prepare($query);
                            $stmt->bindParam(':p_ciap', $p_ciap);
                            $stmt->bindParam(':p_block', $p_block);
                            $stmt->bindParam(':u_id', $u_id);

                            if ($stmt->execute()) {
                                // Confirme a transação
                                $this->conn->commit();
                                return true; // Inserção bem-sucedida
                            } else {
                                // Caso contrário, reverta a transação
                                $this->conn->rollback();
                                return false; // Não foi possível inserir o professor
                            }
                        } else {
                            // Caso contrário, reverta a transação
                            $this->conn->rollback();
                            return false; // Não foi possível inserir o usuário
                        }
                    } catch (PDOException $e) {
                        // Tratar erros de execução da query
                        echo 'Erro na inserção do professor: ' . $e->getMessage();
                        exit();
                    }
                }


                //função para retornar os dados de um professor com base no id fornecido
                public function getTeacherById($p_id) {
                    $sql = "SELECT u.u_nome, u.u_email, u.u_senha, p.p_ciap, p.p_block 
                            FROM tb_user u
                            INNER JOIN tb_professores p ON u.u_id = p.u_id
                            WHERE p.p_id = :p_id";
                
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bindParam(':p_id', $p_id, PDO::PARAM_INT);
                    $stmt->execute();
                
                    if ($stmt->rowCount() > 0) {
                        $dadosProfessor = $stmt->fetch(PDO::FETCH_ASSOC);
                    } else {
                        $dadosProfessor = null;
                    }
                
                    return $dadosProfessor; // Adicione esta linha para retornar os dados
                }
                
                
                //função para retornar o u_id
                public function getUserIdByTeacherId($p_id) {
                    $query = "SELECT u_id FROM tb_professores WHERE p_id = :p_id";
                    $stmt = $this->conn->prepare($query);
                    $stmt->bindParam(":p_id", $p_id);
                    $stmt->execute();
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    return $row['u_id'];
                }
                

                //função para atualizar um registro de professor no banco de dados
                public function updateTeacherr($u_id, $p_id, $u_nome, $u_email, $u_senha, $p_ciap, $p_block) {
                    try {
                        // Iniciar uma transação
                        $this->conn->beginTransaction();
                        
                        // Atualize a tabela tb_user usando u_id
                        $queryUser = "UPDATE tb_user SET u_nome = :u_nome, u_email = :u_email, u_senha = :u_senha WHERE u_id = :u_id";
                        $stmtUser = $this->conn->prepare($queryUser);
                        $stmtUser->bindParam(':u_nome', $u_nome);
                        $stmtUser->bindParam(':u_email', $u_email);
                        $stmtUser->bindParam(':u_senha', $u_senha);
                        $stmtUser->bindParam(':u_id', $u_id); // Use o u_id como referência
                        
                        // Atualize a tabela tb_professores usando p_id
                        $queryProfessores = "UPDATE tb_professores SET p_ciap = :p_ciap, p_block = :p_block WHERE p_id = :p_id";
                        $stmtProfessores = $this->conn->prepare($queryProfessores);
                        $stmtProfessores->bindParam(':p_ciap', $p_ciap);
                        $stmtProfessores->bindParam(':p_block', $p_block);
                        $stmtProfessores->bindParam(':p_id', $p_id); // Use o p_id como referência
                
                        $updateUserResult = $stmtUser->execute();
                        $updateProfessoresResult = $stmtProfessores->execute();
                
                        if ($updateUserResult && $updateProfessoresResult) {
                            // Confirme a transação
                            $this->conn->commit();
                            return true; // Atualização bem-sucedida
                        } else {
                            // Caso contrário, reverta a transação
                            $this->conn->rollback();
                            return false; // Ocorreu um erro na atualização
                        }
                    } catch (PDOException $e) {
                        // Tratar erros de execução da query
                        echo 'Erro na atualização: ' . $e->getMessage();
                        exit();
                    }
                }

                 // Função para atualizar um usuário e um professor em uma transação
                 public function updateUser($u_id, $u_nome, $u_email, $u_senha) {
                    $query = "UPDATE tb_user SET u_nome = :u_nome, u_email = :u_email, u_senha = :u_senha WHERE u_id = :u_id";
            
                    $stmt = $this->conn->prepare($query);
            
                    $stmt->bindParam(':u_id', $u_id);
                    $stmt->bindParam(':u_nome', $u_nome);
                    $stmt->bindParam(':u_email', $u_email);
                    $stmt->bindParam(':u_senha', $u_senha);
            
                    return $stmt->execute();
                }

                 // Função para atualizar um professor
                public function updateProfessor($p_id, $p_ciap, $p_block) {
                    $query = "UPDATE tb_professores SET p_ciap = :p_ciap, p_block = :p_block WHERE p_id = :p_id";

                    $stmt = $this->conn->prepare($query);

                    $stmt->bindParam(':p_id', $p_id);
                    $stmt->bindParam(':p_ciap', $p_ciap);
                    $stmt->bindParam(':p_block', $p_block);

                    return $stmt->execute();
                }                                           

            //função para excluir um professor no banco de dados           
            public function deleteTeacherAndAdminRelations($p_id) {
                try {
                    $this->conn->beginTransaction();
            
                    // Primeiro, exclua os registros na tabela tb_administradores que dependem do professor
                    $queryAdmins = "DELETE FROM tb_administradores WHERE u_id = :u_id";
                    $stmtAdmins = $this->conn->prepare($queryAdmins);
                    $stmtAdmins->bindParam(':u_id', $p_id, PDO::PARAM_INT);
            
                    if ($stmtAdmins->execute()) {
                        // Agora, exclua o professor e o registro correspondente na tabela tb_user
                        $queryTeachers = "DELETE FROM tb_professores WHERE p_id = :p_id";
                        $stmtTeachers = $this->conn->prepare($queryTeachers);
                        $stmtTeachers->bindParam(':p_id', $p_id, PDO::PARAM_INT);
            
                        if ($stmtTeachers->execute()) {
                            // Confirme a transação
                            $this->conn->commit();
                            return true; // Exclusão bem-sucedida
                        } else {
                            // Caso contrário, reverta a transação
                            $this->conn->rollback();
                            return false; // Não foi possível excluir o professor
                        }
                    } else {
                        // Caso contrário, reverta a transação
                        $this->conn->rollback();
                        return false; // Não foi possível excluir os registros na tabela tb_administradores
                    }
                } catch (PDOException $e) {
                    // Tratar erros de execução da query
                    echo 'Erro na exclusão do professor e registros na tabela tb_administradores: ' . $e->getMessage();
                    exit();
                }
            }
            
            //função para listar os professores cadastrados
            public function listTeacher() {
                try {
                    $sql = "SELECT tb_professores.p_id, tb_user.u_id, tb_user.u_nome, tb_user.u_email, tb_professores.p_ciap
                    FROM tb_user 
                    INNER JOIN tb_professores ON tb_user.u_id = tb_professores.u_id";
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

            //função para validação de login
            public function checkLogin($u_email, $u_senha) {
                $sql = "SELECT u.u_id, u.u_nome, u.u_email, u.u_senha, u.u_user
                        FROM tb_user u
                        WHERE u.u_email = :u_email AND u.u_senha = :u_senha";
            
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':u_email', $u_email, PDO::PARAM_STR);
                $stmt->bindParam(':u_senha', $u_senha, PDO::PARAM_STR);
                $stmt->execute();
            
                if ($stmt->rowCount() > 0) {
                    return $stmt->fetch(PDO::FETCH_ASSOC);
                } else {
                    return null;
                }
            }

            //função para retornar os professores para o cadastro de um trabalho
            public function getAllTeachers()
                {
                    $sql = "SELECT tb_professores.p_id, tb_user.u_nome
                    FROM tb_user 
                    INNER JOIN tb_professores ON tb_user.u_id = tb_professores.u_id"; 

                    $stmt = $this->conn->prepare($sql);
                    $stmt->execute();

                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
                }

                public function isEmailRegistered($u_email)
                {
                    try {
                        $query = "SELECT COUNT(*) as count FROM tb_user WHERE u_email = :u_email";
                        $stmt = $this->conn->prepare($query);
                        $stmt->bindParam(':u_email', $u_email);
                        $stmt->execute();
                        
                        $result = $stmt->fetch(PDO::FETCH_ASSOC);
                        return $result['count'] > 0;
                    } catch (PDOException $e) {
                        // Trate qualquer erro de banco de dados aqui
                        return false;
                    }
                }

                //função para verificar se o SIAPE informado já existe
                public function isCiapRegistered($p_ciap)
                    {
                        $query = "SELECT COUNT(*) as count FROM tb_professores WHERE p_ciap = :p_ciap";
                        $stmt = $this->conn->prepare($query);
                        $stmt->bindParam(':p_ciap', $p_ciap);
                        $stmt->execute();
                        $result = $stmt->fetch(PDO::FETCH_ASSOC);

                        return ($result['count'] > 0); // Retorna true se o SIAPE já está registrado
                    }
}

?>