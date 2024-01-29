<?php
// Verificar se uma sessão já está ativa
if (session_status() == PHP_SESSION_NONE) {
    // Se não estiver ativa, iniciar a sessão
    session_start();
}

// Verificar se o parâmetro de pesquisa está presente na URL
if (!isset($_GET['query'])) {
    // Redirecionar de volta para a página de pesquisa se o parâmetro estiver ausente
    header("Location: ../index.php");
    exit();
}

// Recuperar o termo de pesquisa da URL
$termo_pesquisa = '%' . $_GET['query'] . '%';

// Recuperar os resultados da URL e decodificar o JSON
$resultados = json_decode(urldecode($_GET['resultados']), true);
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Resultados da Busca</title>
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
        <div class="if-align">
            <p class="if-text">Pesquisa</p>
            <hr class="if-hr-align">
        </div>

        <div class="if-div-presentation-text">
                    Utilize o campo abaixo para pesquisar por trabalhos considerando: título, autor principal, data da defesa e cursos.
                </div>
                

            <!-- Formulário de pesquisa -->
            <form action="../Controller/process-search.php" method="GET">
                <!-- Campo de pesquisa com ícone de lupa -->
                <div class="if-div-search">
                    <input class="if-input-search" type="text" name="query" placeholder="Buscar no repositório.." value="<?php echo isset($_GET['query']) ? htmlspecialchars($_GET['query']) : ''; ?>">
                    <button type="submit" class="if-button-search"><i class="fas fa-search"></i></button>
                </div>
            </form>
 

        <div style="width: 90%; margin: 0 auto;">
            <div class="card-header" style="background-color: #C6D7BC;">Resultados da busca</div>
            <div class="table-container">
                <div class="table-responsive">
                    <table class="table table-bordered if-table text-center">
                        <thead>
                            <tr>
                                <th class="if-th-recent-title">Título</th>
                                <th>Autores</th>
                                <th class="if-th-recent-defense">Data da defesa</th>
                                <th>Curso</th>
                                <th class="if-th-recent-view">Detalhes</th>
                            </tr>
                        </thead>
                        <tbody>                                    
                            
                            <?php
                            // Loop através dos resultados e exiba cada linha na tabela
                            foreach ($resultados as $resultado) {
                                echo "<tr>";
                                echo "<td>{$resultado['t_titulo']}</td>";
                                echo "<td>{$resultado['ac_nome']}</td>";
                                echo "<td>{$resultado['t_data_def']}</td>";
                                echo "<td>{$resultado['c_nome']}</td>";
                                echo "<td><a href='../View/work-details.php?t_id=".$resultado['t_id']."'><i class='fa fa-folder-open-o fa-2x' aria-hidden='true' style='color: #264811;'></i></a></td>";
 
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>  

    </main>     

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
