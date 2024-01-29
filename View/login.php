
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Login</title>
        <link href="css/styles.css" rel="stylesheet" />       
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
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
    <nav class="sb-topnav navbar navbar-expand if-div-menu">
    <div class="d-flex align-items-center if-div-menu">
        <a class="mr-3 if-a-logo"><img src="img/icone.png" alt="Logo"></a>
        <a class="mr-3 if-a-menu" href="../index.php">Início</a>
        <a class="mr-3 if-a-menu" href="about.php">Sobre</a>        
    </div>
    <div class="text-center flex-grow-1 if-div-menu">IFAcad</div>
    <div class="d-flex align-items-center ml-auto if-div-menu">
    </div>
</nav>
    </header> 
    <?php if(isset($_GET['erro'])){ ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Credenciais inválidas. <strong>Tente novamente!</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                <?php } ?>                                                    
            <main>            
            <div class="if-container">            
                <div class="login-container">
                <img class="if-img-logo" src="img/logo.png" alt="Logo">
                    <form class="login-form" action="../Controller/login-controller.php" method="POST">
                        <h2 class="login-title">Bem vindo(a)</h2>
                        <p class="login-sub-title">Faça login</p>
                        <div class="form-group">
                            <label class="if-label"for="u_email">Usuário:</label>
                            <input  class="if-input" type="text" id="u_email" name="u_email" placeholder="Informe seu email..." required>
                        </div>
                        <div class="form-group">
                            <label class="if-label" for="u_senha">Senha:</label>
                            <input class="if-input" type="password" id="u_senha" name="u_senha" placeholder="Informe sua senha..." required> <!--colocar required--> 
                        </div>
                        <button class="if-button-enter" type="submit">Entrar</button> 
                    
                    </form>
                </div>
            </div>
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