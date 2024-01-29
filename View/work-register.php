<?php
// Verificar se uma sessão já está ativa
if (session_status() == PHP_SESSION_NONE) {
    // Se não estiver ativa, iniciar a sessão
    session_start();
}
require_once '../DataBase/conexao.php';
require_once '../Model/academic-model.php';
require_once '../Model/teacher-model.php';

// Criar uma instância da conexão com o banco de dados
$conexao = new Conexao();
$conn = $conexao->conectar();

$academicModel = new AcademicModel($conn);
$academics = $academicModel->getAllAcademics();

$teacherModel = new TeacherModel($conn);
$teachers = $teacherModel->getAllTeachers();

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Cadastro de trabalho</title>
        <link href="css/styles.css" rel="stylesheet">       
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">          
        <link rel="shortcut icon" href="img/icone.png" type="image/x-icon">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet">
        <script src="https://kit.fontawesome.com/d553081878.js" crossorigin="anonymous"></script>
    </head> 
    <body> 
    <header>
    <?php include_once("top.php");?><!--inclusão do topo--> 
    </header>                                                     
    <div id="layoutSidenav">
    <?php include_once("menu.php");?><!--inclusão do menu lateral-->
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid">
                <h1 class="mt-4">Trabalho</h1>
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
                            <li class="breadcrumb-item active">Trabalho</li>
                        </ol>
                <div class="card mb-4">
                    <div class="card-body">
                        <a href="work-list.php" type="button" class="btn btn-outline-success">Lista de Trabalho</a>
                    </div>
                </div>
                <!--mensagens de erro ou sucesso-->
                <?php if(isset($_GET['erro'])){?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Não foi possível realizar o cadastro do Trabalho. <strong>Tente novamente!</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php } ?>
                
                <?php if(isset($_GET['existe'])){ ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Este Trabalho já está cadastrado. <strong>Tente novamente!</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php } ?>

                <?php if(isset($_GET['sucesso'])){ ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Trabalho cadastrado com <strong>sucesso!</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php } ?>

                <div class="card mb-4">
                    <div class="card-header"><i class="fa fa-book fa-lg" aria-hidden="true" style="color: #637B54;"></i></i> Cadastrar trabalho</div>
                    <div class="card-body">
                        <form action="../Controller/controller-work.php" method="POST" enctype="multipart/form-data">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="t_titulo">Título:</label>
                                        <input class="form-control" name="t_titulo" id="t_titulo" value="" type="text" placeholder="Informe o título do trabalho" required/>
                                    </div>
                                </div>                        
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="t_data_def">Data de defesa:</label>
                                        <input class="form-control" name="t_data_def" id="t_data_def" value="" type="date" placeholder="Informe a data de defesa do trabalho" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="t_tipo">Tipo de trabalho:</label>
                                        <select class="form-control" name="t_tipo" id="t_tipo" required>
                                            <option value="" disabled selected>Selecione o tipo de trabalho</option>
                                            <option value="Relatório de estágio">Relatório de estágio</option>
                                            <option value="Trabalho de conclusão de curso">Trabalho de conclusão de curso</option>  
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="t_palavra_c">Palavras-chave (até 5 palavras):</label>
                                        <input class="form-control" name="t_palavra_c" id="t_palavra_c" value="" type="text" placeholder="Informe as palavras-chave do trabalho" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="t_banca01">Banca - 1° avaliador:</label>
                                        <input class="form-control" name="t_banca01" id="t_banca01" value="" type="text" placeholder="Informe o nome completo do 1° avaliador" required/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <label class="small mb-1" for="t_banca02">2° avaliador:</label>
                                    <input class="form-control" name="t_banca02" id="t_banca02" value="" type="text" placeholder="Informe o nome completo do 2° avaliador" required/>
                                    </div>
                                </div>
                            </div> 
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">   
                                    <label class="small mb-1" for="t_banca03">3° avaliador:</label>                                    
                                        <input class="form-control" name="t_banca03" id="t_banca03" value="" type="text" placeholder="Informe o nome completo do 3° avaliador" required/>
                                    </div>
                                </div>       
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="t_idioma">Idioma (apenas a sigla):</label>
                                        <input class="form-control" name="t_idioma" id="t_idioma" value="" type="text" placeholder="Informe o idioma do trabalho" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="t_resumo">Resumo:</label>
                                        
                                        <textarea class="form-control" name="t_resumo" id="t_resumo" rows="8" cols="50" placeholder="Informe o resumo do trabalho" required></textarea>
                                    </div>
                                </div>                            
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="t_citar">Como citar:</label>
                                        <textarea class="form-control" name="t_citar" id="t_citar" rows="8" cols="50"  placeholder="Informe o resumo do trabalho" required>SOBRENOME, nome. Título: subtítulo (se houver). ano de depósito (capa). Número de folhas ou volumes. Tipo do trabalho (Categoria e área de concentração - Ex: Licenciatura em Pedagogia) - Instituição, Local, ano da defesa.
                                        </textarea>
                                    </div>
                                </div>
                            </div>               
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="t_acad">Autor principal do trabalho:</label>
                                        <select class="form-control" name="t_acad" id="t_acad" required>
                                                <option value="" disabled selected>Selecione o autor principal</option>
                                                <?php
                                                foreach ($academics as $academic) {
                                                    echo "<option value=\"" . $academic['ac_id'] . "\">" . $academic['ac_id'] . " - " . $academic['ac_nome'] . " - " . $academic['c_nome'] ."</option>";
                                                }
                                                ?>
                                            </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="t_acad2">Outros autores (se houver):</label>
                                        <input class="form-control" name="t_acad2" id="t_acad2" value="" type="text" placeholder="Informe o nome completo dos outros autores do trabalho"/>
                                    </div>
                                </div>
                            </div>                                          
                            <div class="form-row">                     
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <label class="small mb-1" for="t_prof">Orientador:</label>
                                        <select class="form-control" name="t_prof" id="t_prof" required>
                                                <option value="" disabled selected>Selecione o orientador</option>
                                                <?php
                                                foreach ($teachers as $teacher) {
                                                    echo "<option value=\"" . $teacher['p_id'] . "\">" . $teacher['p_id'] . " - " . $teacher['u_nome'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                    </div>
                                </div>
                                </div>
                                <div class="form-row">                                                         
                                 <div class="col-md-6">
                                    <div class="form-group">
                                    <label class="small mb-1" for="t_doc">Documento:</label>
                                        <label for="file-upload" class="custom-file-upload">
                                            <i class="fa fa-cloud-upload fa-lg" style="color: #637B54;"></i>     Selecione um documento, somente com extensão .pdf é permitido.
                                        </label>
                                        <input type="file" name="t_doc" id="file-upload" accept=".pdf" style="display: none;" onchange="updateFileName()" />
                                    </div>
                                </div>   
                                <div class="col-md-6">
                                    <div class="form-group">
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">                                                         
                            <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" id="selected-file-name" class="form-control" readonly placeholder="Nenhum arquivo selecionado" />
                                    </div>
                                </div>
                                </div>
                                <div class="form-group mt-4 mb-0">
                                    <button type="submit" name="bnt-cadastrar" class="btn btn-success">Cadastrar</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <footer>
            <?php include_once("baseboard.php"); ?><!--inclusão do rodapé-->
        </footer>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script> 
        <!--script para exclusão-->
        <script>
        function updateFileName() {
            const fileInput = document.getElementById("file-upload");
            const fileNameDisplay = document.getElementById("selected-file-name");

            if (fileInput.files.length > 0) {
                fileNameDisplay.value = fileInput.files[0].name;
            } else {
                fileNameDisplay.value = "Nenhum arquivo selecionado";
            }
        }
        </script>            
    </body>
</html>