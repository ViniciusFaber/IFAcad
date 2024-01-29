<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Repositório Acadêmico IFAcad</title>
        <link href="View/css/styles.css" rel="stylesheet">       
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">          
        <link rel="shortcut icon" href="view/img/icone.png" type="image/x-icon">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400&display=swap" rel="stylesheet">
        <script src="https://kit.fontawesome.com/d553081878.js" crossorigin="anonymous"></script>
    </head>  
    <body> 
    <header>
    <?php session_start(); ?>
    <nav class="sb-topnav navbar navbar-expand if-div-menu">
        <div class="d-flex align-items-center if-div-menu">
            <a class="mr-3 if-a-logo"><img src="View/img/icone.png" alt="Logo"></a>
            <a class="mr-3 if-a-menu" href="index.php">Início</a>
            <a class="mr-3 if-a-menu" href="View/about.php">Sobre</a>        
        </div>
        <div class="text-center flex-grow-1 if-div-menu">IFAcad</div>
        <div class="d-flex align-items-center ml-auto if-div-menu">
            
        <?php
        if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'professor') {
            echo '<a class="ml-3 if-a-enter" href="View/teacher-home.php">Área do Professor <a href="Controller/logout.php" class="ml-2"><i class="fas fa-sign-out-alt"></i></a></a>';
        } elseif (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'administrador') {
            echo '<a class="ml-3 if-a-enter" href="View/administrator-home.php">Área do Administrador <a href="Controller/logout.php" class="ml-2"><i class="fas fa-sign-out-alt"></i></a></a>';
        } else {
            echo '<a class="ml-3 if-a-enter" href="View/login.php">Entrar</a>';
        }
        ?>
        </div>
    </nav>
    </header>                                                     
            <main>        
                <?php if(isset($_GET['acesso_nao_autorizado'])){ ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                Você não tem autorização<strong>tente novamente, ou comunique o administrador!</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                <?php } ?>       
                <div class="if-div-top">
                    <img class="if-img-logo" src="view/img/logo.png" alt="">
                    <div class="if-div-title-start">
                        <span><strong>IFAcad</strong><br>Repositório Acadêmico</span>                        
                    </div>
                </div>                
                <div class="if-div-presentation-text">
                    <p>
                    Este repositório permite que você tenha acesso ao acervo digital de trabalhos acadêmicos do IFPR - Campus Palmas, que compreende a trabalhos de conclusão de curso e relatórios de estágio  disponibilizados gratuitamente à comunidade em geral.
                    </p>                    
                </div>
                <div class="if-div-presentation-text">
                    Utilize o campo abaixo para pesquisar por trabalhos considerando: título, autor principal, data da defesa e cursos.
                </div>

            <!-- Formulário de pesquisa -->
                <form action="Controller/process-search.php" method="GET">
                    <!-- Campo de pesquisa com ícone de lupa -->
                    <div class="if-div-search">
                        <input class="if-input-search" type="text" name="query" placeholder="Buscar no repositório..">
                        <button type="submit" class="if-button-search"><i class="fas fa-search"></i></button>
                    </div>
                </form>            
            
        </div>

        <!-- tabela trabalhos recentes -->
        <div style="width: 90%; margin: 0 auto;">
                <div class="card-header" style="background-color: #C6D7BC;">Adicionados recentemente</div>
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
                                <tfoot>
                                    <!-- Rodapé da tabela (se necessário) -->
                                </tfoot>
                                <tbody>
                                <?php require_once 'Controller/list-recent.php';?> 
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>                           
                </main>     
                <?php include_once("View/baseboard.php");?>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>      
    </body>
</html>