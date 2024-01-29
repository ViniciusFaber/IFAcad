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
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Acesso rápido do administrador</title>
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
            <main>
            <div class="if-align">
                <p class="if-text">Acesso rápido - administrador</p>
                <hr class="if-hr-align">
            </div>
            <div class="if-div-cards">                
            </div>

             
            <!--caminho para gerenciar cursos--> 
            <div class="d-md-flex flex-md-equal" style="margin-left: 5%;">
              <div class="me-md-3 pt-3 px-3 pt-md-1 px-md-1 text-center overflow-hidden" style="width: 45%; background-color:#C5DAB7; margin-right: 5%; border-radius: 20px;  margin-top: 15px">
                <div class="my-1 py-1" style="background-color:#C5DAB7;">
                  <h2 class="display-5" style="font-size: 24px; margin: 10px 10px 5px 10px; color: #264811;">GERENCIAR CURSOS</h2>
                </div>
              <div class="mx-auto" style="width: 280px; height: 280px; border-radius: 100%; margin-top:15px; background-color:#C5DAB7;" >
                  <a class="nav-link collapsed" href="course-register.php">
                    <input type="image" src="img/gerenciar-cursos.png" width="200px" height="200px" style="margin-top: 30px">
                  </a>
              </div>          
          </div>

              <!--caminho para gerenciar professores--> 
            <div class=" me-md-3 pt-3 px-3 pt-md-1 px-md-1 text-center overflow-hidden" style="background-color:#C5DAB7; height: 380px; border-radius: 20px; margin-top: 15px; width: 45%;">
              <div class="my-1 p-1" style="background-color:#C5DAB7;">
                <h2 class="display-5" style="font-size: 24px; margin: 10px 10px 5px 10px; color: #264811;">GERENCIAR PROFESSORES</h2>
              </div>
              <div class="mx-auto" style="width: 280px; height: 280px; border-radius: 100%; margin-top:15px; background-color:#C5DAB7;">
                  <a class="nav-link collapsed" href="teacher-register.php">
                  <input type="image" src="img/gerenciar-professores.png" width="200px" height="200px" style="margin-top: 30px">
                </a>
              </div>
            </div>
          </div>
          <br>
           
          <!--caminho para gerenciar trabalhos--> 
            <div class="d-md-flex flex-md-equal" style="margin-left: 5%;">
                <div class="me-md-3 pt-3 px-3 pt-md-1 px-md-1 text-center overflow-hidden" style="width: 45%; background-color:#C5DAB7; margin-right: 5%; border-radius: 20px;  margin-top: 15px">
                  <div class="my-1 py-1" style="background-color:#C5DAB7;">
                    <h2 class="display-5" style="font-size: 24px; margin: 10px 10px 5px 10px; color: #264811;">GERENCIAR TRABALHOS</h2>
                  </div>
                <div class="mx-auto" style="width: 280px; height: 280px; border-radius: 100%; margin-top:15px; background-color:#C5DAB7;" >
                    <a class="nav-link collapsed" href="work-register.php">
                      <input type="image" src="img/gerenciar-trabalhos.png" width="200px" height="200px" style="margin-top: 30px">
                    </a>
                </div>          
            </div>

           <!--caminho para gerenciar acadêmicos--> 
              <div class=" me-md-3 pt-3 px-3 pt-md-1 px-md-1 text-center overflow-hidden" style="background-color:#C5DAB7; height: 380px; border-radius: 20px; margin-top: 15px; width: 45%;">
                <div class="my-1 p-1" style="background-color:#C5DAB7;">
                  <h2 class="display-5" style="font-size: 24px; margin: 10px 10px 5px 10px; color: #264811;">GERENCIAR ACADÊMICOS</h2>
                </div>
                <div class="mx-auto" style="width: 280px; height: 280px; border-radius: 100%; margin-top:15px; background-color:#C5DAB7;">
                    <a class="nav-link collapsed" href="academic-register.php">
                    <input type="image" src="img/gerenciar-academicos.png" width="200px" height="200px" style="margin-top: 30px">
                  </a>
                </div>
              </div>
            </div>
            <br><br>        
           
            </main>   
                <?php include_once("baseboard.php");?>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>      
    </body>
</html>