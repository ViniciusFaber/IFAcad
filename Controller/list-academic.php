<?php

//fazendo conexão com o banco de dados
require_once '../DataBase/conexao.php';
require_once '../DAO/academicDAO.php';

function listAcademic() {
    // Cria uma instância da classe Conexao
    $conexao = new Conexao();
    $conn = $conexao->conectar();

    // Cria uma instância da classe DAO
    $academicDAO = new AcademicDAO($conn);

    // Obtém a lista
    $academics = $academicDAO->listAcademic();

    if (count($academics) > 0) {
        foreach ($academics as $academic) {
            echo "<tr>";
            echo "<td>".$academic['ac_id']."</td>";
            echo "<td>".$academic['ac_nome']."</td>";
            echo "<td>".$academic['ac_ra']."</td>";
            echo "<td>".$academic['c_nome']."</td>";                    

            // Verificar se o usuário é um administrador para exibir o ícone de exclusão
            if ($_SESSION['user_type'] === 'administrador') {
                echo "<td><a href='../View/academic-update.php?ac_id=" . $academic['ac_id'] . "'><i class='fa fa-pencil-square-o fa-lg' aria-hidden='true' style='color: #264811;'></i></a> | <a href='#' onclick='confirmarExclusao(" . $academic['ac_id'] . ", \"" . $academic['ac_nome'] . "\")'><i class='fa fa-trash-o fa-lg' aria-hidden='true' style='color: #D70C0C;'></i></a></td>";
                echo "</tr>";  
            }
             
           
            if ($_SESSION['user_type'] === 'professor') {
                echo "<td><a href='../View/academic-update.php?ac_id=" . $academic['ac_id'] . "'><i class='fa fa-pencil-square-o fa-lg' aria-hidden='true' style='color: #264811;'></i></a></td>";
                echo "</tr>"; 
            }       
                                    
        }
    } else {
        echo "Nenhum acadêmico cadastrado.";
    }
    // Fecha a conexão com o banco de dados
    $conexao->fecharConexao();
}

listAcademic();

?>
