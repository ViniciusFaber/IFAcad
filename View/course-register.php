<?php
// Verificar se uma sessão já está ativa
if (session_status() == PHP_SESSION_NONE) {
    // Se não estiver ativa, iniciar a sessão
    session_start();
}

// Verificar se o usuário não está logado ou se não é um administrador
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'administrador') {
    // Redirecionar para uma página de acesso não autorizado
    header("Location: teacher-home.php?acesso_nao_autorizado");
    exit();
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
    <title>Cadastro de curso</title>
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

                    <div class="card mb-4">
                        <div class="card-body">
                            <a href="course-list.php" type="button" class="btn btn-outline-success">Lista de Cursos</a>
                        </div>
                    </div>

                    <!-- Mensagens de erro ou sucesso (caso existam) -->
                    <?php if (isset($_GET['erro'])) { ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Não foi possível realizar o cadastro do Curso. <strong>Tente novamente!</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php } ?>

                    <?php if (isset($_GET['existe'])) { ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Este Curso já está cadastrado. <strong>Tente novamente!</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php } ?>

                    <?php if (isset($_GET['sucesso'])) { ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            Curso cadastrado com <strong>sucesso!</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php } ?>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fa fa-university fa-lg" aria-hidden="true" style="color: #637B54;"></i> Cadastrar curso
                        </div>
                        <div class="card-body">
                            <form action="../Controller/controller-course.php" method="POST">
                               
                                <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <label class="small mb-1" for="name_curso">Nome:</label>
                                    <input class="form-control" name="name_curso" id="name_curso" value="" type="text" placeholder="Informe o nome do curso" required/>
                                    </div>
                                </div>
                            </div>

                                <div class="form-group mt-4 mb-0">
                                <button type="submit" name="bnt-cadastrar" class="btn btn-success" aria-label="Cadastrar novo item">Cadastrar</button>
                                </div>
                            </form>
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
