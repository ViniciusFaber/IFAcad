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

require_once '../DataBase/conexao.php';
require_once '../DAO/workDAO.php';
require_once '../Model/academic-model.php';
require_once '../Model/teacher-model.php';


if (isset($_GET['t_id'])) {
    $t_id = $_GET['t_id'];//recebe o id passado por URL
    $conexao = new Conexao();
    $conn = $conexao->conectar();

    $academicModel = new AcademicModel($conn);
    $academics = $academicModel->getAllAcademics();

    $teacherModel = new TeacherModel($conn);
    $teachers = $teacherModel->getAllTeachers();

    $workDao = new WorkDao($conn);
    $workDetails = $workDao->getById($t_id);
} else {
    // Lógica para lidar com o caso em que 't_id' não está presente na URL
    echo "Parâmetro 't_id' não encontrado na URL";
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
        <title>Atualização de trabalho</title>
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
                        <a href="work-list.php" type="button" class="btn btn-outline-success">Lista de Trabalhos</a>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header"><i class="fa fa-university" aria-hidden="true" style="color: #637B54;"></i> Editar Trabalho</div>
                    <div class="card-body">
                    <form action="../Controller/update-work.php" method="POST" enctype="multipart/form-data">
                            
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="t_titulo">Título:</label>
                                        <input class="form-control" name="t_titulo" id="t_titulo" value="<?php echo isset($workDetails['t_titulo']) ? $workDetails['t_titulo'] : ''; ?>" type="text" placeholder="Informe o título do trabalho" />
                                    </div>                                    
                                </div>                           
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="t_data_def">Data de defesa:</label>
                                        <input class="form-control" name="t_data_def" id="t_data_def" value="<?php echo isset($workDetails['t_data_def']) ? $workDetails['t_data_def'] : ''; ?>" type="date" placeholder="Informe a data de defesa do trabalho" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="t_tipo">Tipo de trabalho:</label>
                                        <select class="form-control" name="t_tipo" id="t_tipo" required>
                                            <option value="" disabled selected>Selecione o tipo de trabalho</option>
                                            <option value="Relatório de estágio" <?php if ($workDetails['t_tipo'] == "Relatório de estágio") echo "selected"; ?>>Relatório de estágio</option>
                                            <option value="Trabalho de conclusão de curso" <?php if ($workDetails['t_tipo'] == "Trabalho de conclusão de curso") echo "selected"; ?>>Trabalho de conclusão de curso</option>  
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="t_palavra_c">Palavras-chave (até 5 palavras):</label>
                                        <input class="form-control" name="t_palavra_c" id="t_palavra_c" value="<?php echo isset($workDetails['t_palavra_c']) ? $workDetails['t_palavra_c'] : ''; ?>" type="text" placeholder="Informe as palavras-chave do trabalho" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="t_banca">Banca:</label>
                                        <input class="form-control" name="t_banca" id="t_banca" value="<?php echo isset($workDetails['t_banca']) ? $workDetails['t_banca'] : ''; ?>" type="text" placeholder="Informe o nome completo do 1° avaliador" required/>
                                    </div>
                                </div>                                                           
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="t_idioma">Idioma:</label>
                                        <input class="form-control" name="t_idioma" id="t_idioma" value="<?php echo isset($workDetails['t_idioma']) ? $workDetails['t_idioma'] : ''; ?>" type="text" placeholder="Informe o idioma do trabalho" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="t_resumo">Resumo:</label>
                                        
                                        <textarea class="form-control" name="t_resumo" id="t_resumo" rows="8" cols="50" placeholder="Informe o resumo do trabalho" required><?php echo isset($workDetails['t_resumo']) ? $workDetails['t_resumo'] : ''; ?></textarea>
                                    </div>
                                </div>                            
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="t_citar">Como citar:</label>
                                        <textarea class="form-control" name="t_citar" id="t_citar" rows="8" cols="50"  placeholder="Informe o resumo do trabalho" required><?php echo isset($workDetails['t_citar']) ? $workDetails['t_citar'] : ''; ?>
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="t_acad">Autor principal:</label>
                                        <select class="form-control" name="t_acad" id="t_acad" required>
                                                <option value="" disabled selected>Selecione oautor principal</option>                                                
                                                <?php
                                                foreach ($academics as $academic) {
                                                    $selected = ($academic['ac_id'] == $workDetails['t_acad']) ? 'selected' : '';
                                                    echo "<option value=\"" . $academic['ac_id'] . "\" $selected>" . $academic['ac_id'] . " - " . $academic['ac_nome'] . " - " . $academic['c_nome'] ."</option>";
                                                }
                                                ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="t_acad2">Outros autores (se houver):</label>
                                        <input class="form-control" name="t_acad2" id="t_acad2" value="<?php echo isset($workDetails['t_acad2']) ? $workDetails['t_acad2'] : ''; ?>" type="text" placeholder="Informe o nome completo dos outros autores do trabalho"/>
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
                                                    $selected = ($teacher['p_id'] == $workDetails['t_prof']) ? 'selected' : '';
                                                    echo "<option value=\"" . $teacher['p_id'] . "\" $selected>" . $teacher['p_id'] . " - " . $teacher['u_nome'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                    </div>
                                </div>
                            </div> 
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="t_doc">Documento existente:</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row" >
                                <div class="col-md-6">
                                    <div class="form-group">                                        
                                        <?php if (!empty($workDetails['t_doc'])): ?>
                                            
                                            <a  href="<?php echo $workDetails['t_doc']; ?>" class="btn btn-success w-100" target="_blank" download>
                                                Clique para visualizar o documento existente.
                                            </a>
                                        <?php else: ?>
                                            <p>Nenhum documento existente.</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="file-upload" class="custom-file-upload">
                                            <i class="fa fa-cloud-upload fa-lg" style="color: #637B54;"></i> Selecione um documento, somente com extensão .pdf é permitido.
                                        </label>
                                        <input type="file" name="t_doc" id="file-upload" accept=".pdf" style="display: none;" onchange="updateFileName()" />
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
                                    <input type="hidden" name="t_id" value="<?php echo $t_id; ?>">
                                    <button type="submit" name="btn-editar" class="btn btn-success">Atualizar</button>
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
        <!--script para lidar com a exclusão-->
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