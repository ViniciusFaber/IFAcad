<?php
require_once '../DataBase/conexao.php';

$conexao = new Conexao();
$conn = $conexao->conectar();

if (session_status() == PHP_SESSION_NONE) {
    // Se não estiver ativa, iniciar a sessão
    session_start();
}

// Realizar a consulta ao banco de dados para obter os trabalhos orientados pelo professor
if ($_SESSION['user_type'] === 'professor') {

    $user_id = $_SESSION['user_id'];

    $sql = "SELECT t.t_titulo, a.ac_nome, t.t_data_def, tb_cursos.c_nome as nome_curso 
        FROM tb_trabalhos t
        LEFT JOIN tb_academicos a ON t.t_acad = a.ac_id
        LEFT JOIN tb_professores p ON t.t_prof = p.p_id
        INNER JOIN tb_cursos ON a.ac_curso = tb_cursos.c_id
        WHERE t.t_prof = :p_id
        LIMIT 0, 1000";

        try {
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':p_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            $trabalhosOrientados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro na consulta: " . $e->getMessage();
        }

}



?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Acesso rápido do professor</title>
        <link href="css/styles.css" rel="stylesheet">       
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">          
        <link rel="shortcut icon" href="img/icone.png" type="image/x-icon">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400&display=swap" rel="stylesheet">
        <script src="https://kit.fontawesome.com/d553081878.js" crossorigin="anonymous"></script>
        
    </head> 

    <body> 
    <header>
    <?php include_once("top.php");?><!--para incluir apenas uma vez esse arquivo--> 
    </header>   
     <div id="layoutSidenav">
        <?php include_once("menu.php");?>
            <div id="layoutSidenav_content">                                                  
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Trabalhos orientados</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item">
                                <?php
                                                                
                                if ($_SESSION['user_type'] === 'professor') {
                                    echo '<a href="teacher-home.php">Home (Professor)</a>';
                                } elseif ($_SESSION['user_type'] === 'administrador') {
                                    echo '<a href="administrator-home.php">Home (Administrador)</a>';
                                } else {
                                    echo '<a href="../index.php">Home</a>';
                                }
                                ?>
                            </li>
                            <li class="breadcrumb-item active">Trabalhos orientados</li>
                        </ol>
                        
                        <div class="card mb-4">
                            <div class="card-body">
								<a href="work-register.php" type="button" class="btn btn-outline-primary">+ Trabalho</a>
							</div>
                        </div>
                        
                        <div class="card mb-4">
                            <div class="card-header"><i class="fa fa-list-ul"></i> Lista de Trabalhos orientados por você</div>

                            <?php if(isset($_GET['acesso_nao_autorizado'])){ ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                Seu perfil não tem permissão de acesso. Tente novamente ou comunique o administrador!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <?php } ?>
                            <div class="card-body text-center">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Título</th>
                                                <th>Autores</th>
                                                <th>Data da defesa</th>
                                                <th>Curso</th>
                                                <th>Visualizar</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <!--colocar a requisição do controller-->
                                        </tfoot>
                                        <tbody>
                                            <?php foreach ($trabalhosOrientados as $trabalho): ?>
                                                <tr>    
                                                    <td><?php echo $trabalho['t_titulo']; ?></td>
                                                    <td><?php echo $trabalho['ac_nome'] . ' - ' . $trabalho['c_nome']; ?></td>
                                                    <td><?php echo $trabalho['t_data_def']; ?></td>
                                                    <!-- Adicione mais colunas conforme necessário -->
                                                    <td> <!-- Coluna para o curso, adicione conforme necessário --> </td>
                                                    <td>
                                                        <a href="visualizar-trabalho.php?t_id=<?php echo $trabalho['t_id']; ?>" class="btn btn-info btn-sm">Visualizar</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                </div>
                            </div>                
                        </main>
                    </div>
                </div>
            <footer>
            <?php include_once("baseboard.php"); ?>
        </footer>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>      
    </body>
</html>