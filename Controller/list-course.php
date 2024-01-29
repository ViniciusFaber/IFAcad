<?php
//fazendo conexão com o banco de dados
require_once '../DataBase/conexao.php';
require_once '../DAO/courseDAO.php';

// Função para listar os Cursos cadastrados
function listCourse() {
    // Cria uma instância da classe Conexao
    $conexao = new Conexao();
    $conn = $conexao->conectar();

    // Cria uma instância da classe cursoDAO
    $courseDAO = new CourseDAO($conn);

    // Obtém a lista de cursos
    $courses = $courseDAO->listCourse();

    // Verifica se há cursos cadastrados
    if (count($courses) > 0) {
        foreach ($courses as $course) {
            echo "<tr>";
            echo "<td>".$course['c_id']."</td>";
            echo "<td>".$course['c_nome']."</td>";
            
             // Verificar se o usuário é um administrador para decidir se mostra o bloco
             if ($_SESSION['user_type'] === 'administrador') {
                echo "<td><a href='../View/course-update.php?c_id=" . $course['c_id'] . "'><i class='fa fa-pencil-square-o fa-lg' aria-hidden='true' style='color: #264811;'></i></a> | <a href='#' onclick='confirmarExclusao(" . $course['c_id'] . ", \"" . $course['c_nome'] . "\")'><i class='fa fa-trash-o fa-lg' aria-hidden='true' style='color: #D70C0C;'></i></a></td>";
                echo "</tr>";
            }
        }
    } else {
        echo "Nenhum usuário cadastrado.";
    }
    // Fecha a conexão com o banco de dados
    $conexao->fecharConexao();
}

listCourse();

?>
