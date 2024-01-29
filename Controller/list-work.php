<?php
//fazendo conexão com o banco de dados
require_once '../DataBase/conexao.php';
require_once '../DAO/workDAO.php';

function listWork() {
    // Cria uma instância da classe Conexao
    $conexao = new Conexao();
    $conn = $conexao->conectar();

    // Cria uma instância da classe DAO
    $workDAO = new WorkDAO($conn);

    // Obtém a lista
    $works = $workDAO->listWork();

    if (count($works) > 0) {
        foreach ($works as $works) {
            echo "<tr>";
            echo "<td>".$works['t_id']."</td>";
            echo "<td>".$works['t_titulo']."</td>";
            echo "<td>".$works['ac_nome']."</td>";
            echo "<td>".$works['t_data_def']."</td>";
            echo "<td>".$works['nome_curso']."</td>";
                        
            //se for administrador
            if ($_SESSION['user_type'] === 'administrador') {
                echo "<td><a href='../View/work-update.php?t_id=" . $works['t_id'] . "'><i class='fa fa-pencil-square-o fa-lg' aria-hidden='true' style='color: #264811;'></i></a> | <a href='#' onclick='confirmarExclusao(" . $works['t_id'] . ", \"" . $works['t_titulo'] . "\")'><i class='fa fa-trash-o fa-lg' aria-hidden='true' style='color: #D70C0C;'></i></a></td>";
                
            }
             
           //se for professor
            if ($_SESSION['user_type'] === 'professor') {
                echo "<td><a href='../View/work-update.php?t_id=" . $works['t_id'] . "'><i class='fa fa-pencil-square-o fa-lg' aria-hidden='true' style='color: #264811;'></i></a></td>";
                
            }

            echo "<td><a href='".$works['t_doc']."' target='_blank'><i class='fa fa-file-text-o fa-2x' aria-hidden='true' style='color: #264811;'></i></a></td>";
            
            echo "</tr>";
        }
    } else {
        echo "Nenhum trabalho cadastrado.";
    }
    // Fecha a conexão com o banco de dados
    $conexao->fecharConexao();
}

listWork();

?>
