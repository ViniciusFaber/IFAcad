<?php
// Verificar se uma sessão já está ativa
if (session_status() == PHP_SESSION_NONE) {
    // Se não estiver ativa, iniciar a sessão
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Listagem de cursos</title>
    <link href="css/styles.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="shortcut icon" href="img/icone.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/d553081878.js" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <?php include_once("top.php"); ?>
    </header>

    <div id="layoutSidenav">
        <?php include_once("menu.php"); ?>

        <div id="layoutSidenav_content">
            <main>
                <div class="container">
                    <h1 class="mt-4">Curso</h1>
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
                        <li class="breadcrumb-item active">Curso</li>
                    </ol>

                    <?php
                        // Verificar se o usuário é um administrador para decidir se mostra o bloco
                        if ($_SESSION['user_type'] === 'administrador') {
                            echo '<div class="card mb-4">
                                    <div class="card-body">
                                        <a href="course-register.php" type="button" class="btn btn-outline-primary">+ Curso</a>
                                    </div>
                                </div>';
                        }
                    ?>  
                    <div class="card mb-4">
                        <div class="card-header"><i class="fa fa-list-ul"></i> Lista de Cursos</div>
                        <?php if(isset($_GET['erro'])){ ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                Não foi possível realizar o cadastro do Curso. Tente novamente!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php } ?>
                        <?php if(isset($_GET['existe'])){ ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                Este Curso já está cadastrado. Tente novamente!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php } ?>
                        <?php if(isset($_GET['sucesso'])){ ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                Curso cadastrado com <strong>sucesso!</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php } ?>
                        <?php if(isset($_GET['excluir-sucesso'])){ ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                Curso excluído com <strong>sucesso!</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php } ?>
                        <?php if(isset($_GET['update'])){ ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                Curso atualizado com <strong>sucesso!</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php } ?>
                        <?php if(isset($_GET['update-erro'])){ ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                Não foi possível atualizar o Curso <strong>tente novamente!!</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php } ?>
                        <?php if(isset($_GET['excluir-erro'])){ ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                Não foi possível excluir o Curso <strong>tente novamente!</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="card-body text-center">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Código</th>
                                        <th>Nome</th>
                                        <?php
                                            // Verificar se o usuário é um administrador para decidir se mostra o bloco
                                            if ($_SESSION['user_type'] === 'administrador') {
                                                echo '<th>Ações</th>';
                                            }
                                        ?>   
                                    </tr>
                                </thead>
                                <tfoot>
                                    
                                </tfoot>
                                <tbody>
                                <?php
                                    // Inclua o arquivo que contém os dados da tabela
                                    include_once('../Controller/list-course.php');
                                    ?>
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
    <script>
        //script para a verificação da exclusão
        function confirmarExclusao(c_id, c_nome) {
            if (confirm("Tem certeza de que deseja excluir o curso com ID " + c_id + " (" + c_nome + ")?")) {
                window.location.href = "../Controller/delete-course.php?c_id=" + c_id;
            } else {
                window.location.href = "../View/course-list.php?exclusao=cancelada";
            }
        }
    </script>
</body>
</html>
