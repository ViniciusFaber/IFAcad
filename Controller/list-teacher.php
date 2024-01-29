<?php
//fazendo conexão com o banco de dados
require_once '../DataBase/conexao.php';
require_once '../DAO/teacherDAO.php';

// Função para listar os Professores cadastrados
function listTeacher() {
    // Cria uma instância da classe Conexao
    $conexao = new Conexao();
    $conn = $conexao->conectar();

    // Cria uma instância da classe DAO
    $teacherDAO = new TeacherDAO($conn);

    // Obtém a lista
    $teachers = $teacherDAO->listTeacher();

    // Verifica se há professores cadastrados
    if (count($teachers) > 0) {
        foreach ($teachers as $teacher) {
            echo "<tr>";
            echo "<td>".$teacher['p_id']."</td>";
            //echo "<td>".$teacher['u_id']."</td>";
            echo "<td>".$teacher['u_nome']."</td>";
            echo "<td>".$teacher['u_email']."</td>";
            echo "<td>".$teacher['p_ciap']."</td>";
        
             // Verificar se o usuário é um administrador para decidir se mostra o bloco
             if ($_SESSION['user_type'] === 'administrador') {
                echo "<td><a href='../View/teacher-update.php?p_id=" . $teacher['p_id'] . "'><i class='fa fa-pencil-square-o fa-lg' aria-hidden='true' style='color: #264811;'></i></a> | <a href='#' onclick='confirmarExclusao(" . $teacher['p_id'] . ", \"" . $teacher['u_nome'] . "\")'><i class='fa fa-trash-o fa-lg' aria-hidden='true' style='color: #D70C0C;'></i></a></td>";
                echo "</tr>";
            }
        }
    } else {
        echo "Nenhum professor cadastrado.";
    }
    // Fecha a conexão com o banco de dados
    $conexao->fecharConexao();
}

listTeacher();

?>
