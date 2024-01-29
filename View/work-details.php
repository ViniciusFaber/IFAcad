<?php
// Verificar se uma sessão já está ativa
if (session_status() == PHP_SESSION_NONE) {
    // Se não estiver ativa, iniciar a sessão
    session_start();
}

require_once __DIR__ . '/../DataBase/conexao.php';
require_once __DIR__ . '/../DAO/workDAO.php';

// Criar uma instância da conexão com o banco de dados
$conexao = new Conexao();
$conn = $conexao->conectar();
$workDao = new WorkDAO($conn);

// Verificar se o parâmetro t_id foi passado na URL
if (isset($_GET['t_id'])) {
    // Obtém detalhes do trabalho com base no t_id passado
    $workDetails = $workDao->getWorkDetailsById($_GET['t_id']);
} else {
    // Se não houver t_id na URL, redirecionar para uma página de erro ou outra página apropriada
    header("Location: index.php?erro");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="" 
    <meta name="author" content="">
    <title>Detalhes do trabalho</title>
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
    <nav class="sb-topnav navbar navbar-expand if-div-menu">
        <div class="d-flex align-items-center if-div-menu">
            <a class="mr-3 if-a-logo"><img src="img/icone.png" alt="Logo"></a>
            <a class="mr-3 if-a-menu" href="../index.php">Início</a>
            <a class="mr-3 if-a-menu" href="about.php">Sobre</a>        
        </div>
        <div class="text-center flex-grow-1 if-div-menu">IFAcad</div>
        <div class="d-flex align-items-center ml-auto if-div-menu">
    <?php
        if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'professor') {
            echo '<a class="ml-3 if-a-enter" href="teacher-home.php">Área do Professor <a href="Controller/logout.php" class="ml-2"><i class="fas fa-sign-out-alt"></i></a></a>';
        } elseif (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'administrador') {
            echo '<a class="ml-3 if-a-enter" href="administrator-home.php">Área do Administrador <a href="Controller/logout.php" class="ml-2"><i class="fas fa-sign-out-alt"></i></a></a>';
        } else {
            echo '<a class="ml-3 if-a-enter" href="login.php">Entrar</a>';
        }
        ?>
    </header>

    <main>
        <div class="container-fluid">
            <?php foreach ($workDetails as $work) { ?>
                <h5 class="card-title" style="font-size: 36px; text-align: left; margin-top: 20px; margin-bottom: 20px;"><?php echo isset($work['t_titulo']) ? $work['t_titulo'] : ''; ?></h5>
                <div class="card mb-4">
                    <div class="card-body">
                        <p class="card-text">
                        <i class="fa fa-bars" aria-hidden="true" style='color: #637B54; margin-right: 10px'></i>
                        <strong>Especificação: </strong><?php echo isset($work['t_tipo']) ? $work['t_tipo'] : ''; ?></p>
                        
                        <p class="card-text">
                        <i class="fa fa-user-circle-o" aria-hidden="true" style='color: #637B54; margin-right: 10px'></i>
                        <strong>Autores: </strong><?php echo isset($work['t_acad']) ? $work['t_acad'] : ''; ?>, </strong><?php echo isset($work['t_acad2']) ? $work['t_acad2'] : ''; ?></p>

                        <p class="card-text">
                        <i class="fa fa-text-height" aria-hidden="true" style='color: #637B54; margin-right: 10px'></i>
                        <strong>Palavras-chave: </strong><?php echo isset($work['t_palavra_c']) ? $work['t_palavra_c'] : ''; ?></p>

                        <p class="card-text">
                        <i class="fa fa-calendar-o" aria-hidden="true" style='color: #637B54; margin-right: 10px'></i>
                        <strong>Defendido em: </strong><?php echo isset($work['t_data_def']) ? $work['t_data_def'] : ''; ?></p>

                        <p class="card-text">
                        <i class="fa fa-user-o" aria-hidden="true" style='color: #637B54; margin-right: 10px'></i>
                        <strong>Orientador(a): </strong><?php echo isset($work['t_prof_nome']) ? $work['t_prof_nome'] : ''; ?></p>

                        <p class="card-text">
                        <i class="fa fa-users" aria-hidden="true" style='color: #637B54; margin-right: 5px'></i>
                        <strong>Banca: </strong><?php echo isset($work['t_banca']) ? $work['t_banca'] : ''; ?></p>

                        <p class="card-text">
                        <i class="fa fa-shopping-bag" aria-hidden="true" style='color: #637B54; margin-right: 8px'></i>
                        <strong>Curso: </strong><?php echo isset($work['nome_curso']) ? $work['nome_curso'] : ''; ?></p>

                        <hr>
                        
                        <p style="font-size: 20px;"><strong>Arquivos (download)</strong></p>

                        <div class="form-group mt-4 mb-0">
                            <a  href="<?php echo isset($work['t_doc']) ? $work['t_doc'] : '#'; ?>" class="btn btn-success" target="_blank" download>
                                Clique para visualizar o documento
                            </a>
                        </div>

                        <hr>

                        <p style="font-size: 20px;"><strong>Resumo:</strong></p>
                        <p class="card-text"><?php echo isset($work['t_resumo']) ? $work['t_resumo'] : 'Nenhum resumo disponível.'; ?></p>

                        <hr>

                        <p style="font-size: 20px;"><strong>Idioma:</strong></p>
                        <p class="card-text"><?php echo isset($work['t_idioma']) ? $work['t_idioma'] : 'Idioma não especificado.'; ?></p>

                        <hr>

                        <p style="font-size: 20px;"><strong>Como citar:</strong></p>
                        <p class="card-text"><?php echo isset($work['t_citar']) ? $work['t_citar'] : 'Nenhuma citação disponível.'; ?></p>                      
                    </div>
                </div>
            <?php } ?>
        </div>
    </main>
    <footer>
        <?php include_once("baseboard.php"); ?><!--inclusão do rodapé-->
    </footer>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/datatables-demo.js"></script>
</body>
</html>
