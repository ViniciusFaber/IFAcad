<?php
//fazendo conexão com o banco de dados
require_once __DIR__ . '/../DataBase/conexao.php';
require_once __DIR__ . '/../DAO/workDAO.php';

function listRecent() {
    // Cria uma instância da classe Conexao
    $conexao = new Conexao();
    $conn = $conexao->conectar();

    // Cria uma instância da classe DAO
    $workDAO = new WorkDAO($conn);

    // Obtém a lista
    $works = $workDAO->listRecent();

    if (count($works) > 0) {
        foreach ($works as $works) {
            echo "<tr>";
            
            echo "<td>".$works['t_titulo']."</td>";
            echo "<td>".$works['ac_nome']."</td>";
            echo "<td>".$works['t_data_def']."</td>";
            echo "<td>".$works['nome_curso']."</td>";

            
            echo "<td><a href='View/work-details.php?t_id=".$works['t_id']."'><i class='fa fa-folder-open-o fa-2x' aria-hidden='true' style='color: #264811;'></i></a></td>";
            
            echo "</tr>";
        }
    } else {
        echo "Nenhum trabalho cadastrado.";
    }
    // Fecha a conexão com o banco de dados
    $conexao->fecharConexao();
}

listRecent();

?>
